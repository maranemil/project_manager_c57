<?php /** @noinspection PhpUnusedAliasInspection */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlDialectInspection */
/** @noinspection AutoloadingIssuesInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpUndefinedClassInspection */

/** @noinspection PhpUndefinedNamespaceInspection */

namespace Concrete\Package\ProjectManager\Controller\SinglePage\Dashboard\ProjectManager;

use Concrete\Core\Page\Controller\DashboardPageController;

#use Concrete\Core\Page\Controller\DashboardPageController;
#use \Concrete\Core\Page\Controller\PageController;
use Concrete\Core\Database;
use Concrete\Package\ProjectManager\Models\Percent;

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
 * @method set(string $string, array $arAttributes)
 */
class Attributes extends DashboardPageController
{

    public $helpers = array('html', 'form');

    public function view()
    {
        $db = Loader::db();
        $arAttributes = array();
        #$database = Database::getActiveConnection();
        $rs = $db->Execute('SELECT * FROM btProjectManagerPgAttributes');
        #$countAttributes = $rs->RecordCount();
        $countAttributes = $rs->rowCount();
        while ($row = $rs->fetchRow()) {
            $arAttributes[] = $row;
        }

        $this->set('arAttributes', $arAttributes);
        $this->set('countAttributes', $countAttributes);
    }

}