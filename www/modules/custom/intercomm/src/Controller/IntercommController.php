<?php

namespace Drupal\intercomm\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Intercomm routes.
 */
class IntercommController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
