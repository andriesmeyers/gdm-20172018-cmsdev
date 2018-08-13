<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\mobility\Entity\ModelInterface;

/**
 * Defines the storage handler class for Model entities.
 *
 * This extends the base storage class, adding required special handling for
 * Model entities.
 *
 * @ingroup mobility
 */
class ModelStorage extends SqlContentEntityStorage implements ModelStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ModelInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {model_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {model_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ModelInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {model_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('model_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
