<?php

namespace Drupal\groopal_maps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'GroopalMaps' block.
 *
 * @Block(
 *  id = "groopal_maps_block",
 *  admin_label = @Translation("Groopal Maps"),
 * )
 */
class GroopalMaps extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['google_maps_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google Maps API Key'),
      '#description' => $this->t('Generate your google maps API key and place it here.'),
      '#default_value' => $this->configuration['google_maps_api_key'],
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['google_maps_api_key'] = $form_state->getValue('google_maps_api_key');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'groopal_maps_block';
    $build['#conten'][] = $this->configuration['google_maps_api_key'];

    return $build;
  }

}
