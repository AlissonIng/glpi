<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2009 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Julien Dombre
// Purpose of file:
// ----------------------------------------------------------------------


$NEEDED_ITEMS = array ('cartridge', 'contract', 'document', 'enterprise', 'infocom', 'link',
   'printer');

define('GLPI_ROOT', '..');
include (GLPI_ROOT . "/inc/includes.php");
header("Content-Type: text/html; charset=UTF-8");
header_nocache();

if(!isset($_POST["id"])) {
   exit();
}

checkRight("cartridge","r");

$cartridge = new CartridgeType();
if ($_POST["id"]>0 && $cartridge->can($_POST["id"],'r')) {
   switch($_REQUEST['glpi_tab']) {
      case -1 :
         showCompatiblePrinters($_POST["id"]);
         showCartridgesAdd($_POST["id"]);
         showCartridges($_POST["id"]);
         showCartridges($_POST["id"],1);
         showInfocomForm($CFG_GLPI["root_doc"]."/front/infocom.form.php",CARTRIDGEITEM_TYPE,$_POST["id"],1);
         Document::showAssociated($cartridge);
         showLinkOnDevice(CARTRIDGEITEM_TYPE,$_POST["id"]);
         displayPluginAction(CARTRIDGEITEM_TYPE,$_POST["id"],$_REQUEST['glpi_tab']);
         break;

      case 4 :
         showInfocomForm($CFG_GLPI["root_doc"]."/front/infocom.form.php",CARTRIDGEITEM_TYPE,$_POST["id"],1);
         break;

      case 5 :
         Document::showAssociated($cartridge);
         break;

      case 7 :
         showLinkOnDevice(CARTRIDGEITEM_TYPE,$_POST["id"]);
         break;

      case 10 :
         showNotesForm($_POST['target'],CARTRIDGEITEM_TYPE,$_POST["id"]);
         break;

      default :
         if (!displayPluginAction(CARTRIDGEITEM_TYPE,$_POST["id"],$_REQUEST['glpi_tab'])) {
            showCompatiblePrinters($_POST["id"]);
            showCartridgesAdd($_POST["id"]);
            showCartridges($_POST["id"]);
            showCartridges($_POST["id"],1);
         }
         break;
   }
}
ajaxFooter();

?>
