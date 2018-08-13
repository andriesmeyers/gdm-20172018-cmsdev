<?php

namespace Drupal\mobility;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\mobility\Entity\ModelInterface;

/**
 * Defines the storage handler class for Model entities.
 *
 * This extends the base storage class, adding required special handling for
 * Model entities.
 *
 * @ingroup mobility
 */
interface ModelStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Model revision IDs for a specific Model.
   *
   * @param \Drupal\mobility\Entity\ModelInterface $entity
   *   The Model entity.
   *
   * @return int[]
   *   Model revision IDs (in ascending order).
   */
  public function revisionIds(ModelInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Model author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Model revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\mobility\Entity\ModelInterface $entity
   *   The Model entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ModelInterface $entity);

  /**
   * Unsets the language for all Model with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
