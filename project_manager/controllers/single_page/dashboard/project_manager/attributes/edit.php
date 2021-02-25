<?php

namespace Concrete\Package\Dashboard\ProjectManager\Attributes\Edit;

use Package;

#use BlockType;
#use SinglePage;
use Loader;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Created by PhpStorm.
 * User: Emil Maran ( maran.emil[at]gmail[dot].com)
 * Date: 11.08.14
 * Time: 21:45
 */
class DashboardProjectManagerAttributesEditController extends Controller {

   public $helpers = array('html', 'form');
   public $error;

   public function on_start() {
   }

   public function edit() {
	  $bID   = $this->post('bID');
	  $cText = $this->post('cText');
	  $this->set('bID', $bID);

	  if ($this->post('task') == "edit" && $this->post('bID')) {
		 $this->error = Loader::helper('validation/error');
		 $vt          = Loader::helper('validation/strings');
		 $vn          = Loader::Helper('validation/numbers');

		 if (!$vt->notempty($this->post('cText'))) {
			$this->error->add(t('Attribute name is required'));
		 }

		 if (!$vn->integer($this->post('bID'))) {
			$this->error->add(t('You must choose an attribute.'));
		 }

		 if (!$this->error->has()) {
			$sql = "UPDATE btProjectManagerPgAttributes SET cText='" . $cText . "' WHERE bID=" . $bID . " ";
			$db  = Loader::db();
			$db->Execute($sql);

			$this->redirect("/dashboard/project_manager/attributes/");
		 }
		 else {
			$this->set('error', $this->error);
			//$this->redirect("/dashboard/project_manager/attributes/edit/?bID=".$bID);
		 }
	  }
	  else if ($this->post('task') == "delete" && $this->post('bID')) {
		 $db  = Loader::db();
		 $sql = "SELECT * FROM btProjectManagerPgStatus WHERE aID = " . $bID . " ";
		 $rs  = $db->Execute($sql);
		 #$countPercent = $rs->RecordCount();
		 $row = $rs->fetchRow();

		 if ($row["sID"]) {
			$this->error = Loader::helper('validation/error');
			$this->error->add(t('This attribute is in use and cannot be deleted!'));
			$this->set('error', $this->error);
		 }
		 else {
			$bID = $this->post('bID');
			$sql = "DELETE FROM btProjectManagerPgAttributes WHERE bID=" . $bID . " ";
			$db  = Loader::db();
			$db->Execute($sql);

			$this->redirect("/dashboard/project_manager/attributes/");
		 }
	  }
   }

}