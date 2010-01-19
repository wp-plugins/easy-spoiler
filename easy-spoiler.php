<?php
/*
Plugin Name: Easy Spoiler
Version: 0.1
Plugin URI: http://www.dyerware.com/main/products/easy-spoiler
Description: Creates an attractive container to hide a spoiler within a post or page.
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
    }

	function addCSS() 
	{
	   
		echo '<link type="text/css" rel="stylesheet" href="' . plugins_url ( plugin_basename ( dirname ( __FILE__ ) ) ) .'/easy-spoiler.css" />';
		
	
	}
 
    private function translateNumerics(&$value, $key) {
        
        if ($value == 'false') {
        	$value = false;
        } elseif ($value == 'true') {
            $value = true;
        }
        
    }        
            
	public function process_shortcode($atts, $content=null, $code="") 
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
		$rowDiv = 'spoilerDiv' . $this->spoilerNum;

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
           $scontent = do_shortcode($content);
           
           /*
           	if (function_exists('json_encode')) {
        	   $jscontent = json_encode($scontent);
            } else {
			   require_once('json_encode.php');
		    }
		    */
        }

        $button = "'wpSpoilerToggle(" . $rowDiv2 . ");'";
	
        return <<<ecbCode
<div class={$tableCSS}>

<table class='easySpoilerTable' border='0' style='text-align:center;' align='center' bgcolor='FFFFFF'>

<head>
<tr><th class='easySpoilerTitleA'  style='text-align:left;vertical-align:middle;font-size:120%'>{$spoilertitle}</th>
<th class='easySpoilerTitleB'  style='text-align:right;vertical-align:middle;font-size:100%'><INPUT type='button' id={$spoilerbutton} class='easySpoilerButton' value='Show' onclick={$button} align='right'></th>
</th></tr>
</head>


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
<script type="text/javascript">
//<![CDATA[
function wpSpoilerToggle(id) {
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {
        e.style.display = 'none';
        me.value='Show';
    }
    else
    {        
        e.style.display = 'block';
        me.value='Hide';
    }
}
//]]>
</script>
ecbCode;
   }
}  

// Instantiate our class
$wpEasySpoiler= new wpEasySpoiler();

/**
 * Add filters and actions
 */

add_action('wp_head', array($wpEasySpoiler, 'addCSS'));
add_shortcode('spoiler',array($wpEasySpoiler, 'process_shortcode'));
?>
