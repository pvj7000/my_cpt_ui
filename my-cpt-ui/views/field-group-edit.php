<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$is_editing          = ! empty( $editing_field_group );
$field_group_state   = $editing_field_group ?? [
    'group_id'  => '',
    'title'     => '',
    'locations' => [],
    'fields'    => [],
];
$current_field_count = count( $field_group_state['fields'] );
?>
<div class="my-cpt-ui__card">
    <div class="my-cpt-ui__card-header">
        <div>
            <p class="my-cpt-ui__eyebrow"><?php echo $is_editing ? esc_html__( 'Edit', 'my-cpt-ui' ) : esc_html__( 'Create', 'my-cpt-ui' ); ?></p>
            <h2><?php echo $is_editing ? esc_html__( 'Edit Field Group', 'my-cpt-ui' ) : esc_html__( 'New Field Group', 'my-cpt-ui' ); ?></h2>
            <p class="my-cpt-ui__muted"><?php esc_html_e( 'Attach structured fields to your post types.', 'my-cpt-ui' ); ?></p>
        </div>
    </div>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="my-cpt-ui__form" id="my-cpt-ui-field-group-form">
        <?php wp_nonce_field( 'my_cpt_ui_save_field_group' ); ?>
        <input type="hidden" name="action" value="my_cpt_ui_save_field_group" />
        <input type="hidden" name="original_group_id" value="<?php echo esc_attr( $is_editing ? $field_group_state['group_id'] : '' ); ?>" />
        <div class="my-cpt-ui__grid">
            <div>
                <label class="my-cpt-ui__label" for="group_id"><?php esc_html_e( 'Group Key', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="group_id" id="group_id" placeholder="book_fields" value="<?php echo esc_attr( $field_group_state['group_id'] ); ?>" />
                <?php if ( ! empty( $errors['group_id'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['group_id'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label" for="title"><?php esc_html_e( 'Title', 'my-cpt-ui' ); ?></label>
                <input class="my-cpt-ui__input" type="text" name="title" id="title" placeholder="Book Fields" value="<?php echo esc_attr( $field_group_state['title'] ); ?>" />
                <?php if ( ! empty( $errors['title'] ) ) : ?>
                    <span class="my-cpt-ui__error"><?php echo esc_html( $errors['title'] ); ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label class="my-cpt-ui__label"><?php esc_html_e( 'Attach to Post Types', 'my-cpt-ui' ); ?></label>
                <div class="my-cpt-ui__chip-list">
                    <?php foreach ( $post_types as $post_type ) : ?>
                        <label class="my-cpt-ui__chip"><input type="checkbox" name="locations[]" value="<?php echo esc_attr( $post_type['slug'] ); ?>" <?php checked( in_array( $post_type['slug'], $field_group_state['locations'] ?? [], true ) ); ?> /> <?php echo esc_html( $post_type['plural_label'] ); ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="my-cpt-ui__fieldset">
            <div class="my-cpt-ui__fieldset-header">
                <div>
                    <p class="my-cpt-ui__eyebrow"><?php esc_html_e( 'Fields', 'my-cpt-ui' ); ?></p>
                    <h3><?php esc_html_e( 'Add Fields', 'my-cpt-ui' ); ?></h3>
                </div>
                <button type="button" class="button button-secondary" id="my-cpt-ui-add-field"><?php esc_html_e( 'Add Field', 'my-cpt-ui' ); ?></button>
            </div>
            <div id="my-cpt-ui-fields-container" class="my-cpt-ui__field-rows" aria-live="polite" data-field-count="<?php echo esc_attr( $current_field_count ); ?>">
                <?php if ( empty( $field_group_state['fields'] ) ) : ?>
                    <p class="my-cpt-ui__muted" id="my-cpt-ui-empty-state"><?php esc_html_e( 'No fields yet. Add your first field.', 'my-cpt-ui' ); ?></p>
                <?php else : ?>
                    <?php foreach ( $field_group_state['fields'] as $index => $field ) : ?>
                        <?php $show_choices = ( $field['type'] ?? '' ) === 'select'; ?>
                        <div class="my-cpt-ui__field-row">
                            <div class="my-cpt-ui__field-row-header">
                                <h4><?php esc_html_e( 'Field', 'my-cpt-ui' ); ?></h4>
                                <button type="button" class="my-cpt-ui__remove-field" aria-label="<?php esc_attr_e( 'Remove field', 'my-cpt-ui' ); ?>">&times;</button>
                            </div>
                            <div class="my-cpt-ui__grid">
                                <div>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Field Key', 'my-cpt-ui' ); ?></label>
                                    <input class="my-cpt-ui__input" type="text" name="fields[<?php echo esc_attr( $index ); ?>][field_key]" placeholder="book_isbn" value="<?php echo esc_attr( $field['field_key'] ?? '' ); ?>" />
                                </div>
                                <div>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Label', 'my-cpt-ui' ); ?></label>
                                    <input class="my-cpt-ui__input" type="text" name="fields[<?php echo esc_attr( $index ); ?>][label]" placeholder="ISBN" value="<?php echo esc_attr( $field['label'] ?? '' ); ?>" />
                                </div>
                                <div>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Name', 'my-cpt-ui' ); ?></label>
                                    <input class="my-cpt-ui__input" type="text" name="fields[<?php echo esc_attr( $index ); ?>][name]" placeholder="isbn" value="<?php echo esc_attr( $field['name'] ?? '' ); ?>" />
                                </div>
                                <div>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Type', 'my-cpt-ui' ); ?></label>
                                    <select class="my-cpt-ui__input" name="fields[<?php echo esc_attr( $index ); ?>][type]">
                                        <option value="text" <?php selected( $field['type'] ?? '', 'text' ); ?>><?php esc_html_e( 'Text', 'my-cpt-ui' ); ?></option>
                                        <option value="textarea" <?php selected( $field['type'] ?? '', 'textarea' ); ?>><?php esc_html_e( 'Textarea', 'my-cpt-ui' ); ?></option>
                                        <option value="select" <?php selected( $field['type'] ?? '', 'select' ); ?>><?php esc_html_e( 'Select', 'my-cpt-ui' ); ?></option>
                                        <option value="checkbox" <?php selected( $field['type'] ?? '', 'checkbox' ); ?>><?php esc_html_e( 'Checkbox', 'my-cpt-ui' ); ?></option>
                                    </select>
                                </div>
                                <div>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Default Value', 'my-cpt-ui' ); ?></label>
                                    <input class="my-cpt-ui__input" type="text" name="fields[<?php echo esc_attr( $index ); ?>][default_value]" value="<?php echo esc_attr( $field['default_value'] ?? '' ); ?>" />
                                </div>
                                <div>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Instructions', 'my-cpt-ui' ); ?></label>
                                    <textarea class="my-cpt-ui__input" name="fields[<?php echo esc_attr( $index ); ?>][instructions]" rows="2"><?php echo esc_textarea( $field['instructions'] ?? '' ); ?></textarea>
                                </div>
                                <div>
                                    <label class="my-cpt-ui__label"><input type="checkbox" name="fields[<?php echo esc_attr( $index ); ?>][required]" <?php checked( ! empty( $field['required'] ) ); ?> /> <?php esc_html_e( 'Required', 'my-cpt-ui' ); ?></label>
                                </div>
                                <div class="my-cpt-ui__choices" <?php echo $show_choices ? '' : 'hidden'; ?>>
                                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Choices (value : label)', 'my-cpt-ui' ); ?></label>
                                    <?php $choices = $field['choices'] ?? [ [ 'value' => '', 'label' => '' ] ]; ?>
                                    <?php foreach ( $choices as $choice_index => $choice ) : ?>
                                        <div class="my-cpt-ui__choice-row">
                                            <input class="my-cpt-ui__input" type="text" name="fields[<?php echo esc_attr( $index ); ?>][choices][<?php echo esc_attr( $choice_index ); ?>][value]" placeholder="value" value="<?php echo esc_attr( $choice['value'] ?? '' ); ?>" />
                                            <input class="my-cpt-ui__input" type="text" name="fields[<?php echo esc_attr( $index ); ?>][choices][<?php echo esc_attr( $choice_index ); ?>][label]" placeholder="Label" value="<?php echo esc_attr( $choice['label'] ?? '' ); ?>" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="my-cpt-ui__actions">
            <button type="submit" class="button button-primary"><?php echo $is_editing ? esc_html__( 'Update Field Group', 'my-cpt-ui' ) : esc_html__( 'Save Field Group', 'my-cpt-ui' ); ?></button>
        </div>
    </form>

    <template id="my-cpt-ui-field-template">
        <div class="my-cpt-ui__field-row">
            <div class="my-cpt-ui__field-row-header">
                <h4><?php esc_html_e( 'Field', 'my-cpt-ui' ); ?></h4>
                <button type="button" class="my-cpt-ui__remove-field" aria-label="<?php esc_attr_e( 'Remove field', 'my-cpt-ui' ); ?>">&times;</button>
            </div>
            <div class="my-cpt-ui__grid">
                <div>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Field Key', 'my-cpt-ui' ); ?></label>
                    <input class="my-cpt-ui__input" type="text" name="fields[__INDEX__][field_key]" placeholder="book_isbn" />
                </div>
                <div>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Label', 'my-cpt-ui' ); ?></label>
                    <input class="my-cpt-ui__input" type="text" name="fields[__INDEX__][label]" placeholder="ISBN" />
                </div>
                <div>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Name', 'my-cpt-ui' ); ?></label>
                    <input class="my-cpt-ui__input" type="text" name="fields[__INDEX__][name]" placeholder="isbn" />
                </div>
                <div>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Type', 'my-cpt-ui' ); ?></label>
                    <select class="my-cpt-ui__input" name="fields[__INDEX__][type]">
                        <option value="text"><?php esc_html_e( 'Text', 'my-cpt-ui' ); ?></option>
                        <option value="textarea"><?php esc_html_e( 'Textarea', 'my-cpt-ui' ); ?></option>
                        <option value="select"><?php esc_html_e( 'Select', 'my-cpt-ui' ); ?></option>
                        <option value="checkbox"><?php esc_html_e( 'Checkbox', 'my-cpt-ui' ); ?></option>
                    </select>
                </div>
                <div>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Default Value', 'my-cpt-ui' ); ?></label>
                    <input class="my-cpt-ui__input" type="text" name="fields[__INDEX__][default_value]" />
                </div>
                <div>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Instructions', 'my-cpt-ui' ); ?></label>
                    <textarea class="my-cpt-ui__input" name="fields[__INDEX__][instructions]" rows="2"></textarea>
                </div>
                <div>
                    <label class="my-cpt-ui__label"><input type="checkbox" name="fields[__INDEX__][required]" /> <?php esc_html_e( 'Required', 'my-cpt-ui' ); ?></label>
                </div>
                <div class="my-cpt-ui__choices" hidden>
                    <label class="my-cpt-ui__label"><?php esc_html_e( 'Choices (value : label)', 'my-cpt-ui' ); ?></label>
                    <div class="my-cpt-ui__choice-row">
                        <input class="my-cpt-ui__input" type="text" name="fields[__INDEX__][choices][0][value]" placeholder="value" />
                        <input class="my-cpt-ui__input" type="text" name="fields[__INDEX__][choices][0][label]" placeholder="Label" />
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
