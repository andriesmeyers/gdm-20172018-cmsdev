<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Manufacturer entities.
 *
 * @ingroup mobility
 */
class ManufacturerListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Manufacturer ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\mobility\Entity\Manufacturer */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.manufacturer.edit_form',
      ['manufacturer' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
