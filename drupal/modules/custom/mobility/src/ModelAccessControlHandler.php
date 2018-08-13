<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Model entity.
 *
 * @see \Drupal\mobility\Entity\Model.
 */
class ModelAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\mobility\Entity\ModelInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished model entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published model entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit model entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete model entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add model entities');
  }

}
