<?php

namespace MyCptUi\Admin;

use MyCptUi\Admin\Screens\FieldsScreen;
use MyCptUi\Admin\Screens\PostTypesScreen;
use MyCptUi\Admin\Screens\TaxonomiesScreen;
use MyCptUi\Domain\FieldManager;
use MyCptUi\Domain\PostTypeManager;
use MyCptUi\Domain\TaxonomyManager;
use MyCptUi\Persistence\OptionsRepository;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Menu {
    private PostTypeManager $post_types;
    private TaxonomyManager $taxonomies;
    private FieldManager $fields;
    private OptionsRepository $repository;
    private Notices $notices;

    public function __construct( PostTypeManager $post_types, TaxonomyManager $taxonomies, FieldManager $fields, OptionsRepository $repository, Notices $notices ) {
        $this->post_types  = $post_types;
        $this->taxonomies  = $taxonomies;
        $this->fields      = $fields;
        $this->repository  = $repository;
        $this->notices     = $notices;
    }

    public function register(): void {
        add_menu_page(
            __( 'Content Types', 'my-cpt-ui' ),
            __( 'Content Types', 'my-cpt-ui' ),
            'manage_options',
            'my-cpt-ui',
            [ $this, 'render_page' ],
            'dashicons-index-card',
            30
        );

        add_submenu_page( 'my-cpt-ui', __( 'Post Types', 'my-cpt-ui' ), __( 'Post Types', 'my-cpt-ui' ), 'manage_options', 'my-cpt-ui', [ $this, 'render_page' ] );
        add_submenu_page( 'my-cpt-ui', __( 'Taxonomies', 'my-cpt-ui' ), __( 'Taxonomies', 'my-cpt-ui' ), 'manage_options', 'my-cpt-ui-taxonomies', [ $this, 'render_taxonomies' ] );
        add_submenu_page( 'my-cpt-ui', __( 'Custom Fields', 'my-cpt-ui' ), __( 'Custom Fields', 'my-cpt-ui' ), 'manage_options', 'my-cpt-ui-fields', [ $this, 'render_fields' ] );
    }

    public function render_page(): void {
        $screen = new PostTypesScreen( $this->repository );
        $screen->render();
    }

    public function render_taxonomies(): void {
        $screen = new TaxonomiesScreen( $this->repository );
        $screen->render();
    }

    public function render_fields(): void {
        $screen = new FieldsScreen( $this->repository );
        $screen->render();
    }
}
