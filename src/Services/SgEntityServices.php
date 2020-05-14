<?php

namespace Drupal\sg_entity_services\Services;

use Drupal\sg_entity_services\Manager\SgEntityDisplayManager;
use Drupal\sg_entity_services\Manager\SgEntityStorageManager;
use Drupal\sg_entity_services\Manager\SgFileManager;

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
   * SgEntityServices constructor.
   *
   * @param \Drupal\sg_entity_services\Manager\SgEntityStorageManager $sgEntityStorageManager
   * @param \Drupal\sg_entity_services\Manager\SgEntityDisplayManager $sgEntityDisplayManager
   * @param \Drupal\sg_entity_services\Manager\SgFileManager $sgFileManager
   */
  public function __construct(SgEntityStorageManager $sgEntityStorageManager, SgEntityDisplayManager $sgEntityDisplayManager, SgFileManager $sgFileManager) {
    $this->sgEntityStorageManager = $sgEntityStorageManager;
    $this->sgEntityDisplayManager = $sgEntityDisplayManager;
    $this->sgFileManager = $sgFileManager;
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

}
