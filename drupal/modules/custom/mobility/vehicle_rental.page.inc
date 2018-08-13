<?php

/**
 * @file
 * Contains vehicle_rental.page.inc.
 *
 * Page callback for Vehicle rental entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Vehicle rental templates.
 *
 * Default template: vehicle_rental.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_vehicle_rental(array &$variables) {
  // Fetch VehicleRental Entity Object.
  $vehicle_rental = $variables['elements']['#vehicle_rental'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
