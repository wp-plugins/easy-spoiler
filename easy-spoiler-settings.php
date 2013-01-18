<?php
// This source originated from Hackadellic's TOC plugin
if ( !defined('ABSPATH') )
	exit("Sorry, you are not allowed to access this page directly.");
if ( !isset($this) || !is_a($this, wpEasySpoiler) )
	exit("Invalid operation context.");

$sections = array(
	(object) array(
		'title' => 'Parameter Defaults',
		'help' => 'Fill in the desired defaults for the following options.  You can override these within the shortcode itself by specifying them directly.',
		'options' => array(
			(object) array(
				'title' => 'Default Intro Text',
				'key' => 'DEF_INTRO',
				'help' => 'The default text to the left of the title (intro).' ),
			(object) array(
				'title' => 'Default Title Text',
				'key' => 'DEF_TITLE', 
				'help' => 'The default title text (title).' ),
			(object) array(
				'title' => 'Default CSS Class',
				'key' => 'DEF_STYLE', 
				'help' => 'The default CSS class for the container (tablecss).' ),
		)),
		
	(object) array(
		'title' => 'Global Defaults',
		'help' => 'These settings change all spoilers.',
		'options' => array(
			(object) array(
				'title' => 'Show button Text',
				'key' => 'GBL_SHOW',
				'help' => 'Text for the show button' ),
			(object) array(
				'title' => 'Hide button Text',
				'key' => 'GBL_HIDE', 
				'help' => 'Text for the hide button' ),
			(object) array(
				'title' => 'Select button Text',
				'key' => 'GBL_SELECT', 
				'help' => 'Text for the select button' ),
			(object) array(
				'title' => 'Perform Animations',
				'key' => 'GBL_ANIM',
				'style' => 'max-width: 5em',
				'text' => 'Do Animations',
				'help' => 'You can turn off animations that use the jQuery library if you suspect a plugin conflict, or if you want faster open/close action.' ),		

			(object) array(
				'title' => 'Animation Speed',
				'key' => 'GBL_ANIMATIONSPEED',
				'pick' => (object)array("fast","slow"),
				'help' => 'Speed of the spoiler open/close animations.'	),		
/*
			(object) array(
				'title' => 'Inner Border',
				'key' => 'GBL_BORDERSTYLE',
				'pick' => (object)array("none", "solid", "dotted", "dashed", "double", "ridge", "inset", "outset"),
				'text' => 'Style of the border surrounding the Spoiler contents',
				'help' => 'The border width in pixels.  To not show a border, enter 0.'	),	
					
			(object) array(
				'title' => 'Inner Border Size',
				'key' => 'GBL_BORDERWIDTH',
				'text' => 'Size of the border surrounding the Spoiler contents',
				'help' => 'The border width in pixels.'	),	
*/
				
			(object) array(
				'title' => 'Show Select Content button',
				'key' => 'GBL_SHOWSELECT', 
				'style' => 'max-width: 5em',
				'text' => 'Provide the reader a select content button',				
				'help' => 'If checked, a user can click on a select button as a convenience to auto-select the content of a spoiler.' ),
									
			(object) array(
				'title' => 'Refresh IFrames (beta)',
				'key' => 'GBL_REFRESHIFRAMES', 
				'style' => 'max-width: 5em',
				'text' => 'Scan for and refresh IFrames internal to a spoiler when opened.',				
				'help' => 'Some browsers do not refresh iframes correctly when going from hidden to seen.  This will atempt to force a refresh of the iframes contained within a spoiler upon opening it.' ),	

			(object) array(
				'title' => 'Right-to-Left language',
				'key' => 'GBL_RTOL', 
				'style' => 'max-width: 5em',
				'text' => 'Place the show/hide button on the left side of the spoiler.',				
				'help' => 'If checked, the title will be placed on the right and the button on the left.' ),
		)),
		
	(object) array(
		'title' => 'Editor Settings',
		'help' => 'Choose options related to your blog editor.',
		'options' => array(
			(object) array(
				'title' => 'Editor Buttons',
				'key' => 'GBL_EDITORBUTTONS',
				'style' => 'max-width: 5em',
				'text' => 'Add helper buttons to HTML editor',
				'help' => 'If checked, buttons for inserting a spoiler or spoilter group are added to your editor.  Select the HTML you want hidden and click on spoiler.  Select the spoilers you want grouped and click on spoilergroup.'),
		)),		
	
	(object) array(
	'title' => 'Title Style',
	'help' => 'Customize the styling of the spoiler title.',
	

	'options' => array(
	
		(object) array(
			'title' => 'Use Titlebar As Button',
			'key' => 'GBL_TITLEBARBUTTON', 
			'style' => 'max-width: 5em',
			'text' => 'Do not render buttons and instead user clicks on spoiler title',				
			'help' => 'If checked, a user will click on the title to open and close the spoiler.' ),
			
		(object) array(
			'title' => 'Use <b>bold</b> font',
			'key' => 'GBL_TITLEBOLD', 
			'style' => 'max-width: 5em',
			'text' => 'Render the title in a bold font',				
			'help' => 'If checked, the title will be bold.' ),
	
		(object) array(
			'title' => 'Font Size',
			'key' => 'GBL_TITLESIZE', 
			'text' => 'The size of the font (in percent)',				
			'help' => 'Provide a number as a percent for the title size.  It may be larger than 100 (120 is the default).' ),
	
		(object) array(
			'title' => 'Use wordpress theme native text color',
			'key' => 'GBL_TITLEUSETHEME', 
			'style' => 'max-width: 5em',
			'text' => 'Render the title text using wordpress theme color',				
			'help' => 'If checked, the title text color will be derived from wordpress theme colors.' ),
			
		(object) array(
			'title' => 'Allow Wrapping',
			'key' => 'GBL_TITLEWRAP', 
			'style' => 'max-width: 5em',
			'text' => 'Check this if you want long titles to wrap, rather than an elongated single line.',				
			'help' => 'The default behavior is to perform wrapping of long titles.  If you wish to dictate no wrapping, uncheck this.  If you enable the shortcode parsing within titles you may want to disable wrapping.' ),
					
		(object) array(
			'title' => 'Embed shortcodes within Title',
			'key' => 'GBL_TITLEPARSE', 
			'style' => 'max-width: 5em',
			'text' => 'Tells Easy Spoiler to parse the spoiler title for additional embedded shortcodes.',				
			'help' => 'If checked, ensure you set the open and close tokens below.  You must choose tokens different than the angular brackets [, ].  For example, you may use (, ):  (myshortcode)xx(/myshortcode)' ),
			
		(object) array(
			'title' => 'Shortcode Open character',
			'key' => 'GBL_TITLEPARSECHAROPEN', 
			'text' => 'The character to start a Title shortcode with.  [ is disallowed.',				
			'help' => 'Relevant only if Embed Shortcodes Within Title is entabled.  This is the character (or string) to match signifying the start of a shortcode.   Do not use brackets.' ),

		(object) array(
			'title' => 'Shortcode Close character',
			'key' => 'GBL_TITLEPARSECHARCLOSE', 
			'text' => 'The character to end a Title shortcode with.  ] is disallowed.',				
			'help' => 'Relevant only if Embed Shortcodes Within Title is entabled.  This is the character (or string) to match signifying the end of a shortcode.   Do not use brackets.' ),

	)),	
		
	(object) array(
		'title' => 'Colors',
		'help' => 'These settings change color defaults.  They overide any other choices made on this page regarding color.',
		'options' => array(
		
		
		
			(object) array(
				'title' => 'Use Custom Colors',
				'key' => 'GBL_CUSTOMCOLORS', 
				'style' => 'max-width: 5em',
				'text' => 'Use the colors specified below.  Otherwise, the CSS file is used.',
				'help' => 'The CSS file and your theme defaults provide the default behavior, however if your theme is causing issues or you wish finer control, enable this checkbox and use the settings below.' ),	

			(object) array(
				'title' => 'Outer Background Color',
				'key' => 'GBL_OUTERBKGCOLOR',
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the spoiler outer area background color.' ),
				
			(object) array(
				'title' => 'Reveal Background Color',
				'key' => 'GBL_INNERBKGCOLOR',
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the spoiler reveal background color.' ),
			
			(object) array(
				'title' => 'Button Outline Color',
				'key' => 'GBL_BUTTONLINE', 
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the button border.' ),
					
			(object) array(
				'title' => 'Button Background Color',
				'key' => 'GBL_BUTTONCOLOR', 
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the button background.' ),
			
			(object) array(
				'title' => 'Button Text Color',
				'key' => 'GBL_BUTTONTEXT', 
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the button text.' ),
					
			(object) array(
				'title' => 'Line Color',
				'key' => 'GBL_LINECOLOR', 
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the outlines of the spoiler.' ),
		
			(object) array(
				'title' => 'Title Text Color',
				'key' => 'GBL_TITLECOLOR', 
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the spoiler title text.' ),
				
			(object) array(
				'title' => 'Spoiler Text Color',
				'key' => 'GBL_INNERTEXTCOLOR', 
				'class' => 'dyerware-color',
				'help' => 'HTML Color code for the spoiler text.' ),
		)),
		
		(object) array(
		'title' => 'Button Styling',
		'help' => 'These settings change the button styling defaults (for button colors, see the previous section).',
		'options' => array(					
			(object) array(
				'title' => 'Button Style',
				'key' => 'GBL_BUTTONSTYLE',
				'pick' => (object)array("Default","No Styling", "Flat"),
				'help' => 'The default button type rendered by the plugin.  Use No Styling to have it render natively.  Flat will provide a borderless link-style button'),
	
			(object) array(
				'title' => 'Use wordpress theme native text color',
				'key' => 'GBL_BUTTONTEXTUSETHEME', 
				'style' => 'max-width: 5em',
				'text' => 'Render the button text using wordpress theme color',				
				'help' => 'If checked, the button text color will be derived from wordpress theme colors' ),
			
			/*
			(object) array(
				'title' => 'Image for the Show button',
				'key' => 'GBL_OPENBTNIMAGE',
				'help' => 'URL of an image for the Show button.' ),
			(object) array(
				'title' => 'Image for the Hide button',
				'key' => 'GBL_CLOSEBTNIMAGE', 
				'help' => 'URL of an image for the Hide button' ),		
			*/		
		)),			
	);

?>
<?php // ------------------------------------------------------------------------------------ ?>
<style type="text/css">
<?php
	$R = '3px';
	$sideWidth = '13em';
?>
a.button { display: inline-block; margin: 5px 0 }

dl { padding: 0; margin: 10px 1em 20px 0; background-color: white; border: 1px solid #ddd; }
dt { font-size: 10pt; font-weight: bold; margin: 0; padding: 4px 10px 4px 10px;
	background: #dfdfdf url(<?php echo admin_url('images/gray-grad.png') ?>) repeat-x left top;
}
dd { margin: 0; padding: 10px 20px 10px 20px }
dl {<?php foreach (array('-moz-', '-khtml-', '-webkit-', '') as $pfx) echo " {$pfx}border-radius: $R;" ?> }

dd .caveat { font-weight: bold; color: #C00; text-align: center }

.box { border: 1px solid #ccc; padding: 5px; margin: 5px }
.help { background-color: whitesmoke }

</style>
<?php // ------------------------------------------------------------------------------------ ?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Easy Spoiler by dyerware</h2>
<?php
include 'dyerware-adm-hlp.php';
?>

<?php
include 'dyerware-adm.php';
$helpicon = 'http://www.dyerware.com/images/inspector.png';
?>

<?php // ------------------------------------------------------------------------------------ ?>
<?php if ($updated) : ?>
<div class="updated fade"><p>Plugin settings <?php echo ($status == 'reset') ? 'reset to default values and deleted from database. If you want to, you can safely remove the plugin now' : 'saved' ?>.</p></div>
<?php endif ?>

<?php // ------------------------------------------------------------------------------------ ?>
<?php if ( $updated && $status == 'reset') : ?>

<p class="submit" align="center">
	<a class="button" href="<?php echo $actionURL ?>">Back To Settings ...</a>
</p>

<?php // ------------------------------------------------------------------------------------ ?>
<?php else: ?>

<form method="post">
	<input type="hidden" name="action" value="update" />
	<?php wp_nonce_field($context); ?>

<?php foreach ($sections as $s) : $snr += 1; $shlpid = "shlp-$snr" ?>
<dl>
	<dt><?php echo $s->title ?><?php 
	if ($s->help) :
		?> <a href="javascript:;" onclick="jQuery('#<?php echo $shlpid ?>').slideToggle('fast')"><img src="<?php
			echo $helpicon ?>" /></a><?php
	endif ?></dt>
	<dd>
<?php if ($s->help) : ?>
	<div id="<?php echo $shlpid ?>" class="hidden help box"><?php echo $s->help ?></div>
<?php endif ?>

		<table class="form-table" style="clear:none">
<?php foreach ($s->options as $o) :
	$key = $o->key;
	$v = $options->$key; $t = gettype($v);
	$name = ' name="'.$key.'"';
	$class = $o->class ? " class=\"$o->class\"" : "";
	
	$style = $o->style ? " style=\"$o->style;" : 'style="width:100%;';
	
	if ($o->class == 'dyerware-color')
	{
	   $style .= " background-color:#" . $v . ";"; 
	   $hsb = $this->RGBtoHSB($v);
	   
	   if ($hsb[2] < 50 || ($hsb[1] > 75 && $hsb[2] < 75))
	   {
	       $style .= " color:#FFF;";
	   }
	   else
	   {
	       $style .= " color:#000;";
	   }
	}	
	$style .= '"';
	
	if ($o->pick)
	{ 
          $attr = '<select ' . $name . '>';
          foreach ($o->pick as $item)
    	  {	
    	   $attr .= '<option value="' . $item .  '" ' . (($item == $v)?'SELECTED ':'') . $style .'>' . $item . '</option>';
    	  }
    	  $attr .= "</select>";  
	}
	else
	{
    	$type = ' type="' . (is_bool($v) ? 'checkbox' : 'text') . '" ';
    	$value = is_bool($v) ? ($v ? ' checked="checked"' : '') : ' value="'.$v.'"';
    	$attr = '<input ' . $type . $style . $class . $name . $value . '/>';
	}
 	
	unset($type, $style, $name, $value, $class);
	$text = $o->text ? " <span>$o->text</span>" : '';
?>
		<tr>
			<th scope="row"><?php echo $o->title ?></th>
			<td>
				<div style="vertical-align:bottom"><?php echo $attr ?><?php echo $text ?></div>
				<div><em><?php echo $o->help ?></em></div>
			</td>
		</tr>
<?php endforeach ?>
		</table>
	</dd>
</dl>
<?php endforeach ?>

	<p class="submit" align="center">
		<input type="submit" name="submit" value="<?php _e('Save Settings') ?>"  title="This will store the settings to the database." />
		<input type="submit" name="reset" value="<?php _e('Reset Settings') ?>" title="This will remove the settings from the database, giving you the factory defaults"/>
	</p>
</form>

<?php endif // if ($status) ... ?>
</div>
