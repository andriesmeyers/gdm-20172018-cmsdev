<?php

/**
 * @file
 * Contains model.page.inc.
 *
 * Page callback for Model entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Model templates.
 *
 * Default template: model.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_model(array &$variables) {
  // Fetch Model Entity Object.
  $model = $variables['elements']['#model'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
