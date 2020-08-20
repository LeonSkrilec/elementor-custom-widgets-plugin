<?php
/*
  Plugin Name: Kranjska Gora Elementor widgets
  Plugin URI: https://kranjska-gora.si
  Description: Custom elementor widgets for Kranjska Gora Wordpress theme
  Text Domain: kranjska-gora-widgets
  Version: 1.0
  Author: Leon Škrilec
 */

  if (! defined('ABSPATH')) {
      exit;
  }

  define("PCEW_PATH", plugin_dir_path(__FILE__));
  define("CUSTOM_WIDGETS_CATEGORY_KEY", 'krg');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  class Kranjska_gora_elementor_widgets
  {
      private static $instance = null;

      public static function get_instance()
      {
          if (! self::$instance) {
              self::$instance = new self;
          }
          return self::$instance;
      }

      public function init()
      {
          add_action('wp_enqueue_scripts', array( $this,'widget_scripts'), 9);

          add_action('elementor/elements/categories_registered', array( $this, 'add_custom_elementor_category' ));
          add_action('elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ]);

          add_filter('wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ]);
      }

      public function get_custom_widgets()
      {
          return [
    "Test",
    "Hero"
  ];
      }

      public function widgets_registered()
      {


    // We check if the Elementor plugin has been installed / activated.
          if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
              // We look for any theme overrides for this custom Elementor element.
              // If no theme overrides are found we use the default one in this plugin.

              $widgets = $this->get_custom_widgets();

              foreach ($widgets as $widget_name) {
                  $widget_file = PCEW_PATH . 'widgets/'.$widget_name.'/'.$widget_name.'.php';
                  if ($widget_file && is_readable($widget_file)) {
                      require_once $widget_file;

                      $class_name = $widget_name;
                      \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class_name);
                  }
              }
          }
      }

      public function widget_scripts()
      {
          //wp_register_script( 'testimonials', plugins_url( 'elements/testimonials/script.js', __FILE__ ), ["custom-jquery"] );
      // wp_register_style( 'icons', get_template_directory_uri().'/css/icons.css', [], '1' );
      // wp_enqueue_style( 'icons' );
      }

      public function wpml_widgets_to_translate_filter($widgets)
      {
          $custom_widgets = $this->get_custom_widgets();

          foreach ($custom_widgets as $widget_name) {
              $widget_file = PCEW_PATH . 'widgets/'.$widget_name.'/'.$widget_name.'.php';
              if ($widget_file && is_readable($widget_file)) {
                  require_once $widget_file;

                  $class_name = $widget_name;
                  $widget = new $class_name;

                  $widget_fields = $widget->translatable();

                  $widgets[$widget->get_name()] = $widget_fields;
              }
          }

          return $widgets;
      }

      public function add_custom_elementor_category($elements_manager)
      {
          $elements_manager->add_category(
              CUSTOM_WIDGETS_CATEGORY_KEY,
              [
        'title' => 'Kranjska Gora',
        'icon'  => 'fa fa-plug',
        ]
          );
      
          $reorder_cats = function () {
              uksort($this->categories, function ($keyOne, $keyTwo) {
                  if (substr($keyOne, 0, 4) == CUSTOM_WIDGETS_CATEGORY_KEY) {
                      return -1;
                  }
                  if (substr($keyTwo, 0, 4) == CUSTOM_WIDGETS_CATEGORY_KEY) {
                      return 1;
                  }
                  return 0;
              });
          };
          $reorder_cats->call($elements_manager);
      }
  }

Kranjska_gora_elementor_widgets::get_instance()->init();