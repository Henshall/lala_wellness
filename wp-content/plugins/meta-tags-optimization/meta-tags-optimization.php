<?php 
/*
Plugin Name: Meta Tags Optimization
Description: Check Meta Title, Meta Keywords(s) and Meta Description on posts and pages and consult with a seo expert.
Author: flippercode
Version: 1.6.2
Author URI: http://www.flippercode.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

if ( ! class_exists( 'FC_Meta_Tags_Optimization' ) ) {
	/**
	 * Main plugin class
	 * @author Flipper Code <hello@flippercode.com>
	 * @package Posts
	 */
	class FC_Meta_Tags_Optimization
	{
		/**
		 * List of Modules.
		 * @var array
		 */
		private $modules = array();

		/**
		 * Intialize variables, files and call actions.
		 * @var array
		 */
		public function __construct() {
			
			error_reporting( E_ERROR | E_PARSE );
			$this->_define_constants();
			$this->_load_files();
			register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );
			add_action( 'plugins_loaded', array( $this, 'load_plugin_languages' ) );
			add_action( 'init', array( $this, '_init' ) );
			add_action( 'add_meta_boxes', array($this,'mto_seo_add_custom_box') );

		}
		
		/* Adds a box to the main column on the Post and Page edit screens */
		function mto_seo_add_custom_box() {
			
			$post_types=get_post_types('','names');
			foreach ($post_types as $post_type ) {
				add_meta_box( 'mto_seo_sectionid', 'Meta Tags Optimization',array($this,'mto_seo_inner_custom_box'), $post_type);
			}


		}
				
				/* Prints the box content for Posts */
		function mto_seo_inner_custom_box( $post ) {

		// get post's meta title


		$post_meta_rs=$this->get_post_meta_all($post->ID);

		// get post meta title
		$post_meta_title1='';
		$post_meta_title2='';
		if($post_meta_rs['_aioseop_title']!=''){
			$post_meta_title1=$post_meta_rs['_aioseop_title'];
		}
		else{
			$post_meta_title1=$post->post_title;
		}
		// keyword is here
		$post_meta_keywords=$post_meta_rs['_aioseop_keywords'];

			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			
			if ($site_description){
				$post_meta_title2=" | ".$site_description;
			}
			else{
				$post_meta_title2="";
			}
				
		$post_meta_title=$post_meta_title1;

		// this is for title
		$title_res=$this->checkTitle($post_meta_title,$post_meta_keywords);

		//this is for keywords
		$keyword_res=$this->checkKeyword($post_meta_keywords,$post_meta_keywords);

		//this is for descriptions
		$post_meta_desc=$post_meta_rs['_aioseop_description'];
		$desc_res= $this->metaDescription($post_meta_keywords,$post_meta_desc);


		  // Use nonce for verification
		  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

		?>
		<style>
		.info, .success, .warning, .error, .validation {
		border: 1px solid;
		margin: 10px 0px;
		padding:15px 10px 15px 50px;
		background-repeat: no-repeat;
		background-position: 10px center;
		}
		.info {
		color: #00529B;
		background-color: #BDE5F8;
		background-image: url('<?php echo home_url() . '/wp-content/plugins/meta-tags-optimization/'?>info.png');
		}
		.success {
		color: #4F8A10;
		background-color: #DFF2BF;
		background-image:url('<?php echo home_url() . '/wp-content/plugins/meta-tags-optimization/'?>success.png');
		}
		.warning {
		color: #9F6000;
		background-color: #FEEFB3;
		background-image: url('<?php echo home_url() . '/wp-content/plugins/meta-tags-optimization/'?>warning.png');
		}
		.error {
		color: #D8000C;
		background-color: #FFBABA;
		background-image: url('<?php echo home_url() . '/wp-content/plugins/meta-tags-optimization/'?>error.png');
		}
		.data_info
		{
			font-weight:bold;
			}
			
		.value_info
		{
			font-style:italic;
			}	
		</style>
		<?
			
		  // The actual fields for data entry
		  echo '<table><tr><td><label for="myplugin_new_field" class="data_info">';
			   _e("Post Title : ", 'myplugin_textdomain' );
		  
		  echo '</label><label class="value_info">'.$post_meta_title.'</label></td></tr>';
		  
		  echo '<tr><td> <fieldset class="'.$title_res['type'].'">'.$title_res['message'].'</fieldset></td></tr>';

		  echo '<tr><td><label for="myplugin_new_keyword_field" class="data_info">';
			   _e("Post Keyword(s) : ", 'myplugin_textdomain' );
		  
		  echo '</label><label class="value_info">'.$post_meta_keywords.'</label> </td></tr>';
		  
		  echo '<tr><td><fieldset class="'.$keyword_res['type'].'">'.$keyword_res['message'].'</fieldset></td><br></tr>';
		  
		  echo '<tr><td><label for="myplugin_new_desc_field" class="data_info">';
			   _e("Post Description : ", 'myplugin_textdomain' );
		  echo '</label><label class="value_info">'.$post_meta_desc.'</label></td></tr> ';
		  
		  echo '<tr><td><fieldset class="'.$desc_res['type'].'">'.$desc_res['message'].'</fieldset></td></tr>';

		  echo '<tr><td><fieldset class="info">To Discuss with SEO Consultant and Optimize your Meta Tags, Go with <a target="_blank" href="http://codecanyon.net/item/meta-tags-optimization/4915633">Pro Version</a></fieldset></td></tr></table>';
		  

		} // End functio mto_seo_inner_custom_box
		
		/**
		 * Call WordPress hooks.
		 */
		function _init() { 
			global $wpdb;
			add_action( 'admin_menu', array( $this, 'create_menu' ) );
			
		add_filter( 'plugin_row_meta', array($this,'plugin_row_meta'), 10,2 );

		}
		/**
		 * Settings link.
		 * @param  array $links Array of Links.
		 * @return array        Array of Links.
		 */
		function plugin_row_meta( $links, $file ) {

			if( basename(dirname($file)) == 'meta-tags-optimization' ) {
				$links[] = '<a href="https://codecanyon.net/item/meta-tags-search-engine-optimization-for-wordpress/4915633" target="_blank">Upgrade to Pro</a>';
		   		$links[] = '<a href="http://www.flippercode.com/forums" target="_blank">Support Forums</a>';
			}		
		   
		   return $links;
		}
		
		/**
		 * Process slug and display view in the backend.
		 */
		function processor() {
			error_reporting( E_ERROR | E_PARSE );

			$return = '';
			if ( isset( $_GET['page'] ) ) {
				$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );
			} else {
				$page = 'mto_view_overview';
			}

			$pageData = explode( '_', $page );
			
			if ( 'mto' != strtolower( $pageData[0] ) ) {
				return;
			}
			$obj_type = $pageData[2];
			$obj_operation = $pageData[1];

			if ( count( $pageData ) < 3 ) {
				die( 'Cheating!' );
			}

			try {
				if ( count( $pageData ) > 3 ) {
					$obj_type = $pageData[2].'_'.$pageData[3];
				}

				$factoryObject = new MTO_Controller();
				$viewObject = $factoryObject->create_object( $obj_type );
				$viewObject->display( $obj_operation );

			} catch (Exception $e) {
				echo mto_Template::show_message( array( 'error' => $e->getMessage() ) );

			}

		}

		/**
		 * Create backend navigation.
		 */
		function create_menu() {

			global $navigations;
            
			$pagehook1 = add_menu_page(
				__( 'Meta  Tags Optimisation', MTO_TEXT_DOMAIN ),
				__( 'Meta  Tags Optimisation', MTO_TEXT_DOMAIN ),
				'mto_admin_overview',
				MTO_SLUG,
				array( $this,'processor' )
			);

			if ( current_user_can( 'manage_options' )  ) {
								$role = get_role( 'administrator' );
								$role->add_cap( 'mto_admin_overview' );
			}

			$this->load_modules_menu();
			add_action( 'load-'.$pagehook1, array( $this, 'mto_backend_scripts' ) );
		}
		
		/**
		 * Eneque scripts in the backend.
		 */
		function mto_backend_scripts() {

			wp_enqueue_style( 'wp-color-picker' );
			$wp_scripts = array( 'jQuery', 'wp-color-picker', 'jquery-ui-datepicker','jquery-ui-slider' );

			if ( $wp_scripts ) {
				foreach ( $wp_scripts as $wp_script ) {
					wp_enqueue_script( $wp_script );
				}
			}

			$scripts = array();

			$scripts[] = array(
			'handle'  => 'mto-backend-bootstrap',
			'src'   => MTO_JS.'bootstrap.min.js',
			'deps'    => array(),
			);
			
			if ( $scripts ) {
				foreach ( $scripts as $script ) {
					wp_enqueue_script( $script['handle'], $script['src'], $script['deps'] );
				}
			}
			

			$admin_styles = array(
			'mto-flippercode-bootstrap' => MTO_CSS.'bootstrap.min.flat.css',
			'mto-backend-style' => MTO_CSS.'backend.css'
			);

			if ( $admin_styles ) {
				foreach ( $admin_styles as $admin_style_key => $admin_style_value ) {
					wp_enqueue_style( $admin_style_key, $admin_style_value );
				}
			}

		}
		
		/**
		 * Read models and create backend navigation.
		 */
		function load_modules_menu() {

			$modules = $this->modules;
			$pagehooks = array();
			if ( is_array( $modules ) ) {
				foreach ( $modules as $module ) {

						$object = new $module;
					if ( method_exists( $object,'navigation' ) ) {

						if ( ! is_array( $object->navigation() ) ) {
							continue;
						}

						foreach ( $object->navigation() as $nav => $title ) {

							if ( current_user_can( 'manage_options' ) && is_admin() ) {
								$role = get_role( 'administrator' );
								$role->add_cap( $nav );

							}

							$pagehooks[] = add_submenu_page(
								MTO_SLUG,
								$title,
								$title,
								$nav,
								$nav,
								array( $this,'processor' )
							);

						}
					}
				}
			}

			if ( is_array( $pagehooks ) ) {

				foreach ( $pagehooks as $key => $pagehook ) {
					add_action( 'load-'.$pagehooks[ $key ], array( $this, 'mto_backend_scripts' ) );
				}
			}

		}

		
		/**
		 * Load plugin language file.
		 */
		function load_plugin_languages() {

			load_plugin_textdomain( MTO_TEXT_DOMAIN, false, MTO_FOLDER.'/lang/' );
		}
		/**
		 * Call hook on plugin activation for both multi-site and single-site.
		 * @param  boolean $network_wide IS network activated?.
		 */
		function plugin_activation($network_wide = null) {

			if ( is_multisite() && $network_wide ) {
				global $wpdb;
				$currentblog = $wpdb->blogid;
				$activated = array();
				$sql = "SELECT blog_id FROM {$wpdb->blogs}";
				$blog_ids = $wpdb->get_col( $wpdb->prepare( $sql, null ) );

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->mto_activation();
					$activated[] = $blog_id;
				}

				switch_to_blog( $currentblog );
				update_site_option( 'op_activated', $activated );

			} else {
				$this->mto_activation();
			}
		}
		/**
		 * Call hook on plugin deactivation for both multi-site and single-site.
		 * @param  boolean $network_wide IS network activated?.
		 */
		function plugin_deactivation($network_wide) {

			if ( is_multisite() && $network_wide ) {
				global $wpdb;
				$currentblog = $wpdb->blogid;
				$activated = array();
				$sql = "SELECT blog_id FROM {$wpdb->blogs}";
				$blog_ids = $wpdb->get_col( $wpdb->prepare( $sql, null ) );

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->mto_deactivation();
					$activated[] = $blog_id;
				}

				switch_to_blog( $currentblog );
				update_site_option( 'op_activated', $activated );

			} else {
				$this->mto_deactivation();
			}
		}

		/**
		 * Perform tasks on plugin deactivation.
		 */
		function mto_deactivation() {

		}
		
					
		function checkTitle($titleText="",$keywordsData="")
			{
				$titleText=strtolower($titleText);
				$keywordsData=strtolower($keywordsData);
				$titleLength=strlen($titleText);
				
				if($titleLength==0)
				{
				$result="Title is misssing.";
				$return['type']='error';
				$return['message']=$result;
				return $return;
				}
				$keywordPosition=0;
				$isKeywordExist=false;
				$countEachValue=array(0=>"1",1=>"1",2=>"1");
					// total # of seperator
					$seperator["bar"]["total"]=substr_count($titleText,"|");
					$seperator["dash"]["total"]=substr_count($titleText,"-");
					$seperator["colon"]["total"]=substr_count($titleText,":");
					$seperator["greater"]["total"]=substr_count($titleText,">");
					
					// last occurance of each seperator
					$lastIndex=0;
					$sep='=';
					$seperator["bar"]["last"]=strrpos($titleText,"|");
					if($seperator["bar"]["last"]>$lastIndex)
					{
					$lastIndex=$seperator["bar"]["last"];
					$sep='|';
					}
					$seperator["dash"]["last"]=strrpos($titleText,"-");
					
					if($seperator["dash"]["last"]>$lastIndex)
					{
					$lastIndex=$seperator["dash"]["last"];
					$sep='-';
					}
					$seperator["colon"]["last"]=strrpos($titleText,":");
					
					if($seperator["colon"]["last"]>$lastIndex)
					{
					$lastIndex=$seperator["colon"]["last"];
					$sep=':';
					}
					$seperator["greater"]["last"]=strrpos($titleText,">");
					
					if($seperator["greater"]["last"]>$lastIndex)
					{
					$lastIndex=$seperator["greater"]["last"];
					$sep='>';
					}
				
			
					$splitTitle=explode($sep,trim($titleText));
					
					$splitKeyword=explode(",",trim(strtolower($keywordsData)));
				
				   if($seperator["bar"]["total"]>0 and $sep!='|')
				   {
						$splitTitle[0]=explode("|",$splitTitle[0]);
				   }
					if($seperator["dash"]["total"]>0 and $sep!='-')
				   {
						$splitTitle[0]=explode("-",$splitTitle[0]);
				   }
					if($seperator["greater"]["total"]>0 and $sep!='>')
				   {
						$splitTitle[0]=explode(">",$splitTitle[0]);
				   }
				   
				   if($seperator["colon"]["total"]>0 and $sep!=':')
				   {
						$splitTitle[0]=explode(":",$splitTitle[0]);
				   }
					
				
					$left=count($splitTitle[0])."<br><br>";
					$right=count($splitTitle[1]);	
						
					$keywordLeftSide=false;
					$keywordRightSide=false;
					$unableToPredict=false;
					if($left>1 and $right==1)
					{
						$isKeywordExist=false;
						$keywordLeftSide=false;
						//use this to check repeated keywords
						$countEachValue=array_count_values($splitTitle[0]);
						
						$leftPositionArray=array();
						foreach($countEachValue as $name=>$position){
							$leftPositionArray[]=$name;
							if(in_array(trim($name),$splitKeyword))
							{
								$isKeywordExist=true;
								$keywordLeftSide=true;
							}
							
						} // End Foreach
						
						// check if keyword is not exists in lefy spilt title,then check it in right
						if($keywordLeftSide==false){
							if(in_array(trim($splitTitle[1]),$splitKeyword)){
								$isKeywordExist=true;
								$keywordRightSide=true;
							}
							else{
								$isKeywordExist=false;
								$unableToPredict=true;
							}
						}
						
					
					}
					if($left==1 and $right>1)
					{
						$isKeywordExist=false;
						$keywordRightSide=false;
						//use this to check repeated keywords
						$countEachValue=array_count_values($splitTitle[1]);
						$rightPositionArray=array();
						foreach($countEachValue as $name=>$position){
							$leftPositionArray[]=$name;
							if(in_array(trim($name),$splitKeyword))
							{
								$isKeywordExist=true;
								$keywordRightSide=true;
							}
							
						} // End Foreach
						
						// check if keyword is not exists in right spilt title,then check it in left
						if($keywordRightSide==false){
							if(in_array(trim($splitTitle[0]),$splitKeyword)){
								$isKeywordExist=true;
								$keywordLeftSide=true;
							}
							else{
								$isKeywordExist=false;
								$unableToPredict=true;
							}
						}
					}
					
					if($left==1 and $right==1)
					{
						//use this to check repeated keywords
						
						if(in_array(trim($splitTitle[0]),$splitKeyword)){
						$isKeywordExist=true;
						$keywordLeftSide=true;
						}
						else if(in_array(trim($splitTitle[1]),$splitKeyword)){
						$isKeywordExist=true;
						$keywordRightSide=true;
						}
						else{
						$isKeywordExist=false;
						$unableToPredict=true;
						}
													
					}
					
					$type='error';
					//Now check all condition one by one
					
					//If the title is <69 and the keyword is located first in order, then the text "Title Text 1" shows.
					if($titleLength<=69 and $keywordLeftSide==true and $keywordsData!='')
					{
						$type='success';

						$result="Done! You're done.";
					}
					
					
					//If the title is <69 and the keyword is located but NOT as the first word in order, then the text Title Text 2" shows. And you receive a score of -
					
					elseif($titleLength<69 and $keywordRightSide==true  and $keywordsData!='')
					{
						$type='success';
						$result="Done! You're done.";
					}
					
					// If the title is <69 and the keyword is NOT located at all, then the text "Title Text 3" shows. And you receive a score of –
					elseif($titleLength<69 and $isKeywordExist==false)
					{
						$result="The title is <69 characters and the keyword is NOT located at all";
					}
				
					//If the title is <69 and the keyword is located more than 1 time in the title , then the text "Title Text 4" shows. And you receive a score of  –
					elseif($titleLength<69 and array_filter($countEachValue,"multipleEntries"))
					{
						$result="The title is <69 characters and the keyword is located more than 1 time in the title";
					}
				
					//If the title is >69 and the keyword is located first in order, then the text "Title Text 5" shows.
					elseif($titleLength>69 and $keywordLeftSide==true)
					{
						$result="The title is >69 characters and the keyword is located first in order";
					}
					
					//If the title is >69 and the keyword is located but NOT as the first word in order, then the text "Title Text 6" shows. And you receive a score of -
					
					elseif($titleLength>69 and $keywordRightSide==true)
					{
						$result="The title is >69 characters and the keyword is located but NOT as the first word in order";
					}
					
					// If the title is >69 and the keyword is NOT located at all, then the text "Title Text 7" shows. And you receive a score of –
					elseif($titleLength>69 and $isKeywordExist==false)
					{
						$result="The title is >69 characters and the keyword is NOT located at all";
					}
				
					//If the title is >69 and the keyword is located more than 1 time in the title , then the text "Title Text 8" shows. And you receive a score of  –
						elseif($titleLength>69 and count($countEachValue)>0 and array_filter($countEachValue,"multipleEntries"))
						{
							$result="The title is >69 characters and the keyword is located more than 1 time in the title";
						}
					
					// If a title is NOT located at all, then the text "Title Text 9" shows. And you receive a score of  –	
						elseif($right==0 and $splitTitle[0]=='')
						{
							$result=" Title is missing";
						}
						elseif($keywordsData=='')
						{
							
								$result="Title doesn't have any keyword.";
						}	
				
				
					 $return['type']=$type;
					 $return['message']=$result;		
					 return $return;
			}	
			
		function checkKeyword($keywords,$searchKeywords)
			{
			$type='error';
			if($keywords=='')
				{
					$result="Keyword(s) is misssing.";	
				  $return['type']=$type;
		   $return['message']=$result;
			
			return $return;
		  
				
				}
		   $searchkeywords=trim($searchKeywords);
		   if($searchkeywords)
		   $findKeywords=explode(',',$searchKeywords);
		   if(trim($keywords))
		   {
		   $allKeywords=explode(',',$keywords);
		   $totalKeywords=count($allKeywords);
		   }
		   else
		   $totalKeywords=0;
		   
		   $singleKeywords=true;
		   $keywordsfound=false;
		   // search Keywords in mentioned keywords
		   if(trim($keywords))
		   $keywordsStatus=array_count_values($allKeywords);
		   if($searchkeywords && $keywordsStatus)
		   {
		   foreach($keywordsStatus as $key=>$value)
		   {
			if(in_array(trim($key),$findKeywords))
			{
			 $keywordsfound=true;
			 if($value>1)
			  $singleKeywords=false;
			}
		   }
		   }
		   
		   // check multiple entries in keywords
		   $multipleKeywords=false;
		   if(count($keywordsStatus))
		   {
		   foreach($keywordsStatus as $key=>$value)
		   {
			 if($value>1)
			 {
			  $multipleKeywords=true;
			 }
		   }
		   }
		   
		//   If you find 1-5 meta keywords, and the keyword you search for is in there once, then show text "Meta Keyword 1".

		   if($totalKeywords>=1 and $totalKeywords<=5 and $singleKeywords==true and $keywordsfound==true)
		   {
							$type='success';

			$result="Done! You're done.";
		   }
		//          If you find 1-5 meta keywords, and the keyword you search for is there MORE then once, then show text "Meta Keyword 2".  And you receive a core of –
		   
		  if($totalKeywords>=1 and $totalKeywords<=5 and $singleKeywords==false)
		   {
			$result="The keyword is < 5 and located Multiple Times";
		   }

		//          If you find 1-5 meta keywords, and the keyword you search for is NOT there at all, then show text "Meta Keyword 3".  And you receive a core of –

		  if($totalKeywords>=1 and $totalKeywords<=5 and $keywordsfound==false and $searchkeywords!='')
		   {
			$result="The keyword is < 5 and the keyword is NOT located at all";
		   }
		   
		//          If you find >5 meta keywords, and the keyword you search for is there once, then show text "Meta Keyword 4".  And you receive a core of –
		   
		   if($totalKeywords>5 and $singleKeywords==true and $keywordsfound==true)
		   {
			$result="The keyword is > 5 and located only once";
			
		   }

		//          If you find >5 meta keywords, and the keyword you search for is there MORE then once, then show text "Meta Keyword 5".  And you receive a core of –

		   if($totalKeywords>5 and $singleKeywords==false)
		   {
			$result="The keyword is > 5 and located Multiple Times";
		   }
		   
		//          If you find >5 meta keywords, and the keyword you search for is NOT there at all, then show text "Meta Keyword 6".  And you receive a core of –

		   if($totalKeywords>5 and $keywordsfound==false and $searchkeywords!='')
		   {
			$result="The keyword is > 5 and the keyword is NOT located at all";
		   }
		   
		//    If you find NO meta keywords at all, then show text "Meta keyword 7". And you receive a core of –
		   
		   if($totalKeywords==0)
		   {
			$result="Keyword is missing";
		   }
		   
		   if($totalKeywords>5 and $searchkeywords=='')
		   {
			$result="the keyword is > 5 ";
			
		   }
		   if($totalKeywords>=1 and $totalKeywords<=5 and $searchkeywords=='' and $multipleKeywords==true)
		   {
				$type='success';
				$result="Done! You're done.";
		   }
		   
		   if($totalKeywords>=1 and $totalKeywords<=5 and $searchkeywords=='' and $multipleKeywords==false)
		   {
			$result="the keyword is < 5 and Keyword Located Multiple times";
		   }
		   
		$return['type']=$type;
		   $return['message']=$result;		
				return $return;
				
		 } // End function
			
		function metaDescription($allKeywordsData,$metaDescription)
			{
					$type='error';
				
				  $desLength=strlen($metaDescription);
				  
				  if($desLength==0)
						{
							$result="Description is misssing.";	
						  $return['type']=$type;
				   $return['message']=$result;
					
					return $return;
				  
						}
				  $keywordAtStarting=false;
				  $keywordInDes=false;
				  $allKeywords=explode(",",$allKeywordsData);
				  for($i=0;$i<count($allKeywords);$i++)
				  {
				 
				   if((strripos(ltrim($metaDescription),trim($allKeywords[$i])))===0)
					 {
					  $keywordAtStarting=true;
					 }
				  }
				  
				  for($i=0;$i<count($allKeywords);$i++)
				  {
				
				   if((strripos(ltrim($metaDescription),trim($allKeywords[$i])))!==false)
					 {
					  $keywordInDes=true;
					 }
				  }
				  // now apply condition 
				  
				//    If you find NO description at all. Then show text "Meta desc Text 1". And you receive a core of –
				  if($desLength==0)
				  {
				   $result="Description is misssing.";
					$return['type']=$type;
				   $return['message']=$result;
					
					return $return;
				  
				  }
				 
				//   If you find that description is between 120-156 characters, and the keyword is the first word in the description. Then show text "Meta desc Text 2".
				
				  if($desLength>=120 and $desLength<=156 and $keywordAtStarting==true)
				  {
					$type='success';
					$result="Done! You're done.";
				  }
				//          If you find that description is between 120-156 characters, and the keyword is NOT the first word in the description. Then show text "Meta desc Text 3". And you receive a core of –
				  if($desLength>=120 and $desLength<=156 and $keywordAtStarting==false and $keywordInDes==true)
				  {
					  $type='success';
				  $result="Done! You're done.";
				  }
				
				//         If you find that description is between 120-156 characters, and the keyword is NOT in the description at ALL. Then show text "Meta desc Text 4". And you receive a core of –
				  if($desLength>=120 and $desLength<=156 and $keywordInDes==false)
				  {
				 
				   $result="description is between 120-156 characters and the keyword is NOT in the description at ALL";
				  }
				
				 //         If you find that description is >156 characters, and the keyword is the first word in the description. Then show text "Meta desc Text 5". And you receive a core of –
				  if($desLength>156 and $keywordAtStarting==true)
				  {
				   $result="description is > 156 characters and keyword is the first word in the description";
				  }
				
				//        If you find that description is >156 characters, and the keyword is NOT the first word in the description. Then show text "Meta desc Text 6". And you receive a core of –
				  if($desLength>156 and $keywordAtStarting==false and $keywordInDes==true)
				  {
				   $result="description is > 156 characters and the keyword is NOT the first word in the description";
				  }
				
				//         If you find that description is >156 characters, and the keyword is NOT in the description at ALL. Then show text "Meta desc Text 7". And you receive a core of –
				  if($desLength>156 and $keywordInDes==false)
				  {
				   $result="description is > 156 characters and the keyword is NOT in the description at ALL";
				  }
				
				//         If you find that description is <120 characters, and the keyword is the first word in the description. Then show text "Meta desc Text 8". And you receive a core of -
				  if($desLength<120 and $keywordAtStarting==true)
				  {
				   $type="success";
				   $result="description is < 120 characters and the keyword is the first word in the description";
				  }
				
				//         If you find that description is <120 characters, and the keyword is NOT the first word in the description. Then show text "Meta desc Text 9". And you receive a core of –
				  if($desLength<120 and $keywordAtStarting==false and $keywordInDes==true)
				  {
				  $result="description is < 120 characters and the keyword is NOT the first word in the description";
				  }
				
				//         If you find that description is <120 characters, and the keyword is NOT in the description at ALL. Then show text "Meta desc Text 10". And you receive a core of –
				  if($desLength<120  and $keywordInDes==false)
				  {
				   $result="description is < 120 characters and the keyword is NOT in the description at ALL";
				  }
				  
				  //End Condition
				  $return['type']=$type;
				   $return['message']=$result;
						
						return $return;
						
				 } // End Function


		// put this function out side this class
		function multipleEntries($v)
			{
				if ($v==1)
				{	
					return false;
				}
				else{
					return true;
				}
			}




		// function for getting all custome meta tags using seo one plugin
		function get_post_meta_all($post_id){
				global $wpdb;
				$data   =   array();
			
				$wpdb->query("SELECT * FROM ".$wpdb->postmeta." WHERE post_id=".$post_id);
				foreach($wpdb->last_result as $k => $v){
					$data[$v->meta_key] =   $v->meta_value;
				};
				return $data;
		}


		/**
		 * Perform tasks on plugin deactivation.
		 */
		function mto_activation() {

			global $wpdb;

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			$modules = $this->modules;
			$pagehooks = array();

			if ( is_array( $modules ) ) {
				foreach ( $modules as $module ) {
					$object = new $module;
					if ( method_exists( $object,'install' ) ) {
								$tables[] = $object->install();
					}
				}
			}

			if ( is_array( $tables ) ) {
				foreach ( $tables as $i => $sql ) {
					dbDelta( $sql );
				}
			}

		}
		
		/**
		 * Define all constants.
		 */
		private function _define_constants() {

			global $wpdb;

			if ( ! defined( 'MTO_SLUG' ) ) {
				define( 'MTO_SLUG', 'mto_view_overview' );
			}

			if ( ! defined( 'MTO_VERSION' ) ) {
				define( 'MTO_VERSION', '1.6.1' );
			}

			if ( ! defined( 'MTO_TEXT_DOMAIN' ) ) {
				define( 'MTO_TEXT_DOMAIN', 'op_lang' );
			}

			if ( ! defined( 'MTO_FOLDER' ) ) {
				define( 'MTO_FOLDER', basename( dirname( __FILE__ ) ) );
			}

			if ( ! defined( 'MTO_DIR' ) ) {
				define( 'MTO_DIR', plugin_dir_path( __FILE__ ) );
			}

			if ( ! defined( 'MTO_CORE_CLASSES' ) ) {
				define( 'MTO_CORE_CLASSES', MTO_DIR.'core/' );
			}
			
			if ( ! defined( 'MTO_PLUGIN_CLASSES' ) ) {
				define( 'MTO_PLUGIN_CLASSES', MTO_DIR.'classes/' );
			}
			
			if ( ! defined( 'MTO_CONTROLLER' ) ) {
				define( 'MTO_CONTROLLER', MTO_CORE_CLASSES );
			}

			if ( ! defined( 'MTO_CORE_CONTROLLER_CLASS' ) ) {
				define( 'MTO_CORE_CONTROLLER_CLASS', MTO_CORE_CLASSES.'class.controller.php' );
			}

			if ( ! defined( 'MTO_MODEL' ) ) {
				define( 'MTO_MODEL', MTO_DIR.'modules/' );
			}

			if ( ! defined( 'MTO_URL' ) ) {
				define( 'MTO_URL', plugin_dir_url( MTO_FOLDER ).MTO_FOLDER.'/' );
			}

			if ( ! defined( 'FC_CORE_URL' ) ) {
				define( 'FC_CORE_URL', plugin_dir_url( MTO_FOLDER ).MTO_FOLDER.'/core/' );
			}

			if ( ! defined( 'MTO_INC_URL' ) ) {
				define( 'MTO_INC_URL', MTO_URL.'includes/' );
			}

			if ( ! defined( 'MTO_VIEWS_PATH' ) ) {
				define( 'MTO_VIEWS_PATH', mto_CLASSES.'view' );
			}

			if ( ! defined( 'MTO_CSS' ) ) {
				define( 'MTO_CSS', MTO_URL.'/assets/css/' );
			}

			if ( ! defined( 'MTO_JS' ) ) {
				define( 'MTO_JS', MTO_URL.'/assets/js/' );
			}

			if ( ! defined( 'MTO_IMAGES' ) ) {
				define( 'MTO_IMAGES', MTO_URL.'/assets/images/' );
			}

			if ( ! defined( 'MTO_FONTS' ) ) {
				define( 'MTO_FONTS', MTO_URL.'fonts/' );
			}

		}

		
		/**
		 * Load all required core classes.
		 */
		private function _load_files() {
			
			$coreInitialisationFile = plugin_dir_path( __FILE__ ).'core/class.initiate-core.php';
			if ( file_exists( $coreInitialisationFile ) ) {
			   require_once( $coreInitialisationFile );
			}
			
			//Load Plugin Files	
			$plugin_files_to_include = array('mto-controller.php',
											 'mto-model.php',
											 'meta-tags-functions.php');
			foreach ( $plugin_files_to_include as $file ) {

				if(file_exists(MTO_PLUGIN_CLASSES . $file))
				require_once( MTO_PLUGIN_CLASSES . $file ); 
			}
			
			// Load all modules.
			$core_modules = array( 'overview' );
			if ( is_array( $core_modules ) ) {
				foreach ( $core_modules as $module ) {

					$file = MTO_MODEL.$module.'/model.'.$module.'.php';
					if ( file_exists( $file ) ) {
						include_once( $file );
						$class_name = 'MTO_Model_'.ucwords( $module );
						array_push( $this->modules, $class_name );
					}
				}
			}
		}
		
	
	
	}
	
	
}

new FC_Meta_Tags_Optimization();
