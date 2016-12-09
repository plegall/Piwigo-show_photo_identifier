<?php
/*
Plugin Name: Show Photo Identifier
Version: auto
Description: Show the photo identifier on the page of the photo
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=
Author: plg
Author URI: http://le-gall.net/pierrick
*/

if (!defined('PHPWG_ROOT_PATH'))
{
  die('Hacking attempt!');
}

// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+

global $prefixeTable;

defined('SPI_ID') or define('SPI_ID', basename(dirname(__FILE__)));
define('SPI_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
define('SPI_VERSION', 'auto');

// init the plugin
add_event_handler('init', 'spi_init');
/**
 * plugin initialization
 *   - load language
 */
function spi_init()
{
  if (script_basename() == 'picture')
  {
    // "Downloads" is a key already available in admin.lang.php
    load_language('admin.lang');
  }
}


add_event_handler('loc_end_picture', 'spi_end_picture');
function spi_end_picture()
{
  global $template, $picture;

  $template->set_prefilter('picture', 'spi_picture_prefilter');

  $template->assign(
    array(
      'IMAGE_ID' => $picture['current']['id'],
      )
    );
}

function spi_picture_prefilter($content, &$smarty)
{
  $search = '{if $display_info.rating_score';
  
  $replace = '
	<div id="ImageId" class="imageInfo">
		<dt>{\'Image id\'|@translate}</dt>
		<dd>{$IMAGE_ID}</dd>
	</div>
'.$search;
  
  $content = str_replace($search, $replace, $content);

  return $content;
}
?>