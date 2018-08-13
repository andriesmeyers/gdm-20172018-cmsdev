<?php

namespace Drupal\mobility\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Vehicle entity.
 *
 * @ingroup mobility
 *
 * @ContentEntityType(
 *   id = "vehicle",
 *   label = @Translation("Vehicle"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\mobility\VehicleListBuilder",
 *     "views_data" = "Drupal\mobility\Entity\VehicleViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\mobility\Form\VehicleForm",
 *       "add" = "Drupal\mobility\Form\VehicleForm",
 *       "edit" = "Drupal\mobility\Form\VehicleForm",
 *       "delete" = "Drupal\mobility\Form\VehicleDeleteForm",
 *     },
 *     "access" = "Drupal\mobility\VehicleAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\mobility\VehicleHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "vehicle",
 *   admin_permission = "administer vehicle entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "license_plate",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/mobility/vehicle/{vehicle}",
 *     "add-form" = "/mobility/vehicle/add",
 *     "edit-form" = "/mobility/vehicle/{vehicle}/edit",
 *     "delete-form" = "/mobility/vehicle/{vehicle}/delete",
 *     "collection" = "/mobility/vehicle",
 *   },
 *   field_ui_base_route = "vehicle.settings"
 * )
 */
class Vehicle extends ContentEntityBase implements VehicleInterface {

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

  /**
   * {@inheritdoc}
   */
  public function getLicensePlate() {
    return $this->get('license_plate')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getLocation() {

    return $this->get('field_location')
                ->first()
                ->get('entity')
                ->getTarget()
                ->getValue()
                ->label();
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
      ->setDescription(t('The user ID of author of the Vehicle entity.'))
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

    $fields['license_plate'] = BaseFieldDefinition::create('string')
    ->setLabel(t('License Plate'))
    ->setDescription(t('The registered license plate of the vehicle.'))
    ->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'string',
      'weight' => -4,
    ])
    ->setDisplayOptions('form', [
      'type' => 'string_textfield',
      'weight' => -4,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE)
    ->setRequired(TRUE);

    
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Vehicle is published.'))
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
