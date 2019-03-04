<?php

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatch;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

/**
 * Checks access for displaying configuration translation page.
 */
class HelloAccessCheck implements AccessInterface
{

  public function applies(Route $route){
    return NULL;
  }

  public function access(Route $route, Request $request = NULL, AccountInterface $account){
    $param = $route->getRequirement('_access_hello');
    $createdtime = User::load($account->id())->getCreatedTime();
    if ($createdtime + ($param * 3600) <= time()){
      return AccessResult::allowed();
    }else{
      return AccessResult::forbidden();
    }
  }
}
