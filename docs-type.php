<?php
if(!class_exists('Oleville_Docs_Type'))
{
	class Oleville_Docs_Type
	{
		const POST_TYPE	= "doc";

		private $_meta	= array(
				'date',
				'pri_author',
				'sec_author',
				'tri_author',
				'pri_title',
				'sec_title',
				'tri_title',
				'purpose',
				'body',
				'explanation',
				'signature1',
				'signature2',
				'dateSigned1',
				'dateSigned2'
		);

		/**
		* The Constructor
		*/
		public function __construct()
		{
			// register actions
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));
		}

		/**
		 * hook into WP's init action hook
		 */
		public function init()
		{
			// Initialize Post Type
			$this->create_post_type();
			add_action('save_post', array(&$this, 'save_post'));
			add_action('wp_trash_post', array(&$this, 'delete_post'));
			add_action('publish_post', array(&$this, 'publish_post'));
			add_action('update_post', array(&$this, 'update_post'));
		}

		/**
		 * Create the post type
		 */
		public function create_post_type()
		{
			$labels = array(
				'name'               => _x( 'Documents', 'post type general name' ),
				'singular_name'      => _x( 'Document', 'post type singular name' ),
				'add_new'            => _x( 'Add New', 'document' ),
				'add_new_item'       => __( 'Add New Document' ),
				'edit_item'          => __( 'Edit Document' ),
				'new_item'           => __( 'New Document' ),
				'all_items'          => __( 'All Documents' ),
				'view_item'          => __( 'View Document' ),
				'search_items'       => __( 'Search Documents' ),
				'not_found'          => __( 'No documents found' ),
				'not_found_in_trash' => __( 'No documents found in the Trash' ),
				'parent_item_colon'  => '',
				'menu_name'          => 'Documents'
			);
			$args = array(
					'labels'        => $labels,
					'description'   => 'Holds our documents',
					'public'        => true,
					'menu_position' => 5,
					'supports'      => array('title', 'thumbnail', 'editor'),
					'has_archive'   => true,
					'menu_icon'     => 'dashicons-media-document', // load the icon
			);
			register_post_type(self::POST_TYPE, $args);
		}

		/**
		 * Save the metaboxes for this custom post type
		 */
		public function save_post($post_id)
		{
			// verify if this is an auto save routine.
			// If it is, our form has not been submitted, so we dont want to do anything
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			{
				return;
			}

			if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
			{
				foreach($this->_meta as $field_name)
				{
					// Update the post's meta field
					if(isset( $_POST[$field_name]))
					{
						update_post_meta($post_id, $field_name, sanitize_text_field($_POST[$field_name]));
					}
				}
			} else {
				return;
			}
		}

		/**
		 * Delete the metaboxes for this custom post type
		 */
		public function delete_post($post_id)
		{

		}

		/**
		* hook into WP's admin_init action hook
		*/
		public function admin_init()
		{
			// Add metaboxes
			add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
			// enqueue scripts
			add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));

		}

		/**
		 * hook into WP's add_meta_boxes action hook
		 */
		public function add_meta_boxes()
		{
			// Add this metabox to every selected post
			add_meta_box(
				sprintf('oleville_documents_%s_section', self::POST_TYPE), //container for edit meta fields
				sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))), //name of above container
				array(&$this, 'add_inner_meta_boxes'), // call to add_inner_meta_boxes with argument this
				self::POST_TYPE,
				'normal',
				'high'
			);
		}

		/**
		 * called off of the add meta box
		 */
		public function add_inner_meta_boxes($post)
		{
			wp_nonce_field( plugin_basename( __FILE__ ), 'oleville_documents_member_section_nonce' );
			// Render the job order metabox
			include(sprintf("%s/templates/doc_metabox.php", dirname(__FILE__)));
		}

		/**
		 * Function hooked to WP's admin_enqueue_scripts action
		 */
		public function admin_enqueue_scripts($hook)
		{
			global $post;
			// Check to see that these scripts are only loaded for post-new.php
			// and the type is eventmail
			if('post-new.php' != $hook && 'post.php' != $hook)
				return;
			// if($_GET['post_type'] != self::POST_TYPE && 'post.php' != $hook)
			// 	return;
			wp_register_script(
				'oleville-documents-doc-js',
				plugins_url('templates/js/doc_metabox.js', __FILE__)
			);
			// Register the JS and CSS files with WordPress
			// register = for client
			wp_register_style(
				'oleville-documents-doc-css',
				plugins_url('templates/css/doc_metabox.css', __FILE__)
			);
			wp_register_script(
				'oleville-docs-timepicker-js',
				plugins_url('templates/js/jquery.timepicker.min.js', __FILE__),
				array('jquery')
			);
			// Enqueue the styles and scripts
			// must be registered in order to enqueue them
			wp_enqueue_style('oleville-documents-doc-css');
			wp_enqueue_script('oleville-documents-doc-js');
			wp_enqueue_script('oleville-docs-timepicker-js');
		}
	}
}
