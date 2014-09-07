<?php

/**
 * Check if the given user is authorised.
 */
function check_auth() {
  global $conf;
  if ($_SERVER['PHP_AUTH_USER'] !== $conf['username'] && $_SERVER['PHP_AUTH_PW'] !== $conf['password']) {
    header('WWW-Authenticate: Basic realm="CMS"');
    header('HTTP/1.0 401 Unauthorized');
    print 'Could not authorise.';
    die();
  }
}

check_auth();
