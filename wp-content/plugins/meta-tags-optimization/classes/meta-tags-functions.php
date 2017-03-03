<?php 
/**
 * This file contains functions used in this plugin.
 * @author Flipper Code <hello@flippercode.com>
 * @version 1.0.0
 * @package SEO
 */
 

/**
 * A function to retrive all meta data of the post.
 * @param $post_id integer Pass ID of the post.
 * @return array 
 */
function mto_get_post_meta_all($post_id){
 global $wpdb;
 $data   =   array();
 $wpdb->query("SELECT * FROM ".$wpdb->postmeta." WHERE post_id=".$post_id);
 foreach($wpdb->last_result as $k => $v){
		$data[$v->meta_key] =   $v->meta_value;
 };
 return $data;
}


/**
 * A function to save post's meta data
 * @param integer $post_id name to declare
 * @return void 
 */
function mto_save_post_meta($post_id){
  
  if(!current_user_can('edit_post', $post_id))
  return;
  
  if ( !wp_verify_nonce( $_POST['mto_meta_tag_nonce'],'mto_meta_tag_action' ) )
  return;
  
  delete_post_meta($post_id, '_mto_meta_title');
  delete_post_meta($post_id, '_mto_meta_keywords');
  delete_post_meta($post_id, '_mto_meta_description');

  
  if(isset($_POST['mto_meta_title']) && $_POST['mto_meta_title'] != '')
  update_post_meta($post_id, '_mto_meta_title', $_POST['mto_meta_title']);

  if(isset($_POST['mto_meta_keywords']) && $_POST['mto_meta_keywords'] != '')
  update_post_meta($post_id, '_mto_meta_keywords', $_POST['mto_meta_keywords']);

  if(isset($_POST['mto_meta_description']) && $_POST['mto_meta_description'] != '')
  update_post_meta($post_id, '_mto_meta_description', $_POST['mto_meta_description']);

}

/**
 * A function to load scripts used in plugin.
 * @return void 
 */
function mto_meta_script(){
 ?>
  <script type="text/javascript">
   jQuery(document).ready(function(){
     jQuery('.mto_meta_tags').blur(function(){
	  jQuery('.mto_meta_tags').each(function(){
	  var  obj = jQuery(this);
	
	   var data = {
	     action : 'mto_meta_tags_validate',
		 m_t : jQuery('#mto_meta_title').val(),
		 m_k : jQuery('#mto_meta_keywords').val(),
		 m_d : jQuery('#mto_meta_description').val(),
		 type: obj.attr('id')
	   };
	    
	   jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>',data,function(response){
		 obj.parent().parent().parent().next().find('fieldset').attr('class',response.type).html(response.message); 
	   },'json');
	 });
	});
   })
  </script>
 <?php 
}

/** 
 * A function to validate meta tags entered
 * @return void 
 */

function mto_meta_tags_validate(){
  $validate = '';
 
  $m_t = $_POST['m_t'];
  $m_k = $_POST['m_k'];
  $m_d = $_POST['m_d'];
  $type = $_POST['type'];
 
 
 
  if($type == 'mto_meta_title')
  $validate = checkTitle($m_t,$m_k);
 
  if($type == 'mto_meta_keywords')
  $validate = checkKeyword($m_k,$m_k);
 
  if($type == 'mto_meta_description')
  $validate = metaDescription($m_k,$m_d);
  echo json_encode($validate);
  exit;
}

/** 
 * A function to generate meta tags on front end side.
 * @return string 
 */
function mto_create_meta_tags(){
  global $wp_query;
  $post = $wp_query->get_queried_object();
  $meta_string = '';
  $term_id = '';
  
  
  if(is_single() || is_page()){
	  $meta_keywords = stripslashes(get_post_meta($post->ID, '_mto_meta_keywords',true));
	  $meta_description = trim(stripslashes(get_post_meta($post->ID, '_mto_meta_description',true)));
	  if(isset($meta_keywords) && !empty($meta_keywords))
	   $keywords = $meta_keywords;
	  if(isset($meta_description) && !empty($meta_description))
	  $description = $meta_description;
    
  }
  
  if(is_category()){
   
     if(absint(get_query_var('cat')))
	 $term_id = get_query_var('cat');
   
   }
   else
   if(is_tag()){
     
	 $tag_id = get_query_var('tag_id');
	 if(absint($tag_id))
	 $term_id = $tag_id;
   }
   
   if(!empty($term_id)){
   
    if( $option = get_option('mto_meta_term_'.$term_id)){
	  
	  if(isset($option['mto_meta_keywords']))
	  $keywords = esc_html($option['mto_meta_keywords']);
	  
	  if(isset($option['mto_meta_description']))
	  $description = esc_html($option['mto_meta_description']);

	}
   
   }

  
  $keywords =  apply_filters('mto_meta_keywords',$keywords);
  $description =  apply_filters('mto_meta_description',$description);
  if(isset($description) && !empty($description))
  {
    if(isset($meta_string))
    $meta_string .= "\n";
	$meta_string .=  sprintf('<meta name="description" content="%s" />',$description); 	
  }
  if(isset($keywords) && !empty($keywords))
  {
    if(isset($meta_string))
	$meta_string .= "\n";
	$meta_string .= sprintf('<meta name="keywords" content="%s" />', $keywords);
  }
  if(!empty($meta_string))
  echo "$meta_string \n";   
}

/** 
 * A function to generate meta title on front end side.
 * @return string 
 */
 
function mto_rewrite_meta_title($title,$sep)
{
 global $wp_query; 
 $head_title = '';
   
   if(is_page() || is_single()){
      $post = $wp_query->get_queried_object();
	   $head_title =  trim(stripslashes(get_post_meta($post->ID,'_mto_meta_title',true)));
   }
   
   $term_id = '';
   
   if(is_category()){
   
     if(absint(get_query_var('cat')))
	 $term_id = get_query_var('cat');
   
   }
   else
   if(is_tag()){
   
	 $tag_id = get_query_var('tag_id');
	 if(absint($tag_id))
	 $term_id = $tag_id;
   }
   
   if(!empty($term_id)){
   
    if( $option = get_option('mto_meta_term_'.$term_id)){
	 
	  if(isset($option['mto_meta_title']))
	  $head_title = esc_html($option['mto_meta_title']);
	
	}
   
   }
   
   if(isset($head_title) && !empty($head_title))
   {
	 if(strpos(substr($head_title,-1,2),'|') !== false 
	    || strpos(substr($head_title,-1,2),':') !== false 
		|| strpos(substr($head_title,-1,2),'>') !== false 
		|| strpos(substr($head_title,-1,2),'-') !== false
	   )
	 $title = $head_title.' ';
	 else
	 $title = $head_title.' '.$sep.' ';  	
   }
  return $title;
}

/** 
 * A function to check meta title against seo rules
 * @return string 
 */

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
			
			//echo "Left==".$left;
			//echo "Right==".$right;
				
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
				if(in_array(trim($splitTitle[0]),$splitKeyword)){
				//echo "here1";
				$isKeywordExist=true;
				$keywordLeftSide=true;
				}
				else if(in_array(trim($splitTitle[1]),$splitKeyword)){
				//echo "here2";
				$isKeywordExist=true;
				$keywordRightSide=true;
				}
				else{
				//echo "==here3==";
				$isKeywordExist=false;
				$unableToPredict=true;
				}
											
			}
			
			$type='error';
			//Now check all condition one by one
			
			//If the title is <64 and the keyword is located first in order, then the text "Title Text 1" shows.
			if($titleLength<=64 and $keywordLeftSide==true and $keywordsData!='')
			{
				$type='success';

				$result="Perfect!";
			}
			
			
			//If the title is <64 and the keyword is located but NOT as the first word in order, then the text "Title Text 2" shows. And you receive a score of -
			
			elseif($titleLength<64 and $keywordRightSide==true  and $keywordsData!='')
			{
				$type='success';
				$result="Perfect!";
			}
			
			// If the title is <64 and the keyword is NOT located at all, then the text "Title Text 3" shows. And you receive a score of ñ
			elseif($titleLength<64 and $isKeywordExist==false)
			{
				$type='success';
				$result="Perfect!";
			}
		
			//If the title is <64 and the keyword is located more than 1 time in the title , then the text "Title Text 4" shows. And you receive a score of  ñ
			elseif($titleLength<64 and array_filter($countEachValue,"multipleEntries"))
			{
				$result="The title is <64 characters and the keyword is located more than 1 time in the title";
			}
		
			//If the title is >64 and the keyword is located first in order, then the text "Title Text 5" shows.
			elseif($titleLength>64 and $keywordLeftSide==true)
			{
				$result="The title is >64 characters and the keyword is located first in order";
			}
			
			//If the title is >64 and the keyword is located but NOT as the first word in order, then the text "Title Text 6" shows. And you receive a score of -
			
			elseif($titleLength>64 and $keywordRightSide==true)
			{
				$result="The title is >64 characters and the keyword is located but NOT as the first word in order";
			}
			
			// If the title is >64 and the keyword is NOT located at all, then the text "Title Text 7" shows. And you receive a score of ñ
			elseif($titleLength>64 and $isKeywordExist==false)
			{
				$result="The title is >64 characters and the keyword is NOT located at all";
			}
		
			//If the title is >64 and the keyword is located more than 1 time in the title , then the text "Title Text 8" shows. And you receive a score of  ñ
				elseif($titleLength>64 and count($countEachValue)>0 and array_filter($countEachValue,"multipleEntries"))
				{
					$result="The title is >64 characters and the keyword is located more than 1 time in the title";
				}
			
			// If a title is NOT located at all, then the text "Title Text 9" shows. And you receive a score of  ñ	
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

/** 
 * A function to check meta keywords against seo rules
 * @return string 
 */
	
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
    //return META_KEYWORD_2_SINGLE;
					$type='success';

	$result="Perfect!";
   }
//          If you find 1-5 meta keywords, and the keyword you search for is there MORE then once, then show text "Meta Keyword 2".  And you receive a core of ñ
   
  if($totalKeywords>=1 and $totalKeywords<=5 and $singleKeywords==false)
   {
    //return META_KEYWORD_2_MULTIPLE;
	$result="The keyword is < 5 and located Multiple Times";
   }

//          If you find 1-5 meta keywords, and the keyword you search for is NOT there at all, then show text "Meta Keyword 3".  And you receive a core of ñ

  if($totalKeywords>=1 and $totalKeywords<=5 and $keywordsfound==false and $searchkeywords!='')
   {
    //return META_KEYWORD_2_NOT;
	$result="The keyword is < 5 and the keyword is NOT located at all";
   }
   
//          If you find >5 meta keywords, and the keyword you search for is there once, then show text "Meta Keyword 4".  And you receive a core of ñ
   
   if($totalKeywords>5 and $singleKeywords==true and $keywordsfound==true)
   {
    //return META_KEYWORD_6_SINGLE;
	$result="The keyword is > 5 and located only once";
	
   }

//          If you find >5 meta keywords, and the keyword you search for is there MORE then once, then show text "Meta Keyword 5".  And you receive a core of ñ

   if($totalKeywords>5 and $singleKeywords==false)
   {
    //return META_KEYWORD_6_MULTIPLE;
	$result="The keyword is > 5 and located Multiple Times";
   }
   
//          If you find >5 meta keywords, and the keyword you search for is NOT there at all, then show text "Meta Keyword 6".  And you receive a core of ñ

   if($totalKeywords>5 and $keywordsfound==false and $searchkeywords!='')
   {
    //return META_KEYWORD_6_NOT;
	$result="The keyword is > 5 and the keyword is NOT located at all";
   }
   
//    If you find NO meta keywords at all, then show text "Meta keyword 7". And you receive a core of ñ
   
   if($totalKeywords==0)
   {
    //return META_KEYWORD_0_NOT;
	$result="Keyword is missing";
   }
   
   if($totalKeywords>5 and $searchkeywords=='')
   {
    //return META_KEYWORD_6;
	$result="the keyword is > 5 ";
	
   }
   if($totalKeywords>=1 and $totalKeywords<=5 and $searchkeywords=='' and $multipleKeywords==true)
   {
    //return META_KEYWORD_7;
		$result="the keyword is < 5 and Keyword Located only once";
   }
   
   if($totalKeywords>=1 and $totalKeywords<=5 and $searchkeywords=='' and $multipleKeywords==false)
   {
    //return META_KEYWORD_8;
	$result="the keyword is < 5 and Keyword Located Multiple times";
   }
   
$return['type']=$type;
   $return['message']=$result;		
		return $return;
		
 } // End function
	
/** 
 * A function to check meta description against seo rules
 * @return string 
 */
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
 // echo "<pre>";print_r($allKeywordsData);
  for($i=0;$i<count($allKeywords);$i++)
  {
  /*echo $allKeywords[$i];
  echo "<br />";
  echo ltrim($metaDescription);
  echo "<br />";*/
   if((strripos(ltrim($metaDescription),trim($allKeywords[$i])))===0)
     {
      $keywordAtStarting=true;
     }
  }
  
  for($i=0;$i<count($allKeywords);$i++)
  {
  /*echo $allKeywords[$i];
  echo "<br />";
  echo ltrim($metaDescription);
  echo "<br />";*/
   if((strripos(ltrim($metaDescription),trim($allKeywords[$i])))!==false)
     {
      $keywordInDes=true;
     }
  }
 //echo "now".$keywordInDes;
  // now apply condition 
  
//    If you find NO description at all. Then show text "Meta desc Text 1". And you receive a core of ñ
  if($desLength==0)
  {
   //return META_DESC_0;
   $result="Description is misssing.";
    $return['type']=$type;
   $return['message']=$result;
	
	return $return;
  
  }
 
//   If you find that description is between 120-160 characters, and the keyword is the first word in the description. Then show text "Meta desc Text 2".

  if($desLength>=120 and $desLength<=160 and $keywordAtStarting==true)
  {
    //return META_DESC_121_FIRST;
	$type='success';
    $result="Perfect!";
  }
//          If you find that description is between 120-160 characters, and the keyword is NOT the first word in the description. Then show text "Meta desc Text 3". And you receive a core of ñ
  if($desLength>=120 and $desLength<=160 and $keywordAtStarting==false and $keywordInDes==true)
  {
$type='success';
    $result="Perfect!";
  }

//         If you find that description is between 120-160 characters, and the keyword is NOT in the description at ALL. Then show text "Meta desc Text 4". And you receive a core of ñ
  if($desLength>=120 and $desLength<=160 and $keywordInDes==false)
  {
 
   //return META_DESC_121_NOT;
   $result="description is between 120-160 characters and the keyword is NOT in the description at ALL";
  }

 //         If you find that description is >160 characters, and the keyword is the first word in the description. Then show text "Meta desc Text 5". And you receive a core of ñ
  if($desLength>160 and $keywordAtStarting==true)
  {
   //return META_DESC_151_FIRST;
   $result="description is > 160 characters and keyword is the first word in the description";
  }

//        If you find that description is >160 characters, and the keyword is NOT the first word in the description. Then show text "Meta desc Text 6". And you receive a core of ñ
  if($desLength>160 and $keywordAtStarting==false and $keywordInDes==true)
  {
   //return META_DESC_151_NFIRST;
   $result="description is > 160 characters and the keyword is NOT the first word in the description";
  }

//         If you find that description is >160 characters, and the keyword is NOT in the description at ALL. Then show text "Meta desc Text 7". And you receive a core of ñ
  if($desLength>160 and $keywordInDes==false)
  {
   //return META_DESC_151_NOT;
   $result="description is > 160 characters and the keyword is NOT in the description at ALL";
  }

//         If you find that description is <120 characters, and the keyword is the first word in the description. Then show text "Meta desc Text 8". And you receive a core of -
  if($desLength<120 and $keywordAtStarting==true)
  {
   //return META_DESC_119_NFIRST;
   $type='success';
    $result="Perfect!";
  }

//         If you find that description is <120 characters, and the keyword is NOT the first word in the description. Then show text "Meta desc Text 9". And you receive a core of ñ
  if($desLength<120 and $keywordAtStarting==false and $keywordInDes==true)
  {
  $type='success';
    $result="Perfect!";
  }

//         If you find that description is <120 characters, and the keyword is NOT in the description at ALL. Then show text "Meta desc Text 10". And you receive a core of ñ
  if($desLength<120  and $keywordInDes==false)
  {
   //return META_DESC_119_NOT;
   $result="description is < 120 characters and the keyword is NOT in the description at ALL";
  }
  
  //End Condition
  $return['type']=$type;
   $return['message']=$result;
		
		return $return;
		
 } // End Function