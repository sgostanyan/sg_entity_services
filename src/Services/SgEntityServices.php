<?php

namespace Drupal\sg_entity_services\Services;

use Drupal\sg_entity_services\Manager\SgEntityDisplayManager;
use Drupal\sg_entity_services\Manager\SgEntityStorageManager;
use Drupal\sg_entity_services\Manager\SgFileManager;
use Drupal\sg_entity_services\Manager\SgImageManager;

/**
 * Class SgEntityServices
 *
 * @package Drupal\sg_entity_services\Service
 */
class SgEntityServices {

  /**
   * @var \Drupal\sg_entity_services\Manager\SgEntityStorageManager
   */
  protected $sgEntityStorageManager;

  /**
   * @var \Drupal\sg_entity_services\Manager\SgEntityDisplayManager
   */
  protected $sgEntityDisplayManager;

  /**
   * @var \Drupal\sg_entity_services\Manager\SgFileManager
   */
  protected $sgFileManager;

  /**
   * @var \Drupal\sg_entity_services\Manager\SgImageManager
   */
  protected $sgImageManager;

  /**
   * SgEntityServices constructor.
   *
   * @param \Drupal\sg_entity_services\Manager\SgEntityStorageManager $sgEntityStorageManager
   * @param \Drupal\sg_entity_services\Manager\SgEntityDisplayManager $sgEntityDisplayManager
   * @param \Drupal\sg_entity_services\Manager\SgFileManager $sgFileManager
   * @param \Drupal\sg_entity_services\Manager\SgImageManager $sgImageManager
   */
  public function __construct(SgEntityStorageManager $sgEntityStorageManager, SgEntityDisplayManager $sgEntityDisplayManager, SgFileManager $sgFileManager, SgImageManager $sgImageManager) {
    $this->sgEntityStorageManager = $sgEntityStorageManager;
    $this->sgEntityDisplayManager = $sgEntityDisplayManager;
    $this->sgFileManager = $sgFileManager;
    $this->sgImageManager = $sgImageManager;
  }

  /**
   * @return \Drupal\sg_entity_services\Manager\SgEntityStorageManager
   */
  public function getEntityStorageManager() {
    return $this->sgEntityStorageManager;
  }

  /**
   * @return \Drupal\sg_entity_services\Manager\SgEntityDisplayManager
   */
  public function getEntityDisplayManager() {
    return $this->sgEntityDisplayManager;
  }

  /**
   * @return \Drupal\sg_entity_services\Manager\SgFileManager
   */
  public function getFileManager() {
    return $this->sgFileManager;
  }

  /**
   * @return \Drupal\sg_entity_services\Manager\SgImageManager
   */
  public function getImageManager() {
    return $this->sgImageManager;
  }

}
