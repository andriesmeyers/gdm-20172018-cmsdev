<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Manufacturer entity.
 *
 * @see \Drupal\mobility\Entity\Manufacturer.
 */
class ManufacturerAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mobility\Entity\ManufacturerInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished manufacturer entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published manufacturer entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit manufacturer entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete manufacturer entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add manufacturer entities');
  }

}
