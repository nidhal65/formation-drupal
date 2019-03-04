<?php
/**
 * Created by PhpStorm.
 * User: nidhal.mouldi
 * Date: 26/02/2019
 * Time: 12:18
 */
namespace Drupal\hello\Plugin\Block;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a hello block
 *
 * @Block(
 *   id = "Session_block",
 *   admin_label = @Translation("Session!"),
 *
 *   )
 */
class SessionBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $currentUser;
  protected $database;

  /**
   * HelloBlock constructor.
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Session\AccountInterface $account
   * @param \Drupal\Core\Database\Connection $database
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $account, Connection $database)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $account;
    $this->database = $database;
  }

  /**
   * Creates an instance of the plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('database')
    );
  }

  /**
   * Implements Drupal\Core\Block\BlockBase::build()
   *
   */
  public function build()
  {
    $nbr_session = $this->database->select('sessions','s')->countQuery()->execute()->fetchField();
    $build = [
      '#markup' => $this->t('Il y a actuellement '.$nbr_session.' sessions actives')
    ];
    return $build;
  }

  public function blockAccess(AccountInterface $account)
  {
    return AccessResult::allowedIfHasPermission($account, 'access hello');
  }
}
