<?php
/**
* Main PHP Class for Multisite setup
* 
* @author 		Alex Rabe 
* @copyright 	Copyright 2010
* 
*/
class nggWPMU{

	/**
	 * Check the Quota under WPMU. Only needed for this case
	 * 
	 * @class nggWPMU
	 * @return bool $result
	 */
	function check_quota() {
        	if ( get_site_option( 'upload_space_check_disabled' ) )
        		return false;

			if ( (is_multisite()) && wpmu_enable_function('wpmuQuotaCheck'))
				if( $error = upload_is_user_over_quota( false ) ) {
					nggGallery::show_error( __( 'Sorry, you have used your space allocation. Please delete some files to upload more files.','nggallery' ) );
					return true;
				}
			return false;
	}
}