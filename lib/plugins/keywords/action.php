<?php
/**
 *  Keywords Action component
 *
 *  $Id: action.php 104 2007-11-25 14:50:54Z wingedfox $
 *  $HeadURL: https://svn.debugger.ru/repos/common/DokuWiki/Keywords/tags/Keywords.v0.1/action.php $
 *
 *  @lastmodified $Date: 2007-11-25 17:50:54 +0300 (Вск, 25 Ноя 2007) $
 *  @license      LGPL 2 (http://www.gnu.org/licenses/lgpl.html)
 *  @author       Ilya Lebedev <ilya@lebedev.net>
 *  @version      $Rev: 104 $
 *  @copyright    (c) 2005-2007, Ilya Lebedev
 */

if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_keywords extends DokuWiki_Action_Plugin {

  /**
   * return some info
   */
  function getInfo(){
      preg_match("#^.*?Keywords/([^\\/]+)#"," $HeadURL: https://svn.debugger.ru/repos/common/DokuWiki/Keywords/tags/Keywords.v0.1/action.php $ ", $v);
      $v = preg_replace("#.*?((trunk|\.v)[\d.]+)#","\\1",$v[1]);
      $b = preg_replace("/\\D/","", " $Rev: 104 $ ");
      return array( 'author' => "Ilya Lebedev"
                   ,'email'  => 'ilya@lebedev.net'
                   ,'date'   => preg_replace("#.*?(\d{4}-\d{2}-\d{2}).*#","\\1",'$Date: 2007-11-25 17:50:54 +0300 (Вск, 25 Ноя 2007) $')
                   ,'name'   => "Keywords {$v}.$b Action component."
                   ,'desc'   => "Print page keywords for crawlers."
                   ,'url'    => 'http://wiki.splitbrain.org/plugin:keywords'
                  );
  }
  /*
   * plugin should use this method to register its handlers with the dokuwiki's event controller
   */
  function register(&$controller) {
      $controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE',$this,'keywords',array());
  }
  /**
   *  Prints keywords to the meta header
   *
   *  @author Ilya Lebedev <ilya@lebedev.net>
   */
  function keywords(&$event, $param) {
      global $ID;
      global $conf;
      if (empty($event->data) || empty($event->data['meta'])) return; // nothing to do for us
      
      //Check if keywords are exists
      $kw = p_get_metadata($ID,'keywords');
      if (empty($kw)) return;

      for ($i=0;$i<sizeof($event->data['meta']);$i++) {
          $h = &$event->data['meta'][$i];
          if ('keywords' == $h['name']) {
              $h['content'] .= $kw;
              break;
          }
      }
  }
}
