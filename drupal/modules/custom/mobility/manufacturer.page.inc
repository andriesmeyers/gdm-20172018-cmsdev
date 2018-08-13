<?php

/**
 * @file
 * Contains manufacturer.page.inc.
 *
 * Page callback for Manufacturer entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Manufacturer templates.
 *
 * Default template: manufacturer.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_manufacturer(array &$variables) {
  // Fetch Manufacturer Entity Object.
  $manufacturer = $variables['elements']['#manufacturer'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
