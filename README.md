# My CPT UI

A lightweight WordPress dashboard plugin for creating and managing custom post types, taxonomies, and reusable custom field groups without writing code.

## Requirements
- WordPress 6.4 or later
- PHP 8.0 or later
- Administrator capability (`manage_options`) to access the UI

## Installation
1. Upload the plugin folder to your site's `/wp-content/plugins/` directory.
2. Activate **My CPT UI** from **Plugins → Installed Plugins**.
3. Open **Content Types** in the admin menu to begin configuring post types, taxonomies, and fields.

## Usage
### Managing post types
1. Go to **Content Types → Post Types**.
2. Fill **Singular label**, **Plural label**, and **Slug**. The slug auto-fills from the singular label but can be edited.
3. Toggle visibility options (public, show UI, REST support), choose supported features (title, editor, etc.), and optionally set menu icon/position.
4. Click **Save Post Type**. Existing items can be edited via the **Edit** action or removed with the delete action (a confirmation dialog prevents accidental removal).

### Managing taxonomies
1. Go to **Content Types → Taxonomies**.
2. Provide labels, slug, and select the post types the taxonomy attaches to.
3. Configure REST, UI, hierarchy, and admin column options as needed.
4. Save the taxonomy. Use **Edit** to change it later or **Delete** (with confirmation) to remove it.

### Managing field groups
1. Go to **Content Types → Custom Fields**.
2. Choose a **Group key** and **Title**, then select the post types where the group should appear.
3. Add fields via **Add field**, setting the label, name, type (text, textarea, select, checkbox), optional instructions, default value, and choices for select fields.
4. Save the field group. The fields appear as meta boxes on the selected post types and are exposed in the REST API as single-value post meta.

## Hooks
- `my_cpt_ui_post_types`, `my_cpt_ui_taxonomies`, `my_cpt_ui_field_groups` — filter saved configuration before registration.
- `my_cpt_ui_post_type_args`, `my_cpt_ui_taxonomy_args` — filter arguments before registering with WordPress.
- `my_cpt_ui_post_type_saved`, `my_cpt_ui_post_type_deleted`, `my_cpt_ui_taxonomy_saved`, `my_cpt_ui_taxonomy_deleted`, `my_cpt_ui_field_group_saved`, `my_cpt_ui_field_group_deleted` — action hooks for lifecycle events.

## Notes and best practices
- After creating or deleting post types or taxonomies on production sites, flush permalinks by visiting **Settings → Permalinks → Save Changes** to avoid 404s.
- Limit access to trusted administrators; all management routes already check for `manage_options` capability and nonces.
- When adding many custom fields, keep labels concise and provide clear instructions to improve editor usability.

## Support & development
- Development dependencies are installed via Composer (`composer install`).
- To customize styling or behavior, edit files in `assets/` and `views/`, then clear any admin caches to see changes.
