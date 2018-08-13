<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Vehicle rental entities.
 *
 * @ingroup mobility
 */
class VehicleRentalListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Vehicle rental ID');
    $header['from'] = $this->t('From');
    $header['to'] = $this->t('To');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\mobility\Entity\VehicleRental */
    $row['id'] = Link::createFromRoute(
      $entity->id(),
      'entity.vehicle_rental.edit_form',
      ['vehicle_rental' => $entity->id()]
    );
    $row['from'] = $entity->getFrom();
    $row['to'] = $entity->getTo();
    return $row + parent::buildRow($entity);
  }

}
