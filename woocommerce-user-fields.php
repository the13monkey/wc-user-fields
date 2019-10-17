<?php 

    /**
     * Plugin Name: WooCommerce User Account Custom Fields
     * Description: Enables users to create and save custom user account information through woocommerce native forms, and store the newly created data into    WordPress's User_Metadata table.
     * Version: 1.0.0
     * Author: Dinah Chen
     * Author URI: http://dinahchen.com 
     */

    defined( 'ABSPATH' ) or die( 'No script kiddes please!' );

    function add_custom_user_fields() {

        if( !is_user_logged_in() ) {

            return "Please log in";

        } 
?>

    <form method="post" action="">
        
        <input type="text" style="display: none" name="meta_key" id="meta_key" value="company_name">
        <input type="text" name="meta_value" id="company_name" placeholder="Enter your company's name">
        <input type="submit" value="Submit" name="submit">

    </form>

<?php
        $company_name = "Whatever the company is";
        $meta_key = "company_name";
        

        //Check if form is submitted
        if( isset( $_POST['submit'] ) ) {

            $user = wp_get_current_user();
            $user_id = $user->ID;
            $meta_key = $_POST['meta_key'];
            $meta_value = $_POST['meta_value'];

            //Check if user meta already exists
            if( get_user_meta( $user_id, $meta_key ) ) {

                update_user_meta( $user_id, $meta_key, $meta_value );

            } else {

                add_user_meta( $user_id, $meta_key, $meta_value );

            }

            return "Success";

        }

    }
    add_shortcode( 'custom-user-account', 'add_custom_user_fields' );
    

?>