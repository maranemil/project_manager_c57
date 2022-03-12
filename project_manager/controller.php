<?php /** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUndefinedConstantInspection */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlDialectInspection */
/** @noinspection PhpUndefinedNamespaceInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection AutoloadingIssuesInspection */

/** @noinspection PhpUnused */

namespace Concrete\Package\ProjectManager;

use Package;
use BlockType;
use SinglePage;
use Loader;
use Events;
use User;
use Group;
use Concrete\Core\Html\Service\Html;
use View;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Created by PhpStorm.
 * User: Emil Maran ( maran.emil[at]gmail[dot].com)
 * Date: 11.08.14
 * Time: 21:33
 */
#class ProjectManagerPackage extends Package
class Controller extends Package
{
    protected $pkgHandle          = 'project_manager';
    protected $appVersionRequired = "5.4.1";
    protected $pkgVersion         = "0.9";

    public function getPackageDescription()
    {
        return t("Manage Status from All Pages");
    }

    public function GetPackageName()
    {
        return t("MCE37 Project Manager v0.9");
    }

    /**
     * @return void
     */
    public function on_start()
    {
    }

    /**
     * @return void
     */
    public function install()
    {
        $pkg = parent::install();

        // add dummy pages attributes
        $db = Loader::db();
        $db->Execute("INSERT INTO `btProjectManagerPgAttributes` (`bID`, `cText`)
		VALUES (1, 'IMAGE'),
		       (2, 'TEXT'),
		       (3, 'HTML'),
		       (4, 'JS/CSS'),
		       (5, 'FLOW');
		       ");

        #Loader::model('single_page');
        SinglePage::add('/dashboard/project_manager/view', $pkg);
        SinglePage::add('/dashboard/project_manager/overview', $pkg);
        SinglePage::add('/dashboard/project_manager/attributes', $pkg);
        SinglePage::add('/dashboard/project_manager/attributes/edit', $pkg);
        SinglePage::add('/dashboard/project_manager/attributes/delete', $pkg);
        SinglePage::add('/dashboard/project_manager/about', $pkg);

        // copy ajax tool
        /* @var $fh FileHelper */
        $fh = Loader::helper('file');
        $sourcePkg = DIR_PACKAGES . "/" . $this->pkgHandle . "/tools/";
        $targetTls = DIR_BASE . "/application/tools/";
        $fh->copyAll($sourcePkg, $targetTls, $mode = null); // @ $mode = 0777

    }

    public function upgrade()
    {
        $pkg = Package::getByHandle($this->pkgHandle);
        parent::upgrade();
    }

    public function uninstall()
    {
        // clean Database
        parent::uninstall();
        $btTable = 'btProjectManagerPgStatus, btProjectManagerPgAttributes';
        $db = Loader::db();
        $db->Execute('DROP TABLE ' . $btTable);

        // remove ajax tool
        /* @var $fh FileHelper */
        #$fh = Loader::helper('file');
        $targetTool = DIR_BASE . "/application/tools/ajax_connector_pm.php";
        unlink($targetTool);
        #$fh->removeAll( $targetTool);

    }
}