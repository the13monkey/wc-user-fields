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

        $user = wp_get_current_user();
        $user_id = $user->ID;

        $firstname = get_user_meta( $user_id, 'firstname', true );
        $lastname = get_user_meta( $user_id, 'lastname', true );
        $nickname = get_user_meta( $user_id, 'nickname', true );
        $companyname = get_user_meta( $user_id, 'companyname', true );
        $contactemail = get_user_meta( $user_id, 'contactemail', true ); 
        $phonenumber = get_user_meta( $user_id, 'phonenumber', true);

?>

<form method="post" action="" id="wuf-edit-account-details" class="py-5">

    <div class="pt-md-4 border rounded">

	    <h4 class="px-md-4 mb-md-4">Contact Information</h4>

	    <div class="form-row mb-md-3 px-md-3">

		    <div class="form-group col-md-6">
			    <label for="firstname"><?php esc_html_e( 'First Name', 'woocommerce' ) ?>&nbsp;<span class="required">*</span></label>
			    <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="firstname" id="firstname" autocomplete="firstname" value="<?php echo $firstname ?>" />
		    </div>

		    <div class="form-group col-md-6">
			    <label for="lastname"><?php esc_html_e( 'Last Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="lastname" id="lastname" autocomplete="lastname" value="<?php echo $lastname ?>" />
		    </div>

	    </div>

	    <div class="form-row px-md-3">

		    <div class="form-group col-md-6">
			    <label for="nickname"><?php esc_html_e( 'Display Name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="nickname" id="nickname" value="<?php echo $nickname ?>" />
			    <p class="display-10 text-muted mb-0 pb-0">This is how you want us to call you, NOT your user name.</p>
		    </div>

		    <div class="form-group col-md-6">
			    <label for="companyname"><?php esc_html_e( 'Company Name', 'woocommerce' ); ?>&nbsp;</label>
			    <input type="text" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="companyname" id="companyname" autocomplete="company_name" value="<?php echo $companyname ?>" />
		    </div>

	    </div>

	    <div class="form-row mb-md-3 px-md-3 pb-md-4">
		    
            <div class="form-group col-md-6">
			    <label for="contactemail"><?php esc_html_e( 'Email Address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="contactemail" id="contactemail" autocomplete="email" value="<?php echo $contactemail ?>" />
		    </div>
		    
            <div class="form-group col-md-6">
			    <label for="phonenumber"><?php esc_html_e( 'Phone Number', 'woocommerce' ); ?>&nbsp;<span class="required"></span></label>
			    <input type="text" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="phonenumber" id="phonenumber" autocomplete="phone_number" value="<?php echo $phonenumber ?>" />
		    </div>

	    </div>

    </div>	

    <input class="btn btn-green w-100 mt-md-5" type="submit" name="wuf_save_account_details" value="Save Changes">

</form>

<?php

        if( isset( $_POST['wuf_save_account_details'] ) ) {

            $user_metas = array (
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'nickname' => $_POST['nickname'],
                'companyname' => $_POST['companyname'],
                'contactemail' => $_POST['contactemail'],
                'phonenumber' => $_POST['phonenumber'],
            );

            foreach( $user_metas as $key => $value ) {

                if( get_user_meta( $user_id, $key, true ) ) {

                    update_user_meta( $user_id, $key, $value, true );

                } else {

                    add_user_meta( $user_id, $key, $value, true );

                }

            }

        }
    }    
     
    add_action( 'custom-user-account', 'add_custom_user_fields' );
    
?>