<?php

Class ACF_User_Documentation {

	var $default_args = array(
		'allowed_users' => array(1,'admin')
	);

	var $path_to_dir;

	/**
	 * init()
	 * 
	 * @return void
	 */
		function init(){

			//	Get the Current Path to this Directory
	  		$this->path_to_dir = substr( __DIR__, strpos( __DIR__, '/wp-content' ));

			//	Sort out the arguments
			$args = array();
			$args = apply_filters( 'acf_user_documentation_args', $args );
			$this->default_args = array_merge( $this->default_args, $args );

			//	Adding the 'User Documentation' Tab
			add_action( 'admin_menu', array( $this, 'add_menu_tab' ) );

			//	Enqueue ACF admin scripts and Styles
			add_action('admin_head', array( &$this, 'enqueue_admin_scripts' ));

			//	Setup the Documentation Post Type
			add_action( 'init', array( $this, 'register_doc_post_type' ), 0 );

			//	CSS style for specific users
			add_action('admin_head', array( $this, 'global_admin_doc_styles' ) );

		}

	 /**
	  * enqueue_admin_scripts()
	  * 
	  * Enqueue admin scripts and style sheets.
	  *
	  * @return void
	  */

		function enqueue_admin_scripts() {

			//	acf-user-documentation js
			wp_register_script( 'acf-user-documentation-js', $this->path_to_dir . '/assets/js/acf-user-documentation.js', array( 'jquery' ) );
			wp_enqueue_script( 'acf-user-documentation-js' );

			//	acf-user-documentation css
			wp_register_style( 'acf-user-documentations-css', $this->path_to_dir . '/assets/css/acf-user-documentation.css', '', '', 'screen' );
	        wp_enqueue_style( 'acf-user-documentations-css' );

		}

	/**
	 * add_menu_tab()
	 *
	 * Creates the backend page that displays all user doc posts
	 *
	 * @return void
	 */
		function add_menu_tab(){

			add_menu_page( 
				__( 'User Documentation - MiNDFOOD' ),
				__( 'User Documentation' ),
				'administrator',
				'user-documentation',
				array( $this, 'get_page' )
			);

		}

	/**
	 * global_admin_doc_styles()
	 * 
	 * @return void
	 */
	function global_admin_doc_styles() {

		$user = wp_get_current_user();
		$user_data = $user->data;

		if( !in_array( $user->ID, $this->default_args['allowed_users'] ) && !in_array( $user_data->user_login, $this->default_args['allowed_users'] ) ): ?>

		<style>
			#menu-posts-user-doc{
				display: none;
			}
		</style>

		<?php endif;
	}

	/**
	 * register_doc_post_type()
	 *
	 * Sets up the custom post type required for this plugin
	 * 
	 * @return void
	 */
	function register_doc_post_type(){

		$post_name_singular = 'User Doc';
		$post_name_slug 	= 'user-doc';
		$post_name_plural 	= 'User Docs';

		$labels = array(
			'name'                => _x( $post_name_singular, 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( $post_name_singular, 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( $post_name_plural, 'text_domain' ),
			'all_items'           => __( 'All '.$post_name_plural, 'text_domain' ),
			'view_item'           => __( 'View '.$post_name_singular, 'text_domain' ),
			'add_new_item'        => __( 'Add New '.$post_name_singular, 'text_domain' ),
			'add_new'             => __( 'New '.$post_name_singular, 'text_domain' ),
			'edit_item'           => __( 'Edit '.$post_name_singular, 'text_domain' ),
			'update_item'         => __( 'Update '.$post_name_singular, 'text_domain' ),
			'search_items'        => __( 'Search '.$post_name_plural, 'text_domain' ),
			'not_found'           => __( 'No '.$post_name_plural.' found', 'text_domain' ),
			'not_found_in_trash'  => __( 'No '.$post_name_plural.' found in Trash', 'text_domain' ),

		);

		$args = array(
			'label'               => __( $post_name_plural, 'text_domain' ),
			'description'         => __( $post_name_plural, 'text_domain' ),
			'labels'              => $labels,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'tags' ),
			'hierarchical'        => true,
			'show_ui'             => true,
			'menu_position'       => 100,
			'capability_type'     => 'post',
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'has_archive' 		  => false,
			'rewrite' => array(
				'slug' => 'style',
				'with_front' => true 
			)
		);

		register_post_type( $post_name_slug , $args );

	}

	/**
	 * get_page()
	 *
	 * HTML for the User Documentation page
	 * 
	 * @return void
	 */
	function get_page(){

		global $post;

		$args = array(
			'post_type' => array( 'user-doc' ),
			'post_status' => 'publish'
		);

		$WP_query = null;
		$WP_query = new WP_Query($args);

		//	Print the Nav menu for the Documentation
		echo "<ul id=\"doc-links\">";

			echo "<li><h3><a href=\"#doc-links\">Contents:</a></h3></li>";

		if( $WP_query->have_posts() ) while ($WP_query->have_posts()) : $WP_query->the_post();

			echo "<li><a href=\"#{$post->post_name}\">".get_the_title()."</a></li>";

		endwhile;

		echo "</ul>";

		//	Rewind the loop
		rewind_posts();

		//	Begin the Documentation loop
		if( $WP_query->have_posts() ) while ( $WP_query->have_posts() ) : $WP_query->the_post();

			echo "<div id=\"{$post->post_name}\" class=\"doc-content\">";

				echo "<h2>".get_the_title()."</h2>";

				the_content();

			echo "</div>";

		endwhile;

	}

}

$user_docs = new ACF_User_Documentation;

$user_docs->init();

