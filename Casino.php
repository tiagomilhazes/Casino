<?php
/**
 * Plugin Name: Casino Rating
 * Description: A plugin to parse and display data from JSON in a table
 * Version: 1.0
 * Author: Tiago Milhazes
 */

// Plugin code goes here

// Enqueue the CSS
function my_plugin_enqueue_style()
{
  // Register the style
  wp_register_style('styles', plugins_url('/css/style.css', __FILE__), array(), '1.0');
  // Enqueue the style
  wp_enqueue_style('styles');
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
  // Enqueue Font Awesome CSS
  wp_enqueue_style('font-awesome');
}

add_action('wp_enqueue_scripts', 'my_plugin_enqueue_style');

?>