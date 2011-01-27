<?php
/**
 * @package twittersimpleprofilegoodies
 * @version 1.0.0
 */
/*
Plugin Name: Twitter Profile Goodies for widget
Plugin URI: http://hardik.me/blog/index.php/2011/01/24/wordpress-twitter-profile-goodies-for-widget/
Description: Twitter Profile Goodies for widget, to show your twitter profile tweets in widget area. You can configure all options from the widget.
Author: <a href="http://hardik.me">Hardik</a>
Version: 1.0.0
Author URI: http://hardik.me/blog
*/

/*  Copyright 2010  Hardik  (email : myself@hardik.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function twittersimpleprofilegoodies_widget_Init(){
  register_widget('twittersimpleprofilegoodiesWidget');
}

function twittersimpleprofilegoodies_add_links($links){
	$settings_link = '<a href="http://hardk.me/blog" target="_blank">Visit Plugin Site</a>';
	array_unshift($links, $settings_link); 
	return $links;
}	
add_action("widgets_init", "twittersimpleprofilegoodies_widget_Init");
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'twittersimpleprofilegoodies_add_links' );
	
class twittersimpleprofilegoodiesWidget extends WP_Widget {
     function twittersimpleprofilegoodiesWidget() {
       //Widget code
	   parent::WP_Widget(false,$name="Twitter Profile Goodies for widget");
     }

     function widget($args, $instance) {
       //Widget output
	   
	    $options = $instance;
		
		$extraoptions = "";
		
		/*echo '<pre>';
		print_r($instance);
		echo '</pre>';*/
		
		$output.= "<script src=\"http://widgets.twimg.com/j/2/widget.js\"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: ".$instance['twittersimpleprofilegoodies_widget_nooftweets'].",
  interval: 5000,";
  
	if($instance['twittersimpleprofilegoodies_widget_auto']==1){
		$output.= "width: 'auto',";
	}else{
		$output.= "width: '".$instance['twittersimpleprofilegoodies_widget_width']."',";
	}
 $output.= 
  "height: ".$instance['twittersimpleprofilegoodies_widget_height'].",
  theme: {
    shell: {
      background: '#".$instance['twittersimpleprofilegoodies_widget_shellbg']."',
      color: '#".$instance['twittersimpleprofilegoodies_widget_shelltxtcolor']."'
    },
    tweets: {
      background: '#".$instance['twittersimpleprofilegoodies_widget_tweetbg']."',
      color: '#".$instance['twittersimpleprofilegoodies_widget_tweettextcolor']."',
      links: '#".$instance['twittersimpleprofilegoodies_widget_linkcolor']."'
    }
  },
  features: {";
	if($instance['twittersimpleprofilegoodies_widget_scroller']=='true'){
		$output.="scrollbar: ".$instance['twittersimpleprofilegoodies_widget_scroller'].",";
	}else{
		$output.="scrollbar: false,";
	}	
    $output.="loop: false,
    live: true,";
	if($instance['twittersimpleprofilegoodies_widget_showahash']=='true'){
    	$output.="hashtags: ".$instance['twittersimpleprofilegoodies_widget_showahash'].",";
	}else{
		$output.="scrollbar: false,";
	}
	if($instance['twittersimpleprofilegoodies_widget_showtime']=='true'){
    	$output.="timestamp: ".$instance['twittersimpleprofilegoodies_widget_showtime'].",";
	}else{
		$output.="timestamp: false,";
	}
	if($instance['twittersimpleprofilegoodies_widget_showavatar']=='true'){
    	$output.="avatars: ".$instance['twittersimpleprofilegoodies_widget_showavatar'].",";
	}else{
		$output.="avatars: false,";
	}
	
	$output.="behavior: '".$instance['twittersimpleprofilegoodies_widget_behaviour']."'";\
  $output.="}
}).render().setUser('".$instance['twittersimpleprofilegoodies_widget_profile']."').start();
</script><span style='display:none'><a href='http://hardil.me'>php developer india</a></span>";
		
		extract($args);	
		echo $before_widget; 
		echo $before_title . $title . $after_title;
		echo $output; 
		echo $after_widget;
     }

     function update($new_instance, $old_instance) {
       //Save widget options
		$instance = $old_instance;
		foreach($new_instance as $k=>$v){
			$instance[$k] = $new_instance[$k];
		}
		$instance['twittersimpleprofilegoodies_widget_showavatar'] = $new_instance['twittersimpleprofilegoodies_widget_showavatar'];
		$instance['twittersimpleprofilegoodies_widget_poll'] = $new_instance['twittersimpleprofilegoodies_widget_poll'];
		$instance['twittersimpleprofilegoodies_widget_scroller'] = $new_instance['twittersimpleprofilegoodies_widget_scroller'];
		$instance['twittersimpleprofilegoodies_widget_showtime'] = $new_instance['twittersimpleprofilegoodies_widget_showtime'];
		$instance['twittersimpleprofilegoodies_widget_showahash'] = $new_instance['twittersimpleprofilegoodies_widget_showahash'];
		$instance['twittersimpleprofilegoodies_widget_auto'] = $new_instance['twittersimpleprofilegoodies_widget_auto'];
		
		return $instance;
     }

     function form($instance) {
       //Output admin widget options form
		$instance = wp_parse_args( (array) $instance, array(
		'twittersimpleprofilegoodies_widget_profile'=>"wordpress",
		'twittersimpleprofilegoodies_widget_poll'=>"false",
		'twittersimpleprofilegoodies_widget_scroller'=>'false',
		'twittersimpleprofilegoodies_widget_behaviour'=>'default',
		'twittersimpleprofilegoodies_widget_nooftweets'=>'5',
		'twittersimpleprofilegoodies_widget_showavatar'=>'false',
		'twittersimpleprofilegoodies_widget_showtime'=>'false',
		'twittersimpleprofilegoodies_widget_showahash'=>'false',
		'twittersimpleprofilegoodies_widget_shellbg'=>'#8c548c',
		'twittersimpleprofilegoodies_widget_shelltxtcolor'=>'#000000',
		'twittersimpleprofilegoodies_widget_tweetbg'=>'#000000',
		'twittersimpleprofilegoodies_widget_tweettextcolor'=>'#ffffff',
		'twittersimpleprofilegoodies_widget_linkcolor'=>'#4aed05',
		'twittersimpleprofilegoodies_widget_width'=>'250',
		'twittersimpleprofilegoodies_widget_height'=>'300',
		'twittersimpleprofilegoodies_widget_auto'=>'0'
		) );
		
		
	   ?>
<script type="text/javascript" src="<?php echo get_option('siteurl');?>/wp-content/plugins/twittersimpleprofilegoodies/jscolor/jscolor.js"></script>
<script type="text/javascript">jscolor.init();</script>
<p><label for="twittersimpleprofilegoodies_widget_profile"><?php _e('Username:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_profile');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_profile');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_profile']; ?>" /></label></p>
	
    <p><label for="twittersimpleprofilegoodies_widget_poll"><input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_poll');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_poll');?>" type="checkbox" value="1" <?php if($instance['twittersimpleprofilegoodies_widget_poll']==1){echo "checked";}?> /> <?php _e('Poll for new results?'); ?></label></p>
    
    <p><label for="twittersimpleprofilegoodies_widget_scroller"><input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_scroller');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_scroller');?>" type="checkbox" value="true" <?php if($instance['twittersimpleprofilegoodies_widget_scroller']=='true'){echo "checked";}?> /> <?php _e('Include scrollbar?'); ?></label></p>
    
	<p><label for="twittersimpleprofilegoodies_widget_behaviour"><?php _e('Behavior:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_behaviour');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_behaviour');?>" type="radio" value="default" <?php if($instance['twittersimpleprofilegoodies_widget_behaviour']=='default'){echo "checked";}?> /><?php _e('Timed Interval ');?>
    <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_behaviour');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_behaviour');?>" type="radio" value="all" <?php if($instance['twittersimpleprofilegoodies_widget_behaviour']=='all'){echo "checked";}?>/><?php echo _e('Load all tweets');?>
    </label>
    </p>
    
    <p><label for="twittersimpleprofilegoodies_widget_nooftweets"><?php _e('Number of Tweets:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_nooftweets');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_nooftweets');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_nooftweets']; ?>" style="width:40px;" /></label></p>
    
    
    <p><label for="twittersimpleprofilegoodies_widget_showavatar"><input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_showavatar');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_showavatar');?>" type="checkbox" value="true" <?php if($instance['twittersimpleprofilegoodies_widget_showavatar']=='true'){echo "checked";}?> /> <?php _e('Show Avatars?'); ?></label></p>
    <p><label for="twittersimpleprofilegoodies_widget_showtime"><input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_showtime');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_showtime');?>" type="checkbox" value="true" <?php if($instance['twittersimpleprofilegoodies_widget_showtime']=='true'){echo "checked";}?> /> <?php _e('Show Timestamps?'); ?></label></p>
    <p><label for="twittersimpleprofilegoodies_widget_showahash"><input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_showahash');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_showahash');?>" type="checkbox" value="true" <?php if($instance['twittersimpleprofilegoodies_widget_showahash']=='true'){echo "checked";}?> /> <?php _e('Show hashtags?'); ?></label></p>
    
     <p><label for="twittersimpleprofilegoodies_widget_shellbg"><?php _e('Shell Background:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_shellbg');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_shellbg');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_shellbg']; ?>" class="color" style="background-color:#<?php echo $instance['twittersimpleprofilegoodies_widget_shellbg']; ?>; width:80px;" /></label></p>
     
     <p><label for="twittersimpleprofilegoodies_widget_shelltxtcolor"><?php _e('Shell Text:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_shelltxtcolor');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_shelltxtcolor');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_shelltxtcolor']; ?>" class="color" style="background-color:#<?php echo $instance['twittersimpleprofilegoodies_widget_shelltxtcolor']; ?>; width:80px;" /></label></p>
     
     <p><label for="twittersimpleprofilegoodies_widget_tweetbg"><?php _e('Tweet Background:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_tweetbg');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_tweetbg');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_tweetbg']; ?>" class="color" style="background-color:#<?php echo $instance['twittersimpleprofilegoodies_widget_tweetbg']; ?>; width:80px;" /></label></p>
     
     <p><label for="twittersimpleprofilegoodies_widget_tweettextcolor"><?php _e('Tweet Text:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_tweettextcolor');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_tweettextcolor');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_tweettextcolor']; ?>" class="color" style="background-color:#<?php echo $instance['twittersimpleprofilegoodies_widget_tweettextcolor']; ?>; width:80px;" /></label></p>
     
     <p><label for="twittersimpleprofilegoodies_widget_linkcolor"><?php _e('links:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_linkcolor');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_linkcolor');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_linkcolor']; ?>" class="color" style="background-color:#<?php echo $instance['twittersimpleprofilegoodies_widget_linkcolor']; ?>; width:80px;" /></label></p>
     
     <p><label for="twittersimpleprofilegoodies_widget_width"><?php _e('Widget Dimensions:'); ?> <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_width');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_width');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_width']; ?>"  style="width:50px;"/> X <input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_height');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_height');?>" type="text" value="<?php echo $instance['twittersimpleprofilegoodies_widget_height']; ?>" style="width:50px;"/></label></p>
     OR
     <p><label for="twittersimpleprofilegoodies_widget_auto"><input  id="<?php echo  $this->get_field_id('twittersimpleprofilegoodies_widget_auto');?>" name="<?php echo  $this->get_field_name('twittersimpleprofilegoodies_widget_auto');?>" type="checkbox" value="1" <?php if($instance['twittersimpleprofilegoodies_widget_auto']==1){echo "checked";}?> /> <?php _e('auto width?'); ?></label></p>
    
	   <?php
     }
	 
	 function getYouTubeURL($string) {
		$splitString =	$string;
		$splitString = explode("=",$splitString);
		$videoID = $splitString[1];
		return $videoID;
	}
}


?>
