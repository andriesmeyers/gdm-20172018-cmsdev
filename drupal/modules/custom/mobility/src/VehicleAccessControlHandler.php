<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Vehicle entity.
 *
 * @see \Drupal\mobility\Entity\Vehicle.
 */
class VehicleAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mobility\Entity\VehicleInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished vehicle entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published vehicle entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit vehicle entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete vehicle entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add vehicle entities');
  }

}
