<?php

// Ensure users are authorised.
require_once 'auth.php';

/**
 * The entry point of the application.
 */
function main() {
  if (!isset($_GET['page'])) {
    header('Location: ?page=/');
  }
  print get_current_page();
  print build_static_resources();
}

/**
 * Replace links on the page with a ?page= version.
 *
 * @param $html_string
 *   A string of HTML.
 * @return string
 *   Replaced HTML.
 */
function replace_links($html_string) {
  return str_replace('<a href="', '<a href="?page=', $html_string);
}

/**
 * Get the HTML matching the current page defined by $_GET[page].
 *
 * @return string
 */
function get_current_page() {
  $page = $_GET['page'];
  $file = '..' . ($page == '/' ? '/index.html' : $page);
  $content = file_get_contents($file);
  return $content;
}

/**
 * Gather static resources into a string.
 *
 * @return string
 *   A string of HTML.
 */
function build_static_resources() {
  global $conf;
  $res = array(
    'js' => array(
      'files' => glob('lib/js/*'),
      'prefix' => '<script type="text/javascript">',
      'suffix' => '</script>',
    ),
    'css' => array(
      'files' => glob('lib/css/*'),
      'prefix' => '<style type="text/css">',
      'suffix' => '</style>',
    ),
  );
  $res_str = '';
  foreach ($res as $resource) {
    foreach ($resource['files'] as $file) {
      $res_str .= $resource['prefix'] . file_get_contents($file) . $resource['suffix'];
    }
  }
  $res_str .= $res['js']['prefix'] . 'window.Static_CMS_selectors = "' . $conf['selectors'] . '";' . $res['js']['suffix'];
  return $res_str;
}

main();
