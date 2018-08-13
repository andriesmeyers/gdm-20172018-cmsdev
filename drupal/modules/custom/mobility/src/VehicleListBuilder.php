<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Vehicle entities.
 *
 * @ingroup mobility
 */
class VehicleListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['license_plate'] = $this->t('License Plate');
    $header['field_location'] = $this->t('Location');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\mobility\Entity\Vehicle */
    $row['license_plate'] = Link::createFromRoute(
      $entity->getLicensePlate(),
      'entity.vehicle.edit_form',
      ['vehicle' => $entity->id()]
    );
    $row['field_location'] = $entity->getLocation();
    return $row + parent::buildRow($entity);
  }

}
