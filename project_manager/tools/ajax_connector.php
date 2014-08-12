<?php

#namespace Concrete\Package\ProjectManager\Tools;
namespace Concrete\Packages\ProjectManager\Tools;
#use \Concrete\Package\ProjectManager\Models\Percent as PercentCalc;
use Loader;
#use Controller;
use \Concrete\Core\User as UserC57;
use User;
#use UserInfo as CoreUserInfo;
#use Request;
#use UserList;
#use Permissions;
#use Exception;
#use stdClass
#use \Concrete\Core\Foundation\Object;
#use UserInfo;
#use User;
#use Concrete\Controller\Backend\UserInterface;
#use View;
#use Page;
#use Page;

#use Session;
#use \Concrete\Core\Database;
#use Core;


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(1);

#Loader::model('groups');
#Loader::model('users');

	$pID = $_REQUEST["pID"]; // Page ID
	$aID = $_REQUEST["aID"]; // Attribute ID
	$sID = $_REQUEST["sID"]; // Status ID
	 
	$u = new UserC57();
	$uID = $u->getUserID();
	//$ui = UserInfo::getByID($uID);

echo $uID."....<br>";die("_____");


	$db = Loader::db();
	$queryCheck = "SELECT * FROM btProjectManagerPgStatus WHERE aID = ".$aID." AND pID = ".$pID." ";
	$rs = $db->Execute($queryCheck);
	#$countCheck = $rs->RecordCount();
    $countCheck = $rs->rowCount();
	
	//echo $pID."<br>";die();
	
	if($countCheck){
		$queryUpdate = "UPDATE btProjectManagerPgStatus SET sID = ".$sID." WHERE aID = ".$aID." AND pID = ".$pID." ";
		$db->Execute($queryUpdate);
	}
	else{
		$queryInsert = "INSERT INTO btProjectManagerPgStatus (bID,pID,aID,cDate,uID,sID) VALUES( NULL,".$pID.",".$aID.",NOW(),".$uID.",".$sID." ) "; 
		$db->Execute($queryInsert);
	}
	
	$rs = $db->Execute('SELECT * FROM btProjectManagerPgAttributes');
	#$countAttributes = $rs->RecordCount();
    $countAttributes = $rs->rowCount();

	##$pm = Loader::model("percent","project_manager");
	echo PercentCalc::PercentByPage($pID,$countAttributes);
