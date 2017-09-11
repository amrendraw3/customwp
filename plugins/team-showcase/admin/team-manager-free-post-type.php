<?php

	/*
	* @Author 		Themepoints
	* Copyright: 	2016 Themepoints
	* Version : 1.2
	*/

if ( ! defined( 'ABSPATH' ) )

	die("Can't load this file directly");	

	/*===================================================================
		Register Custom Post Function
	=====================================================================*/

	function team_manager_free_custom_post_type(){
			$labels = array(
				'name'                  => _x( 'Team Showcase', 'Post Type General Name', 'team-manager-free' ),
				'singular_name'         => _x( 'Team Showcase', 'Post Type Singular Name', 'team-manager-free' ),
				'menu_name'             => __( 'Team Showcase', 'team-manager-free' ),
				'name_admin_bar'        => __( 'Team Manager', 'team-manager-free' ),
				'parent_item_colon'     => __( 'Parent Item:', 'team-manager-free' ),
				'all_items'             => __( 'All Members', 'team-manager-free' ),
				'add_new_item'          => __( 'Add New Member', 'team-manager-free' ),
				'add_new'               => __( 'Add New Member', 'team-manager-free' ),
				'new_item'              => __( 'New Member', 'team-manager-free' ),
				'edit_item'             => __( 'Edit Member', 'team-manager-free' ),
				'update_item'           => __( 'Update Member', 'team-manager-free' ),
				'view_item'             => __( 'View Member', 'team-manager-free' ),
				'search_items'          => __( 'Search Member', 'team-manager-free' ),
				'not_found'             => __( 'Not found', 'team-manager-free' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'team-manager-free' ),
				'items_list'            => __( 'Items list', 'team-manager-free' ),
				'items_list_navigation' => __( 'Items list navigation', 'team-manager-free' ),
				'filter_items_list'     => __( 'Filter items list', 'team-manager-free' ),
			);
			$args = array(
				'label'                 => __( 'Post Type', 'team-manager-free' ),
				'description'           => __( 'Post Type Description', 'team-manager-free' ),
				'labels'                => $labels,
				'supports'              =>  array( 'title', 'editor', 'thumbnail',),
				'hierarchical'          => false,
				'public'                => true,
				'menu_icon' 			=> 'dashicons-admin-users',
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,		
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
			);
			register_post_type( 'team_mf', $args );

		}
		// end custom post type
	add_action('init', 'team_manager_free_custom_post_type');


	function team_manager_free_custom_post_taxonomies_reg() {
		  $labels = array(
			'name'              => _x( 'Team Groups', 'taxonomy general name' ),
			'singular_name'     => _x( 'Team Group', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Groups' ),
			'all_items'         => __( 'All Groups' ),
			'parent_item'       => __( 'Parent Group' ),
			'parent_item_colon' => __( 'Parent Group:' ),
			'edit_item'         => __( 'Edit Group' ), 
			'update_item'       => __( 'Update Group' ),
			'add_new_item'      => __( 'Add New Group' ),
			'new_item_name'     => __( 'New Group' ),
			'menu_name'         => __( 'Team Groups' ),
		  );
		  $args = array(
			'labels' => $labels,
			'hierarchical' => true,
		  );
		  register_taxonomy( 'team_mfcategory', 'team_mf', $args );
	}
	add_action( 'init', 'team_manager_free_custom_post_taxonomies_reg', 0 );

 
	function team_manager_free_admin_enter_title( $input ) {
		global $post_type;

		if ( 'team_mf' == $post_type )
			return __( 'Enter Member Name', 'team-manager-free' );

		return $input;
	}
	add_filter( 'enter_title_here', 'team_manager_free_admin_enter_title' );


	function team_manager_free_custom_post_help($content){
		global $post_type,$post;
		if ($post_type == 'team_mf') {
			if(!has_post_thumbnail( $post->ID )){
			   $content .= '<p>'.__('Please upload square-cropped photos with a minimum dimension of 500px','team-manager-free').'</p>';
			}
		}
		return $content;
	}
	add_filter('admin_post_thumbnail_html','team_manager_free_custom_post_help');


	function team_manager_free_custom_post_updated_messages( $messages ) {
		global $post, $post_id;
		$messages['team_mf'] = array(
			1 => __('Team Showcase updated.', 'team-manager-free'),
			2 => $messages['post'][2],
			3 => $messages['post'][3],
			4 => __('Team Showcase updated.', 'team-manager-free'),
			5 => isset($_GET['revision']) ? sprintf( __('Team Showcase restored to revision from %s', 'team-manager-free'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Team Showcase published.', 'team-manager-free'),
			7 => __('Team Showcase saved.', 'team-manager-free'),
			8 => __('Team Showcase submitted.', 'team-manager-free'),
			9 => sprintf( __('Team Showcase scheduled for: <strong>%1$s</strong>.', 'team-manager-free'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
			10 => __('Team Showcase draft updated.', 'team-manager-free'),
		);
		return $messages;
	}
	add_filter( 'post_updated_messages', 'team_manager_free_custom_post_updated_messages' );	



	
	function team_manager_free_custom_post_add_submenu_items(){
		add_submenu_page('edit.php?post_type=team_mf', __('Create Shortcode', 'team-manager-free'), __('Create Shortcode', 'team-manager-free'), 'manage_options', 'post-new.php?post_type=team_mf_team');
	}
	add_action('admin_menu', 'team_manager_free_custom_post_add_submenu_items');


	function team_manager_free_custom_post_create_team_type() {

	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Shortcodes', 'Post Type General Name', 'team-manager-free' ),
			'singular_name'       => _x( 'Shortcode', 'Post Type Singular Name', 'team-manager-free' ),
			'menu_name'           => __( 'Shortcodes', 'team-manager-free' ),
			'parent_item_colon'   => __( 'Parent Shortcode', 'team-manager-free' ),
			'all_items'           => __( 'All Shortcodes', 'team-manager-free' ),
			'view_item'           => __( 'View Shortcode', 'team-manager-free' ),
			'add_new_item'        => __( 'Create New Shortcode', 'team-manager-free' ),
			'add_new'             => __( 'Add New Shortcode', 'team-manager-free' ),
			'edit_item'           => __( 'Edit Shortcode', 'team-manager-free' ),
			'update_item'         => __( 'Update Shortcode', 'team-manager-free' ),
			'search_items'        => __( 'Search Shortcode', 'team-manager-free' ),
			'not_found'           => __( 'Not Found', 'team-manager-free' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'team-manager-free' ),
		);

	// Set other options for Custom Post Type

		$args = array(
			'label'               => __( 'Shortcodes', 'team-manager-free' ),
			'description'         => __( 'Shortcode news and reviews', 'team-manager-free' ),
			'labels'              => $labels,
			'supports'            => array( 'title'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu' 		  => 'edit.php?post_type=team_mf',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		// Registering your Custom Post Type
		register_post_type( 'team_mf_team', $args );

	}

	add_action( 'init', 'team_manager_free_custom_post_create_team_type');	

	function team_manager_free_team_mf_team_admin_enter_title( $input ) {
		global $post_type;

		if ( 'team_mf_team' == $post_type )
			return __( 'Enter Shortcode Name For Identity', 'team-manager-free' );

		return $input;
	}
	add_filter( 'enter_title_here', 'team_manager_free_team_mf_team_admin_enter_title' );

	
	function team_manager_free_custom_post_team_mf_team_updated_messages( $messages ) {
		global $post, $post_id;
		$messages['team_mf_team'] = array( 
			1 => __('Shortcode updated.', 'team-manager-free'),
			2 => $messages['post'][2],
			3 => $messages['post'][3],
			4 => __('Shortcode updated.', 'team-manager-free'),
			5 => isset($_GET['revision']) ? sprintf( __('Shortcode restored to revision from %s', 'team-manager-free'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Shortcode published.', 'team-manager-free'),
			7 => __('Shortcode saved.', 'team-manager-free'),
			8 => __('Shortcode submitted.', 'team-manager-free'),
			9 => sprintf( __('Shortcode scheduled for: <strong>%1$s</strong>.', 'team-manager-free'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
			10 => __('Shortcode draft updated.', 'team-manager-free'),
		);
		return $messages;
	}
	add_filter( 'post_updated_messages', 'team_manager_free_custom_post_team_mf_team_updated_messages' );
	


	/*----------------------------------------------------------------------
		Add Meta Box 
	----------------------------------------------------------------------*/
	function team_manager_free_custom_post_meta_box() {
		add_meta_box(
			'custom_meta_box', // $id
			'Member Details', // $title
			'team_manager_free_custom_inner_custom_boxes', // $callback
			'team_mf', // $page
			'normal', // $context
			'high'); // $priority
		add_meta_box(
			'custom_meta_box2', // $id
			'Member Social Info', // $title
			'team_manager_free_custom_inner_custom_boxess', // $callback
			'team_mf', // $page
			'normal'
		);
	}
	add_action('add_meta_boxes', 'team_manager_free_custom_post_meta_box');

	/*----------------------------------------------------------------------
		Content Options Meta Box 
	----------------------------------------------------------------------*/
	
	function team_manager_free_custom_inner_custom_boxes( $post ) {

		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'team_manager_free_custom_inner_custom_boxes_noncename' );

		?>

		<div id="details_profiles_area">
			<div class="details_profiles_cols">
				<!-- Designation -->
				<p><label for="post_title_designation"><strong><?php _e('Designation', 'team-manager-free');?></strong></label></p>
				<input type="text" name="post_title_designation" placeholder="Designation" id="post_title_designation" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'client_designation', true); ?>" />

				<!-- Address  -->
				<p><label for="client_address_input"><strong><?php _e('Address', 'team-manager-free');?></strong></label></p>
				<input type="text" name="client_address_input" placeholder="Winston Salem, NC" id="client_address_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'company_address', true); ?>" />

				<!-- Contact Number -->
				<p><label for="contact_number_input"><strong><?php _e('Contact Number', 'team-manager-free');?></strong></label></p>
				<input type="text" name="contact_number_input" placeholder="xxx-xxx-xxxx" id="contact_number_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'contact_number', true); ?>" />
			</div>
			<div class="details_profiles_cols">
				<!-- Contact Email -->
				<p><label for="contact_email_input"><strong><?php _e('Email', 'team-manager-free');?></strong></label></p>
				<input type="text" name="contact_email_input" placeholder="email@exapmle.com" id="contact_email_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'contact_email', true); ?>" />

				<!-- Description -->
				<p><label for="short_description_input"><strong><?php _e('Short Description (Max 140 characters)', 'team-manager-free');?></strong></label></p>
				<textarea name="short_description_input" id="short_description_input" class="regular-text code" cols="30" rows="4" maxlength="140"><?php echo get_post_meta($post->ID, 'client_shortdescription', true); ?></textarea>
			</div>
		</div>
		<?php
	}
	
	function team_manager_free_custom_inner_custom_boxess( $post ) {
		?>
		<div id="details_profiles_area">
			<div class="details_profiles_cols">
				<!-- Facebook -->
				<p><label for="facebook_social_input"><strong><?php _e('Facebook', 'team-manager-free');?></strong></label></p>
				<input type="text" name="facebook_social_input" placeholder="http://exapmle.com/username" id="facebook_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_facebook', true); ?>" />

				<!-- Twitter -->
				<p><label for="twitter_social_input"><strong><?php _e('Twitter', 'team-manager-free');?></strong></label></p>
				<input type="text" name="twitter_social_input" placeholder="http://exapmle.com/username" id="twitter_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_twitter', true); ?>" />

				<!-- Google plus -->
				<p><label for="googleplus_social_input"><strong><?php _e('Google Plus', 'team-manager-free');?></strong></label></p>
				<input type="text" name="googleplus_social_input" placeholder="http://exapmle.com/username" id="googleplus_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_googleplus', true); ?>" />

				<!-- Instagram -->
				<p><label for="instagram_social_input"><strong><?php _e('Instagram', 'team-manager-free');?></strong></label></p>
				<input type="text" name="instagram_social_input" placeholder="http://exapmle.com/username (Only Pro)" id="instagram_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_instagram', true); ?>" />
			</div>
			<div class="details_profiles_cols">
				<!-- Pinterest -->
				<p><label for="pinterest_social_input"><strong><?php _e('Pinterest', 'team-manager-free');?></strong></label></p>
				<input type="text" name="pinterest_social_input" placeholder="http://exapmle.com/username (Only Pro)" id="pinterest_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_pinterest', true); ?>" />

				<!-- LinkedIn -->
				<p><label for="linkedIn_social_input"><strong><?php _e('LinkedIn', 'team-manager-free');?></strong></label></p>
				<input type="text" name="linkedIn_social_input" placeholder="http://exapmle.com/username (Only Pro)" id="linkedIn_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_linkedin', true); ?>" />

				<!-- Dribbble -->
				<p><label for="dribbble_social_input"><strong><?php _e('Dribbble', 'team-manager-free');?></strong></label></p>
				<input type="text" name="dribbble_social_input" placeholder="http://exapmle.com/username (Only Pro)" id="dribbble_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_dribbble', true); ?>" />

				<!-- Youtube -->
				<p><label for="youtube_social_input"><strong><?php _e('Youtube', 'team-manager-free');?></strong></label></p>
				<input type="text" name="youtube_social_input" placeholder="http://exapmle.com/username (Only Pro)" id="youtube_social_input" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'social_youtube', true); ?>" />
			</div>
		</div>
		<?php
	}
	
	
	

	# Save Options Meta Box Function
	function team_manager_free_custom_inner_custom_boxes_save($post_id){

		if(isset($_POST['post_title_designation'])) {
			update_post_meta($post_id, 'client_designation', $_POST['post_title_designation']);
		}

		if(isset($_POST['short_description_input'])) {
			update_post_meta($post_id, 'client_shortdescription', $_POST['short_description_input']);
		}

		if(isset($_POST['client_address_input'])) {
			update_post_meta($post_id, 'company_address', $_POST['client_address_input']);
		}

		if(isset($_POST['contact_number_input'])) {
			update_post_meta($post_id, 'contact_number', $_POST['contact_number_input']);
		}

		if(isset($_POST['contact_email_input'])) {
			update_post_meta($post_id, 'contact_email', $_POST['contact_email_input']);
		}

		if(isset($_POST['facebook_social_input'])) {
			update_post_meta($post_id, 'social_facebook', $_POST['facebook_social_input']);
		}

		if(isset($_POST['twitter_social_input'])) {
			update_post_meta($post_id, 'social_twitter', $_POST['twitter_social_input']);
		}

		if(isset($_POST['googleplus_social_input'])) {
			update_post_meta($post_id, 'social_googleplus', $_POST['googleplus_social_input']);
		}
	}
	add_action('save_post', 'team_manager_free_custom_inner_custom_boxes_save');


	# Columns Declaration Function
	function team_manager_free_columns($team_manager_free_columns){

		$order='asc';
		if($_GET['order']=='asc') {
			$order='desc';
		}
		$team_manager_free_columns = array(
			"cb" 		=> "<input type=\"checkbox\" />",
			"thumbnail" => __('Image', 'team-manager-free'),
			"title" 	=> __('Name', 'team-manager-free'),
			"client_shortdescription" => __('Short Description', 'team-manager-free'),
			"client_designation" => __('Designation', 'team-manager-free'),
			"ktstcategories" => __('Groups', 'team-manager-free'),
			"date" => __('Date', 'team-manager-free'),
		);
		return $team_manager_free_columns;
	}

	# testimonial Value Function
	function team_manager_free_columns_display($team_manager_free_columns, $post_id){

		global $post;
		$width = (int) 80;
		$height = (int) 80;

		if ( 'thumbnail' == $team_manager_free_columns ) {
			if ( has_post_thumbnail($post_id)) {
				$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
				echo $thumb;
			}
			else {
				echo __('None');
			}
		}

		if ( 'client_designation' == $team_manager_free_columns ) {
			echo get_post_meta($post_id, 'client_designation', true);
		}
		if ( 'client_shortdescription' == $team_manager_free_columns ) {
			echo get_post_meta($post_id, 'client_shortdescription', true);
		}
		if ( 'ktstcategories' == $team_manager_free_columns ) {
			$terms = get_the_terms( $post_id , 'team_mfcategory');
			$count = count($terms);
			if ( $terms ){
				$i = 0;
				foreach ( $terms as $term ) {
					echo '<a href="'.admin_url( 'edit.php?post_type=team_mf&team_mfcategory='.$term->slug ).'">'.$term->name.'</a>';	
					
					if($i+1 != $count) {
						echo " , ";
					}
					$i++;
				}
			}
		}
	}
	
	# Add manage_tmls_posts_columns Filter 
	add_filter("manage_team_mf_posts_columns", "team_manager_free_columns");
	add_action("manage_team_mf_posts_custom_column",  "team_manager_free_columns_display", 10, 2 );	


	function team_manager_free_add_shortcode_column( $columns ) {
		return array_merge( $columns,
			array( 'shortcode' => __( 'Shortcode', 'team-manager-free' ) ) );
	}
	add_filter( 'manage_team_mf_team_posts_columns' , 'team_manager_free_add_shortcode_column' );

	function team_manager_free_add_posts_shortcode_display( $column, $post_id ) {
		if ($column == 'shortcode'){
			?>
			<input style="background:#ddd" type="text" onClick="this.select();" value="[tmfshortcode <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" /><br />
		  <textarea cols="50" rows="1" style="background:#ddd" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[tmfshortcode id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea>
			<?php
		}
	}
	add_action( 'manage_team_mf_team_posts_custom_column' , 'team_manager_free_add_posts_shortcode_display', 10, 2 );

	/*=====================================================================
		Register Post Meta Boxes
	=======================================================================*/
	function team_manager_free_add_metabox() {
		$screens = array('team_mf_team');
		foreach ($screens as $screen) {
			add_meta_box('team_manager_free_sectionid', __('Team Options', 'team-manager-free'),'single_team_manager_free_display', $screen,'normal','high');
		}
	} // end metabox boxes

	add_action('add_meta_boxes', 'team_manager_free_add_metabox');
		
		
	/*=====================================================================
	 * Renders the nonce and the textarea for the notice.
	 =======================================================================*/
	function single_team_manager_free_display( $post ) {
	global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
	
	<div id="tabs-container">
		<ul class="tabs-menu">
			<li>
				<a href="#tab-1"><i class="fa fa-gear"></i><?php _e('Team Settings', 'team-manager-free')?></a>
			</li>
			<li>
				<a href="#tab-2"><i class="fa fa-paint-brush" aria-hidden="true"></i><?php _e('Color Settings', 'team-manager-free')?></a>
			</li>
			<li>
				<a href="#tab-3"><i class="fa fa-paint-brush" aria-hidden="true"></i><?php _e('Social Color Settings', 'team-manager-free')?></a>
			</li>
			<li>
				<a href="#tab-4"><i class="fa fa-life-ring" aria-hidden="true"></i><?php _e('Support', 'team-manager-free')?></a>
			</li>
		</ul>
		<div class="tab">
		<?php

		//get the saved meta as an arry
		$team_manager_free_category_select 			= get_post_meta( $post->ID, 'team_manager_free_category_select', true );
		$team_manager_free_post_themes 				= get_post_meta( $post->ID, 'team_manager_free_post_themes', true );
		$team_manager_free_post_column 				= get_post_meta( $post->ID, 'team_manager_free_post_column', true );
		$team_manager_free_img_height 				= get_post_meta( $post->ID, 'team_manager_free_img_height', true );
		$team_manager_free_social_target 			= get_post_meta( $post->ID, 'team_manager_free_social_target', true );
		$team_manager_free_text_alignment 			= get_post_meta( $post->ID, 'team_manager_free_text_alignment', true );
		$team_manager_free_biography_option 		= get_post_meta( $post->ID, 'team_manager_free_biography_option', true );
		$team_manager_free_header_font_size 		= get_post_meta( $post->ID, 'team_manager_free_header_font_size', true );
		$team_manager_free_designation_font_size 	= get_post_meta( $post->ID, 'team_manager_free_designation_font_size', true );
		$team_manager_free_header_font_color 		= get_post_meta( $post->ID, 'team_manager_free_header_font_color', true );
		$team_manager_free_name_hover_font_color 	= get_post_meta( $post->ID, 'team_manager_free_name_hover_font_color', true );
		$team_manager_free_designation_font_color 	= get_post_meta( $post->ID, 'team_manager_free_designation_font_color', true );
		$team_manager_free_biography_font_size 		= get_post_meta( $post->ID, 'team_manager_free_biography_font_size', true );
		$team_manager_free_overlay_bg_color 		= get_post_meta( $post->ID, 'team_manager_free_overlay_bg_color', true );
		$team_manager_free_biography_font_color 	= get_post_meta( $post->ID, 'team_manager_free_biography_font_color', true );
		?>

		<div id="tab-1" class="tab-content">
			<div class="wrap">
				<table class="form-table">
					<?php $args_cat = array(
						'show_option_all'    => '',
						'show_option_none'   => '',
						'option_none_value'  => '-1',
						'orderby'            => 'ID',
						'order'              => 'ASC',
						'show_count'         => 0,
						'hide_empty'         => 1,
						'child_of'           => 0,
						'exclude'            => '',
						'include'            => '',
						'echo'               => 1,
						'selected'           => $team_manager_free_category_select,
						'hierarchical'       => 0,
						'name'               => 'team_manager_free_category_select',
						'id'                 => 'team_manager_free_category_select',
						'class'              => 'postform',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => 'team_mfcategory',
						'hide_if_empty'      => false,
						'value_field'	     => 'term_id',
					); ?>

					<tr valign="top">
						<th scope="row"><label style="padding-left:10px;" for="team_manager_free_category_select"><?php echo __( 'Select Category', 'team-manager-free' ); ?></label></th>
						<td style="vertical-align:middle;">
							<?php wp_dropdown_categories( $args_cat ); ?><br/>
							<span class="team_manager_hint"><?php echo __('Select Team Showcase Category.( <span style="color:red">Multi select categories option only available in pro version</span>)', 'team-manager-free'); ?></span>	
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label style="padding-left:10px;" for="team_manager_free_post_themes"><?php echo __('Select Themes:', 'team-manager-free'); ?></label></th>
						<td style="vertical-align:middle;">
							<select class="timezone_string" name="team_manager_free_post_themes">
								<option value="theme1" <?php if($team_manager_free_post_themes=='theme1') echo "selected"; ?> ><?php _e('Team Theme 1', 'team-manager-free')?></option>
								<option value="theme2" <?php if($team_manager_free_post_themes=='theme2') echo "selected"; ?> ><?php _e('Team Theme 2', 'team-manager-free')?></option>
								<option value="theme3" <?php if($team_manager_free_post_themes=='theme3') echo "selected"; ?> ><?php _e('Team Theme 3', 'team-manager-free')?></option>
								<option value="theme4" <?php if($team_manager_free_post_themes=='theme4') echo "selected"; ?> ><?php _e('Team Theme 4', 'team-manager-free')?></option>
								<option value="theme5" disabled <?php if($team_manager_free_post_themes=='theme5') echo "selected"; ?> ><?php _e('Team Theme 5 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme6" disabled <?php if($team_manager_free_post_themes=='theme6') echo "selected"; ?> ><?php _e('Team Theme 6 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme7" disabled <?php if($team_manager_free_post_themes=='theme7') echo "selected"; ?> ><?php _e('Team Theme 7 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme8" disabled <?php if($team_manager_free_post_themes=='theme8') echo "selected"; ?> ><?php _e('Team Theme 8 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme9" disabled <?php if($team_manager_free_post_themes=='theme9') echo "selected"; ?> ><?php _e('Team Theme 9 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme10" disabled <?php if($team_manager_free_post_themes=='theme10') echo "selected"; ?> ><?php _e('Team Theme 10 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme11" disabled <?php if($team_manager_free_post_themes=='theme11') echo "selected"; ?> ><?php _e('Team Theme 11 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme12" disabled <?php if($team_manager_free_post_themes=='theme12') echo "selected"; ?> ><?php _e('Team Theme 12 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme13" disabled <?php if($team_manager_free_post_themes=='theme13') echo "selected"; ?> ><?php _e('Team Theme 13 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme14" disabled <?php if($team_manager_free_post_themes=='theme14') echo "selected"; ?> ><?php _e('Team Theme 14 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme15" disabled <?php if($team_manager_free_post_themes=='theme15') echo "selected"; ?> ><?php _e('Team Theme 15 (Available Pro)', 'team-manager-free')?></option>
								<option value="theme16" disabled <?php if($team_manager_free_post_themes=='theme16') echo "selected"; ?> ><?php _e('Team Theme 16 (Available Pro)', 'team-manager-free')?></option>
							</select><br/>
						<span class="team_manager_hint"><?php echo __('Select Team Showcase Themes.', 'team-manager-free'); ?></span>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label style="padding-left:10px;" for="team_manager_free_img_height">Image Height(px)</label>
						</th>
						<td style="vertical-align:middle;">
							<input type="text" name="team_manager_free_img_height" id="team_manager_free_img_height" maxlength="4" class="timezone_string" required value="<?php  if($team_manager_free_img_height !=''){echo $team_manager_free_img_height; }else{ echo '220';} ?>">
						</td>
					</tr>

				<tr valign="top">
					<th scope="row">
						<label style="padding-left:10px;" for="team_manager_free_post_column"><?php echo __('Team Column:', 'team-manager-free'); ?></label>
					</th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_post_column">
						<option value="3" <?php if($team_manager_free_post_column=='3') echo "selected"; ?> ><?php _e('3 Column', 'team-manager-free')?></option>
						<option value="2" <?php if($team_manager_free_post_column=='2') echo "selected"; ?> ><?php _e('2 Column', 'team-manager-free')?></option>
						<option value="1" disabled <?php if($team_manager_free_post_column=='1') echo "selected"; ?> ><?php _e('1 Column (Available Pro)', 'team-manager-free')?></option>
						<option value="4" disabled <?php if($team_manager_free_post_column=='4') echo "selected"; ?> ><?php _e('4 Column (Available Pro)', 'team-manager-free')?></option>
						<option value="5" disabled <?php if($team_manager_free_post_column=='5') echo "selected"; ?> ><?php _e('5 Column (Available Pro)', 'team-manager-free')?></option>
						<option value="6" disabled <?php if($team_manager_free_post_column=='6') echo "selected"; ?> ><?php _e('6 Column (Available Pro)', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Select Team Showcase Column.', 'team-manager-free'); ?></span>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_header_font_size"><?php echo __('Name Font Size:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_header_font_size">
						<option value="15" <?php if($team_manager_free_header_font_size=='15') echo "selected"; ?> ><?php _e('15px', 'team-manager-free')?></option>
						<option value="10" <?php if($team_manager_free_header_font_size=='10') echo "selected"; ?> ><?php _e('10px', 'team-manager-free')?></option>
						<option value="11" <?php if($team_manager_free_header_font_size=='11') echo "selected"; ?> ><?php _e('11px', 'team-manager-free')?></option>
						<option value="12" <?php if($team_manager_free_header_font_size=='12') echo "selected"; ?> ><?php _e('12px', 'team-manager-free')?></option>
						<option value="13" <?php if($team_manager_free_header_font_size=='13') echo "selected"; ?> ><?php _e('13px', 'team-manager-free')?></option>
						<option value="14" <?php if($team_manager_free_header_font_size=='14') echo "selected"; ?> ><?php _e('14px', 'team-manager-free')?></option>
						<option value="16" <?php if($team_manager_free_header_font_size=='16') echo "selected"; ?> ><?php _e('16px', 'team-manager-free')?></option>
						<option value="17" <?php if($team_manager_free_header_font_size=='17') echo "selected"; ?> ><?php _e('17px', 'team-manager-free')?></option>
						<option value="18" <?php if($team_manager_free_header_font_size=='18') echo "selected"; ?> ><?php _e('18px', 'team-manager-free')?></option>
						<option value="19" <?php if($team_manager_free_header_font_size=='19') echo "selected"; ?> ><?php _e('19px', 'team-manager-free')?></option>
						<option value="20" <?php if($team_manager_free_header_font_size=='20') echo "selected"; ?> ><?php _e('20px', 'team-manager-free')?></option>
						<option value="21" <?php if($team_manager_free_header_font_size=='21') echo "selected"; ?> ><?php _e('21px', 'team-manager-free')?></option>
						<option value="22" <?php if($team_manager_free_header_font_size=='22') echo "selected"; ?> ><?php _e('22px', 'team-manager-free')?></option>
						<option value="23" <?php if($team_manager_free_header_font_size=='23') echo "selected"; ?> ><?php _e('23px', 'team-manager-free')?></option>
						<option value="24" <?php if($team_manager_free_header_font_size=='24') echo "selected"; ?> ><?php _e('24px', 'team-manager-free')?></option>
						<option value="25" <?php if($team_manager_free_header_font_size=='25') echo "selected"; ?> ><?php _e('25px', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Select Team Showcase Name Font Size.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_designation_font_size"><?php echo __('Designation Font Size:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_designation_font_size">
						<option value="12" <?php if($team_manager_free_designation_font_size=='12') echo "selected"; ?> ><?php _e('12px', 'team-manager-free')?></option>
						<option value="10" <?php if($team_manager_free_designation_font_size=='10') echo "selected"; ?> ><?php _e('10px', 'team-manager-free')?></option>
						<option value="11" <?php if($team_manager_free_designation_font_size=='11') echo "selected"; ?> ><?php _e('11px', 'team-manager-free')?></option>
						<option value="13" <?php if($team_manager_free_designation_font_size=='13') echo "selected"; ?> ><?php _e('13px', 'team-manager-free')?></option>
						<option value="14" <?php if($team_manager_free_designation_font_size=='14') echo "selected"; ?> ><?php _e('14px', 'team-manager-free')?></option>
						<option value="15" <?php if($team_manager_free_designation_font_size=='15') echo "selected"; ?> ><?php _e('15px', 'team-manager-free')?></option>
						<option value="16" <?php if($team_manager_free_designation_font_size=='16') echo "selected"; ?> ><?php _e('16px', 'team-manager-free')?></option>
						<option value="17" <?php if($team_manager_free_designation_font_size=='17') echo "selected"; ?> ><?php _e('17px', 'team-manager-free')?></option>
						<option value="18" <?php if($team_manager_free_designation_font_size=='18') echo "selected"; ?> ><?php _e('18px', 'team-manager-free')?></option>
						<option value="19" <?php if($team_manager_free_designation_font_size=='19') echo "selected"; ?> ><?php _e('19px', 'team-manager-free')?></option>
						<option value="20" <?php if($team_manager_free_designation_font_size=='20') echo "selected"; ?> ><?php _e('20px', 'team-manager-free')?></option>
						<option value="21" <?php if($team_manager_free_designation_font_size=='21') echo "selected"; ?> ><?php _e('21px', 'team-manager-free')?></option>
						<option value="22" <?php if($team_manager_free_designation_font_size=='22') echo "selected"; ?> ><?php _e('22px', 'team-manager-free')?></option>
						<option value="23" <?php if($team_manager_free_designation_font_size=='23') echo "selected"; ?> ><?php _e('23px', 'team-manager-free')?></option>
						<option value="24" <?php if($team_manager_free_designation_font_size=='24') echo "selected"; ?> ><?php _e('24px', 'team-manager-free')?></option>
						<option value="25" <?php if($team_manager_free_designation_font_size=='25') echo "selected"; ?> ><?php _e('25px', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Select Team Showcase Designation Font Size.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_biography_option"><?php echo __('Short Biography:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_biography_option">
						<option value="block" <?php if($team_manager_free_biography_option=='block') echo "selected"; ?> ><?php _e('Show', 'team-manager-free')?></option>
						<option value="none" <?php if($team_manager_free_biography_option=='none') echo "selected"; ?> ><?php _e('Hide', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Show/Hide Team Member Short Biography.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_biography_font_size"><?php echo __('Biography Font Size:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_biography_font_size">
						<option value="12" <?php if($team_manager_free_biography_font_size=='12') echo "selected"; ?> ><?php _e('12px', 'team-manager-free')?></option>
						<option value="13" <?php if($team_manager_free_biography_font_size=='13') echo "selected"; ?> ><?php _e('13px', 'team-manager-free')?></option>
						<option value="14" <?php if($team_manager_free_biography_font_size=='14') echo "selected"; ?> ><?php _e('14px', 'team-manager-free')?></option>
						<option value="15" <?php if($team_manager_free_biography_font_size=='15') echo "selected"; ?> ><?php _e('15px', 'team-manager-free')?></option>
						<option value="16" <?php if($team_manager_free_biography_font_size=='16') echo "selected"; ?> ><?php _e('16px', 'team-manager-free')?></option>
						<option value="17" <?php if($team_manager_free_biography_font_size=='17') echo "selected"; ?> ><?php _e('17px', 'team-manager-free')?></option>
						<option value="18" <?php if($team_manager_free_biography_font_size=='18') echo "selected"; ?> ><?php _e('18px', 'team-manager-free')?></option>
						<option value="19" <?php if($team_manager_free_biography_font_size=='19') echo "selected"; ?> ><?php _e('19px', 'team-manager-free')?></option>
						<option value="20" <?php if($team_manager_free_biography_font_size=='20') echo "selected"; ?> ><?php _e('20px', 'team-manager-free')?></option>
						<option value="21" <?php if($team_manager_free_biography_font_size=='21') echo "selected"; ?> ><?php _e('21px', 'team-manager-free')?></option>
						<option value="22" <?php if($team_manager_free_biography_font_size=='22') echo "selected"; ?> ><?php _e('22px', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Select Team Showcase Biography Font Size.', 'team-manager-free'); ?></span>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_text_alignment"><?php echo __('Biography Text Alignment:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_text_alignment">
						<option value="default" <?php if($team_manager_free_text_alignment=='default') echo "selected"; ?> ><?php _e('Update Soon ..', 'team-manager-free')?></option>
						<option value="left" disabled <?php if($team_manager_free_text_alignment=='left') echo "selected"; ?> ><?php _e('Left', 'team-manager-free')?></option>
						<option value="center" disabled <?php if($team_manager_free_text_alignment=='center') echo "selected"; ?> ><?php _e('Center', 'team-manager-free')?></option>
						<option value="right" disabled <?php if($team_manager_free_text_alignment=='right') echo "selected"; ?> ><?php _e('Right', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Text Alignment.', 'team-manager-free'); ?></span>					
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_social_target"><?php echo __('Open Social Media Link:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
					<select class="timezone_string" name="team_manager_free_social_target">
						<option value="_self" <?php if($team_manager_free_social_target=='_self') echo "selected"; ?> ><?php _e('Same Page', 'team-manager-free')?></option>
						<option value="_blank" <?php if($team_manager_free_social_target=='_blank') echo "selected"; ?> ><?php _e('New Page', 'team-manager-free')?></option>
					</select>
					<span class="team_manager_hint"><?php echo __('Open Social Media Target Link Same page or New page.', 'team-manager-free'); ?></span>					
					</td>
				</tr>
				
				</table>		
			</div>
		
		</div>
		<div id="tab-2" class="tab-content">
			<div class="wrap">
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_header_font_color"><?php echo __('Name Font Color:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_free_header_font_color' class='team-manager-free-header-font-color' type='text' id="team_manager_free_header_font_color" value='<?php echo $team_manager_free_header_font_color; ?>' /><br>
						<span class="team_manager_hint"><?php echo __('Select Team Showcase Name Font Color.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_name_hover_font_color"><?php echo __('Name Hover Font Color:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_free_name_hover_font_color' class='team-manager-free-hover-font-color' type='text' id="team_manager_free_name_hover_font_color" value='<?php echo $team_manager_free_name_hover_font_color; ?>' /><br>
						<span class="team_manager_hint"><?php echo __('Select Team Showcase Name Hover Font Color.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_designation_font_color"><?php echo __('Designation Font Color:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_free_designation_font_color' class='team-manager-free-designation-font-color' type='text' id="team_manager_free_designation_font_color" value='<?php echo $team_manager_free_designation_font_color; ?>' /><br>
						<span class="team_manager_hint"><?php echo __('Select Team Showcase Designation Font Color.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_biography_font_color"><?php echo __('Biography Font Color:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						<input size='10' name='team_manager_free_biography_font_color' class='team_manager_free_biography-font-color' type='text' id="team_manager_free_biography_font_color" value='<?php echo $team_manager_free_biography_font_color; ?>' /><br>
						<span class="team_manager_hint"><?php echo __('Select Team Showcase Biography Font Color.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_overlay_bg_color"><?php echo __('Overlay Bg Color:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						<input  size='10' name='team_manager_free_overlay_bg_color' class='team_manager_free_overlay_bg-color' type='text' id="team_manager_free_overlay_bg_color" value='<?php echo $team_manager_free_overlay_bg_color; ?>' /><br>
						<span class="team_manager_hint"><?php echo __('Select Team Showcase Overlay Bg Color.', 'team-manager-free'); ?></span>
					</td>
				</tr>
				</table>
			</div>
		</div>
		<div id="tab-3" class="tab-content">
			<div class="wrap">
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_header_font_color"><?php echo __('Upgrade Pro Version to Unlock All Features.', 'team-manager-free'); ?></label></th>
				</tr>
				</table>
			</div>
		</div>
		<div id="tab-4" class="tab-content">
			<div class="wrap">
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_header_font_color"><?php echo __('Support Forum:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						If you need any helps, please don't hesitate to post it on <a href="https://wordpress.org/support/plugin/team-showcase">WordPress.org Support Forum</a> or <a href="http://themepoints.com/questions-answer/">Themepoints.com Support Forum</a>.
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label style="padding-left:10px;" for="team_manager_free_header_font_color"><?php echo __('Submit a Review:', 'team-manager-free'); ?></label></th>
					<td style="vertical-align:middle;">
						We spend plenty of time to develop a plugin like If you like this plugin, please rate it <a target="_blank" style="color: red;
font-size: 20px;margin-left: 5px;" href="https://wordpress.org/support/plugin/team-showcase/reviews/"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></a>. If you have any problems with the plugin, please let us know before leaving a review. we try to solve your problem as soon as we can.
					</td>
				</tr>
				</table>
			</div>
		</div>
		
		<script type="text/javascript">
		jQuery(document).ready(function(jQuery)
			{	
			jQuery('#team_manager_free_header_font_color,#team_manager_free_biography_font_color,#team_manager_free_name_hover_font_color,#team_manager_free_designation_font_color,#team_manager_free_overlay_bg_color').wpColorPicker();
			});
		</script> 			
		
	</div>
	</div>
	<?php
	}		
		
		
	/**
	 * Saves the notice for the given post.
	 *
	 * @params	$post_id	The ID of the post that we're serializing
	 */
	function save_notice( $post_id ) {

    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return $post_id;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data
	$team_manager_free_category_select = sanitize_text_field( $_POST['team_manager_free_category_select'] );
	$team_manager_free_post_themes = sanitize_text_field( $_POST['team_manager_free_post_themes'] );
	$team_manager_free_post_column = sanitize_text_field( $_POST['team_manager_free_post_column'] );
	$team_manager_free_img_height = sanitize_text_field( $_POST['team_manager_free_img_height'] );
	$team_manager_free_social_target = sanitize_text_field( $_POST['team_manager_free_social_target'] );
	$team_manager_free_text_alignment = sanitize_text_field( $_POST['team_manager_free_text_alignment'] );
	$team_manager_free_biography_option = sanitize_text_field( $_POST['team_manager_free_biography_option'] );
	$team_manager_free_header_font_size = sanitize_text_field( $_POST['team_manager_free_header_font_size'] );
	$team_manager_free_designation_font_size = sanitize_text_field( $_POST['team_manager_free_designation_font_size'] );
	$team_manager_free_header_font_color = sanitize_text_field( $_POST['team_manager_free_header_font_color'] );
	$team_manager_free_name_hover_font_color = sanitize_text_field( $_POST['team_manager_free_name_hover_font_color'] );
	$team_manager_free_designation_font_color = sanitize_text_field( $_POST['team_manager_free_designation_font_color'] );
	$team_manager_free_biography_font_size = sanitize_text_field( $_POST['team_manager_free_biography_font_size'] );
	$team_manager_free_overlay_bg_color = sanitize_text_field( $_POST['team_manager_free_overlay_bg_color'] );
	$team_manager_free_biography_font_color = sanitize_text_field( $_POST['team_manager_free_biography_font_color'] );
 
	
	update_post_meta( $post_id, 'team_manager_free_category_select', $team_manager_free_category_select );
	update_post_meta( $post_id, 'team_manager_free_post_themes', $team_manager_free_post_themes );
	update_post_meta( $post_id, 'team_manager_free_post_column', $team_manager_free_post_column );
	update_post_meta( $post_id, 'team_manager_free_img_height', $team_manager_free_img_height );
	update_post_meta( $post_id, 'team_manager_free_social_target', $team_manager_free_social_target );
	update_post_meta( $post_id, 'team_manager_free_text_alignment', $team_manager_free_text_alignment );
	update_post_meta( $post_id, 'team_manager_free_biography_option', $team_manager_free_biography_option );
	update_post_meta( $post_id, 'team_manager_free_header_font_size', $team_manager_free_header_font_size );
	update_post_meta( $post_id, 'team_manager_free_designation_font_size', $team_manager_free_designation_font_size );
	update_post_meta( $post_id, 'team_manager_free_header_font_color', $team_manager_free_header_font_color );
	update_post_meta( $post_id, 'team_manager_free_name_hover_font_color', $team_manager_free_name_hover_font_color );
	update_post_meta( $post_id, 'team_manager_free_designation_font_color', $team_manager_free_designation_font_color );
	update_post_meta( $post_id, 'team_manager_free_biography_font_size', $team_manager_free_biography_font_size );
	update_post_meta( $post_id, 'team_manager_free_overlay_bg_color', $team_manager_free_overlay_bg_color );
	update_post_meta( $post_id, 'team_manager_free_biography_font_color', $team_manager_free_biography_font_color );

	} // end save_notice		
		
	add_action('save_post', 'save_notice');


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	