<?php

namespace Drupal\bootstrap_site_alert\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BootstrapSiteAlertConfig.
 */
class BootstrapSiteAlertConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'bootstrap_site_alert.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bootstrap_site_alert_config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('bootstrap_site_alert.config');

    // Set our Bootstrap version.
    $form['bootstrap_site_alert_version'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Bootstrap Version'),
      '#options' => [
        '3' => $this->t('3'),
        '4' => $this->t('4'),
        '5' => $this->t('5'),
      ],
      '#empty_option' => $this->t('- SELECT -'),
      '#required' => TRUE,
      '#default_value' => $config->get('bootstrap_site_alert_version'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('bootstrap_site_alert_version')['value'] ??
      $form_state->getValue('bootstrap_site_alert_version');

    $this->config('bootstrap_site_alert.config')
      ->set('bootstrap_site_alert_version', $value)
      ->save();

    parent::submitForm($form, $form_state);
  }

}
