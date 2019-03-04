<?php
/**
 * Created by PhpStorm.
 * User: nidhal.mouldi
 * Date: 27/02/2019
 * Time: 16:34
 */

namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 */
class HelloConfigForm extends ConfigFormBase{

  /**
   * @return string
   */
  public function getFormId()
  {
    return 'hello_admin_config';
  }

  protected function getEditableConfigNames()
  {
    return ['hello.setting'];
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::buildForm($form, $form_state);
    $value = $this->config('hello.setting')->get('purge_days_number');
    $form['activity_time'] = [
      '#type' => 'select',
      '#title' => $this->t('How long to keep user acrivity statistics'),
      '#options' => ['0' =>'Never purge', '1' => '1', '2' => '2', '7' => '7', '14' => '14','30' => '30'],
      '#default_value' => $value
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->config('hello.setting')->set('purge_days_number', $form_state->getValue('activity_time'))->save();
    $form_state->setRebuild();
  }
}
