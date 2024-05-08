<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /icms_version.php
 *
 * menu version infomation
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**  General Information  */
$modversion = array(
						"name"						=> _MI_MENU_MD_NAME,
						"version"					=> "1.3",
						"description"				=> _MI_MENU_MD_DESC,
						"author"					=> "fiammybe",
						"author_realname"			=> "David Janssens",
						"credits"					=> "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
						"help"						=> "admin/manual.php",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 1,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "menu",

					/**  Images information  */
						"iconsmall"					=> "images/icon_small.png",
						"iconbig"					=> "images/icon_big.png",
						"image"						=> "images/icon_big.png", /* for backward compatibility */

					/**  Development information */
						"status_version"			=> "1.3",
						"status"					=> "beta",
						"date"						=> "08 May 2024",
						"author_word"				=> "",
						"warning"					=> _CO_ICMS_WARNING_BETA,

					/** Contributors */
						"developer_website_url"		=> "https://github.com/fiammybe/impresscms-module-menu",
						"developer_website_name"	=> "fiammybe's Github",
						"developer_email"			=> "david.j@impresscms.org",

					/** Administrative information */
						"hasAdmin"					=> 1,
						"adminindex"				=> "admin/menu.php",
						"adminmenu"					=> "admin/acp_menu.php",

					/** Install and update informations */
						"onInstall"					=> "include/onupdate.inc.php",
						"onUpdate"					=> "include/onupdate.inc.php",
						"onUninstall"				=> "include/onupdate.inc.php",

					/** Search information */
						"hasSearch"					=> 0,
						"search"					=> array(),

					/** Menu information */
						"hasMain"					=> 0,

					/** Notification and comment information */
						"hasNotification"			=> 0,
						"hasComments"				=> 0
				);

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1102'>fiammybe</a>";
$modversion['people']['documenters'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1102'>fiammybe</a>";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";
$modversion['people']['other'][] = "Templates by: [url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";
$modversion['people']['testers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// SUPPORT //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['submit_bug'] = "https://github.com/fiammybe/impresscms-module-menu/issues";
$modversion['submit_feature'] = "https://github.com/fiammybe/impresscms-module-menu/issues";
$modversion['support_site_url'] = "https://github.com/fiammybe/impresscms-module-menu/issues";
$modversion['support_site_name']= 'Github';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// DATABASE /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i= 0;
$i++;
$modversion['object_items'][$i] = 'menu';
$i++;
$modversion['object_items'][$i] = 'item';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_single_item.html',
										'description'	=> _MI_MENU_TPL_MENU_SINGLE_ITEM
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_admin.html',
										'description'	=> _MI_MENU_TPL_ADMIN
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_requirements.html',
										'description'	=> _MI_MENU_TPL_REQUIREMENTS
								);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// simple Menu Block
$i++;
$modversion['blocks'][$i]['file']			= 'menu_block_menu_simple.php';
$modversion['blocks'][$i]['name']			= _MI_MENU_BLOCK_MENU_SIMPLE;
$modversion['blocks'][$i]['description']	= _MI_MENU_BLOCK_MENU_SIMPLE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_menu_menu_simple_show';
$modversion['blocks'][$i]['edit_func']		= 'b_menu_menu_simple_edit';
$modversion['blocks'][$i]['options']		= '1|weight|ASC|0|0'; // menu id|order|sort|js|css
$modversion['blocks'][$i]['template']		= 'menu_block_menu_simple.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;
// megamenu Block
$i++;
$modversion['blocks'][$i]['file']			= 'menu_block_megamenu.php';
$modversion['blocks'][$i]['name']			= _MI_MENU_BLOCK_MENU_MEGA;
$modversion['blocks'][$i]['description']	= _MI_MENU_BLOCK_MENU_MEGA_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_menu_megamenu_show';
$modversion['blocks'][$i]['edit_func']		= 'b_menu_megamenu_edit';
$modversion['blocks'][$i]['options']		= '1|weight|ASC|1|fade|hover|1|0|right|'; // menu id|order|sort|show images|effect|event|full width|style|direction
$modversion['blocks'][$i]['template']		= 'menu_block_megamenu.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;
