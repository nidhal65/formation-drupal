<?php
/**
 * Created by PhpStorm.
 * User: nidhal.mouldi
 * Date: 26/02/2019
 * Time: 12:18
 */
namespace Drupal\hello\Plugin\Block;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a hello block
 *
 * @Block(
 *   id = "Hello_block",
 *   admin_label = @Translation("Hello!"),
 *
 *   )
 */
class HelloBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $currentUser;

  /**
   * HelloBlock constructor.
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Session\AccountInterface $account
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $account)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $account;
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
      $container->get('current_user')
    );
  }

  /**
   * Implements Drupal\Core\Block\BlockBase::build()
   *
   */
  public function build()
  {
    $build = [
      '#markup' => $this->t('welcome '.$this->currentUser->getDisplayName().' ! '. date('Y-m-d H:i:s',\Drupal::time()->getCurrentTime())),
      '#cache' => [
        'keys' => ['hello_1'],
        'max-age' => '1000'
      ]
    ];
    return $build;
  }
}
