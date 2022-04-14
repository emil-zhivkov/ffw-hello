<?php

namespace Drupal\nothing_fancy\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class RequestForm extends FormBase
{
  public function getFormId() {
    return 'nothing_fancy_get_form';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['pattern'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter ur name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' => '',
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#default_value' => $this->t('Send') ,
    ];
    $form['#theme'] = 'hello';
    return $form;


  }

  public function submitForm(array & $form, FormStateInterface $form_state) {

    $get_path_update = explode("/", \Drupal::service('path.current')->getPath());


    $field = $form_state->getValues();

    $re_url = Url::fromRoute('nothing_fancy.managet');

    $fields["pattern"] = $field['pattern'];


    \Drupal::messenger()->addMessage($this->t('data=pattern='.$fields["pattern"]));


    $form_state->setRedirectUrl($re_url);


  }
}
