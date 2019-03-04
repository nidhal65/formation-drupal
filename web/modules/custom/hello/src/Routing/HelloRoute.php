<?php
/**
 * Created by PhpStorm.
 * User: guillaume.gallier
 * Date: 14/02/2019
 * Time: 10:58
 */

namespace Drupal\hello\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class HelloRoute extends RouteSubscriberBase
{
  /**
   * Alters existing routes for a specific collection.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection for adding routes.
   */
  protected function alterRoutes(RouteCollection $collection)
  {
    $route = $collection->get('hello.calculatrice_form');
    $route->setRequirements(['_access_hello' => '1']);
  }
}
