<?php

namespace Drupal\mobility\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vehicle entities.
 *
 * @ingroup mobility
 */
interface VehicleInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Vehicle license plate.
   *
   * @return string
   *   License plate of the Vehicle.
   */
  public function getLicensePlate();
 
  /**
   * Gets the Vehicle location.
   *
   * @return string
   *   Location of the Vehicle
   */
  public function getLocation();

  /**
   * Gets the Vehicle creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Vehicle.
   */
  public function getCreatedTime();

  /**
   * Sets the Vehicle creation timestamp.
   *
   * @param int $timestamp
   *   The Vehicle creation timestamp.
   *
   * @return \Drupal\mobility\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Vehicle published status indicator.
   *
   * Unpublished Vehicle are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Vehicle is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Vehicle.
   *
   * @param bool $published
   *   TRUE to set this Vehicle to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mobility\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setPublished($published);

}
