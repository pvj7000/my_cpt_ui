<?php
/**
 * Plugin Name: My CPT UI
 * Description: Minimal UI for managing custom post types, taxonomies, and custom fields.
 * Version: 0.1.0
 * Author: CentralDev
 * Text Domain: my-cpt-ui
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

MyCptUi\Plugin::boot();
