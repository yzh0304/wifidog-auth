<?php
  /********************************************************************\
   * This program is free software; you can redistribute it and/or    *
   * modify it under the terms of the GNU General Public License as   *
   * published by the Free Software Foundation; either version 2 of   *
   * the License, or (at your option) any later version.              *
   *                                                                  *
   * This program is distributed in the hope that it will be useful,  *
   * but WITHOUT ANY WARRANTY; without even the implied warranty of   *
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    *
   * GNU General Public License for more details.                     *
   *                                                                  *
   * You should have received a copy of the GNU General Public License*
   * along with this program; if not, contact:                        *
   *                                                                  *
   * Free Software Foundation           Voice:  +1-617-542-5942       *
   * 59 Temple Place - Suite 330        Fax:    +1-617-542-2652       *
   * Boston, MA  02111-1307,  USA       gnu@gnu.org                   *
   *                                                                  *
   \********************************************************************/
  /**@file
   * @author Copyright (C) 2004 Technologies Coeus inc.
   */
  /*Prevent caching*/

require_once BASEPATH.'include/common.php';
define('DEFAULT_CONTENT_SMARTY_PATH', LOCAL_CONTENT_REL_PATH.DEFAULT_NODE_ID.'/');
define('NODE_CONTENT_SMARTY_PATH', LOCAL_CONTENT_REL_PATH.CURRENT_NODE_ID.'/');
define('COMMON_CONTENT_SMARTY_PATH', LOCAL_CONTENT_REL_PATH.'common/');

// load Smarty library
require_once(BASEPATH.'lib/smarty/Smarty.class.php');

// The setup.php file is a good place to load
// required application library files, and you
// can do that right here. An example:
// require('guestbook/guestbook.lib.php');

class SmartyWifidog extends Smarty {

   function SmartyWifidog()
   {
   
        // Class Constructor. These automatically get set with each new instance.

        $this->Smarty();

        $this->template_dir = BASEPATH;
        $this->compile_dir = BASEPATH.'tmp/smarty/templates_c/';
        $this->config_dir = BASEPATH.'tmp/smarty/configs/';
        $this->cache_dir = BASEPATH.'tmp/smarty/cache/';
        
        $this->caching = false;
        $this->assign('app_name','Wifidog auth server');
	
	if(is_file(NODE_CONTENT_PHP_RELATIVE_PATH.PAGE_HEADER_NAME))
	  {
	    $this->assign('header_file',NODE_CONTENT_SMARTY_PATH.PAGE_HEADER_NAME);
	  }
	else
	  {
	    $this->assign('header_file',DEFAULT_CONTENT_SMARTY_PATH.PAGE_HEADER_NAME);
	  }
	
	if (is_file(NODE_CONTENT_PHP_RELATIVE_PATH.PAGE_FOOTER_NAME))
	  {
	    $this->assign('footer_file',NODE_CONTENT_SMARTY_PATH.PAGE_FOOTER_NAME);
	  }
	else
	  {
	    $this->assign('footer_file',DEFAULT_CONTENT_SMARTY_PATH.PAGE_FOOTER_NAME);
	  }	
	
	$this->assign('stylesheet_url',STYLESHEET_URL);

/* Common content */
	$this->assign('common_content_url',COMMON_CONTENT_URL);	/* For html href and src */
	$this->assign('common_content_smarty_path',COMMON_CONTENT_SMARTY_PATH);	/* For smarty includes */
	$this->assign('network_logo_url',COMMON_CONTENT_URL.NETWORK_LOGO_NAME);
	$this->assign('network_logo_banner_url',COMMON_CONTENT_URL.NETWORK_LOGO_BANNER_NAME);
	$this->assign('wifidog_logo_url', COMMON_CONTENT_URL.WIFIDOG_LOGO_NAME);
	$this->assign('wifidog_logo_banner_url',COMMON_CONTENT_URL.WIFIDOG_LOGO_BANNER_NAME);
	
/* Usefull stuff from config.php */
	$this->assign('hotspot_network_name',HOTSPOT_NETWORK_NAME);
	$this->assign('hotspot_network_url',HOTSPOT_NETWORK_URL);

     $this->assign('hotspot_logo_url', find_local_content_url(HOTSPOT_LOGO_NAME));
     $this->assign('hotspot_logo_banner_url', find_local_content_url(HOTSPOT_LOGO_BANNER_NAME));

     $this->assign('hotspot_id', CURRENT_NODE_ID);
     global $db;
     $db->ExecSqlUniqueRes("SELECT * FROM nodes WHERE node_id='". $db->EscapeString(CURRENT_NODE_ID)."'", $node_info);
     if($node_info==null)
       {
	 $this->assign('hotspot_name', UNKNOWN_HOSTPOT_NAME);
       }
     else
       {
	 $this->assign('hotspot_name', $node_info['name']);
       }
   }

/**similar to display(), but will find the content in the appropriate local content directory */
   function displayLocalContent($template_filename)
   {
     if (is_file(NODE_CONTENT_URL.$template_filename))
       {
	 $this->display(NODE_CONTENT_SMARTY_PATH.$template_filename);
       }
     else
       {
	 $this->display(DEFAULT_CONTENT_SMARTY_PATH.$template_filename);
       }
   }

   function SetTemplateDir( $template_dir)
   {
     $this->template_dir= $template_dir;
   }

} /* end class SmartyWifidog */
?>