<?php
/**
 * Plugin Name: Link in bio grid
 * Description: Upload square images to posts and display them in a grid using a shortcode.
 * Version: 1.0
 * Author: Ákos Nikházy
 */

if (!defined('ABSPATH')) {
    exit; 
}
add_action('wp_enqueue_scripts', 'linb_enqueue_styles');
add_action('add_meta_boxes', 'linb_add_meta_box');
add_action('save_post', 'linb_save_meta_box');
add_shortcode('image_grid', 'linb_image_grid_shortcode');
add_action('wp_head', 'linb_add_styles');

function linb_enqueue_styles()
{
    wp_enqueue_style('linb-styles', plugin_dir_url(__FILE__) . 'style.css');
}

function linb_add_meta_box() 
{
    add_meta_box('linb_image_meta_box', 'upload link in bio image', 'linb_render_meta_box', 'post', 'side', 'high');
}

function linb_render_meta_box($post) 
{
    $image = get_post_meta($post->ID, '_linb_square_image', true);
    ?>
    <input type="hidden" id="linb_image" name="linb_image" value="<?php echo esc_attr($image); ?>" />
    <img id="linb_image_preview" src="<?php echo esc_url($image); ?>" style="max-width:100%; height:auto;" />
    <button type="button" class="button" id="linb_upload_image_button">Upload Image</button>
    <script>
        jQuery(document).ready(function($) {
            $('#linb_upload_image_button').click(function(e) {
                e.preventDefault();
                var image_frame;
                if (image_frame) {
                    image_frame.open();
                    return;
                }
                image_frame = wp.media({
                    title: 'Select or Upload an Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                image_frame.on('select', function() {
                    var attachment = image_frame.state().get('selection').first().toJSON();
                    $('#linb_image').val(attachment.url);
                    $('#linb_image_preview').attr('src', attachment.url);
                });
                image_frame.open();
            });
        });
    </script>
    <?php
}

function linb_save_meta_box($post_id) 
{
    if (array_key_exists('linb_image', $_POST)) 
	{
        update_post_meta($post_id, '_linb_square_image', $_POST['linb_image']);
    }
}

function linb_image_grid_shortcode() 
{
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );
	
    $query = new WP_Query($args);
	
    $output = '<div class="linb-image-grid">';
	
    while ($query->have_posts()) 
	{
        
		$query->the_post();
        $image = get_post_meta(get_the_ID(), '_linb_square_image', true);
        
		if ($image)
		{
            $output .= '<div class="linb-grid-item">';
            $output .= '<a href="' . get_permalink() . '"><img src="' . esc_url($image) . '" alt="' . get_the_title() . '" /></a>';
            $output .= '</div>';
        }
    }
	
    $output .= '</div>';
	
    wp_reset_postdata();
	
    return $output;
}

function linb_add_styles() 
{
	wp_enqueue_style('link_in_bio_style', plugin_dir_url(__FILE__) . 'css/link_in_bio.css', array(), time());
}
