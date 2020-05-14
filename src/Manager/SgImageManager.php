<?php

namespace Drupal\sg_entity_services\Manager;

use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class SgImageManager.
 *
 * @package Drupal\sg_entity_services\Manager
 */
class SgImageManager {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * SgImageManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Get image styles.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getImageStyles() {
    $styles = $this->entityTypeManager->getStorage('image_style')->loadMultiple();
    $styleList = [];
    foreach ($styles as $style) {
      $styleList[$style->id()] = $style->label();
    }
    return $styleList;
  }

  /**
   * @param $fid
   * @param $imageStyle
   *
   * @return mixed
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getImageStyleUrl($fid, $imageStyle) {
    $uri = $this->entityTypeManager->getStorage('file')->load($fid)->getFileUri();
    $style = $this->entityTypeManager->getStorage('image_style')->load($imageStyle);
    $destination = $style->buildUri($uri);
    if (!file_exists($destination)) {
      $style->createDerivative($uri, $destination);
    }
    return $style->buildUrl($uri);
  }

}
