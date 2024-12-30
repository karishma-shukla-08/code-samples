<?php
/**
 * Registers a custom Gutenberg block 'Call to Action'.
 *
 * The block displays a customizable call-to-action message with a button.
 *
 * @return void
 *
 * Example usage:
 * // Hook this function into 'init' action.
 * add_action('init', 'register_cta_block');
 */
function register_cta_block() {
    if (!function_exists('register_block_type')) {
        return; // Gutenberg is not available.
    }

    register_block_type('custom/cta', [
        'editor_script'   => 'cta-block-editor-script',
        'render_callback' => 'render_cta_block',
        'attributes'      => [
            'text' => [
                'type'    => 'string',
                'default' => 'Click Here!',
            ],
            'url'  => [
                'type'    => 'string',
                'default' => '#',
            ],
        ],
    ]);

    // Enqueue block editor script.
    wp_register_script(
        'cta-block-editor-script',
        get_template_directory_uri() . '/js/cta-block.js',
        ['wp-blocks', 'wp-element', 'wp-editor'],
        '1.0',
        true
    );
}

/**
 * Renders the 'Call to Action' block on the frontend.
 *
 * @param array $attributes The block attributes.
 * @return string The block's HTML output.
 */
function render_cta_block($attributes) {
    $text = esc_html($attributes['text']);
    $url  = esc_url($attributes['url']);

    return sprintf(
        '<div class="cta-block">
            <a href="%s" class="cta-button">%s</a>
        </div>',
        $url,
        $text
    );
}
