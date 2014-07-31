<?php
   /*
   Plugin Name: People Directory Custom Post Type
   Plugin URI: http://stephen-chapman.com
   Description: A plugin to add a custom post type for people
   Version: 0.1
   Author: Stephen Chapman
   Author URI: http://stephen-chapman.com
   License: GPL2
   */


   add_action( 'init', 'create_people_dir' ); // Execute the custom function named create_movie_review during the initialization phase every time a page is generated.

   function create_px_people() {
    register_post_type( 'people_dir',
        array(
            'labels' => array(
                'name' => 'People',
                'singular_name' => 'Person',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Person',
                'edit' => 'Edit',
                'edit_item' => 'Edit Person',
                'new_item' => 'New Person',
                'view' => 'View',
                'view_item' => 'View Person',
                'search_items' => 'Search People',
                'not_found' => 'No People found',
                'not_found_in_trash' => 'No People found in Trash',
                'parent' => 'Parent Person'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'taxonomies' => array( '' ),
            'menu_icon' => 'dashicons-groups', // 16x16 pixel image
            'has_archive' => true,
            'rewrite' => array('slug' => 'people')
        )
    );
}

	add_action( 'admin_init', 'my_admin' ); // Registers a function to be called when the WordPress admin interface is visited

	function my_admin() {
    add_meta_box( 'people_dir_meta_box', // Registers a meta box and associates it with the px_people custom post type
        'Person Bio',
        'display_people_dir_meta_box',
        'people_dir', 'side', 'core'
    );
}
 	// Render the contents of the meta box
	function display_people_dir_meta_box( $people_dir ) {
	    
	    $staff_position = esc_html( get_post_meta( $people_dir->ID, 'staff_position', true ) );
	    ?>
	    <table>
	        <tr>
	            <td style="width: 100%">Staff Position</td>
	            <td><input type="text" name="staff_position" value="<?php echo $staff_position; ?>" /></td>
	        </tr>
	    </table>
	    <?php
	}

// This function is executed when posts are saved or deleted from the admin panel
function add_people_dir_fields( $people_dir_id, $people_dir ) {
    // Check post type for movie reviews
    if ( $people_dir->post_type == 'people_dir' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['staff_position'] ) && $_POST['staff_position'] != '' ) {
            update_post_meta( $people_dir_id, 'media_source', $_POST['staff_position'] );
        }
    }
}

add_action( 'save_post', 'add_people_dir_fields', 10, 1 ); // This function is called when posts get saved in the database.

?>