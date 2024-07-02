<?php

namespace Drupal\job_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Jobles\Careerjet;
// use Drupal\job_api\Controller\ResultController;



/**
 * Implements a custom form.
 */
class testForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'test_api_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['test_keyword'] = [
     '#type' => 'textfield',
     '#title' => $this->t('Enter Job'),
     '#required' => FALSE,
   ];

   $form['test_country'] = [
     '#type' => 'textfield',
     '#title' => $this->t('Enter Country'),
     '#required' => FALSE,
   ];

   $form['test_city'] = [
     '#type' => 'textfield',
     '#title' => $this->t('Enter City'),
     '#required' => FALSE,
   ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  // public function submitForm(&$form, FormStateInterface $form_state)
  // {

  //   // $keyword = $form_state->getValue('test_keyword');
  //   // $country = $form_state->getValue('test_country');
  //   // $city = $form_state->getValue('test_city');

  //   // $url = Url::fromRoute('job_api.my_page')
  //   //         ->setOption('query', ['test_keyword' => $keyword, 'test_country' => $country, 'test_city' => $city]);
  //   // $form_state->setRedirectUrl($url);
  //   $form_state->setRedirect('job_api.my_page', [
  //     'test_keyword' => $form_state->getValue('test_keyword'),
  //     'test_country' => $form_state->getValue('test_country'),
  //     'atest_city' => $form_state->getValue('test_city'),
  //   ]);
    
  //   // $controller = \Drupal::service('controller_resolver')->getControllerFromDefinition('\Drupal\job_api\Controller\ResultController::myPage');
  //   // $filters = [
  //   //   'keyword' => $keyword,
  //   //   'location' => $country . $city,
  //   // ];

  //   // $url = ResultController::myPage('job_api.my_page', [
  //   //         'keyword' => $keyword,
  //   //         'country' => $country,
  //   //         'city' => $city,
  //   // ]);

  //     // $form_state->setRedirect('job_api.my_page',
  //     //   array(
  //     //     'query' => array(
  //     //       'keyword' => $keyword,
  //     //       'country' => $country,
  //     //       'city' => $city,
  //     //     ),
  //     //   ),
  //     // );
  // }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('job_api.my_page', [
      'test_keyword' => $form_state->getValue('test_keyword'),
      'test_country' => $form_state->getValue('test_country'),
      'test_city' => $form_state->getValue('test_city'),
    ]);
  }
}
