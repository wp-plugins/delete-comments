<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    gm_delete_comments
 * @subpackage gm_delete_comments/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    gm_delete_comments
 * @subpackage gm_delete_comments/public
 * @author     Gaurav Mittal <info@gauravmittal.in>
 */
class gm_delete_comments_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $gm_delete_comments    The ID of this plugin.
	 */
	private $gm_delete_comments;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $gm_delete_comments       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $gm_delete_comments, $version ) {

		$this->gm_delete_comments = $gm_delete_comments;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in gm_delete_comments_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The gm_delete_comments_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->gm_delete_comments, plugin_dir_url( __FILE__ ) . 'css/gm-delete-comments-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in gm_delete_comments_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The gm_delete_comments_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->gm_delete_comments, plugin_dir_url( __FILE__ ) . 'js/gm-delete-comments-public.js', array( 'jquery' ), $this->version, false );

	}

}
