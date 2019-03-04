<?php

namespace Drupal\hello\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CalculatriceForm.
 */
class CalculatriceForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'calculatrice_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['first'] = [
      '#type' => 'number',
      '#title' => $this->t('First Value'),
      '#weight' => '1',
      '#ajax' => [
        'callback' => [$this, 'validateValueAjax'],
        'event' => 'change'
      ],
      '#suffix' => '<span class="text-error-first" style="color: red;"></span>'
    ];
    $form['operation'] = [
      '#type' => 'radios',
      '#title' => $this->t('Operation'),
      '#options' => ['+' =>'Ajout', '-' => 'Soustraction', '*' => 'Multiplication', '/' => 'Division'],
      '#weight' => '2',
    ];
    $form['second'] = [
      '#type' => 'number',
      '#title' => $this->t('Second value'),
      '#weight' => '3',
      '#ajax' => [
        'callback' => [$this, 'validateValueAjax'],
        'event' => 'change'
      ],
      '#suffix' => '<span class="text-error-second red" style="color: red;"></span>'
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate'),
      '#weight' => '4',
    ];

    if(isset($form_state->getRebuildInfo()['result'])) {
      $form['result'] = [
        '#type' => 'html_tag',
        '#tag' => 'h2',
        '#weight' => '0',
        '#value' => $this->t('Resultat :') . $form_state->getRebuildInfo()['result']
      ];
    }
    return $form;
  }

  public function validateValueAjax(array &$form, FormStateInterface $formState){
    $element = $formState->getTriggeringElement()['#name'];
    $element_value = $formState->getValue($element);
    $css_error = ['border' => '2px solid red'];
    $css_true = ['border' => '2px solid green'];
    $message = 'The '.$element.' value is greater than 20';

    $response = new AjaxResponse();
    if($element_value != NULL && $element_value > 20) {
      $response->addCommand(new CssCommand('#edit-'.$element, $css_error));
      $response->addCommand(new HtmlCommand('.text-error-'.$element, $message));
    }elseif ($element_value != NULL && $element_value <= 20){
      $response->addCommand(new CssCommand('#edit-'.$element, $css_true));
      $response->addCommand(new HtmlCommand('.text-error-'.$element, ''));
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $first = $form_state->getValue('first');
    $second = $form_state->getValue('second');
    $op = $form_state->getValue('operation');

    if($first > 20){
      $form_state->setErrorByName('first', $this->t('The first value is greater than 20'));
    }
    if($first == NULL){
      $form_state->setErrorByName('first', $this->t('The first value can not be null'));
    }
    if($second > 20){
      $form_state->setErrorByName('second', $this->t('The second value is greater than 20'));
    }
    if($second == NULL){
      $form_state->setErrorByName('second', $this->t('The second value can not be null'));
    }
    if($op == NULL){
      $form_state->setErrorByName('operation', $this->t('Please select operation'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    \Drupal::state()->set('date_time_calculatrice', date('Y/m/d H:i'));

    $first = $form_state->getValue('first');
    $second = $form_state->getValue('second');
    $op = $form_state->getValue('operation');
    switch ($op){
      case '+':
        $result = $first + $second;
        break;
      case '-':
        $result = $first - $second;
        break;
      case '*':
        $result = $first * $second;
        break;
      case '/':
        $result = $first / $second;
        break;
    }
      $form_state->addRebuildInfo('result', $result);
    $form_state->setRebuild();
//      \Drupal::messenger()->addMessage($result);

  }

}
