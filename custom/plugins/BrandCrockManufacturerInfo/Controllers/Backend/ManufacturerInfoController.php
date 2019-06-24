<?php

use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_ManufacturerInfoController extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    public function getWhitelistedCSRFActions()
    {
        return [
            'index',
            'listmanufacturer'
        ];
    }

    public function preDispatch()
    {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    public function postDispatch()
    {
        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign(['csrfToken' => $csrfToken]);
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function indexAction()
    {
        $miArticleListQuery = "select a.name, a.id,
							d.id, d.ordernumber, d.articleID, d.instock, d.active
							from s_articles a, s_articles_details d
							where a.id = d.articleID and d.active = 1";
        $miArticleFetchData = Shopware()->Db()->fetchAll($miArticleListQuery);
        $message = '';
        if (!$miArticleFetchData) {
            $mimessage = 'No Data in Database';
            $this->View()->assign(['mimessage' => $mimessage]);
            return;
        }

        $this->View()->assign(['miArticleFetchData' => $miArticleFetchData]);
    }

    public function addmanufacturerAction()
    {
        $miordernumber = $this->Request()->getParam('miordernumber');
        $this->View()->assign(['miordernumber' => $miordernumber]);

        //Language Dropdown
        $miLanguageQuerydd = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";

        $miFetchLanguageData = Shopware()->Db()->fetchAll($miLanguageQuerydd);
        $this->View()->assign(['miFetchLanguageData' => $miFetchLanguageData]);
    }

    public function savemanufacturerAction()
    {
        $miordernumber = $this->Request()->getParam('miordernumber');
        $midesc = $this->Request()->getParam('midesc');
        $milocaleid = $this->Request()->getParam('milocaleid');
        $miposition = $this->Request()->getParam('miposition');

        $miimg_path = basename($_FILES["mifile_source"]["name"]);
        $mists = $this->Request()->getParam('mists', 0);
        $miimageName = $miordernumber . "-" . $miimg_path;

        $miLocaleQuery = 'select locale from  s_core_locales where id =' . $milocaleid;
        $milocaleData = Shopware()->Db()->fetchRow($miLocaleQuery);
        $milocale = $milocaleData['locale'];

        $midocPath = Shopware()->DocPath();
        $midestinationDir = $midocPath . 'files/Manufacturer-Img';
        $mitargetDir = $midestinationDir . "/";
        $miuploadFile = $mitargetDir . $miordernumber . "-" . $miimg_path;
        if (!empty($_FILES["mifile_source"]["name"])) {
            move_uploaded_file($_FILES["mifile_source"]["tmp_name"], $miuploadFile);
        }

        $miInsertManufacturer = 'Insert into bcgh_manufacturer_details (ordernumber, img_path, active, position, language, description) 
		            values ("' . $miordernumber . '","' . $miimageName . '",
		           "' . $mists . '","' . $miposition . '","' . $milocale . '","' . $midesc . '" )';
        $miexecuteData = Shopware()->Db()->exec($miInsertManufacturer);
        return $this->redirect(
            array(
                'controller' => 'ManufacturerInfoController',
                'action' => 'listmanufacturer')
        );
    }

    public function listmanufacturerAction()
    {
        $ddmiLanguageQuery = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";
        $miFetchLanguageData = Shopware()->Db()->fetchAll($ddmiLanguageQuery);
        $this->View()->assign(['miFetchLanguageData' => $miFetchLanguageData]);
        $mimessage = '';
        $miListQuery = "select * from bcgh_manufacturer_details order by  position asc";
        $miFetchData = Shopware()->Db()->fetchAll($miListQuery);
        if (!$miFetchData) {
            $mimessage = 'No Data in Database';
            $this->View()->assign(['message' => $mimessage]);
            return;
        }
        $this->View()->assign(['miFetchData' => $miFetchData]);
    }

    public function editmanufacturerAction()
    {
        $miid = $this->Request()->getParam('miid');
        $miEditQuery = "select * from bcgh_manufacturer_details where id =" . $miid;
        $miEditFetchData = Shopware()->Db()->fetchAll($miEditQuery);
        $this->View()->assign(['miEditFetchData' => $miEditFetchData]);

        //Dropdown language Data
        $ddmiLanguageQuery = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";
        $miFetchLanguageData = Shopware()->Db()->fetchAll($ddmiLanguageQuery);
        $this->View()->assign(['miFetchLanguageData' => $miFetchLanguageData]);


    }

    public function updatemanufacturerAction()
    {
        $miid = $this->Request()->getParam('miid');
        $miordernumber = $this->Request()->getParam('miordernumber');
        $miposition = $this->Request()->getParam('miposition');
        $mists = $this->Request()->getParam('mists', 0);
        $miImgFile = basename($_FILES["mifile_source"]["name"]);
        $miunlinkFile = $this->Request()->getParam('mifiledata');
        $midesc = $this->Request()->getParam('midesc');
        $milocaleid = $this->Request()->getParam('milocaleid');
        $miLocaleQuery = 'select locale from  s_core_locales where id =' . $milocaleid;
        $milocaleData = Shopware()->Db()->fetchRow($miLocaleQuery);
        $milocale = $milocaleData['locale'];
        if (!empty($miImgFile)) {
            $miimageName = $miordernumber . "-" . $miImgFile;
            $midocPath = Shopware()->DocPath();
            $midestinationDir = $midocPath . 'files/Manufacturer-Img';
            $mitargetDir = $midestinationDir . "/";
            $miuploadFile = $mitargetDir . $miordernumber . "-" . $miImgFile;
            $mifileTypeFile = pathinfo($miuploadFile, PATHINFO_EXTENSION);
            unlink($mitargetDir . $miunlinkFile);

            move_uploaded_file($_FILES["mifile_source"]["tmp_name"], $miuploadFile);
            $miInsertData = 'update bcgh_manufacturer_details set ordernumber = "' . $miordernumber . '", 
              img_path = "' . $miimageName . '",active = "' . $mists . '", position ="' . $miposition . '", language = "' . $milocale . '"
              , description = "' . $midesc . '" where id = "' . $miid . '"';
            $miexecuteData = Shopware()->Db()->exec($miInsertData);

        } else {
            $miUpdateData = 'update bcgh_manufacturer_details  set ordernumber = "' . $miordernumber . '",
            active = "' . $mists . '", position ="' . $miposition . '", language = "' . $milocale . '", description = "' . $midesc . '" where id = "' . $miid . '"';
            $miexecuteData = Shopware()->Db()->exec($miUpdateData);
        }
        return $this->redirect(
            array(
                'controller' => 'ManufacturerInfoController',
                'action' => 'listmanufacturer')
        );
    }

    public function deletemanufacturerAction()
    {
        $miid = $this->Request()->getParam('miid');
        $midelQuery = "select img_path from bcgh_manufacturer_details where id =" . $miid;
        $midelfetchFile = Shopware()->Db()->fetchOne($midelQuery);
        $mifileName = $midelfetchFile;
        if (!empty($mifileName)) {
            $mibasePath = Shopware()->DocPath();
            $miunlinkPath = $mibasePath . 'files/Manufacturer-Img/' . $midelfetchFile;
            unlink($miunlinkPath);
        }
        $miDeleteQuery = "delete from bcgh_manufacturer_details  where id =" . $miid;
        $miExecuteQuery = Shopware()->Db()->exec($miDeleteQuery);
        return $this->redirect(
            array(
                'controller' => 'ManufacturerInfoController',
                'action' => 'listmanufacturer')

        );
    }

    public function duplicatemanufacturerAction()
    {
        $miid = $this->Request()->getParam('miid');
        $miduplicateQurey = "select * from bcgh_manufacturer_details where id = " . $miid;
        $miduplicateFetchData = Shopware()->Db()->fetchRow($miduplicateQurey);

        $miordernumber = $miduplicateFetchData['ordernumber'];
        $miposition = $miduplicateFetchData['position'];
        $mists = $miduplicateFetchData['active'];
        $midesc = $miduplicateFetchData['description'];
        $milang = $miduplicateFetchData['language'];

        $miposition = $miposition + 1;


        $miupdatedupQuery = "insert into bcgh_manufacturer_details (ordernumber, position, active, description, language) values (?, ?, ?, ?, ?)";
        $miupdatedupQuery =  Shopware()->Db()->query($miupdatedupQuery, [$miordernumber, $miposition, $mists, $midesc, $milang]);
        return $this->redirect(
            array(
                'controller' => 'ManufacturerInfoController',
                'action' => 'listmanufacturer')

        );

    }


}