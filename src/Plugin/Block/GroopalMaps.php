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
  	/* All configurations will be updated to be twig variables. possible to keep it simple can have 3 color profiles to choose from
  // need to add field for the following:
  //  Latitude/Longitude for centering,
  //  Zoom
  //  Map Height
  //  Map Width
  //  Map Colors (use google default select + have option for code editor to enter JSON)
  //  Map Options - Relating to UI/UX
  //  Locations - array, needs the following fields: title, address, link, lat, long
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
      '#required'=> TRUE
    ];
    $form['locations'] = array(
      '#type' => 'text_format',
      '#title' => 'Locations',
      '#format' => 'plain_text',
      '#description' => $this->t('Add locations in Javascript array format like above. [["text that displays on click", latitude, longitude],["text that displays on click", latitude, longitude]]'),
      '#default_value' => $this->configuration['locations'],
      '#weight' => '0',
      '#required'=> TRUE
    );
    $form['center_lat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Latitude'),
      '#description' => $this->t('Enter the Latitude for centering the map'),
      '#default_value' => $this->configuration['center_lat'],
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
      '#required'=> TRUE
    ];
    $form['center_long'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Longitude'),
      '#description' => $this->t('Enter the Longitude for centering the map'),
      '#default_value' => $this->configuration['center_long'],
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
      '#required'=> TRUE
    ];
    $form['zoom'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Zoom'),
      '#description' => $this->t('Set zoom index for the map'),
      '#default_value' => 12,
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
      '#required'=> TRUE
    ];
    $form['map_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Height of Map (css)'),
      '#description' => $this->t('Specify height of map in CSS terms (i.e. 20vh or 1500px) *Do not use % value'),
      '#default_value' => '45vh',
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
      '#required'=> TRUE
    ];
    $form['map_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('width of Map (css)'),
      '#description' => $this->t('Specify width of map in CSS terms (i.e. 100%)'),
      '#default_value' => '100%',
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
      '#required'=> TRUE
    ];
    $form['map_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Color Style'),
      '#description' => $this->t('Specify what style profile you would like to use'),
      '#options' => array(
          0 => t('Default'),
         1 => t('Silver'),
         2 => t('Midnight'),
         3 => t('Vintage'),
         4 => t('Groopal'),
       ),
      '#default_value' => $this->configuration['map_style'],
      '#required'=> TRUE
    ];
    $form['disable_ui'] = array (
      '#type' => 'radios',
      '#title' => ('Disable default UI'),
      '#description' => $this->t('This will hide all buttons'),
      '#default_value' => $this->configuration['disable_ui'],
      '#options' => array(
        TRUE =>t('Yes'),
        FALSE =>t('No')
      ),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['google_maps_api_key'] = $form_state->getValue('google_maps_api_key');
    $this->configuration['center_lat'] = $form_state->getValue('center_lat');
    $this->configuration['center_long'] = $form_state->getValue('center_long');
    $this->configuration['zoom'] = $form_state->getValue('zoom');
    $this->configuration['map_height'] = $form_state->getValue('map_height');
    $this->configuration['map_width'] = $form_state->getValue('map_width');
    $this->configuration['map_style'] = $form_state->getValue('map_style');
    $this->configuration['disable_ui'] = $form_state->getValue('disable_ui');
    $this->configuration['locations'] = $form_state->getValue('locations');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'groopal_maps_block';
    $build['#content']['api_key'] = $this->configuration['google_maps_api_key'];
    $build['#content']['lat'] = $this->configuration['center_lat'];
    $build['#content']['long'] = $this->configuration['center_long'];
    $build['#content']['map_zoom'] = $this->configuration['zoom'];
    $build['#content']['height'] = $this->configuration['map_height'];
    $build['#content']['width'] = $this->configuration['map_width'];
    $build['#content']['style'] = $this->configuration['map_style'];
    $build['#content']['ui'] = $this->configuration['disable_ui'];
    $build['#content']['locations'] = $this->configuration['locations'];
    return $build;
  }

}
