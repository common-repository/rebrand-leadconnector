<?php
namespace BZ_LC;

define('BZLC_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZLC_PRODUCT_ID',   'RLCL');
define('BZLC_VERSION',   	'1.0');
define('BZLC_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZ_LC_NS','BZ_LC');
define('BZLC_PLUGIN_FILE', 'rebrand-leadconnector-lite/rebrand-leadconnector-lite.php');   //Main base file

class BZRebrandLCSettings {
		
		public $pageslug 	   = 'llc-rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	=> '',
				'plugin_desc'       	=> '',
				'plugin_author'     	=> '',
				'plugin_uri'        	=> '',
				
			);
        
				if ( is_plugin_active( 'blitz-rebrand-leadconnector-pro/blitz-rebrand-leadconnector-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
			$this->bzlc_activation_hooks();	
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzlc_activation_hooks() {
		
			global $blog_id;
	
			add_filter( 'gettext', 					array($this, 'bzlc_update_label'), 20, 3 );
			add_filter( 'all_plugins', 				array($this, 'bzlc_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzlc_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzlc_adminloadStyles'));
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzlc_load_wp_media_files'));
			
			add_action( 'admin_init',				array($this, 'bzlc_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzlc_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzlc_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzlc_hide_rebrand_from_menu'), 20, 2);
			}
		}
		
	public function bzlc_load_wp_media_files() {
    wp_enqueue_media();
}
	
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzlc_hide_rebrand_from_menu($lccurrent, $screen) {

			$rebranding = $this->bzlc_get_rebranding();

			$lccurrent .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';

			if($this->bzlc_getOption( 'rebrand_lc_screen_option','' )){
				
				$cartflows_screen_option = $this->bzlc_getOption( 'rebrand_lc_screen_option',''); 
				
				if($cartflows_screen_option=='show'){
					//$current .='It is showing now. ';
					$lccurrent .= __('Hide the "','bzlc').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzlc') .$hide;
					$lccurrent .= '<style>#adminmenu .toplevel_page_lc-plugin a[href="admin.php?page=llc-rebrand"]{display:block;}</style>';
				} else {
					//$current .='It is disabling now. ';
					$lccurrent .= __('Show the "','bzlc').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzlc') .$show;
					$lccurrent .= '<style>#adminmenu .toplevel_page_lc-plugin a[href="admin.php?page=llc-rebrand"]{display:none;}</style>';
				}		
				
			} else {
					//$current .='It is showing now. ';
					$lccurrent .= __('Hide the "','bzlc').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzlc') .$hide;
					$lccurrent .= '<style>#adminmenu .toplevel_page_lc-plugin a[href="admin.php?page=llc-rebrand"]{display:block;}</style>';
			}	

			$lccurrent .=' <br/><br/> </fieldset>' ;
			
			return $lccurrent;
		}
		
		
		
				
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzlc_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzlc_css', plugins_url('assets/css/bzlc-main.css', __FILE__) );
					wp_enqueue_style( 'bzlc_css' );
					
					wp_register_script( 'bzlc_js', plugins_url('assets/js/bzlc-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzlc_js' );
					
				}
			}
		}	
		
		
		
		
	   public function bzlc_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'leadcon_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'leadcon_rebrand');	
				}
			}

			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzlc_render_fields() {
			
			$branding = get_option( 'leadcon_rebrand');
			include BZLC_BASE_DIR . 'admin/bzlc-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		public function bzlc_menu() {  
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzlc');
			$rebranding = $this->bzlc_get_rebranding();
			
			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzlc_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'lc-plugin', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'lc-plugin', $title, $title, $cap, $slug, $func );
				}
			}	
			
			//~ echo '<pre/>';
			//~ print_r($menu);
				
			foreach($menu as $custommenusK => $custommenusv ) {
				if( $custommenusK == '58.5' ) {
					$menu[$custommenusK][0] = $rebranding['plugin_name']; //change menu Label
							
				}
			}
			return $menu;
		}
		
			
		
		/**
		 * Renders to fields
		*/
		public function bzlc_render() {
			
			$this->bzlc_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzlc_save_settings() {
			
			if ( ! isset( $_POST['llc_wl_nonce'] ) || ! wp_verify_nonce( $_POST['llc_wl_nonce'], 'llc_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['llc_submit'] ) ) {
				return;
			}
			$this->bzlc_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzlc_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzlc_get_rebranding();
			
			echo '<style id="llc-wl-admin-style">';
			include BZLC_BASE_DIR . 'admin/bzlc-style.css.php';
			echo '</style>';
			
			echo '<script id="llc-wl-admin-script">';
			include BZLC_BASE_DIR . 'admin/bzlc-script.js.php';
			echo '</script>';
			
		}	  
	
	

		/**
		 * Update branding
		*/
	    public function bzlc_update_branding() {
			
			if ( ! isset($_POST['llc_wl_nonce']) ) {
				return;
			}
			

			$data = array(
				'plugin_name'       => isset( $_POST['llc_wl_plugin_name'] ) ? sanitize_text_field( $_POST['llc_wl_plugin_name'] ) : '',
				
				'plugin_desc'       => isset( $_POST['llc_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['llc_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['llc_wl_plugin_author'] ) ? sanitize_text_field( $_POST['llc_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['llc_wl_plugin_uri'] ) ? sanitize_text_field( $_POST['llc_wl_plugin_uri'] ) : '',
								
			);

			update_option( 'leadcon_rebrand', $data );
		}
    
    
     
  
  
		
		/**
		 * change plugin meta
		*/  
        public function bzlc_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['leadconnector/LeadConnector.php'] ) ) {
				return $all_plugins;
			}
		
			$rebranding = $this->bzlc_get_rebranding();
			
			$all_plugins['leadconnector/LeadConnector.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['leadconnector/LeadConnector.php']['Name'];
			
			$all_plugins['leadconnector/LeadConnector.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['leadconnector/LeadConnector.php']['PluginURI'];
			
			$all_plugins['leadconnector/LeadConnector.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['leadconnector/LeadConnector.php']['Description'];
			
			$all_plugins['leadconnector/LeadConnector.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['leadconnector/LeadConnector.php']['Author'];
			
			$all_plugins['leadconnector/LeadConnector.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['leadconnector/LeadConnector.php']['AuthorURI'];
			
			$all_plugins['leadconnector/LeadConnector.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['leadconnector/LeadConnector.php']['Title'];
			
			$all_plugins['leadconnector/LeadConnector.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['leadconnector/LeadConnector.php']['AuthorName'];
			
			return $all_plugins;
			
		}
	
    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzlc_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzlc_get_rebranding();
			
			$bzlc_new_text = $translated_text;
			$bzlc_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			if ( ! empty( $bzlc_name ) ) {
				$bzlc_new_text = str_replace( 'LeadConnector', $bzlc_name, $bzlc_new_text );
				$bzlc_new_text = str_replace( 'leadconnector', $bzlc_name, $bzlc_new_text );
				$bzlc_new_text = str_replace( 'Lead Connector', $bzlc_name, $bzlc_new_text );
			}
			
			return $bzlc_new_text;
		}
	
	
	
		
		   
		/**
		 * update options
		*/
		public function bzlc_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		
		   
		/**
		 * get options
		*/	
		public function bzlc_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}
		
	
} //end Class
