<?php

namespace Drupal\hello\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AnnonceEntityTypeForm.
 */
class AnnonceEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $annonce_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $annonce_type->label(),
      '#description' => $this->t("Label for the Annonce type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $annonce_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\hello\Entity\AnnonceEntityType::load',
      ],
      '#disabled' => !$annonce_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $annonce_type = $this->entity;
    $status = $annonce_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Annonce type.', [
          '%label' => $annonce_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Annonce type.', [
          '%label' => $annonce_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($annonce_type->toUrl('collection'));
  }

}
