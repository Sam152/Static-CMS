<?php

// Ensure users are authorised.
require_once 'auth.php';

/**
 * The entry point of the application.
 */
function main() {
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['static_page'])) {
      header('Location: ?static_page=/');
    }
    print get_current_page();
    print build_static_resources();
    exit;
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    return save_to_disk($_GET['static_page'], $_POST['content']);
    exit;
  }
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
  return str_replace('<a href="', '<a href="?static_page=', $html_string);
}

/**
 * Get the HTML matching the current page defined by $_GET[page].
 *
 * @return string
 */
function get_current_page() {
  $page = $_GET['static_page'];
  $file = '..' . ($page == '/' ? '/index.html' : $page);
  $content = file_get_contents($file);
  return replace_links($content);
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
  return '<div id="static-cms-res">' . $res_str . '</div>';
}

/**
 * Save some HTML back to the file system.
 *
 * @param $path
 *   The file to save.
 * @param $content
 *   The content to save it with.
 *
 * @return string
 *   A status for the browser.
 */
function save_to_disk($path, $content) {
  $path = $path == '/' ? 'index.html' : $path;
  $content = str_replace('?static_page=', '', $content);
  return file_put_contents('../' . $path, $content);
}

main();
