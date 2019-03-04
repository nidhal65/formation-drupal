<?php

/**
 * @file
 * Contains annonce.page.inc.
 *
 * Page callback for Annonce entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Annonce templates.
 *
 * Default template: annonce.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_annonce(array &$variables) {
  // Fetch AnnonceEntity Entity Object.
  $annonce = $variables['elements']['#annonce'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
