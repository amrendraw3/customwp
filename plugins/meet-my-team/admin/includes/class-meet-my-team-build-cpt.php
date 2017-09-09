<?php
/**
 * Meet My Team
 *
 * @package   Meet My Team
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2014 Buooy
 */
class Meet_My_Team_Build_Cpt {

	/* All Necessary Variables */
	protected $post_type 	= 'team_members';
	protected $text_domain 	= 'meet-my-team';
	protected $post_name 	= 'Team Members';
	protected $menu_name 	= 'Meet My Team';
	protected $parent_item 	= 'Parent Team Member';
	protected $items_name 	= 'Members';
	protected $item_name 	= 'Member';
	protected $meta_box_title = 'Additional Details';
	protected $description  = 'Team members is a custom post type for Meet My Team';

	protected $tax_name_lower = 'group';
	protected $tax_name_upper = 'Group';

	/* Custom Fields */
	public $mmt_meta_boxes = array();



	public function __construct() {
	}

	/**
	 * 	-	Builds the Meet My team Custom Post Type
	 *	
	 *	POST TYPE: team_members
	 *
	 * @since    1.0.0
	 */
	public function build_custom_post_type() {
		
		// Builds the team_member post type
		$labels = array(
			'name'                => _x( $this->post_name, 'Post Type General Name', $this->text_domain ),
			'singular_name'       => _x( $this->post_name, 'Post Type Singular Name', $this->text_domain ),
			'menu_name'           => __( $this->menu_name, $this->text_domain ),
			'parent_item_colon'   => __( $this->parent_item, $this->text_domain ),
			'all_items'           => __( 'All '.$this->items_name, $this->text_domain ),
			'view_item'           => __( 'View '.$this->item_name, $this->text_domain ),
			'add_new_item'        => __( 'Add New '.$this->item_name, $this->text_domain ),
			'add_new'             => __( 'Add New', $this->text_domain ),
			'edit_item'           => __( 'Edit '.$this->item_name, $this->text_domain ),
			'update_item'         => __( 'Update '.$this->item_name, $this->text_domain ),
			'search_items'        => __( 'Search '.$this->item_name, $this->text_domain ),
			'not_found'           => __( 'Not found', $this->text_domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->text_domain ),
		);
		$args = array(
			'label'               => __( $this->post_name, $this->text_domain ),
			'description'         => __( $this->description, $this->text_domain ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'page-attributes' ),
			'taxonomies'          => array( "category" ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 70,
			'menu_icon'           => 'dashicons-groups',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( $this->post_type, $args );

	}


	/**
	 * Initialize the metabox class.
	 */
	public function cmb_initialize_mmt_meta_boxes() {

		if ( ! class_exists( 'cmb_Meta_Box' ) ){
			require_once 'Custom-Metaboxes-and-Fields/init.php';
		}

	}


	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	public function mmt_metaboxes() {

		global $meta_boxes;

		$prefix = 'mmt_'; // Prefix for all fields

	    $meta_boxes[$this->post_type.'_metabox'] = array(
	        'id' 		=> 	$this->post_type.'_metabox',
	        'title' 	=> 	$this->post_name.' Details',
	        'pages' 	=> 	array( $this->post_type ), // post type
	        'context' 	=> 'normal',
	        'priority' 	=> 'high',
	        'show_names' => true, // Show field names on the left
	        'fields' => array(

	        	/* Bio Picture */
	            array(
	                'name' 	=> 'Bio Picture',
	                'desc' 	=> 'Member\'s Bio Picture',
	                'id'	=> $prefix . 'bio_picture',
	                'type' 	=> 'file',
	                'save_id' => false, // save ID using true
	                'options' => array('url', 'attachment'),
	            ),

	        	/* Designation */
	            array(
	                'name' 	=> 'Designation',
	                'desc' 	=> 'Member\'s Designation',
	                'id'	=> $prefix.'designation',
	                'type' 	=> 'text',
	                'options' => array(),
	            ),

	            /* Email */
	            array(
	                'name' 	=> 'Email',
	                'desc' 	=> 'Member\'s Email',
	                'id'	=> $prefix . 'email',
	                'type' 	=> 'text',
	                'options' => array(),
	            ),

	            /* Biography */
	            array(
	                'name' 	=> 'Biography',
	                'desc' 	=> 'Member\'s Biography',
	                'id'	=> $prefix . 'biography',
	                'type' 	=> 'wysiwyg',
	                'options' => array(),
	            ),

	            /* Personal URL */
	            array(
	                'name' 	=> 'Personal URL',
	                'desc' 	=> 'Member\'s URL',
	                'id'	=> $prefix . 'url',
	                'type' 	=> 'text',
	                'options' => array(),
	            ),
	        ),
	    );

		return $meta_boxes;
	}

}