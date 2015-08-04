<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    gm_delete_comments
 * @subpackage gm_delete_comments/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    gm_delete_comments
 * @subpackage gm_delete_comments/admin
 * @author     Gaurav Mittal <info@gauravmittal.in>
 */
class gm_delete_comments_Admin {

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
	 * The admin notice of the page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
        public $notice_message;
        
        
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $gm_delete_comments       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */        
                
	public function __construct( $gm_delete_comments, $version ) {

		$this->gm_delete_comments = $gm_delete_comments;
		$this->version = $version;
                $this->notice_message = $notice_message;
                
                add_action('admin_menu', array($this,'register_gm_delete_comments_menu'));
		add_action( 'init', array($this,'process_post') );
                

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->gm_delete_comments, plugin_dir_url( __FILE__ ) . 'css/gm-delete-comments-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->gm_delete_comments, plugin_dir_url( __FILE__ ) . 'js/gm-delete-comments-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        public function my_admin_error_notice($message) {
            $class = "update-nag";
            if($message != '')
            return "<div class=\"$class\"> <p>$message</p></div>"; 
        }
        
        
        /*
         *  Rgister Menu
         * 
         * @since    1.0.0
         */        
        public function register_gm_delete_comments_menu() {
            
                
                /*
                 *  This will register new sub menu under tools menu
                 */
                 add_management_page('Delete Comments', 'Delete Comments', 'manage_options', 'gm-delete-comments-page', array($this,'gm_delete_comments_callback') );
        }

	/*
	 *
	*/
	public function process_post(){
			global $wpdb;
			
                        
                echo get_template_part( 'partials/gm', 'delete', 'comments', 'admin', 'display' );
                // Count Total Comments
                $comments_count = wp_count_comments();                        
                $total_comments =  $comments_count->total_comments;
                        
                        
                /*
                 * For Delete All Comments
                 *
                 * This function will delete all comments from `wp_comments` table and 
                 * SET the `post_count` "0" to unlink the comments.
                 *
                 */
                if(isset($_POST['remove_comments']) && isset($_POST['all_comments']) && $_POST['all_comments'] == 'remove_all_comments')
                        {								
                            
                                if($wpdb->query("DELETE FROM $wpdb->comments") != FALSE)
                                        {
                                                $wpdb->query("Update $wpdb->posts set comment_count = 0 where post_author != 0");
                                                                                               
                                                $this->notice_message = "<div class='updated'><p>All comments have been deleted.</p></div>";
                                        }
                                else 
                                        {
                                                                                                                                                
                                                $this->notice_message = "<div class='error'><p>There is no comments.</p></div>";
                                                
                                        }
                                
                        }

                /*
                 * Delete Category Wise
                 *
                 * This function will delete comments from `wp_comments` table and 
                 * SET the `post_count` "0" to unlink the comments category wise.
                 *
                 * Delete the comment only selected by user			 
                 */
                if(isset($_POST['remove_catwise_comments']) && isset($_POST['selected_comments']) && $_POST['selected_comments'] == 'remove_selected_comments')
                        {
                                $get_selected_categoreis = $_POST['gm_catgories'];
                
                                if($total_comments > 0)
                                        {
                                                foreach($get_selected_categoreis as $gm_get_ids)
                                                        {

                                                                /*
                                                                 * For Delete Comments
                                                                 *
                                                                 * This Query for delete comments from `wp_comments` table on behalf of the category ID.									 
                                                                 */
                                                                echo $del_query = 'DELETE wc.* FROM `wp_comments` AS wc 
                                                                                          INNER JOIN `wp_posts` AS wp ON wc.`comment_post_ID` = wp.ID 
                                                                                          INNER JOIN `wp_term_relationships` AS wtr ON wp.`ID` = wtr.`object_id` 
                                                                                          WHERE wp.`post_author` != "0" AND 
                                                                                                wtr.`term_taxonomy_id` = "'.$gm_get_ids.'"';

                                                                $wpdb->query($del_query);					

                                                                /*
                                                                 * For Update `wp_posts`
                                                                 *
                                                                 * This Query is for SET the `post_count` "0" to unlink the comments on behalf of the category ID.									 
                                                                 */					
                                                                $up_query = 'UPDATE wp_posts AS wp
                                                                                          INNER JOIN wp_term_relationships AS wtr ON wp.ID = wtr.object_id
                                                                                          SET wp.comment_count = "0"
                                                                                          WHERE  wp.post_author != "0" 
                                                                                                and wtr.term_taxonomy_id = "'.$gm_get_ids.'"';

                                                                $wpdb->query($up_query);
                                                        }
                                                $this->notice_message = "<div class='updated'><p>Selected comments have been deleted.</p></div>";
                                        }
                                else 
                                        {
                                                $this->notice_message = "<div class='error'><p>There is no comments.</p></div>";
                                        }


                        }
                        
                     /*
                 * Delete Category Wise
                 *
                 * This function will delete comments from `wp_comments` table and 
                 * SET the `post_count` "0" to unlink the comments category wise.
                 *
                 * Delete the comment only selected by user			 
                 */
                if(isset($_POST['remove_by_author']) && isset($_POST['remove_by_author_hide']) && $_POST['remove_by_author_hide'] == 'remove_all_by_author')
                        {
                                $get_selected_authors = $_POST['get_authors'];
                                //print_r($get_selected_authors);
                                //exit;
                                if($total_comments > 0)
                                        {
                                                foreach($get_selected_authors as $gm_get_author_ids)
                                                        {

                                                                /*
                                                                 * For Delete Comments
                                                                 *
                                                                 * This Query for delete comments from `wp_comments` table on behalf of the category ID.									 
                                                                 */
                                                                $del_by_athor_query = 'DELETE  wc.* FROM `wp_comments` As wc 
                                                                                            INNER JOIN `wp_posts` AS wps ON wps.`ID` = wc.`comment_post_ID` 
                                                                                            WHERE wps.post_author = "'.$gm_get_author_ids.'"';

                                                                $wpdb->query($del_by_athor_query);					

                                                                /*
                                                                 * For Update `wp_posts`
                                                                 *
                                                                 * This Query is for SET the `post_count` "0" to unlink the comments on behalf of the category ID.									 
                                                                 */					
                                                                $up_by_author_query = 'UPDATE `wp_posts` SET `comment_count` = 0 WHERE `post_author` = "'.$gm_get_author_ids.'"';

                                                                $wpdb->query($up_by_author_query);
                                                        }
                                                $this->notice_message = "<div class='updated'><p>Selected comments have been deleted.</p></div>";
                                        }
                                else 
                                        {
                                                $this->notice_message = "<div class='error'><p>There is no comments.</p></div>";
                                        }


                        }   
		}
                
      
		
        /*
         *  Options Callback function for delete comments menu
         */
        public function gm_delete_comments_callback() {
            
                
                /*
                 *  Here we can write code for options page
                 */
                 
                $returndata .= $this->notice_message;
               
                $returndata .= '<div class="wrap">
						<h2>Delete Comments</h2>
						<h2 class="nav-tab-wrapper">
							<a class="nav-tab '.((!isset($_GET["tab"]))? 'nav-tab-active':"" ).'" href="?page=gm-delete-comments-page">Delete</a>
							
							
						</h2>';
				if(!isset($_GET["tab"])){
				$returndata .=  '<div id="poststuff">
									<section id="All Comments" class="postbox">
										<h3 class="hndle">Remove All Comments</h3>
										<div class="inside">
											<form method="post">									
												<input type="hidden" name="all_comments" value="remove_all_comments" />
												<input class="button-primary" type="submit" name="remove_comments" value="Delete All Comments" />
											</form>
										</div>
									</section>
									<section id="All Comments" class="postbox">
										<h3 class="hndle">Remove Category Wise</h3>
										<div class="inside">
											<form method="post">
												<ul class="gm_list">';
													$category_ids = get_all_category_ids();
													foreach($category_ids as $cat_id) {
													  $cat_name = get_cat_name($cat_id);
													  $returndata .= '<li><input type="checkbox" name="gm_catgories[]" value="'.$cat_id.'" />'.$cat_name.'</li>';
													}
					$returndata .=				'</ul>';	
					$returndata .=              '<input type="hidden" name="selected_comments" value="remove_selected_comments" />
												<input class="button-primary" type="submit" name="remove_catwise_comments" value="Delete Selected Comments" />
											</form>
										</div>
									</section>
                                                                        <section id="Comments By User" class="postbox">
										<h3 class="hndle">Remove Comments By User</h3>
                                                                                ';
                                        
                                                                                /*
                                                                                 * Get All Users List
                                                                                 */
                                                                                $allUsers = get_users('orderby=post_count&order=DESC');    
                                                                                //print_r($allUsers);
                                                                                // Remove subscribers from the list as they won't write any articles
                                                                                
					$returndata .=				'<div class="inside">
											<form method="post">	
                                                                                        <ul class="gm_list">';
                                                                                        foreach($allUsers as $currentUser)
                                                                                            {
                                                                                                $returndata .=  '<li><input type="checkbox" value="'.$currentUser->ID.'" name="get_authors[]"/>'.$currentUser->user_nicename.' ('.$currentUser->user_email.')</li>';                                                                                        
                                                                                            }
                                        $returndata .=                                  '</ul><div class="clear"></div>
												<input type="hidden" name="remove_by_author_hide" value="remove_all_by_author" />
												<input class="button-primary" type="submit" name="remove_by_author" value="Delete Selected" />
											</form>
										</div>
									</section>
								</div>';
				}
                $returndata .= '</div>';
                
                echo $returndata;
        }
}
