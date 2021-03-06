<?php
/**
 * Write your own functions or modify functions, actions, and filters using this file.
 * LIST YOUR FUNCTIONS (optional):
 * cp_import_wp_childstyle() [CUSTOM]
 * cp_get_price() [OVERWRITE]
 */

//Place All Your Custom Function Below This Line

/**
 * HOMEPAGE DYNAMIC SIDEBAR LOGIN/REGISTRATION  : here we are updating the home page sidebar
 * to have a login form and display user options when logged in. Already enabled in child theme.
 * USE: I suggest you replace the get_option('cp_ads_welcome_msg') on sidebar.php with our new
 * function here <?php echo cp_dynamic_get_option('cp_ads_welcome_msg'); ?>.
 */
function cp_dynamic_welcome_widget($optionString) {
 global $user_ID, $user_identity, $user_level;
 if(!isset($optionString)) $optionString = 'cp_ads_welcome_msg';
 if ( $user_ID ) {
 $smHomepageSidebar = '<h2>User Options</h2>';
 $smHomepageSidebar .= '<div>';
 $smHomepageSidebar .= '<ul>';
 $smHomepageSidebar .= '<li><a href="' . CP_DASHBOARD_URL . '">' . __('My Dashboard','cp') . '</a></li>' ;
 $smHomepageSidebar .= '<li><a href="' . CP_PROFILE_URL . '">' . __('Edit Profile','cp') . '</a></li>';
 $smHomepageSidebar .= '<li><a href="' . CP_PROFILE_URL . 'change_password/">' . __('Change Password','cp') . '</a></li>';
 if (current_user_can('manage_options'))
 $smHomepageSidebar .= '<li><a href="' . get_option('home') . '/wp-admin/">' . __('WordPress Admin','cp') . '</a></li>';
 $smHomepageSidebar .= '<li><a href="' . wp_logout_url() . '">' . __('Log Out','cp') . '</a></li>';
 $smHomepageSidebar .= '</ul>';
 $smHomepageSidebar .= '</div><!-- /recordfromblog -->';
 }
 else {    //if the user has no user ID then they are not logged in
 $smHomepageSidebar = '<div style="padding-bottom:10px;">';
 $smHomepageSidebar .= get_option($optionString); //cp_ads_welcome_msg
 $smHomepageSidebar .= '<div style="float: right; text-align: center;">';
 $smHomepageSidebar .= '<a href="' . get_option('home') . '/wp-login.php">' . __("Already a Member?", 'cp') . '</a><br />';
 $smHomepageSidebar .= '</div>';
 if (get_option('users_can_register') || get_blog_option($blog_id, 'users_can_register', 0))
 $smHomepageSidebar .= '<a href="' . get_option('home') . '/wp-login.php?action=register">' . __("Join Now!", 'cp') . '</a>';
 $smHomepageSidebar .= '<br />';
 $smHomepageSidebar .= '</div><!-- /dotted -->';

 //Create the Login Form
 $smHomepageSidebar .= '<div style="margin-top: 10px;">';
 $smHomepageSidebar .= '<form action="' . get_bloginfo('url') . '/wp-login.php" method="post">';
 $smHomepageSidebar .= '<label style="font-size: 11px; margin-left: 1px;" for="log">Username: <input type="text" name="log" id="log" value="' .  wp_specialchars(stripslashes($user_login), 1) . '" size="11" style="height: 10px; font-size: 10px;" /></label>';

 $smHomepageSidebar .= '<label style="font-size: 11px; margin-left: 1px;" for="pwd">Password: <input type="password" name="pwd" id="pwd" size="11" style="height: 10px; font-size: 10px;" /></label>';
 $smHomepageSidebar .= '<input style="font-size: 11px; margin-left: 1px;" type="submit" name="submit" value="Login"  /><br />';
 $smHomepageSidebar .= '<label style="font-size: 11px; margin-left: 1px; vertical-align:baseline; line-height: 2.1em;" for="rememberme"><input  style="margin: 0; position: relative; top: 3px;" name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me </label>  | ';
 $smHomepageSidebar .= '<a style="font-size: 11px; margin-left: 1px;" href="' . get_bloginfo('url') . '/wp-login.php?action=lostpassword">Recover password</a>';
 $smHomepageSidebar .= '<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '"/>';
 $smHomepageSidebar .= '</form>';
 $smHomepageSidebar .= '</div>';
 }
 return $smHomepageSidebar;
}


//change price to spit out correct looking currency and ignore anything that's not a price.
function cp_get_price($postid) {
	if(get_post_meta($postid, 'cp_price', true)) {
		$price_out = get_post_meta($postid, 'cp_price', true);

		// uncomment the line below to change price format
		$price_out =  ereg_replace("[^0-9.]", "", $price_out);
		$price_out = number_format($price_out, 2, '.', ',');
		$price_out = cp_pos_currency($price_out);
	} else {
		if( get_option('cp_force_zeroprice') == 'yes' )
			$price_out = cp_pos_currency(0);
		else
			$price_out = '&nbsp;';
	}
	echo $price_out;
}


//Do not place any code below this line.
?>