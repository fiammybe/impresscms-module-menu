<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /class/Items.php
 *
 * Class representing menu items objects
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
if(!defined("MENU_DIRNAME")) define("MENU_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_menu_Item extends icms_ipf_Object {

	public $_updating = FALSE;

	public $_withSubs = FALSE;

	/**
	 * Constructor
	 *
	 * @param mod_menu_Items $handler Object handler
	 */
	public function __construct(&$handler) {
		global $icmsConfig, $icmsConfigMultilang;
		parent::__construct($handler);

		$this->quickInitVar("item_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("item_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("item_dsc", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("item_menu", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->quickInitVar("item_target", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("item_url", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, "");
		$this->quickInitVar("item_image", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("item_pid", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("item_active", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("item_hassub", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("language", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, "all");
		$this->initCommonVar("weight");
		// set controls
		$this->setControl("item_dsc", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("item_menu", array("itemHandler" => "item", "method" => "getMenuList", "module" => "menu", "onSelect" => "submit"));
		$this->setControl("item_pid", array("itemHandler" => "item", "method" => "getItemListForPid", "module" => "menu"));
		$this->setControl("item_target", array("name" => "select", "itemHandler" => "item", "method" => "getTargets", "module" => "menu"));
		$this->setControl("item_image", array("name" => "image", "nourl" => TRUE));
		$this->setControl("item_active", "yesno");
		$this->setControl("item_hassub", "yesno");

		if($icmsConfigMultilang['ml_enable'] == TRUE) {
			$this->setControl("language", array("name" => "language", "all" => TRUE));
		} else {
			$this->hideFieldFromForm("language");
		}
		/**
		 * @TODO add a custom button for canceling adding new fields
		 */
		//hide static fields
		$this->hideFieldFromForm("item_hassub");

	}

	public function item_active() {
		$active = $this->getVar('item_active', 'e');
		if ($active == FALSE) {
			return '<a href="' . MENU_ADMIN_URL . 'item.php?item_id=' . $this->id() . '&amp;op=visible">
				<img src="' . MENU_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . MENU_ADMIN_URL . 'item.php?item_id=' . $this->id() . '&amp;op=visible">
				<img src="' . MENU_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}

	function getCloneItemLink() {
		$ret = '<a href="' . $this->handler->_moduleUrl . 'admin/' . $this->handler->_itemname . '.php?op=clone&amp;item_id=' . $this->id() . '" title="' . _AM_MENU_ITEM_CLONE
		 . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/editcopy.png" /></a>';
		return $ret;
	}

	public function getItemMenu() {
		$menu_id = $this->getVar("item_menu", "e");
		$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");
		$menuObj = $menu_handler->get($menu_id);
		$title = $menuObj->title();
		unset($menuObj, $menu_handler, $menu_id);
		return $title;
	}

	public function getParentItem() {
		$pid = $this->getVar("item_pid", "e");
		return ($pid == 0) ? "---------------" : $this->handler->get($pid)->title();
	}

	public function getImgPreview() {
		if($this->getItemImagePath()) {
			$img = '<img src="' . $this->getItemImagePath() . '" . width=64% />';
			return $img;
		}
	}

	public function getWeightControl() {
		$control = new icms_form_elements_Text('', 'weight[]', 5, 7,$this->getVar('weight', 'e'));
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}

	/**
	 * @TODO remove this after refactoring
	 */
	public function getItemDsc() {
		$dsc = $this->getVar("item_dsc", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		return (!$dsc) ? FALSE : $dsc;
	}

	public function getItemUrl() {
		$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid", "e") : 0;
		$url = $this->getVar("item_url");
		if(strpos($url, "{UID}") !== FALSE)
		$url = str_replace("{UID}", $uid, $url);
		switch ($this->getVar("item_target")) {
			case 1:
				$url = ICMS_URL.'/'.$url;
				break;
			case 2:
				$url = ICMS_MODULES_URL.'/'.$url;
				break;
		}
		return $url;
	}

	public function getItemImagePath() {
		$image = $this->getVar("item_image", "e");
		if(($image != "") && ($image != "0")) {
			$path = $this->handler->_uploadUrl . $this->handler->_itemname . '/' . $image;
			return $path;
		} else {
			return FALSE;
		}
	}

	public function itemIsActive() {
		$active = $this->getVar("item_active", "e");
		return ($active == 1) ? TRUE : FALSE;
	}

	public function hasSubs() {
		$subs = $this->getVar("item_hassub", "e");
		return ($subs > 0) ? TRUE : FALSE;
	}

	public function getItemSubs() {
		global $icmsConfig;
		if($this->hasSubs()) {
			$subs = $this->handler->getItems(TRUE, $this->id(), $this->getVar("item_menu", "e"),0,0,"item_view",$this->handler->_currentMenu['item_order'], $this->handler->_currentMenu['item_sort'], $icmsConfig['language']);
			return $subs;
		}
	}

	public function isCurrent() {
		$currentUrl = ICMS_URL.$_SERVER['REQUEST_URI'];
		$itemUrl = $this->getItemUrl();
		return ($currentUrl == $itemUrl) ? TRUE : FALSE;

	}

	public function render($menuImages, $dsc) {
		$itemUrl = $this->getItemUrl();
		$target = ($this->getVar("item_target", "e") == 3) ? ' target="_blank" rel="external"' : '';
		$ret = '<a href="'.$itemUrl.'"'.$target.' >';
		switch ($menuImages) {
			case 1:
				$ret .= '<img class="item-image" src="'.$this->getItemImagePath().'" title="'.$this->title().'" alt="'.$this->title().'" />';
				$ret .= '<span class="item-title">'.$this->title().'</span>';
				if($dsc) $ret .= '<span class="item-description">'.$this->summary().'</span>';
				break;
			case 2:
				$ret .= '<span class="item-title">'.$this->title().'</span>';
				if($dsc) $ret .= '<span class="item-description">'.$this->summary().'</span>';
				break;
			case 3:
				$ret .= '<img class="item-image" src="'.$this->getItemImagePath().'" title="'.$this->title().'" alt="'.$this->title().'" />';
				if($dsc) $ret .= '<span class="item-description">'.$this->summary().'</span>';
				break;
		}
		$ret .= '</a>';
		return $ret;

	}

	function accessGranted($per_name = "") {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(MENU_DIRNAME);
		$viewperm = $gperm_handler->checkRight('item_view', $this->id(), $groups, $module->getVar("mid"));
		if ($viewperm && $this->itemIsActive() ) return TRUE;
		return FALSE;
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['url'] = $this->getItemUrl();
		$ret['img'] = $this->getItemImagePath();
		$ret['hassub'] = $this->hasSubs();
		if($this->handler->_withSubs) {
			$ret['subs'] = $this->getItemSubs();
			$ret['isCurrent'] = $this->isCurrent();
		}
		return $ret;
	}

}