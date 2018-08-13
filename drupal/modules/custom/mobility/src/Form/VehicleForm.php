<?php

namespace Drupal\mobility\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Vehicle edit forms.
 *
 * @ingroup mobility
 */
class VehicleForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\mobility\Entity\Vehicle */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Vehicle.', [
          '%label' => $entity->getLicensePlate(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Vehicle.', [
          '%label' => $entity->getLicensePlate(),
        ]));
    }
    $form_state->setRedirect('entity.vehicle.canonical', ['vehicle' => $entity->id()]);
  }

}
