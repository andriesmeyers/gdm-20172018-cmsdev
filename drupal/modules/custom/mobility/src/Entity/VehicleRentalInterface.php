<?php

namespace Drupal\mobility\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vehicle rental entities.
 *
 * @ingroup mobility
 */
interface VehicleRentalInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Vehicle rental creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Vehicle rental.
   */
  public function getCreatedTime();

  /**
   * Sets the Vehicle rental creation timestamp.
   *
   * @param int $timestamp
   *   The Vehicle rental creation timestamp.
   *
   * @return \Drupal\mobility\Entity\VehicleRentalInterface
   *   The called Vehicle rental entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Vehicle rental published status indicator.
   *
   * Unpublished Vehicle rental are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Vehicle rental is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Vehicle rental.
   *
   * @param bool $published
   *   TRUE to set this Vehicle rental to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mobility\Entity\VehicleRentalInterface
   *   The called Vehicle rental entity.
   */
  public function setPublished($published);

}
