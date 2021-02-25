<?php

namespace Concrete\Package\ProjectManager\Tools;

use \Concrete\Package\ProjectManager\Models\Percent as PercentCalc;

#use \Concrete\Core\Legacy\Loader;
#use \Concrete\Core\Legacy\UserList;
#use \Concrete\Core\User\User as User;
#use User;

use UserInfo as CoreUserInfo;
use Session;
use Loader;
use Core;
use User;
use Permissions;
use Request;
use Database;

#use \Concrete\Core\Foundation;

/*
use Config;
use UserInfo as CoreUserInfo;
use Request;
use Events;
use Page;
use GroupList;
use Core;
*/

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Created by PhpStorm.
 * User: Emil Maran ( maran.emil[at]gmail[dot].com)
 * Date: 06.08.14
 * Time: 21:33
 */

#var_dump($_SESSION);
/*if ( !empty(Session::get('uID'))   ) {
    echo Session::get('uID');
}*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

$pID = $_REQUEST["pID"]; // Page ID
$aID = $_REQUEST["aID"]; // Attribute ID
$sID = $_REQUEST["sID"]; // Status ID

#Loader::model('user');
$u   = new User();
$uID = $u->getUserID();

/*if($u->isLoggedIn()) {
    $ui = UserInfo::getByID($u->getUserID());
    echo $ui->getAttribute('Name');
    $uName = $u->getUserName();
}*/
//$ui = UserInfo::getByID($uID);

$db         = Loader::db();
$queryCheck = "SELECT * FROM btProjectManagerPgStatus WHERE aID = " . $aID . " AND pID = " . $pID . " ";
$rs         = $db->Execute($queryCheck);
#$countCheck = $rs->RecordCount();
$countCheck = $rs->rowCount();

if ($countCheck) {
   $queryUpdate = "UPDATE btProjectManagerPgStatus SET sID = " . $sID . " WHERE aID = " . $aID . " AND pID = " . $pID . " ";
   $db->Execute($queryUpdate);
}
else {
   $queryInsert = "INSERT INTO btProjectManagerPgStatus (bID,pID,aID,cDate,uID,sID) VALUES( NULL," . $pID . "," . $aID . ",NOW()," . $uID . "," . $sID . " ) ";
   $db->Execute($queryInsert);
}

$rs = $db->Execute('SELECT * FROM btProjectManagerPgAttributes');
#$countAttributes = $rs->RecordCount();
$countAttributes = $rs->rowCount();

#Loader::model("percent","project_manager");
#$pm = new Percent();
echo PercentCalc::PercentByPage($pID, $countAttributes);
