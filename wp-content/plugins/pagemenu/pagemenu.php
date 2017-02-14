<?php
/*
	Plugin Name: pagemenu
	Plugin URI: http://rickwright11.com/?page_id=19
	Description: Pagemenu selects pages from the Wordpress database and presents them in a dropdown menu. It is a horizontal dropdown menu based on css properties and includes a css file. No javascript is required.Installation is normal - as for any Wordpress plugin just unzip/copy to the Wordpress plugin directory plugins/pagemenu and activate by clicking activate on the wp admin plugin page
	Version:  0.1
	Author: Rick Mosher
	Author URI: http://rickwright11.com

	Copyright 2009  Rick Mosher  (email : )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	function loadcss(){
		?>
			<link rel="stylesheet" href="<?php bloginfo('url');?>/wp-content/plugins/pagemenu/cssmenu.css" type="text/css" media="screen" />
		<?php
		}

	function pagemenu(){
    	Global $wpdb;
		$r = "\n<ul id = cssmenu>\n";	
		$q = "SELECT ID, post_title, guid FROM $wpdb->posts WHERE post_type = 'page' AND post_parent = '0' ORDER BY menu_order";
		if($result = $wpdb->get_results($q)){
			foreach($result as $menu ){
				$postparent  = $menu->ID;
				$title       = $menu->post_title;
				$guid        = $menu->guid;
				$r          .= "\n\t<li ><a href = \"$guid\"> $title  &nbsp</a>";
				$r 			.= "\n\t\t<ul>";
				$innerq      = "SELECT post_title, guid FROM $wpdb->posts WHERE post_parent = $postparent AND post_status = 'publish' ORDER BY menu_order";
				$innerresult = $wpdb->get_results($innerq);
				foreach($innerresult as $drops){
					$innertitle = $drops->post_title;
					$guid       = $drops->guid;			
					$r         .= "\n\t\t\t<li> <a href = \"$guid\">$innertitle</a></li>";
					}
				$r .= "\n\t\t</ul>\n\t</li>\n";
				}
			$r .= "</ul>\n";
			}
		else{
			$r == " No Menu listings from DB ";
			}	
		return $r;
		}

	Global $pmenu;
	$pmenu = __FILE__;
	function menu(){
		global $pmenu;
		return $pmenu;
		}

register_activation_hook(__FILE__, 'menu_activate');

	add_action('wp_head', 'loadcss');
	add_action('wp_head', 'pagemenu', 1);	
