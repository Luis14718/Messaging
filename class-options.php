<?php


class Tokenization {

    public static function init(){
        add_action('admin_menu', array( 'Tokenization', 'token_required' ));
    }
    public static function token_required() {
        add_menu_page(
            'Messaging', // Page Title
            'Token Required', // Menu Title
            'manage_options', // Capability
            'text-message', // Menu Slug
            array( 'Tokenization', 'token_display_form' ), // Callback Function
            'dashicons-admin-generic', // Icon URL
            20 // Position
        );
     
    }
    public static function token_display_form() {
        
        if (isset($_POST['submit'])) {
            $accountid = sanitize_text_field($_POST['account_id']);
            $token = sanitize_text_field($_POST['token']);

            update_option( 'twilio_account_sid',  $accountid );
            update_option( 'twilio_auth_token', $token);
            return self::view('form');
            
        }

        self::view('form-token');
        
    }
    
    public static function view( $name ) {
		$file = MESSAGING__PLUGIN_DIR . 'views/'. $name . '.php';
		include( $file );
        
	}
    

}