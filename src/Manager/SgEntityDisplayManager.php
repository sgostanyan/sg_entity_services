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
    $viewModes = $this->entityDisplayRepository->getViewModeOptions($entityType);
    $viewModesSanitized = [];
    if (!empty($viewModes)) {
      foreach ($viewModes as $id => $label) {
        $viewModesSanitized[$id] = $id == 'default' ? 'default' : $label;
      }
    }
    return $viewModesSanitized;
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

  /**
   * @param $fid
   * @param $imageStyle
   *
   * @param $attributes
   *
   * @return mixed
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function imageStyleRender($fid, $imageStyle, array $attributes = []) {
    $uri = $this->entityTypeManager->getStorage('file')
      ->load($fid)
      ->getFileUri();
    $style = $this->entityTypeManager->getStorage('image_style')
      ->load($imageStyle);
    $destination = $style->buildUri($uri);
    if (!file_exists($destination)) {
      $style->createDerivative($uri, $destination);
    }

    return [
      '#theme' => 'image',
      '#style_name' => $imageStyle,
      '#uri' => $style->buildUrl($uri),
      '#attributes' => $attributes,
    ];
  }

}
