<?php

namespace Drupal\sg_entity_services\Manager;

use Drupal\Core\Entity\EntityDisplayRepository;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Render\Renderer;

/**
 * Class SgEntityDisplayManager.
 *
 * @package Drupal\sg_entity_services\Manager
 */
class SgEntityDisplayManager {

  /**
   * @var \Drupal\Core\Entity\EntityDisplayRepository
   */
  protected $entityDisplayRepository;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Render.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * SgToolsEntityDisplayManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityDisplayRepository $entityDisplayRepository
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   * @param \Drupal\Core\Render\Renderer $renderer
   */
  public function __construct(EntityDisplayRepository $entityDisplayRepository, EntityTypeManager $entityTypeManager, Renderer $renderer) {
    $this->entityDisplayRepository = $entityDisplayRepository;
    $this->entityTypeManager = $entityTypeManager;
    $this->renderer = $renderer;
  }

  /**
   * GetViewModes.
   *
   * @param string $entityType
   *   EntityType.
   *
   * @return array
   *   View mode array.
   */
  public function getViewModes(string $entityType) {
    $viewModes = $this->entityDisplayRepository->getViewModes($entityType);
    $sanitized = [];
    if ($viewModes) {
      foreach ($viewModes as $label => $viewMode) {
        $sanitized[$label] = $viewMode['id'];
      }
    }
    return $sanitized;
  }

  /**
   * @param \Drupal\Core\Entity\EntityInterface $entity
   * @param null $viewMode
   *
   * @return array
   */
  public function renderEntity(EntityInterface $entity, $viewMode = NULL) {
    return $this->entityTypeManager->getViewBuilder($entity->getEntityType()->id())->view($entity, $viewMode);
  }

  /**
   * @param array $renderArray
   *
   * @return \Drupal\Component\Render\MarkupInterface|string
   * @throws \Exception
   */
  public function renderArrayToMarkup(array $renderArray) {
    return $this->renderer->render($renderArray);
  }

  /**
   * @param $tag
   * @param $value
   * @param array $attributes
   *
   * @return array
   */
  public function htmlTagRender($tag, $value, array $attributes = []) {
    return [
      '#type' => 'html_tag',
      '#tag' => $tag,
      '#value' => t($value),
      '#attributes' => $attributes,
    ];
  }

}
