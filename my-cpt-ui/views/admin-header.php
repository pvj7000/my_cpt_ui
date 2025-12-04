<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$current_page = $_GET['page'] ?? 'my-cpt-ui';
$base_url     = admin_url( 'admin.php' );
?>
<div class="wrap my-cpt-ui">
    <h1 class="my-cpt-ui__title"><?php esc_html_e( 'Content Types', 'my-cpt-ui' ); ?></h1>
    <nav class="my-cpt-ui__tabs" aria-label="<?php esc_attr_e( 'Content Type tabs', 'my-cpt-ui' ); ?>">
        <a class="my-cpt-ui__tab <?php echo $current_page === 'my-cpt-ui' ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'page' => 'my-cpt-ui' ], $base_url ) ); ?>">
            <?php esc_html_e( 'Post Types', 'my-cpt-ui' ); ?>
        </a>
        <a class="my-cpt-ui__tab <?php echo $current_page === 'my-cpt-ui-taxonomies' ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'page' => 'my-cpt-ui-taxonomies' ], $base_url ) ); ?>">
            <?php esc_html_e( 'Taxonomies', 'my-cpt-ui' ); ?>
        </a>
        <a class="my-cpt-ui__tab <?php echo $current_page === 'my-cpt-ui-fields' ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'page' => 'my-cpt-ui-fields' ], $base_url ) ); ?>">
            <?php esc_html_e( 'Custom Fields', 'my-cpt-ui' ); ?>
        </a>
    </nav>
    <?php if ( ! empty( $updated ) ) : ?>
        <div class="my-cpt-ui__notice success">
            <span><?php esc_html_e( 'Saved successfully.', 'my-cpt-ui' ); ?></span>
        </div>
    <?php endif; ?>
    <?php if ( ! empty( $errors ) ) : ?>
        <div class="my-cpt-ui__notice error">
            <span><?php esc_html_e( 'Please fix the highlighted fields.', 'my-cpt-ui' ); ?></span>
        </div>
    <?php endif; ?>
</div>
