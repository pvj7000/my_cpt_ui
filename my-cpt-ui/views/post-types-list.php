<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="my-cpt-ui__card">
    <div class="my-cpt-ui__card-header">
        <div>
            <p class="my-cpt-ui__eyebrow"><?php esc_html_e( 'Overview', 'my-cpt-ui' ); ?></p>
            <h2><?php esc_html_e( 'Post Types', 'my-cpt-ui' ); ?></h2>
            <p class="my-cpt-ui__muted"><?php esc_html_e( 'Registered custom post types and their visibility.', 'my-cpt-ui' ); ?></p>
        </div>
    </div>
    <table class="widefat fixed my-cpt-ui__table">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Name', 'my-cpt-ui' ); ?></th>
                <th><?php esc_html_e( 'Slug', 'my-cpt-ui' ); ?></th>
                <th><?php esc_html_e( 'Status', 'my-cpt-ui' ); ?></th>
                <th><?php esc_html_e( 'Supports', 'my-cpt-ui' ); ?></th>
                <th><?php esc_html_e( 'Actions', 'my-cpt-ui' ); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ( empty( $post_types ) ) : ?>
            <tr>
                <td colspan="4" class="my-cpt-ui__muted"><?php esc_html_e( 'No post types yet. Create your first one below.', 'my-cpt-ui' ); ?></td>
            </tr>
        <?php else : ?>
            <?php foreach ( $post_types as $post_type ) : ?>
                <tr>
                    <td><?php echo esc_html( $post_type['plural_label'] ); ?></td>
                    <td><code><?php echo esc_html( $post_type['slug'] ); ?></code></td>
                    <td><span class="my-cpt-ui__badge is-active"><?php esc_html_e( 'Active', 'my-cpt-ui' ); ?></span></td>
                    <td><?php echo esc_html( implode( ', ', $post_type['supports'] ?? [] ) ); ?></td>
                    <td>
                        <?php if ( ! empty( $post_type['managed'] ) ) : ?>
                            <div class="my-cpt-ui__table-actions">
                                <a class="button" href="<?php echo esc_url( add_query_arg( [ 'page' => 'my-cpt-ui', 'tab' => 'post-types', 'edit' => $post_type['slug'] ], admin_url( 'admin.php' ) ) ); ?>"><?php esc_html_e( 'Edit', 'my-cpt-ui' ); ?></a>
                                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="my-cpt-ui__inline-form my-cpt-ui__delete-form" data-confirm-message="<?php esc_attr_e( 'Delete this post type? This cannot be undone.', 'my-cpt-ui' ); ?>">
                                    <?php wp_nonce_field( 'my_cpt_ui_delete_post_type' ); ?>
                                    <input type="hidden" name="action" value="my_cpt_ui_delete_post_type" />
                                    <input type="hidden" name="slug" value="<?php echo esc_attr( $post_type['slug'] ); ?>" />
                                    <button type="submit" class="button button-link-delete"><?php esc_html_e( 'Delete', 'my-cpt-ui' ); ?></button>
                                </form>
                            </div>
                        <?php else : ?>
                            <span class="my-cpt-ui__muted"><?php esc_html_e( 'Registered elsewhere', 'my-cpt-ui' ); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
