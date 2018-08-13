<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Model entities.
 *
 * @ingroup mobility
 */
class ModelListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Model ID');
    $header['manufacturer'] = $this->t('Manufacturer');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\mobility\Entity\Model */
    $row['id'] = $entity->id();
    $row['manufacturer'] = $entity->getManufacturer()->label();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.model.edit_form',
      ['model' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
