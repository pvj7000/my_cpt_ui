<?php

namespace MyCptUi;

use MyCptUi\Admin\Assets;
use MyCptUi\Admin\Menu;
use MyCptUi\Admin\Notices;
use MyCptUi\Domain\FieldManager;
use MyCptUi\Domain\PostTypeManager;
use MyCptUi\Domain\TaxonomyManager;
use MyCptUi\Persistence\OptionsRepository;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Plugin {
    public const OPTION_NAME = 'my_cpt_ui_config';
    public const VERSION = '0.1.0';

    public static function boot(): void {
        $repository = new OptionsRepository( self::OPTION_NAME );
        $post_types = new PostTypeManager( $repository );
        $taxonomies = new TaxonomyManager( $repository );
        $fields = new FieldManager( $repository );
        $notices = new Notices();

        add_action( 'plugins_loaded', [ self::class, 'load_textdomain' ] );
        add_action( 'init', [ $post_types, 'register_post_types' ], 9 );
        add_action( 'init', [ $taxonomies, 'register_taxonomies' ], 10 );
        add_action( 'init', [ $fields, 'register_fields' ], 11 );

        $menu = new Menu( $post_types, $taxonomies, $fields, $repository, $notices );
        $assets = new Assets();

        add_action( 'admin_menu', [ $menu, 'register' ] );
        add_action( 'admin_enqueue_scripts', [ $assets, 'enqueue' ] );

        do_action( 'my_cpt_ui_bootstrapped' );
    }

    public static function load_textdomain(): void {
        load_plugin_textdomain( 'my-cpt-ui', false, dirname( plugin_basename( __DIR__ . '/../my-cpt-ui.php' ) ) . '/languages/' );
    }
}
