<?php

namespace Drupal\mobility\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Vehicle rental edit forms.
 *
 * @ingroup mobility
 */
class VehicleRentalForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\mobility\Entity\VehicleRental */
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
        drupal_set_message($this->t('Created the %label Vehicle rental.', [
          '%label' => $entity->id(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Vehicle rental.', [
          '%label' => $entity->id(),
        ]));
    }
    $form_state->setRedirect('entity.vehicle_rental.canonical', ['vehicle_rental' => $entity->id()]);
  }

}
