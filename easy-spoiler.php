<?php
/*
Plugin Name: Easy Spoiler
Version: 1.9
Plugin URI: http://www.dyerware.com/main/products/easy-spoiler
Description: Creates an attractive container to hide a spoiler within a post or page.  Works in comments and widgets as well.  Also supports clustering spoilers into groups.
Author: dyerware
Author URI: http://www.dyerware.com
*/
/*  Copyright © 2009, 2010, 2011, 2012  dyerware
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
/*
    Admin panel code lifted (and expanded upon) from Hackadelic TOC plugin.  GREAT design.
*/  



/*
fix title text in admin
*/

class wpEasySpoiler
{
    private $spoilerNum = 0;
    private $spoilerGroupNum = 0;
    private $currentGroup = 0;
    private $currentGroupSpoiler = 0;
    private $spoilerArray = Array();

	// Database Settings
    var $DEF_INTRO = 'Spoiler Inside';
	var $DEF_TITLE = '';
	var $DEF_STYLE = 'easySpoilerWrapper';
	var $GBL_SHOW = 'Show';
	var $GBL_HIDE = 'Hide';
	var $GBL_SELECT = 'Select';
	var $GBL_ANIM = true;
	var $GBL_EDITORBUTTONS = true;
	
	var $GBL_BUTTONSTYLE = "Default";
	var $GBL_OPENBTNIMAGE = 0;
	var $GBL_CLOSEBTNIMAGE = 0;
	
	var $GBL_CUSTOMCOLORS = false;
	var $GBL_LINECOLOR = "29180C";
	var $GBL_TITLECOLOR = "02003D";
	var $GBL_OUTERBKGCOLOR = "FFD694";
	var $GBL_INNERBKGCOLOR = "black";
	var $GBL_INNERTEXTCOLOR = "004F01";
	var $GBL_BUTTONCOLOR = "FCB69F";
	var $GBL_BUTTONLINE = "black";
	var $GBL_BUTTONTEXT = "black";
	
	var $GBL_TITLEBARBUTTON = false;
	var $GBL_REFRESHIFRAMES = false;
	var $GBL_ANIMATIONSPEED = 'fast';
	var $GBL_SHOWSELECT     = true;
	
	var $GBL_TITLEBOLD = false;
	var $GBL_TITLESIZE = 120;
	
	var $GBL_TITLEPARSE = false;
	var $GBL_TITLEPARSECHAROPEN =  '(';
	var $GBL_TITLEPARSECHARCLOSE = ')';
	var $GBL_TITLEWRAP = true;
	
	var $GBL_TITLEUSETHEME = false;
	var $GBL_BUTTONTEXTUSETHEME = false;
	
	var $GBL_RTOL = false;
	
	/*
	var $GBL_BORDERWIDTH = 0;
	var $GBL_BORDERSTYLE = "none";
	*/
	
	
	var $op; 
    
	public function __construct()
    { 
       $jsDir = get_option('siteurl') . '/wp-content/plugins/easy-spoiler/js/';
       wp_register_script('wpEasySpoilerJS', "{$jsDir}easy-spoiler.js", false, '1.2'); 
       
       $this->init_options_map();
       $this->load_options();

	   if (is_admin()) 
	   {
	   		add_action('admin_head', array(&$this,'add_admin_files'));
			add_action('admin_menu', array(&$this, 'add_admin_menu'));
	   }       
	   
	   if (strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php') || strpos($_SERVER['REQUEST_URI'], 'page-new.php') || strpos($_SERVER['REQUEST_URI'], 'page.php') || strpos($_SERVER['REQUEST_URI'], 'comment.php')) {
			//add_action('admin_footer', array(&$this, 'init_html_editor_tags'));
			add_action('admin_print_footer_scripts', array(&$this, 'init_html_editor_tags'), 100 );
		}               
    }

	function add_admin_files() 
    {	
        $plgDir = plugins_url ( plugin_basename ( dirname ( __FILE__ ) ) ); 
        	
    	if ( isset( $_GET['page'] ) && $_GET['page'] == 'easy-spoiler/easy-spoiler.php' ) 
    	{
    	    echo "<link rel='stylesheet' media='screen' type='text/css' href='" . $plgDir . "/colorpicker/code/colorpicker.css' />\n";
    		echo "<script type='text/javascript' src='" . $plgDir . "/colorpicker/code/colorpicker.js'></script>\n";
  
	
        $cmt = '// <![CDATA[';
        $cmte = '// ]]>';
        echo '
<script type="text/javascript">
' . $cmt . '
	jQuery(document).ready(function($){       		
        jQuery(".dyerware-color").each(function(index, obj){
			$(obj).ColorPicker({
			 	onShow: function (colpkr) {
              		$(colpkr).fadeIn(200);
              		return false;
	            },
            	onHide: function (colpkr) {
            		$(colpkr).fadeOut(200);
            		return false;
            	},
            	onChange: function (hsb, hex, rgb) {
            		jQuery(obj).css("backgroundColor", "#" + hex);
            		jQuery(obj).css("color", (hsb.b < 50 || (hsb.s > 75 && hsb.b < 75)) ? "#fff" : "#000");
            		jQuery(obj).val(hex.toUpperCase()); 
            	},
        		onSubmit: function(hsb, hex, rgb, el) 
        		  { jQuery(obj).css("backgroundColor", "#" + hex);
        		    jQuery(obj).css("color", (hsb.b < 50 || (hsb.s > 75 && hsb.b < 75)) ? "#fff" : "#000");
        		    jQuery(el).val(hex.toUpperCase()); 
        		    jQuery(el).ColorPickerHide(); },
        		onBeforeShow: function () 
        		  { jQuery(this).ColorPickerSetColor( jQuery(this).attr("value") ); }
        		});
		}); 	     	
	});	
' . $cmte . '
</script>';	
    	}	       	
    }


    function CTXID() 
    { 
        return get_class($this); 
    }

	function addCSS() 
	{	   
		echo '<link type="text/css" rel="stylesheet" href="' . plugins_url ( plugin_basename ( dirname ( __FILE__ ) ) ) .'/easy-spoiler.css" />';	
	}
 
 	function add_admin_menu() 
 	{
		$title = 'Easy Spoiler';
		add_options_page($title, $title, 10, __FILE__, array(&$this, 'handle_options'));
	}
	
	function init_options_map() 
	{
		$opnames = array(
			'DEF_INTRO', 'DEF_TITLE', 'DEF_STYLE', 'GBL_SHOW', 'GBL_HIDE', 'GBL_ANIM', 'GBL_EDITORBUTTONS',
			'GBL_BUTTONSTYLE', 'GBL_OPENBTNIMAGE', 'GBL_CLOSEBTNIMAGE', 'GBL_CUSTOMCOLORS', 'GBL_LINECOLOR',
			'GBL_TITLECOLOR', 'GBL_OUTERBKGCOLOR', 'GBL_INNERBKGCOLOR', 'GBL_BUTTONCOLOR', 'GBL_BUTTONTEXT',
			'GBL_INNERTEXTCOLOR', 'GBL_BUTTONLINE', 'GBL_REFRESHIFRAMES', 'GBL_ANIMATIONSPEED', 'GBL_TITLEBARBUTTON', 
			'GBL_SHOWSELECT', 'GBL_SELECT', 'GBL_TITLEBOLD', 'GBL_TITLESIZE', 'GBL_TITLEPARSE', 'GBL_TITLEPARSECHAROPEN',
			'GBL_TITLEPARSECHARCLOSE','GBL_TITLEWRAP', 'GBL_TITLEUSETHEME', 'GBL_BUTTONTEXTUSETHEME', 'GBL_RTOL',
		);
		$this->op = (object) array();
		foreach ($opnames as $name)
			$this->op->$name = &$this->$name;
	}
	
	function load_options() 
	{
		$context = $this->CTXID();
		$options = $this->op;
		$saved = get_option($context);
		if ($saved) foreach ( (array) $options as $key => $val ) 
		{
			if (!isset($saved->$key)) continue;
			$this->assign_to($options->$key, $saved->$key);
		}
		// Backward compatibility hack, to be removed in a future version
		//$this->migrateOptions($options, $context);
	}
		
	function handle_options() 
	{
		$actionURL = $_SERVER['REQUEST_URI'];
		$context = $this->CTXID();
		$options = $this->op;
		$updated = false;
		$status = '';
		if ( $_POST['action'] == 'update' ):
			check_admin_referer($context);
			if (isset($_POST['submit'])):
				foreach ($options as $key => $val):
					$bistate = is_bool($val);
					if ($bistate):
						$newval = isset($_POST[$key]);
					else:
						if ( !isset($_POST[$key]) ) continue;
						$newval = trim( $_POST[$key] );
					endif;
					if ( $newval == $val ) continue;
					$this->assign_to($options->$key, $newval);
					$updated = true; $status = 'updated';
				endforeach;
				if ($updated): update_option($context, $options); endif;
			elseif (isset($_POST['reset'])):
				delete_option($context);
				$updated = true; $status = 'reset';
			endif;
		endif;
		include 'easy-spoiler-settings.php';
	}
	
	private function assign_to(&$var, $value) 
	{
		settype($value, gettype($var));
		$var = $value;
	}
	
     
    private function translate_numerics(&$value, $key) 
    {   
        if ($value == 'false') {
        	$value = false;
        } elseif ($value == 'true') {
            $value = true;
        }
        
    }        
     
    public function output_scripts ()
    {
       wp_enqueue_script('jquery');   
       wp_enqueue_script('wpEasySpoilerJS');  
    }   

    function init_html_editor_tags()
    {
    	       
        if (is_admin() == true && $this->GBL_EDITORBUTTONS == true)
        {    
            echo '<script type="text/javascript">';
?>

if ( typeof QTags != 'undefined' )
{
	QTags.addButton( 'dyerware_easyspoiler', 'Spoiler', '[spoiler]', '[/spoiler]', '');
}

else if (gac_edbar=document.getElementById("ed_toolbar") ) 
{
	if(typeof edButtons!="undefined")
	{
		var gac_Nr, gac_But, gac_But;
		gac_Nr = edButtons.length;
		edButtons[gac_Nr] = new edButton("ed_"+gac_Nr, "Spoilers", "[spoiler]", "[/spoiler]", "");
		gac_But = gac_edbar.lastChild;
		while (gac_But.nodeType != 1) {
			gac_But = gac_But.previousSibling;
		}
		gac_But = gac_But.cloneNode(true);
		gac_But.id = "ed_"+gac_Nr;
		gac_But._idx = gac_Nr;
		gac_But.value = "Spoiler";
		gac_But.title = "Spoiler";
		gac_But.onclick = function() {edInsertTag(edCanvas, this._idx); return false; }
		gac_edbar.appendChild(gac_But);
		
		
		gac_Nr = edButtons.length;
		edButtons[gac_Nr] = new edButton("ed_"+gac_Nr, "Spoiler Group", "[spoilergroup]", "[/spoilergroup]", "");
		gac_But = gac_edbar.lastChild;
		while (gac_But.nodeType != 1) {
			gac_But = gac_But.previousSibling;
		}
		gac_But = gac_But.cloneNode(true);
		gac_But.id = "ed_"+gac_Nr;
		gac_But._idx = gac_Nr;
		gac_But.value = "Spoiler Group";
		gac_But.title = "Spoiler Group";
		gac_But.onclick = function() {edInsertTag(edCanvas, this._idx); return false; }
		gac_edbar.appendChild(gac_But);
	}
}

<?php
            echo '</script>';
        }      
    }
    
	public function process_group($atts, $content=null, $code="") 
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
	       
        // A group has no arguments.
        $this->spoilerGroupNum++; 
        $this->currentGroup = $this->spoilerGroupNum;
        $this->currentGroupSpoiler = 0;
        $this->spoilerArray = Array();
                           
        // Bust out our children
        $scontent = do_shortcode($content);
        
        if ($this->GBL_TITLEUSETHEME)
        {
        	$gblTitleColor = '';
        }
        else 
        {
        	$gblTitleColor = 'color:#000000;';
        }
        
        if ($this->GBL_BUTTONTEXTUSETHEME)
        {
        	$gblButtonTextColor = '';
        }
        else
        {
        	$gblButtonTextColor = 'color:#000000;';
        }
        
        if ($this->GBL_CUSTOMCOLORS)
        {
        	$gblLineColor = 'border-color:#' . $this->GBL_LINECOLOR . ';';
        	$gblTitleColor = 'color:#' . $this->GBL_TITLECOLOR . ';';
        	$gblInnerTextColor = 'color:#' . $this->GBL_INNERTEXTCOLOR . ';';
        	
        	$gblButtonTextColor = 'color:#' . $this->GBL_BUTTONTEXT . ';';
        	$gblButtonBkg = 'background-color:#' . $this->GBL_BUTTONCOLOR . ';background-image:none;';  
        	      	
        	$gblOuterBkg = 'background-color:#' . $this->GBL_OUTERBKGCOLOR . ';background-image:none;';
        	$gblInnerBkg = 'background-color:#' . $this->GBL_INNERBKGCOLOR . ';background-image:none;';
        }
        
        //var $GBL_RTOL = false;
        	    		
        $toggleList = "";
        $iframe = 'false';
        if ($this->GBL_REFRESHIFRAMES)
        	$iframe = 'true';
        $doAnim = 'false';
        if ($this->GBL_ANIM)
            $doAnim = 'true';
        
        foreach ($this->spoilerArray as $entry)
    	{
    	   $toggleList = $toggleList . "wpSpoilerHide('".$entry."'," . $doAnim . ",'".$this->GBL_SHOW. "','" . $this->GBL_ANIMATIONSPEED ."');";
    	}
    	                           
        // Custom group action that ensures only ONE spoiler is opened at once.
        $groupScript = "function wpSpoilerGroupToggle_" . $this->currentGroup . "(id) {" .
                           "var myName = id + '_action';" .
                           "var e = document.getElementById(id);".
                           "if(e.style.display == 'block')".
                           "{wpSpoilerToggle(id," . $doAnim. ",'" . $this->GBL_SHOW . "','" .$this->GBL_HIDE. "','" . $this->GBL_ANIMATIONSPEED . "','" . $iframe . "');}".
                           "else".
                           "{" . $toggleList . "wpSpoilerToggle(id," .$doAnim.  ",'" .$this->GBL_SHOW."','" .$this->GBL_HIDE. "','" . $this->GBL_ANIMATIONSPEED . "','" . $iframe ."');}".
                        "}";
                        
                                
        $this->currentGroup = 0;
        $this->currentGroupSpoiler = 0;
      
        return <<<ecbCode
<div style='display:none; white-space:wrap; overflow:auto;'>
{$scontent} 
</div>    
<div class='easySpoilerGroupWrapperLast' style='{$gblLineColor}'><div class='easySpoilerConclude' style='{$gblLineColor};border:0px;'><table class='easySpoilerTable'  border='0' style='text-align:center;' frame='box' align='center' bgcolor='FFFFFF'>
<tr><th class='easySpoilerEnd' style='width:100%;{$gblOuterBkg}{$gblLineColor}'></th>
<td class='easySpoilerEnd' style='white-space:nowrap;{$gblOuterBkg}{$gblLineColor}' colspan='2'></td></tr>             
<tr><td  colspan='2' class='easySpoilerGroupWrapperLastRow' style='{$gblOuterBkg}{$gblLineColor}'></td></tr>
</table>
</div>
<script type='text/javascript'>{$groupScript}</script>
</div>
ecbCode;
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
                    //$haveIssue = TRUE;
                    $nearKey = $keyval;
                    $nearValue = $att;
                    break;
    	       }
    	    }
	    }

	    if ($haveIssue === TRUE)
	       return "<p><b>EASY SPOILER SHORTCODE ERROR</b><lu><li>Check for misspelled parameters (case matters)</li><li>Check for new lines (all must reside on one long line)</li><li>Error near [" . $key . "], [" . $att . "]</li></lu><br/>For assistance, please visit <a>http://www.dyerware.com/main/products/easy-spoiler</a></p>";
	       
        $spoilerConfig = shortcode_atts( array(
                'intro' => $this->DEF_INTRO,
                'title' => $this->DEF_TITLE,
                'tablecss' => $this->DEF_STYLE)
			    , $atts );


	    // Translate strings to numerics
	    array_walk($spoilerConfig, array($this, 'translate_numerics'));
	                       
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
			// Use embedded shortcodes within title?
			if ($this->GBL_TITLEPARSE)
			{
				$spoilerConfig['title'] = str_replace($this->GBL_TITLEPARSECHAROPEN,  "[", $spoilerConfig['title']);
				$spoilerConfig['title'] = str_replace($this->GBL_TITLEPARSECHARCLOSE, "]", $spoilerConfig['title']);
				$spoilerConfig['title'] = do_shortcode($spoilerConfig['title']);
			}
			
			if ($spoilerConfig['intro'] == '')
				$spoilertitle = $spoilerConfig['title'];
			else
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
        
        $doBorder = "";
      
        
        	    
        if ($this->GBL_TITLEUSETHEME)
        {
        	$gblTitleColor = '';
        }
        else 
        {
        	$gblTitleColor = 'color:#000000;';
        }
        
        if ($this->GBL_BUTTONTEXTUSETHEME)
        {
        	$gblButtonTextColor = '';
        }
        else
        {
        	$gblButtonTextColor = 'color:#000000;';
        }
	    
        if ($this->GBL_CUSTOMCOLORS)
        {
        	$gblLineColor = 'border-color:#' . $this->GBL_LINECOLOR . ';';
        	$gblTitleColor = 'color:#' . $this->GBL_TITLECOLOR . ';';
        	$gblInnerTextColor = 'color:#' . $this->GBL_INNERTEXTCOLOR . ';';
        	
        	$gblButtonTextColor = 'color:#' . $this->GBL_BUTTONTEXT . ';';
        	$gblButtonBkg = 'background-color:#' . $this->GBL_BUTTONCOLOR . ';background-image:none;';
        	$gblButtonLine = 'border-style:solid;border-color:#' . $this->GBL_BUTTONLINE . ';';

        	$gblOuterBkg = 'background-color:#' . $this->GBL_OUTERBKGCOLOR . ';background-image:none;';
        	$gblInnerBkg = 'background-color:#' . $this->GBL_INNERBKGCOLOR . ';background-image:none;';
        	
        	$doBorder = "border: 1px inset;";
        }
        
        // some parameters
        $show = '"' . $this->GBL_SHOW . '"';
        $hide = '"' . $this->GBL_HIDE . '"';
        $speed = '"' . $this->GBL_ANIMATIONSPEED . '"';
        $iframe = 'false';
        if ($this->GBL_REFRESHIFRAMES)
        	$iframe = 'true';
        $doAnim = 'false';
        if ($this->GBL_ANIM)
            $doAnim = 'true';
            
        // Some styling
        $titleSize = $this->GBL_TITLESIZE;
        $fontWeight = "normal";
        if ($this->GBL_TITLEBOLD)
        	$fontWeight = "bold";
        
        $titleWrap = "normal";
        if ($this->GBL_TITLEWRAP == false)
        	$titleWrap = "nowrap";
        	
        $doShowButtons = "";
        $doSelButtons = "";
        $titleAction = "";
        $buttonAction = "onclick='wpSpoilerToggle(" . $rowDiv2 . "," .$doAnim. "," .$show. "," .$hide. "," .$speed. "," .$iframe. "); return false;'";

       	$buttonCSS = "'easySpoilerButton'";
	    $buttonOtherCSS = "'easySpoilerButtonOther'";	    
	    if ($this->GBL_RTOL)
	    {
	    	$buttonCSS = "'easySpoilerButtonLeft'";
	    }
	    
        if ($this->GBL_TITLEBARBUTTON)
        {
        	if ($this->GBL_RTOL)
        	{
        		$buttonCSS = "'easySpoilerButtonLeft'";
        	}
        	else
        	{
        		$buttonOtherCSS = "'easySpoilerButton'";
        	}
        	
        	$doShowButtons = "display:none;";
        	$titleAction = $buttonAction . " onselectstart='return false;'";
        	$buttonAction = "";
        	$spoilertitle = "<a href='' " . $titleAction . " style='text-decoration: none;" . $gblTitleColor . "'>" . $spoilertitle . "</a>";
        }
        
	    $begin = "";
	    $end = "";
	    $conclude = "";
	
	    if ($this->GBL_BUTTONSTYLE == "Default")
	 	{
	 		if ($this->GBL_CUSTOMCOLORS == false)
	 		{
		 		//$gblButtonTextColor = 'color:#000000;';
	        	$gblButtonBkg = 'background-color:#fcfcfc;background-image:none;';
	        	$gblButtonLine = 'border-style:solid;border-color:#cccccc;';
	        	$doBorder = "border: 1px inset;";
	 		}
	 	}
	 	else if ($this->GBL_BUTTONSTYLE == "flat")
	 	{	

	 	}
	 	else
	 	{
	 		$buttonCSS = "'easySpoilerButtonBare'";
	 	}
	    
	    // Group features vs standalone
	    if ($this->currentGroup == 0)
	    {
	      $titlea = "'easySpoilerTitleA'";
	      $titleb = "'easySpoilerTitleB'";
	      $conclude = "<div class='easySpoilerConclude' style='" .
	      			   $gblLineColor . "'><table class='easySpoilerTable' border='0' style='text-align:center;' frame='box' align='center' bgcolor='FFFFFF'><tr><th class='easySpoilerEnd' style='width:100%;".
	      $gblOuterBkg . $gblLineColor . "'></th><td class='easySpoilerEnd' style='white-space:nowrap;" . 
	      $gblOuterBkg . $gblLineColor . "' colspan='2'></td></tr><tr><td class='easySpoilerGroupWrapperLastRow' colspan='2' style='" .
	      $gblOuterBkg . $gblLineColor .  "'></td></tr></table></div>";
	    }
	    else
	    {
	       array_push($this->spoilerArray, $rowDiv);
	       $buttonAction = "onclick='wpSpoilerGroupToggle_" . $this->currentGroup . "(". $rowDiv2 ."); return false;'";
	       if ($this->GBL_TITLEBARBUTTON)
	       {
	        	$doShowButtons = "display:none;";
	        	$titleAction = $buttonAction . " onselectstart='return false;'";
	        	$buttonAction = "";
	        	$spoilertitle = "<a href='' " . $titleAction . ">" . $spoilertitle . "</a>";
	       }
        
	       $begin = "</div>";
	       $end = "<div style='display:none'>";
	       if ($this->currentGroupSpoiler == 0)
	       {
	           $tableCSS = "'easySpoilerGroupWrapperFirst'";
	           $titlea = "'easySpoilerTitleA'";
	           $titleb = "'easySpoilerTitleB'";
	       }
	       else
	       {
				$tableCSS = "'easySpoilerGroupWrapper'";
				$titlea = "'easySpoilerGroup'";
				$titleb = "'easySpoilerGroup'";
				
				if ($this->GBL_BUTTONSTYLE == "Default" || $this->GBL_BUTTONSTYLE == "Classic")
				{
					$buttonCSS = "'easySpoilerGroupButton'";
				}
				else
				{
					$buttonCSS = "'easySpoilerButtonBare'";
				}
	       }
	       
	       $this->currentGroupSpoiler++;
	    }
	    
	   // <div class={$tableCSS}>     <xnput type='button'  value='Select' {$selAction} align='right'/>
	   //<input type='button' id={$spoilerbutton} class={$buttonCSS} value={$show} {$buttonAction} align='right' style='{$gblButtonTextColor}{$gblButtonBkg}{$gblButtonLine}${doShowButtons}'/></th>
	   $selAction = "onclick='wpSpoilerSelect(\"" . $rowDiv . "\"); return false;'"; 
	   if ($this->GBL_SHOWSELECT == false)
	   {
	   		$selAction = "";
	   		$doSelButtons = "display:none;";
	   }

	   $hideButtons = "";
	   if ($this->GBL_SHOWSELECT == false && $this->GBL_TITLEBARBUTTON)
	   {
	   	$hideButtons = "padding:0px;";
	   }
	   	
	   if ($this->GBL_RTOL)
	   {
		$row1 = "<th class=" . $titlea . "style='" . $hideButtons . "text-align:left;vertical-align:middle;font-size:100%;" . $gblOuterBkg . $gblLineColor . " white-space:nowrap;'>" .
			"<a href='' " . $buttonAction . " id=" . $spoilerbutton . " class=" . $buttonOtherCSS . " value=" . $show . 
			" align='left' style='font-size:100%;" . $gblButtonTextColor . $gblButtonBkg . $doBorder . $gblButtonLine . $doShowButtons . " margin: 3px 0px 3px 5px; padding: 4px;'>" . $this->GBL_SHOW . "</a>" .
			"<a href='' " . $selAction . " class=" . $buttonCSS . " style='font-size:100%;" . $gblButtonTextColor . $gblButtonBkg . $doBorder . $gblButtonLine . 
			$doSelButtons . " margin: 3px 0px 3px; padding: 4px; ' align='left'>" . $this->GBL_SELECT . "</a>" .
			"</th>";
			
		$row2 = "<th class=" . $titleb . " style='white-space:" . $titleWrap . ";font-weight:" . $fontWeight . ";text-align:right;vertical-align:middle;font-size:" . $titleSize . "%;" . 
	   			$gblOuterBkg . $gblLineColor . $gblTitleColor. "'>" . $spoilertitle . "</th>";	   
	   }
	   else
	   {
	   	//<th class={$titlea}  style='white-space:{$titleWrap};font-weight:{$fontWeight};text-align:left;vertical-align:middle;font-size:{$titleSize}%;{$gblOuterBkg}{$gblLineColor}{$gblTitleColor}'>{$spoilertitle}</th>
	   	$row1 = "<th class=" . $titlea . " style='white-space:" . $titleWrap . ";font-weight:" . $fontWeight . ";text-align:left;vertical-align:middle;font-size:" . $titleSize . "%;" . 
	   			$gblOuterBkg . $gblLineColor . $gblTitleColor. "'>" . $spoilertitle . "</th>";
		//<th class={$titleb}  style='{$hideButtons}text-align:right;vertical-align:middle;font-size:100%;{$gblOuterBkg}{$gblLineColor} white-space:nowrap;'>
			//<a href='' {$selAction} class={$buttonOtherCSS} style='font-size:100%;{$gblButtonTextColor}{$gblButtonBkg}${doBorder}{$gblButtonLine} ${doSelButtons} margin: 3px 0px 3px; padding: 4px; ' align='right'>{$this->GBL_SELECT}</a><a href='' {$buttonAction} id={$spoilerbutton} class={$buttonCSS} value={$show} align='right' style='font-size:100%;{$gblButtonTextColor}{$gblButtonBkg}${doBorder}{$gblButtonLine}${doShowButtons} margin: 3px 0px 3px 5px; padding: 4px;"'>{$this->GBL_SHOW}</></th>
		$row2 = "<th class=" . $titleb . "style='" . $hideButtons . "text-align:right;vertical-align:middle;font-size:100%;" . $gblOuterBkg . $gblLineColor . " white-space:nowrap;'>" .
			"<a href='' " . $selAction . " class=" . $buttonOtherCSS . " style='font-size:100%;" . $gblButtonTextColor . $gblButtonBkg . $doBorder . $gblButtonLine . $doSelButtons . 
			" margin: 3px 0px 3px; padding: 4px; ' align='right'>" . $this->GBL_SELECT . "</a><a href='' " . $buttonAction . " id=" . $spoilerbutton . " class=" . $buttonCSS . " value=" . 
			$show . " align='right' style='font-size:100%;" . $gblButtonTextColor . $gblButtonBkg . $doBorder . $gblButtonLine . $doShowButtons . " margin: 3px 0px 3px 5px; padding: 4px;'>" . 
			$this->GBL_SHOW . "</></th>";
	   } 

       return <<<ecbCode
{$begin}
<div class={$tableCSS} style='{$gblLineColor}'>
<table class='easySpoilerTable' border='0' style='text-align:center;' align='center' bgcolor='FFFFFF' >

<tr style='white-space:{$titleWrap};'>
{$row1}
{$row2}
</tr>
<tr><td class='easySpoilerRow' colspan='2' style='{$gblLineColor}'><div id='{$rowDiv}' class='easySpoilerSpoils'  style='display:none; white-space:wrap; overflow:auto; vertical-align:middle;{$gblInnerBkg}${gblInnerTextColor}{$gblLineColor}'>
{$scontent}
</div></td></tr>
</table>
{$conclude}
</div>
{$end}
ecbCode;
   }
   
   
   // This is for support within comments:  NO expansion of shortcodes
   // within spoiler as users could invoke any shortcode you have installed.
   public function do_shortcode_in_comment($content) 
   {
    	global $shortcode_tags;
    
    	if (empty($shortcode_tags) || !is_array($shortcode_tags))
    		return $content;

    	$pattern = '(.?)\[(spoiler)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
    	return preg_replace_callback('/'.$pattern.'/s', 
    	       'do_easyspoiler_tag_in_comment', $content);
    }
    
       
   // This is for support in widgets: Will do full expansion of any shortcode
   // within spoiler.
   public function do_shortcode($content) 
   {
    	global $shortcode_tags;
    
    	if (empty($shortcode_tags) || !is_array($shortcode_tags))
    		return $content;
    	$pattern = '(.?)\[(spoiler)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
    	return preg_replace_callback('/'.$pattern.'/s', 'do_shortcode_tag', $content);
    }
    
   
   
   function RGBtoHSB ($rgb)
   {
        sscanf ($rgb, "%02x%02x%02x", $r, $g, $b);
     
        $h = 0;
        $s = 0;
        
        $min = min($r, $g, $b);
        $max = max($r, $g, $b);
        $delta = $max - $min;
        $b = $max;
        if ($max != 0) {
        	
        }
        $s = $max != 0 ? 255 * $delta / $max : 0;
        if ($s != 0) {
        	if ($r == $max) {
        		$h = ($g - $b) / $delta;
        	} else if ($g == $max) {
        		$h = 2 + ($b - $r) / $delta;
        	} else {
        		$h = 4 + ($r - $g) / $delta;
        	}
        } else {
        	$h = -1;
        }
        $h *= 60;
        if ($h < 0) {
        	$h += 360;
        }
        $s *= 100/255;
        $b *= 100/255;
 
        return array($h, $s, $b);
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

add_shortcode('spoilergroup',array($wpEasySpoiler, 'process_group'));
add_shortcode('spoiler',array($wpEasySpoiler, 'process_shortcode'));

add_filter('comment_text', array($wpEasySpoiler, 'do_shortcode_in_comment'));
add_filter('widget_text', array($wpEasySpoiler, 'do_shortcode'));


?>
