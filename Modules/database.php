<?php
/**
 * @Author: Eka Syahwan
 * @Date:   2018-09-05 18:32:27
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2018-10-01 03:59:49
*/
class Database
{	
	public function menu(){
		$menu[] = array(
			'title' 	=> '[Wordpress] Scanner Plugin & Themes',
			'action' 	=> 'wordpress_scanner_plugin', 
		);
		$menu[] = array(
			'title' 	=> '[Wordpress] Exploit Plugin & Themes',
			'action' 	=> 'wordpress_exploit_plugin_themes', 
		);
		$menu[] = array(
			'title' 	=> '[Wordpress] Attack default admin',
			'action' 	=> 'wordpress_exploit_defaultadmin', 
		);
		$menu[] = array(
			'title' 	=> '[Scanner] Cms Detector',
			'action' 	=> 'scanner_cms_detector', 
		);
		$menu[] = array(
			'title' 	=> '[Magento] LFI & Upload Shell',
			'action' 	=> 'magento_exploit', 
		);
		$menu[] = array(
			'title' 	=> '[Joomla] Scanner Plugin',
			'action' 	=> 'scanner_plugins_joomla', 
		);
		$menu[] = array(
			'title' 	=> '[Joomla] Exploit ',
			'action' 	=> 'joomla_exploit_menu', 
		);
		return $menu;
	}
	public function menu_exploit(){
		$menu[] = array(
			'title' 	=> 'Email Subscribers',
			'action' 	=> 'Email_Subscribers', 
		);
		$menu[] = array(
			'title' 	=> 'Gravity Forms',
			'action' 	=> 'Gravity_Forms', 
		);
		$menu[] = array(
			'title' 	=> 'WP Content Injection',
			'action' 	=> 'content_injection', 
		);
		$menu[] = array(
			'title' 	=> 'Woocommerce order export',
			'action' 	=> 'w_o_e', 
		);
		return $menu;
	}
	public function menu_exploitJoomla(){
		$menu[] = array(
			'title' 	=> 'jLike 1.0 - Information Leak',
			'action' 	=> 'jLike_Component', 
		);
		
		return $menu;
	}
	public function cms_detector(){
		$cms = array(
			'wordpress' => 'wp-content', 
			'magento' 	=> '/skin/frontend',
			'joomla' 	=> 'Joomla! - Open Source Content Management',
			'drupal' 	=> 'sites/all/modules',
		);
		return $cms;
	}
	public function joomla_plugins(){
		$plugins = array(
			'com_jlike' 				=> 'administrator/components/com_jlike/config.xml', //https://www.exploit-db.com/exploits/43977/
			'com_joomanager' 			=> 'administrator/components/com_joomanager/views/items/metadata.xml', // https://www.exploit-db.com/exploits/42590/
			'com_simpleimageupload' 	=> 'administrator/components/com_simpleimageupload/manifest.xml', //https://www.exploit-db.com/exploits/37364/
			'com_macgallery' 			=> 'administrator/components/com_macgallery/com_macgallery.xml', //https://www.exploit-db.com/exploits/34755/
			'com_creativecontactform' 	=> 'administrator/components/com_creativecontactform/config.xml',
			'com_hwdvideoshare' 		=> 'administrator/components/com_hwdvideoshare/config.xml',
			'com_joomsport' 			=> 'administrator/components/com_joomsport/config.xml',
		);
		return $plugins;
	}
	public function wordpress_plugins(){
		$plugins = array(
			'ckeditor-for-wordpress' 		=> 'wp-content/plugins/ckeditor-for-wordpress/readme.txt',
			'email-subscribers' 			=> 'wp-content/plugins/email-subscribers/readme.txt',
			'wp-checkout' 					=> 'wp-content/plugins/wp-checkout/readme.txt', 
			'wp-responsive' 				=> 'wp-content/plugins/wp-responsive-thumbnail-slider/readme.txt', 
			'peugeot-music-plugin' 			=> 'wp-content/plugins/peugeot-music-plugin/readme.txt',
			'uploader' 						=> 'wp-content/plugins/uploader/readme.txt',
			'viral-optins' 					=> 'wp-content/plugins/viral-optins/readme.txt',
			'Tevolution' 					=> 'wp-content/plugins/Tevolution/readme.txt',
			'revslider'	 					=> 'wp-content/plugins/revslider/readme.txt',
			'category-page-icons' 			=> 'wp-content/plugins/category-page-icons/readme.txt',
			'downloads-manager' 			=> 'wp-content/plugins/downloads-manager/readme.txt',
			'file-upload' 					=> 'wp-content/plugins/formcraft/file-upload/readme.txt',
			'cherry-plugin' 				=> 'wp-content/plugins/cherry-plugin/readme.txt',
			'hd-webplayer' 					=> 'wp-content/plugins/hd-webplayer/readme.txt',
			'job-manager-uploads'			=> 'wp-content/plugins/job-manager-uploads/readme.txt',
			'u-design' 						=> 'wp-content/themes/u-design/styles/readme.txt',
			'wp-easycart' 					=> 'wp-content/plugins/wp-easycart/readme.txt',
			'wp-filemanager' 				=> 'wp-content/plugins/wp-filemanager/readme.txt',
			'viral-optins' 					=> 'wp-content/plugins/viral-optins/readme.txt',
			'blaze-slide' 					=> 'wp-content/plugins/blaze-slide-show-for-wordpress/readme.txt',
			'simple-ads-manager' 			=> 'wp-content/plugins/simple-ads-manager/readme.txt',
			'cherry-plugin' 				=> 'wp-content/plugins/cherry-plugin/readme.txt',
			'sfwd-lms'						=> 'wp-content/plugins/sfwd-lms/readme.txt',
			'woocommerce' 					=> 'wp-content/plugins/woocommerce/readme.txt',
			'qualifire' 					=> 'wp-content/themes/qualifire/qualifire/style.css',
			'striking-r' 					=> 'wp-content/themes/striking_r/framework/plugins/wordpress-importer/readme.txt',
			'RightNow' 						=> 'wp-content/themes/RightNow/readme.txt',
			'wf_woocommerce_order_im_ex' 	=> 'wp-admin/admin.php?page=wf_woocommerce_order_im_ex&action=export',
		);
		return $plugins;
	}
}