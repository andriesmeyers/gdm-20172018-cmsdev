<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Vehicle rental entity.
 *
 * @see \Drupal\mobility\Entity\VehicleRental.
 */
class VehicleRentalAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mobility\Entity\VehicleRentalInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished vehicle rental entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published vehicle rental entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit vehicle rental entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete vehicle rental entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add vehicle rental entities');
  }

}
