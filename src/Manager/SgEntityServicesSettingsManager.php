<?php

namespace Drupal\sg_entity_services\Manager;

use Drupal\Core\Extension\ModuleHandler;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SgEntityServicesSettingsManager
 *
 * @package Drupal\sg_entity_services\Manager
 */
class SgEntityServicesSettingsManager {

  /**
   * @var \Drupal\Core\Extension\ModuleHandler
   */
  protected $moduleHandler;

  /**
   * @var string
   */
  protected $path;

  /**
   * SgEntityServicesSettingsManager constructor.
   *
   * @param \Drupal\Core\Extension\ModuleHandler $moduleHandler
   */
  public function __construct(ModuleHandler $moduleHandler) {
    $this->moduleHandler = $moduleHandler;
    $this->path = $moduleHandler->getModule('sg_entity_services')->getPath() . '/settings/';
  }

  /**
   * @return mixed
   */
  public function getEntityBundleInfos() {
    return Yaml::parse(file_get_contents($this->path . 'entity_bundle_infos.yml'));
  }

}
