<?php

namespace MyCptUi\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Assets {
    public function enqueue(): void {
        $screen = get_current_screen();
        if ( ! $screen || strpos( $screen->base, 'my-cpt-ui' ) === false ) {
            return;
        }

        wp_enqueue_style( 'my-cpt-ui-admin', plugins_url( 'assets/css/admin.css', dirname( __DIR__ ) . '/../my-cpt-ui.php' ), [], '0.1.0' );
        wp_enqueue_script( 'my-cpt-ui-admin', plugins_url( 'assets/js/admin.js', dirname( __DIR__ ) . '/../my-cpt-ui.php' ), [ 'jquery' ], '0.1.0', true );
    }
}
