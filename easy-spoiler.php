<?php
/*
Plugin Name: Easy Spoiler
Version: 0.2.1
Plugin URI: http://www.dyerware.com/main/products/easy-spoiler
Description: Creates an attractive container to hide a spoiler within a post or page.  Works in comments and widgets as well.
Author: dyerware
Author URI: http://www.dyerware.com
*/
/*  Copyright © 2009, 2010  dyerware
    Support: support@dyerware.com

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
  
class wpEasySpoiler
{
    private $spoilerNum = 0;
    
	public function __construct()
    { 
       $jsDir = get_option('siteurl') . '/wp-content/plugins/easy-spoiler/js/';
       wp_register_script('wpEasySpoilerJS', "{$jsDir}easy-spoiler.js", false, '0.1');                     
    }

	function addCSS() 
	{	   
		echo '<link type="text/css" rel="stylesheet" href="' . plugins_url ( plugin_basename ( dirname ( __FILE__ ) ) ) .'/easy-spoiler.css" />';	
	}
 
	public function output_scripts ()
    {
        
       wp_enqueue_script('wpEasySpoilerJS');
        
    }
     
    private function translateNumerics(&$value, $key) {
        
        if ($value == 'false') {
        	$value = false;
        } elseif ($value == 'true') {
            $value = true;
        }
        
    }        
        
	    
	public function process_shortcode($atts, $content=null, $code="", $expand=TRUE) 
	{  
	   	$haveIssue = FALSE;
	    $nearKey = "";
	    $nearValue = "";
	    	           
	    if ($atts)
	    {
    	    foreach ($atts as $key => $att)
    	    {
    	       $keyval = (int)$key;
    	       if ($keyval != 0 || strpos($key, "0") === 0)
    	       {
                    $haveIssue = TRUE;
                    $nearKey = $keyval;
                    $nearValue = $att;
                    break;
    	       }
    	    }
	    }

	    if ($haveIssue === TRUE)
	       return "<p><b>EASY SPOILER SHORTCODE ERROR</b><lu><li>Check for misspelled parameters (case matters)</li><li>Check for new lines (all must reside on one long line)</li><li>Error near [" . $key . "], [" . $att . "]</li></lu><br/>For assistance, please visit <a>http://www.dyerware.com/main/products/easy-spoiler</a></p>";
	       
        $spoilerConfig = shortcode_atts( array(
                'intro' => 'Spoiler Inside',
                'title' => '',
                'tablecss' => 'easySpoilerWrapper')
			    , $atts );


	    // Translate strings to numerics
	    array_walk($spoilerConfig, array($this, 'translateNumerics'));
	         
	       	       
	    $this->spoilerNum++;
	    
	    $randomatic = mt_rand(0,0x7fff);
	    $randomatic = $randomatic << 16;
	    global $post;
	    if ($post)
	    {
            $randomatic = $randomatic | 0x8000;            
	    }	    
	    
	    $r = $randomatic | $this->spoilerNum;
        $rowDiv = 'spoilerDiv' . base_convert($r, 10, 16);

		$rowDiv2 = '"' . $rowDiv . '"';
		$spoilerbutton = "'" . $rowDiv . '_action' . "'";
		
		if ($spoilerConfig['title'] === '')
		{
		  $spoilertitle = $spoilerConfig['intro'];
		}
		else
		{
		  $spoilertitle = $spoilerConfig['intro'] . ': ' . $spoilerConfig['title'];
		}
		  
		$tableCSS = "'" . $spoilerConfig['tablecss'] . "'";			
	
	    if (is_null($content))
	    {
	       $scontent = "(no spoiler)";
	    }
        else
        {
            if ($expand == TRUE)
            {
                $scontent = do_shortcode($content);
            }
            else
            {
                $scontent = $content;
            }
        }

        $button = "'wpSpoilerToggle(" . $rowDiv2 . ");'";
	
        return <<<ecbCode
<div class={$tableCSS}>

<table class='easySpoilerTable' border='0' style='text-align:center;' align='center' bgcolor='FFFFFF'>

<tr><th class='easySpoilerTitleA'  style='text-align:left;vertical-align:middle;font-size:120%'>{$spoilertitle}</th>
<th class='easySpoilerTitleB'  style='text-align:right;vertical-align:middle;font-size:100%'><INPUT type='button' id={$spoilerbutton} class='easySpoilerButton' value='Show' onclick={$button} align='right'></th>
</tr>

<tr><td class='easySpoilerRow' colspan='2'><div id={$rowDiv} class='easySpoilerSpoils' style='display:none; white-space:wrap; vertical-align:middle;'>
{$scontent}
</div></td></tr>
</table>


<div class='easySpoilerConclude'><table class='easySpoilerTable'  border='0' style='text-align:center;' frame='box' align='center' bgcolor='FFFFFF'>
<tr><th class='easySpoilerEnd' style='width:100%'></th>
<td class='easySpoilerEnd' style='white-space:nowrap;' colspan='2'></td></tr>
                   
<tr><td class='easySpoilerEnd' colspan='2'></td></tr>
</table>
</div>
</div>
ecbCode;
   }
   
   
   // This is for support within comments:  NO expansion of shortcodes
   // within spoiler as users could invoke any shortcode you have installed.
   public function do_shortcode_in_comment($content) {
    	global $shortcode_tags;
    
    	if (empty($shortcode_tags) || !is_array($shortcode_tags))
    		return $content;

    	$pattern = '(.?)\[(spoiler)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
    	return preg_replace_callback('/'.$pattern.'/s', 
    	       'do_easyspoiler_tag_in_comment', $content);
    }
    
       
   // This is for support in widgets: Will do full expansion of any shortcode
   // within spoiler.
   public function do_shortcode($content) {
    	global $shortcode_tags;
    
    	if (empty($shortcode_tags) || !is_array($shortcode_tags))
    		return $content;
    	$pattern = '(.?)\[(spoiler)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
    	return preg_replace_callback('/'.$pattern.'/s', 'do_shortcode_tag', $content);
    }
}  

// Instantiate our class
$wpEasySpoiler= new wpEasySpoiler();


/*
 * Our comment support for this shortcut.  We prevent shortcut expansion for 
 * security reasons.
 */
function do_easyspoiler_tag_in_comment($m)
    {  
        global $shortcode_tags;
        
       	// allow [[foo]] syntax for escaping a tag
    	if ($m[1] == '[' && $m[6] == ']') {
    		return substr($m[0], 1, -1);
    	}
    
    	$tag = $m[2];
    	$attr = shortcode_parse_atts($m[3]);

    	if ( isset($m[5]) ) {
    		// enclosing tag - extra parameter
    		return $m[1] . call_user_func($shortcode_tags[$tag], $attr, $m[5], $m[2], FALSE) . $m[6];
    	} else {
    		// self-closing tag
    		return $m[1] . call_user_func($shortcode_tags[$tag], $attr, NULL, $m[2], FALSE) . $m[6];
    	}
    }


/**
 * Add filters and actions
 */

add_action('wp_head', array($wpEasySpoiler, 'addCSS'));
add_action('wp_print_scripts', array($wpEasySpoiler, 'output_scripts'));

add_shortcode('spoiler',array($wpEasySpoiler, 'process_shortcode'));

add_filter('comment_text', array($wpEasySpoiler, 'do_shortcode_in_comment'));
add_filter('widget_text', array($wpEasySpoiler, 'do_shortcode'));
?>
