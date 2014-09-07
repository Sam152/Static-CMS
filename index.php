<?php
/**
 * @file
 * Configure the CMS and then upload to any static website directory.
 */

// Set the credentials of the user.
$conf['username'] = 'user';
$conf['password'] = 'user';

// A list of selectors that can be modified by the front-end user.
$conf['selectors'] = 'h1,h2,h3,p,#site-title';

@include_once 'config.php';
require_once 'lib/app.php';
