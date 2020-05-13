<?php

namespace Drupal\sg_entity_services\Manager;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityRepository;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class SgEntityStorageManager.
 *
 * @package Drupal\sg_entity_services\Manager
 */
class SgEntityStorageManager {

  const ENTITY_BUNDLE_INFO = [
    'node' => [
      'bundle' => 'type',
      'id' => 'nid',
    ],
    'taxonomy_term' => [
      'bundle' => 'vid',
      'id' => 'tid',
    ],
    'media' => [
      'bundle' => 'bundle',
      'id' => 'mid',
    ],
  ];

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Entity\EntityRepository
   */
  protected $entityRepository;

  /**
   * SgEntityStorageManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   Entity type manager.
   * @param \Drupal\Core\Entity\EntityRepository $entityRepository
   *   Entity repository.
   */
  public function __construct(EntityTypeManager $entityTypeManager, EntityRepository $entityRepository) {
    $this->entityTypeManager = $entityTypeManager;
    $this->entityRepository = $entityRepository;
  }

  /**
   * @param string $entityType
   *   Entity type.
   * @param array|null $bundles
   *   List of entity bundles.
   * @param array $ids
   *   List of entity ids.
   *
   * @return \Drupal\Core\Entity\EntityInterface[]
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getEntities(string $entityType, array $bundles = NULL, array $ids = NULL) {
    $storage = $this->entityTypeManager->getStorage($entityType);
    $entityTypeField = isset(self::ENTITY_BUNDLE_INFO[$entityType]['bundle']) ? self::ENTITY_BUNDLE_INFO[$entityType]['bundle'] : NULL;
    $entityIdField = isset(self::ENTITY_BUNDLE_INFO[$entityType]['id']) ? self::ENTITY_BUNDLE_INFO[$entityType]['id'] : NULL;

    // Get entity query.
    $query = $storage->getQuery();

    // Filter by bundles.
    if ($bundles !== NULL) {
      if (!empty($bundles) && $entityTypeField) {
        $query->condition($entityTypeField, $bundles, 'IN');
      }
      else {
        return [];
      }
    }

    // Filter by ids.
    if ($ids !== NULL) {
      if (!empty($ids) && $entityIdField) {
        $query->condition($entityIdField, $ids, 'IN');
      }
      else {
        return [];
      }
    }

    // Load entities.
    $entities = $this->entityTypeManager->getStorage($entityType)->loadMultiple($query->execute());
    $entitiesArray = [];
    foreach ($entities as $key => $entity) {
      $entitiesArray[$entity->bundle()][$entity->id()] = $this->entityRepository->getTranslationFromContext($entity);
    }

    return $entitiesArray;
  }

  /**
   * @param string $entityType
   *   Entity type.
   * @param array $values
   *   Array of field values.
   * @param array $translations
   *   Array of field values for translation.
   *   Ex: [
   *       'en' => [
   *          'title' => 'EN title',
   *          'body' => [
   *            'value' => 'English summary',
   *          ],
   *          'field_tags' => [
   *            [
   *              'target_id' => 1,
   *            ],
   *          ],
   *       ],
   *       'es' => [
   *         'title' => 'ES title',
   *         'body' => [
   *           'value' => 'Spanish summary',
   *         ],
   *        'field_tags' => [
   *          [
   *            'target_id' => 1,
   *          ],
   *       ],
   *     ],
   *
   * @return \Drupal\Core\Entity\EntityInterface
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createEntity(string $entityType, array $values, array $translations = NULL) {
    // Create entity.
    $entity = $this->entityTypeManager->getStorage($entityType)->create($values);
    $entity->save();

    //Add translations.
    if (!empty($translations)) {
      $this->addTranslations($entity, $translations);
    }
    return $entity;
  }

  /**
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   Entity interface.
   * @param array $translations
   *   Array of field values for translation.
   *   Ex: [
   *       'en' => [
   *          'title' => 'EN title',
   *          'body' => [
   *            'value' => 'English summary',
   *          ],
   *          'field_tags' => [
   *            [
   *              'target_id' => 1,
   *            ],
   *          ],
   *       ],
   *       'es' => [
   *         'title' => 'ES title',
   *         'body' => [
   *           'value' => 'Spanish summary',
   *         ],
   *        'field_tags' => [
   *          [
   *            'target_id' => 1,
   *          ],
   *       ],
   *     ],
   *
   * @return \Drupal\Core\Entity\EntityInterface
   */
  public function addTranslations(EntityInterface $entity, array $translations) {
    foreach ($translations as $lang => $values) {
      if ($entity && !$entity->hasTranslation($lang)) {
        $entityArray = $entity->toArray();
        $translatedEntityArray = array_merge($entityArray, $values);
        $translatedEntity = $entity->addTranslation($lang, $translatedEntityArray);
        $translatedEntity->save();
      }
    }
    return $entity;
  }

}
