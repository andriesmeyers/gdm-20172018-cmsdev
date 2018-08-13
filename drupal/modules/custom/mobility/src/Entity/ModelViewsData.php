<?php

namespace Drupal\mobility\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Model entities.
 */
class ModelViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}