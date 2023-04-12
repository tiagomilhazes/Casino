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

// Parse JSON and display in table
function parse_json_display_table()
{
  // Retrieve JSON data

  $json_file_path = plugin_dir_path(__FILE__) . 'data.json'; // Update the file path to your local JSON file
  $json_data = file_get_contents($json_file_path);
  $data = json_decode($json_data, true);

  // Check if data is available
  if (isset($data['toplists']['575']) && !empty($data['toplists']['575'])) {
    // Sort data by position field
    $sorted_data = $data['toplists']['575'];
    usort($sorted_data, function ($a, $b) {
      return $a['position'] - $b['position'];
    });


    // Display data in a table
    echo '<div id=tableContainer>';
    echo '<table>';
    echo '<thead><tr><th>Casino</th><th>Bonus</th><th>Features</th><th>Play</th></tr></thead>';
    echo '<tbody>';
    foreach ($sorted_data as $item) {
      echo '<tr>';
      echo '<td id=review><img id=logo src="' . $item['logo'] . '" alt="Image">'; // Display image in <td>
      echo '<a href="' . $item['brand_id'] . '" target="_blank"> Review </a>'; // Change brand_id to a link
      echo '</td>';
      echo '<td id=bonus><div id=divRating>';
      // Convert rating to stars
      $rating = $item['info']['rating'];
      for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
          echo '<i class="fas fa-star"></i>'; // Font Awesome star icon for filled star
        } else {
          echo '<i class="far fa-star"></i>'; // Font Awesome star icon for empty star
        }
      }
      echo '</div>';
      echo '<span>' . $item['info']['bonus'] . '</span>';
      echo '</td>';
      echo '<ul>';
      echo '<td id=features><li>' . implode('<li>', $item['info']['features']) . '</td>';
      echo '</ul>';
      echo '<td id=play><a id=playButton href="' . $item['play_url'] . '" class="play-now-button" target="_blank">Play Now</a><br>"' . $item['terms_and_conditions'] . '"</td>'; // Add Play Now button with URL from play_url
      echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
  } else {
    echo 'No data available.';
  }
}
add_shortcode('parse_json_table', 'parse_json_display_table');

?>