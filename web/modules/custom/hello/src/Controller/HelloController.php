<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;

/**
 * Class DefaultController.
 *
 * @package Drupal\hello\Controller
 */
class HelloController extends ControllerBase
{

  /**
   * @return array
   */
  public function content()
    {
        return ['#markup' => t('vous êtes sur la page Hello. Votre nom utilisateur courant est ')];
    }

  public function list_noeuds($type){

    $node_types = $this->entityTypeManager()->getStorage('node_type')->loadMultiple();
    $items_list = [];
    foreach ($node_types as $node_type){
      $items_list[] = $node_type->toLink();
    }
    $node_type_list = [
      '#theme' => 'item_list',
      '#items' => $items_list,
    ];

    $storage = $this->entityTypeManager()->getStorage('node');
    $query = $storage->getQuery();
    if($type) {
      $query->condition('type', $type);
    }
    $ids = $query->pager(10)->execute();
    $nodes = $storage->loadMultiple($ids);

    $items = [];
//    $build = '<ul>';
    foreach ($nodes as $node){
      $items[] = $node->toLink();
    }
    $list = [
      '#theme' => 'item_list',
      '#items' => $items,
      '#title' => $this->t('Node list')
    ];
    $pager = ['#type' => 'pager'];
    return [
      'list' => $list,
      'pager' => $pager,
      '#cache' => [
        'keys' => ['hello:node_list'],
        'tags' => ['node_list', 'node_type_list'],
        'contexts' => ['url']
      ]
    ];
  }

  public function user_statistics($user){
    $database = \Drupal::database();
    $connections = $database->select('hello_user_statistics', 'us')
      ->fields('us',['action', 'time'])
      ->condition('uid', $user)
      ->execute()
      ->fetchAll();
    $items = [];
    $con = 0;
    foreach ($connections as $connection){
      $action = $connection->action == 0 ? $action = 'Logout' : $action = 'Login';
      $con += $connection->action == 1 ? 1 : 0;

      $items[] = ['Action' => $action, 'Time' => date ( 'Y/m/d H:i', $connection->time )];
    }
    $account = User::load($user);
    $output = [
      '#theme' => 'hello',
      '#data' => ucfirst($account->getDisplayName()).' has been connected '.$con.' times.'
    ];
    $list = [
      '#theme' => 'table',
      '#header' => ['Action', 'Time'],
      '#rows' => $items,
      '#title' => $this->t('connections')
    ];
    return [
      'message' =>$output,
      'list' => $list
  ];
  }

}
