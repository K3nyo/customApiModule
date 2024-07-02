<?php

namespace Drupal\toastify\Form;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Toastify settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->moduleHandler = $container->get('module_handler');

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'toastify_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['toastify.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('toastify.settings');
    $colorElement = $this->moduleHandler->moduleExists('jquery_colorpicker')
      ? 'jquery_colorpicker'
      : 'color';

    $form['status'] = [
      '#type' => 'details',
      '#title' => $this->t('Status'),
      '#open' => TRUE,
    ];

    $form['warning'] = [
      '#type' => 'details',
      '#title' => $this->t('Warning'),
    ];

    $form['error'] = [
      '#type' => 'details',
      '#title' => $this->t('Error'),
    ];

    foreach (['status', 'warning', 'error'] as $type) {
      $form[$type][$type . '_duration'] = [
        '#type' => 'number',
        '#title' => $this->t('Duration'),
        '#default_value' => $config->get($type . '.duration'),
        '#required' => TRUE,
        '#min' => 0,
      ];

      $form[$type][$type . '_gravity'] = [
        '#type' => 'select',
        '#title' => $this->t('Gravity'),
        '#default_value' => $config->get($type . '.gravity'),
        '#options' => [
          'top' => $this->t('Top'),
          'bottom' => $this->t('Bottom'),
        ],
      ];

      $form[$type][$type . '_positionLeft'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Position left'),
        '#default_value' => $config->get($type . '.positionLeft'),
      ];

      if (!_toastify_is_gin_theme_active()) {
        $form[$type][$type . '_color'] = [
          '#type' => $colorElement,
          '#title' => $this->t('Color'),
          '#default_value' => $config->get($type . '.color'),
        ];

        $form[$type][$type . '_color2'] = [
          '#type' => $colorElement,
          '#title' => $this->t('Color 2'),
          '#default_value' => $config->get($type . '.color2'),
        ];

        $form[$type][$type . '_colorProgressBar'] = [
          '#type' => $colorElement,
          '#title' => $this->t('Color (progress bar)'),
          '#default_value' => $config->get($type . '.colorProgressBar'),
        ];

        $form[$type][$type . '_direction'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Gradient direction'),
          '#default_value' => $config->get($type . '.direction'),
        ];
      }

      $form[$type][$type . '_close'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Close button'),
        '#default_value' => $config->get($type . '.close'),
      ];
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('toastify.settings');
    foreach (['status', 'warning', 'error'] as $type) {
      $config->set($type . '.duration', $form_state->getValue($type . '_duration'));
      $config->set($type . '.gravity', $form_state->getValue($type . '_gravity'));
      $config->set($type . '.positionLeft', boolval($form_state->getValue($type . '_positionLeft')));
      $config->set($type . '.close', boolval($form_state->getValue($type . '_close')));

      if (!_toastify_is_gin_theme_active()) {
        $config->set($type . '.color', $form_state->getValue($type . '_color'));
        $config->set($type . '.color2', $form_state->getValue($type . '_color2'));
        $config->set($type . '.colorProgressBar', $form_state->getValue($type . '_colorProgressBar'));
        $config->set($type . '.direction', Xss::filter($form_state->getValue($type . '_direction')));
      }
    }
    $config->save();

    $this->messenger()->addError('This is an example error message.');
    $this->messenger()->addWarning('This is an example warning message.');
    $this->messenger()->addStatus('This is an example status message.');

    parent::submitForm($form, $form_state);
  }

}
