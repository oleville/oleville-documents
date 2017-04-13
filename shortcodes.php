<?php
if(!class_exists('Oleville_Docs_Shortcode'))
{
	class Oleville_Docs_Shortcode
	{
		const POST_TYPE = "doc";
		const SHORTCODE = "doc";

		private $_meta = array(
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

		private $messages = array(
			'success' => array(),
			'error' => array(),
			);

		/**
		* Constructor
		*/
		public function __construct()
		{
			// Register Action Hooks
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));

		}

		/**
		* Function hooked to WP's init action
		*/
		public function init()
		{
			//error_log("Adding Short Code");

			global $wpdb;
			// Add the shortcode hook
			if (!shortcode_exists('show-documents')) {
				add_shortcode('show-documents', array(&$this, 'docs_handler'));
			}
			wp_enqueue_style( 'display_style', WP_PLUGIN_URL.'/oleville-documents/css/docs.css');

		}

		public function docs_handler($attr)
		{
			return $this->show_docs();
		}

		public function show_docs()
		{
			$allDocs = $this->get_all_docs();
			$result = '';
			$count = 1;
			$class = 'firstColor';
			foreach ($allDocs as $doc)
			{
				if ($count%2 === 0) {
					$class = 'firstColor';
				} else {
					$class = 'secondColor';
				}
				$result .= '<a class="aColors" href ="' . $doc['url'] . '"/ >';
				$result .= '<div class="' . $class . '" >';
				$result .= '<img class="arrow" src="http://dev.oleville.com/wp-content/uploads/2017/01/chevron-arrow.png"/>';

				$result .= '<h6 class="title">' . $doc['title'] . '</h6>';
				$result .= '<br><span class="date">' . $doc['date'] . '</span><br/>';

				$result .= '</div>';
				$result .= '</a>';
				$count ++;

			}

			return $result;

		}

		//this will return a structure if all members that are in the database, and their associated metadata
		public function get_all_docs()
		{
			global $wpdb;

			//query the DB for the members
			$args = array(
				'post_type' => 'doc',
				'posts_per_page' => -1,
				'meta_key' => 'date',
				'orderby' => 'meta_value',
				'order' => 'DESC', // what code is this?
			);
			$query = new WP_Query($args); // make the query

			//$formattedMemberData; // an array that will hold references to all the members in the database

			//add them to the custom data structure, built out of nested arrays (kinda like a JSON structure, which is convenient because that's how the OH are stored)
			while ($query -> have_posts())
			{
				$query->the_post();

				$docId = get_the_ID(); // the member's id
				//write_log($memberId);

				$pri_author = get_post_meta($docId, 'pri_author', TRUE);
				$sec_author = get_post_meta($docId, 'sec_author', TRUE);
				$tri_author = get_post_meta($docId, 'tri_author', TRUE);
				$authors = array(
					$pri_author,
					$sec_author,
					$tri_author
				);

				$signature1 = get_post_meta($docId, 'signature1', TRUE);
				$signature2 = get_post_meta($docId, 'signature2', TRUE);
				$signatures = array(
					$signature1,
					$signature2
				);

				$thisDoc = array(
					'title' 	=> get_the_title(), // the doc's title
					'id' 			=> $docId, // the doc's ID
					'date'    => get_post_meta($docId, 'date', TRUE),
					'authors' => $authors,
					'purpose' => get_post_meta($docId, 'purpose', TRUE),
					'explanation' => get_post_meta($docId, 'explanation', TRUE),
					'purpose' => get_post_meta($docId, 'purpose', TRUE),
					'signatures' => $signatures,
					'url' => get_permalink($docId)
					);

				$formattedDocData[] = $thisDoc; // add this member's array to the array of all members
			}

			return $formattedDocData; // return the array of all members
		}

		public function admin_init()
		{
			//do nothing
		}
	}
}
