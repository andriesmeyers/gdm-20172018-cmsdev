<?php

namespace Drupal\mobility\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Vehicle rental entity.
 *
 * @ingroup mobility
 *
 * @ContentEntityType(
 *   id = "vehicle_rental",
 *   label = @Translation("Vehicle rental"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\mobility\VehicleRentalListBuilder",
 *     "views_data" = "Drupal\mobility\Entity\VehicleRentalViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\mobility\Form\VehicleRentalForm",
 *       "add" = "Drupal\mobility\Form\VehicleRentalForm",
 *       "edit" = "Drupal\mobility\Form\VehicleRentalForm",
 *       "delete" = "Drupal\mobility\Form\VehicleRentalDeleteForm",
 *     },
 *     "access" = "Drupal\mobility\VehicleRentalAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\mobility\VehicleRentalHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "vehicle_rental",
 *   admin_permission = "administer vehicle rental entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/mobility/vehicle_rental/{vehicle_rental}",
 *     "add-form" = "/mobility/vehicle_rental/add",
 *     "edit-form" = "/mobility/vehicle_rental/{vehicle_rental}/edit",
 *     "delete-form" = "/mobility/vehicle_rental/{vehicle_rental}/delete",
 *     "collection" = "/mobility/vehicle_rental",
 *   },
 *   field_ui_base_route = "vehicle_rental.settings"
 * )
 */
class VehicleRental extends ContentEntityBase implements VehicleRentalInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  public function getFrom(){
    return $this->get('field_from')->value;
  }

  public function getTo(){
    return $this->get('field_to')->value;
  }
  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Vehicle rental entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Vehicle rental is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
