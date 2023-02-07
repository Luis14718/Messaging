<?php
/*
Plugin Name: Messaging
Description: Programming test for Job application 
Version: 1.0
Author: Luis Daniel Rodriguez Sanchez
*/

// variables 
error_reporting(E_ALL);
ini_set('display_errors', 1);
define( 'MESSAGING__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );




wp_register_style( 'style.css', plugins_url( 'assets/css/style.css', __FILE__ ), array(), "v00" );
wp_enqueue_style( 'program-test-style', plugins_url( 'assets/css/style.css', __FILE__ ) ); 





register_activation_hook( __FILE__, 'program_test_activate' );

function program_test_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'messaging';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        phone VARCHAR(20) NOT NULL,
        message TEXT NOT NULL,
        timestamp DATETIME NOT NULL
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}



if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( MESSAGING__PLUGIN_DIR . 'class-messaging.php' );
	add_action( 'init', array( 'Messaging', 'init' ) );
    require_once( MESSAGING__PLUGIN_DIR . 'class-table-messaging.php' );
    add_action( 'init', array('Tablemessaging' , 'init'));
    
}



function my_plugin_enqueue_scripts() {
    wp_enqueue_script( 'my-plugin-script', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'my_plugin_enqueue_scripts' );