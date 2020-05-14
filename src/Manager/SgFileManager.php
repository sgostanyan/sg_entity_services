<?php

namespace Drupal\sg_entity_services\Manager;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SgFileManager.
 *
 * @package Drupal\sg_entity_services\Manager
 */
class SgFileManager {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * SgFileManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   Entity type manager.
   *   Render.
   * @param \Drupal\Core\File\FileSystemInterface $fileSystem
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   */
  public function __construct(EntityTypeManager $entityTypeManager, FileSystemInterface $fileSystem, RequestStack $requestStack) {
    $this->entityTypeManager = $entityTypeManager;
    $this->fileSystem = $fileSystem;
    $this->requestStack = $requestStack;
  }

  /**
   * @param $source
   * @param $filename
   * @param string $destination
   *
   * @return int|string|null
   */
  public function generateFileEntity($source, $filename, $destination = 'public://') {

    if (file_exists($source . $filename)) {
      // Get file.
      $filepath = $source . $filename;
      $data = file_get_contents($filepath);

      // Prepare destination.
      if ($data) {
        if ($this->fileSystem->prepareDirectory($destination, $this->fileSystem::CREATE_DIRECTORY)) {
          $file = file_save_data($data, $destination . $filename, $this->fileSystem::EXISTS_REPLACE);
          if ($file) {
            return $file->id();
          }
        }
      }
    }
    return NULL;
  }

  /**
   * @param $fid
   *
   * @return array
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getFileInfos($fid) {
    $file = $this->entityTypeManager->getStorage('file')->load($fid);
    if ($file) {
      $size = $this->sanitizeFileSize($file->getSize());
      $mimeArray = explode('/', $file->getMimeType());
      $fileMime = end($mimeArray);
      $urls = $this->getFileUrl($fid);

      return [
        'mime' => $fileMime,
        'size' => $size,
        'url' => [
          'absolute' => isset($urls['absolute']) ? $urls['absolute'] : '',
          'relative' => isset($urls['relative']) ? $urls['relative'] : '',
          'internal' => isset($urls['internal']) ? $urls['internal'] : '',
          'system' => isset($urls['system']) ? $urls['system'] : '',
        ],
        'referenced' => file_get_file_references($file),
      ];
    }
  }

  /**
   * @param $size
   *
   * @return int|string
   */
  public function sanitizeFileSize($size) {
    $fileSize = intval($size);
    $ko = $fileSize / 1000;
    if ($ko < 1000) {
      $fileSize = round($ko) . t(" Ko");
    }
    else {
      $fileSize = round($ko / 1000, 2) . t(" Mo");
    }
    return $fileSize;
  }

  /**
   * @param $fid
   * @param string $options
   *
   * @return array|null
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getFileUrl($fid, $options = 'absolute') {
    if ($fid) {
      $file = $this->entityTypeManager->getStorage('file')->load($fid);
      $path = $file->getFileUri();
      if ($file && $path) {
        return [
          'absolute' => file_create_url($path),
          'relative' => str_replace($this->requestStack->getCurrentRequest()->getSchemeAndHttpHost(), '', file_create_url($path)),
          'internal' => $path,
          'system' => $this->fileSystem->realpath($path),
        ];
      }
    }
    return NULL;
  }

}
