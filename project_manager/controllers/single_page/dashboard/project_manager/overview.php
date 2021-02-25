<?php

namespace Concrete\Package\ProjectManager\Controller\SinglePage\Dashboard\ProjectManager;

use \Concrete\Core\Page\Controller\DashboardPageController;

#use Concrete\Core\Page\Controller\DashboardPageController;
#use \Concrete\Core\Page\Controller\PageController;
use \Concrete\Core\Database;
use \Concrete\Package\ProjectManager\Models\Percent;

#use Concrete\Core\Database\Database;
use Cache;
use Config;
use Localization;
use PageController;
use Session;
use UserAttributeKey;
use Package;
use BlockType;
use SinglePage;
use Loader;
use Events;
use User;
use Group;
use View;
use Page;
use Permissions;
use UserInfo;
use PageTemplate;

#use PageList;
use Concrete\Core\Page\PageList;
use Settings;
use Exception;
use Concrete\Core\Html\Service\Html;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Created by PhpStorm.
 * User: Emil Maran ( maran.emil[at]gmail[dot].com)
 * Date: 12.08.14
 * Time: 21:33
 */

#class DashboardProjectManagerController extends Controller {
#class OverviewController extends DashboardPageController{
#class ProjectManager extends PageController{
class Overview extends DashboardPageController {
#class DashboardProjectManagerController extends DashboardPageController {

   public $helpers = array('html', 'form');

   /*
	* public function view() {
	   $this->redirect("/dashboard/project_manager/overview/");
   }
   */

   public function view() {
	  $db = Loader::db();
	  #$rs = $db->Execute('SELECT * FROM btProjectManagerPgAttributes'); // executeQuery
	  try {
		 $rs = $db->Execute('SELECT * FROM btProjectManagerPgAttributes');
	  }
	  catch (Exception $e) {
		 $this->error->add($e);
	  }

	  #$countAttributes = $rs->RecordCount();
	  $countAttributes = $rs->rowCount();

	  $arAttributes = array();
	  while ($row = $rs->fetchRow()) {
		 $arAttributes[] = $row['cText'];
	  }

	  $this->set('arAttributes', $arAttributes);
	  $this->set('countAttributes', $countAttributes);

	  #Loader::model('page_list');
	  #$pageList = new PageList();
	  #$pageList->sortBy('cDateAdded', 'desc');
	  #$pageList->sortBy('cID', 'asc');
	  #$this->set('pageList', $pageList);
	  #$this->set('pageResults', $pageList->getPage());
	  #$this->set('pageTotal', $pageList->getTotal());
	  #$this->set('pageSummary', $pageList->displaySummary());

	  $pageList = new PageList();
	  #$pageList->filterByPageTypeID($ct->getPageTypeID());
	  #$pageList->filterByPageTemplate($template);
	  #$pageList->ignorePermissions();
	  $this->set('pageList', $pageList);
	  $this->set('pageResults', $pageList->getResults());
	  $this->set('pageTotal', $pageList->getTotalResults());
	  #$this->set('pageSummary', $pageList->displaySummary());
	  #$this->view();

   }

}