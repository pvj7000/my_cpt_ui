<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="my-cpt-ui__card">
    <div class="my-cpt-ui__card-header">
        <div>
            <?php $is_editing = ! empty( $editing_taxonomy ); ?>
            <p class="my-cpt-ui__eyebrow"><?php echo $is_editing ? esc_html__( 'Edit', 'my-cpt-ui' ) : esc_html__( 'Create', 'my-cpt-ui' ); ?></p>
            <h2><?php echo $is_editing ? esc_html__( 'Edit Taxonomy', 'my-cpt-ui' ) : esc_html__( 'New Taxonomy', 'my-cpt-ui' ); ?></h2>
            <p class="my-cpt-ui__muted"><?php esc_html_e( 'Attach taxonomies to one or more post types.', 'my-cpt-ui' ); ?></p>
        </div>
    </div>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="my-cpt-ui__form">
        <?php wp_nonce_field( 'my_cpt_ui_save_taxonomy' ); ?>
        <input type="hidden" name="action" value="my_cpt_ui_save_taxonomy" />
        <input type="hidden" name="original_slug" value="<?php echo esc_attr( $is_editing ? $editing_taxonomy['slug'] : '' ); ?>" />
        <div class="my-cpt-ui__grid">
            <div>
                <label class="my-cpt-ui__label" for="singular_label"><?php esc_html_e( 'Singular Label', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="singular_label" id="taxonomy_singular_label" placeholder="Genre" value="<?php echo esc_attr( $editing_taxonomy['singular_label'] ?? '' ); ?>" />
                <?php if ( ! empty( $errors['singular_label'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['singular_label'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label" for="plural_label"><?php esc_html_e( 'Plural Label', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="plural_label" id="taxonomy_plural_label" placeholder="Genres" value="<?php echo esc_attr( $editing_taxonomy['plural_label'] ?? '' ); ?>" />
                <?php if ( ! empty( $errors['plural_label'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['plural_label'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label" for="slug"><?php esc_html_e( 'Slug', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="slug" id="taxonomy_slug" placeholder="genre" value="<?php echo esc_attr( $editing_taxonomy['slug'] ?? '' ); ?>" data-touched="<?php echo $is_editing ? 'true' : 'false'; ?>" />
                <?php if ( ! empty( $errors['slug'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['slug'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label"><?php esc_html_e( 'Attach to Post Types', 'my-cpt-ui' ); ?></label>
                <div class="my-cpt-ui__chip-list">
                    <?php foreach ( $post_types as $post_type ) : ?>
                        <label class="my-cpt-ui__chip"><input type="checkbox" name="object_type[]" value="<?php echo esc_attr( $post_type['slug'] ); ?>" <?php checked( in_array( $post_type['slug'], $editing_taxonomy['object_type'] ?? [], true ) ); ?> /> <?php echo esc_html( $post_type['plural_label'] ); ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="my-cpt-ui__toggle-group">
                <label><input type="checkbox" name="public" <?php checked( $editing_taxonomy['public'] ?? true ); ?> /> <?php esc_html_e( 'Public', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="show_ui" <?php checked( $editing_taxonomy['show_ui'] ?? true ); ?> /> <?php esc_html_e( 'Show in Admin', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="show_in_rest" <?php checked( $editing_taxonomy['show_in_rest'] ?? true ); ?> /> <?php esc_html_e( 'Expose to REST', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="hierarchical" <?php checked( $editing_taxonomy['hierarchical'] ?? false ); ?> /> <?php esc_html_e( 'Hierarchical', 'my-cpt-ui' ); ?></label>
                <label><input type="checkbox" name="show_admin_column" <?php checked( $editing_taxonomy['show_admin_column'] ?? false ); ?> /> <?php esc_html_e( 'Admin Column', 'my-cpt-ui' ); ?></label>
            </div>
        </div>
        <div class="my-cpt-ui__actions">
            <button type="submit" class="button button-primary"><?php echo $is_editing ? esc_html__( 'Update Taxonomy', 'my-cpt-ui' ) : esc_html__( 'Save Taxonomy', 'my-cpt-ui' ); ?></button>
        </div>
    </form>
</div>
