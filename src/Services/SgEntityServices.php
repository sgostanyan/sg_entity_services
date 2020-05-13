<?php

namespace Drupal\sg_entity_services\Services;

use Drupal\sg_entity_services\Manager\SgEntityDisplayManager;
use Drupal\sg_entity_services\Manager\SgEntityStorageManager;

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
   * SgEntityServices constructor.
   *
   * @param \Drupal\sg_entity_services\Manager\SgEntityStorageManager $sgEntityStorageManager
   * @param \Drupal\sg_entity_services\Manager\SgEntityDisplayManager $sgEntityDisplayManager
   */
  public function __construct(SgEntityStorageManager $sgEntityStorageManager, SgEntityDisplayManager $sgEntityDisplayManager) {
    $this->sgEntityStorageManager = $sgEntityStorageManager;
    $this->sgEntityDisplayManager = $sgEntityDisplayManager;
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

}
