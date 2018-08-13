<?php

namespace Drupal\mobility\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\mobility\Entity\ModelInterface;

/**
 * Class ModelController.
 *
 *  Returns responses for Model routes.
 */
class ModelController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Model  revision.
   *
   * @param int $model_revision
   *   The Model  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($model_revision) {
    $model = $this->entityManager()->getStorage('model')->loadRevision($model_revision);
    $view_builder = $this->entityManager()->getViewBuilder('model');

    return $view_builder->view($model);
  }

  /**
   * Page title callback for a Model  revision.
   *
   * @param int $model_revision
   *   The Model  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($model_revision) {
    $model = $this->entityManager()->getStorage('model')->loadRevision($model_revision);
    return $this->t('Revision of %title from %date', ['%title' => $model->label(), '%date' => format_date($model->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Model .
   *
   * @param \Drupal\mobility\Entity\ModelInterface $model
   *   A Model  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ModelInterface $model) {
    $account = $this->currentUser();
    $langcode = $model->language()->getId();
    $langname = $model->language()->getName();
    $languages = $model->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $model_storage = $this->entityManager()->getStorage('model');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $model->label()]) : $this->t('Revisions for %title', ['%title' => $model->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all model revisions") || $account->hasPermission('administer model entities')));
    $delete_permission = (($account->hasPermission("delete all model revisions") || $account->hasPermission('administer model entities')));

    $rows = [];

    $vids = $model_storage->revisionIds($model);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\mobility\ModelInterface $revision */
      $revision = $model_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $model->getRevisionId()) {
          $link = $this->l($date, new Url('entity.model.revision', ['model' => $model->id(), 'model_revision' => $vid]));
        }
        else {
          $link = $model->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.model.translation_revert', ['model' => $model->id(), 'model_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.model.revision_revert', ['model' => $model->id(), 'model_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.model.revision_delete', ['model' => $model->id(), 'model_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['model_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
