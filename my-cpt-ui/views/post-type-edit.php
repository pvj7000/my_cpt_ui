<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$supports        = [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ];
$is_editing      = ! empty( $editing_post_type );
$post_type_state = $editing_post_type ?? [
    'singular_label'  => '',
    'plural_label'    => '',
    'slug'            => '',
    'public'          => true,
    'show_ui'         => true,
    'show_in_rest'    => true,
    'has_archive'     => false,
    'hierarchical'    => false,
    'supports'        => [ 'title', 'editor' ],
    'menu_icon'       => 'dashicons-admin-post',
    'capability_type' => 'post',
    'menu_position'   => 10,
];
$post_type_state['menu_position'] = $post_type_state['menu_position'] ?? 10;
?>
<div class="my-cpt-ui__card">
    <div class="my-cpt-ui__card-header">
        <div>
            <p class="my-cpt-ui__eyebrow"><?php echo $is_editing ? esc_html__( 'Edit', 'my-cpt-ui' ) : esc_html__( 'Create', 'my-cpt-ui' ); ?></p>
            <h2><?php echo $is_editing ? esc_html__( 'Edit Post Type', 'my-cpt-ui' ) : esc_html__( 'New Post Type', 'my-cpt-ui' ); ?></h2>
            <p class="my-cpt-ui__muted"><?php esc_html_e( 'Define labels, visibility, and supports.', 'my-cpt-ui' ); ?></p>
        </div>
    </div>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="my-cpt-ui__form">
        <?php wp_nonce_field( 'my_cpt_ui_save_post_type' ); ?>
        <input type="hidden" name="action" value="my_cpt_ui_save_post_type" />
        <input type="hidden" name="original_slug" value="<?php echo esc_attr( $is_editing ? $post_type_state['slug'] : '' ); ?>" />
        <div class="my-cpt-ui__grid">
            <div>
                <label class="my-cpt-ui__label" for="singular_label"><?php esc_html_e( 'Singular Label', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="singular_label" id="singular_label" placeholder="Book" value="<?php echo esc_attr( $post_type_state['singular_label'] ); ?>" />
                <?php if ( ! empty( $errors['singular_label'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['singular_label'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label" for="plural_label"><?php esc_html_e( 'Plural Label', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="plural_label" id="plural_label" placeholder="Books" value="<?php echo esc_attr( $post_type_state['plural_label'] ); ?>" />
                <?php if ( ! empty( $errors['plural_label'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['plural_label'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label" for="slug"><?php esc_html_e( 'Slug', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="slug" id="slug" placeholder="book" value="<?php echo esc_attr( $post_type_state['slug'] ); ?>" data-touched="<?php echo $is_editing ? 'true' : 'false'; ?>" />
                <?php if ( ! empty( $errors['slug'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['slug'] ); ?></span>
                <?php endif; ?>
            </div>
            <div class="my-cpt-ui__toggle-group">
                <label><input type="checkbox" name="public" <?php checked( $post_type_state['public'] ); ?> /> <?php esc_html_e( 'Public', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="show_ui" <?php checked( $post_type_state['show_ui'] ); ?> /> <?php esc_html_e( 'Show in Admin', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="show_in_rest" <?php checked( $post_type_state['show_in_rest'] ); ?> /> <?php esc_html_e( 'Expose to REST', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="has_archive" <?php checked( $post_type_state['has_archive'] ); ?> /> <?php esc_html_e( 'Has Archive', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="hierarchical" <?php checked( $post_type_state['hierarchical'] ); ?> /> <?php esc_html_e( 'Hierarchical', 'my-cpt-ui' ); ?></label>
            </div>
            <div>
                <label class="my-cpt-ui__label"><?php esc_html_e( 'Supports', 'my-cpt-ui' ); ?></label>
                <div class="my-cpt-ui__chip-list">
                    <?php foreach ( $supports as $support ) : ?>
                        <label class="my-cpt-ui__chip"><input type="checkbox" name="supports[]" value="<?php echo esc_attr( $support ); ?>" <?php checked( in_array( $support, $post_type_state['supports'] ?? [], true ) ); ?> /> <?php echo esc_html( ucfirst( str_replace( '-', ' ', $support ) ) ); ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="my-cpt-ui__two-col">
                <div>
                    <label class="my-cpt-ui__label" for="capability_type"><?php esc_html_e( 'Capability Type', 'my-cpt-ui' ); ?></label>
                    <input class="my-cpt-ui__input" type="text" name="capability_type" id="capability_type" value="<?php echo esc_attr( $post_type_state['capability_type'] ); ?>" />
                </div>
                <div>
                    <label class="my-cpt-ui__label" for="menu_icon"><?php esc_html_e( 'Menu Icon', 'my-cpt-ui' ); ?></label>
                    <input class="my-cpt-ui__input" type="text" name="menu_icon" id="menu_icon" value="<?php echo esc_attr( $post_type_state['menu_icon'] ); ?>" />
                </div>
            </div>
            <div>
                <label class="my-cpt-ui__label" for="menu_position"><?php esc_html_e( 'Menu Position', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="number" name="menu_position" id="menu_position" value="<?php echo esc_attr( $post_type_state['menu_position'] ); ?>" placeholder="10" />
            </div>
        </div>
        <div class="my-cpt-ui__actions">
            <button type="submit" class="button button-primary"><?php echo $is_editing ? esc_html__( 'Update Post Type', 'my-cpt-ui' ) : esc_html__( 'Save Post Type', 'my-cpt-ui' ); ?></button>
        </div>
    </form>
</div>
