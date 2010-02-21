/*
 * http://www.dyerware.com
 * Support: support@dyerware.com
*/

<?php
if ( !defined('ABSPATH') )
	exit("Sorry, you are not allowed to access this page directly.");
if ( !isset($this) || !is_a($this, wpEasySpoiler) )
	exit("Invalid operation context.");

$sections = array(
	(object) array(
		'title' => 'Parameter Defaults',
		'help' => 'Fill in the desired defaults for the following options.  You can override these within the shortcut itself by specifying them directly.',
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
				'title' => 'Show button',
				'key' => 'GBL_SHOW',
				'help' => 'Text for the show button' ),
			(object) array(
				'title' => 'Hide button',
				'key' => 'GBL_HIDE', 
				'help' => 'Text for the hide button' ),
			(object) array(
				'title' => 'Perform Animations',
				'key' => 'GBL_ANIM',
				'style' => 'max-width: 5em',
				'text' => 'Do Animations',
				'help' => 'You can turn off animations that use the jQuery library if you suspect a plugin conflict, or if you want faster open/close action.' ),				
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

	$type = ' type="' . (is_bool($v) ? 'checkbox' : 'text') . '"';
	$style = $o->style ? " style=\"$o->style\"" : 'style="width:100%"';
	$value = is_bool($v) ? ($v ? ' checked="checked"' : '') : ' value="'.$v.'"';
	$name = ' name="'.$key.'"';
	$attr = $type . $style . $name . $value;
	unset($type, $style, $name, $value);
	$text = $o->text ? " <span>$o->text</span>" : '';
?>
		<tr>
			<th scope="row"><?php echo $o->title ?></th>
			<td>
				<div style="vertical-align:bottom"><input<?php echo $attr ?> /><?php echo $text ?></div>
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