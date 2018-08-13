<?php

namespace Drupal\mobility\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Manufacturer entities.
 *
 * @ingroup mobility
 */
interface ManufacturerInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Manufacturer name.
   *
   * @return string
   *   Name of the Manufacturer.
   */
  public function getName();

  /**
   * Sets the Manufacturer name.
   *
   * @param string $name
   *   The Manufacturer name.
   *
   * @return \Drupal\mobility\Entity\ManufacturerInterface
   *   The called Manufacturer entity.
   */
  public function setName($name);

  /**
   * Gets the Manufacturer creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Manufacturer.
   */
  public function getCreatedTime();

  /**
   * Sets the Manufacturer creation timestamp.
   *
   * @param int $timestamp
   *   The Manufacturer creation timestamp.
   *
   * @return \Drupal\mobility\Entity\ManufacturerInterface
   *   The called Manufacturer entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Manufacturer published status indicator.
   *
   * Unpublished Manufacturer are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Manufacturer is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Manufacturer.
   *
   * @param bool $published
   *   TRUE to set this Manufacturer to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\mobility\Entity\ManufacturerInterface
   *   The called Manufacturer entity.
   */
  public function setPublished($published);

}
