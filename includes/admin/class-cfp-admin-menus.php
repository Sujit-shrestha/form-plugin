<?php
defined('ABSPATH') || exit;
/**
 * Creates admin menus in admin dashboard.
 * 
 * @version 1.0.1
 */

 class CFP_Admin_Menus {
  /**
   * Constructor
   */
  public function __construct() {

    add_action( 'admin_enqueue_scripts' , array( 'CFP_Display_Entries' , 'admin_enqueuing' ) );

    add_action( 'wp_ajax_admin_entries_search_action' , array( 'CFP_Display_Entries' , 'handle_search' ) );
    
    add_action( 'wp_ajax_admin_entries_sort_action' , array( 'CFP_Display_Entries' , 'handle_sort' ) );



    $this -> initHooks ();

  }
  /**
   * Creates instance
   */
  public static function createInstance () {

    return new self;
  }

  /**
   * Hooks 
   */

   public function initHooks () {
    /**
     * Actions
     */
    add_action ( 'admin_menu' , array( $this , 'admin_menu' ) ) ;

   }
  
  /**
   * Add menu items.
   */
  public function admin_menu () {
    add_menu_page (
      esc_html__( 'CFP Forms' , CFP_text_domain ),
      esc_html__( 'CFP Forms' , CFP_text_domain),
      'manage_options' ,
      'cfp_admin_main_menu',
      null ,
      self::get_icon_url(),
      '2'

    );

    //Loads submenu to the menu
    
    add_submenu_page(
      'cfp_admin_main_menu',
      esc_html__( "Entries" , CFP_text_domain ),
      esc_html__( "Entries" , CFP_text_domain ),
      'manage_options' ,
      'cfp_admin_main_menu',
      array( $this , 'displayData' ) ,
      

    );

    add_submenu_page(
      'cfp_admin_main_menu',
      esc_html__( "Test" , 'contact-form-plugin-cfp-themegrill' ),
      esc_html__( "Test" , 'contact-form-plugin-cfp-themegrill' ),
      'manage_options' ,
      'cfp_admin_settings_submenu',
      array( $this , 'entriesInit' ) ,
      
    );
  }
  /**
   * Custom table display
   */
  public function displayData () {

    $formEntriesDisplay =  CFP_Display_Entries :: getInstance ( );
    ?>
     <div class="wrap">
           <h2><?php esc_html_e("Form Entries" , CFP_text_domain);?></h2>
           <?php $formEntriesDisplay -> init (); ?>
       </div>
    <?php


  }

  /**
   * Display using wp_list_table 
   */
  public function entriesInit () {
  
   $exampleListTable = new CFP_Entries_Display_using_WPListTable();
   $exampleListTable->prepare_items();
   ?>
       <div class="wrap">
           <div id="icon-users" class="icon32"></div>
           <h2><?php esc_html_e('Example List Table Page' , CFP_text_domain ); ?></h2>
           <?php $exampleListTable->display(); ?>
           
       </div>
   <?php

  }

  public static function get_icon_url( $fill = '#82878c', $base64 = true ) {
		$svg = '<svg fill="#000000" width="800px" height="800px" viewBox="0 0 36 36" version="1.1"  preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <title>form-line</title>
    <path d="M21,12H7a1,1,0,0,1-1-1V7A1,1,0,0,1,7,6H21a1,1,0,0,1,1,1v4A1,1,0,0,1,21,12ZM8,10H20V7.94H8Z" class="clr-i-outline clr-i-outline-path-1"></path><path d="M21,14.08H7a1,1,0,0,0-1,1V19a1,1,0,0,0,1,1H18.36L22,16.3V15.08A1,1,0,0,0,21,14.08ZM20,18H8V16H20Z" class="clr-i-outline clr-i-outline-path-2"></path><path d="M11.06,31.51v-.06l.32-1.39H4V4h20V14.25L26,12.36V3a1,1,0,0,0-1-1H3A1,1,0,0,0,2,3V31a1,1,0,0,0,1,1h8A3.44,3.44,0,0,1,11.06,31.51Z" class="clr-i-outline clr-i-outline-path-3"></path><path d="M22,19.17l-.78.79A1,1,0,0,0,22,19.17Z" class="clr-i-outline clr-i-outline-path-4"></path><path d="M6,26.94a1,1,0,0,0,1,1h4.84l.3-1.3.13-.55,0-.05H8V24h6.34l2-2H7a1,1,0,0,0-1,1Z" class="clr-i-outline clr-i-outline-path-5"></path><path d="M33.49,16.67,30.12,13.3a1.61,1.61,0,0,0-2.28,0h0L14.13,27.09,13,31.9a1.61,1.61,0,0,0,1.26,1.9,1.55,1.55,0,0,0,.31,0,1.15,1.15,0,0,0,.37,0l4.85-1.07L33.49,19a1.6,1.6,0,0,0,0-2.27ZM18.77,30.91l-3.66.81L16,28.09,26.28,17.7l2.82,2.82ZM30.23,19.39l-2.82-2.82L29,15l2.84,2.84Z" class="clr-i-outline clr-i-outline-path-6"></path>
    <rect x="0" y="0" width="36" height="36" fill-opacity="0"/>
    </svg>';

		if ( $base64 ) {
			return 'data:image/svg+xml;base64,' . base64_encode( $svg );
		}

		return $svg;
	}
 }