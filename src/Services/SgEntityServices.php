<?php

namespace Drupal\sg_entity_services\Services;

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
   * SgEntityServices constructor.
   *
   * @param \Drupal\sg_entity_services\Manager\SgEntityStorageManager $sgEntityStorageManager
   */
  public function __construct(SgEntityStorageManager $sgEntityStorageManager) {
    $this->sgEntityStorageManager = $sgEntityStorageManager;
  }

  /**
   * @return \Drupal\sg_entity_services\Manager\SgEntityStorageManager
   */
  public function getEntityStorageManager() {
    return $this->sgEntityStorageManager;
  }

}
