<?php

use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_MultiArticleTabsController extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    public function getWhitelistedCSRFActions()
    {
        return [
            'index',
            'listpdf',
            'listfaq'
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
        $ArticleListQuery = "select a.name, a.id,
							d.id, d.ordernumber, d.articleID, d.instock, d.active
							from s_articles a, s_articles_details d
							where a.id = d.articleID and d.active = 1";
        $ArticleFetchData = Shopware()->Db()->fetchAll($ArticleListQuery);
        $message = '';
        if (!$ArticleFetchData) {
            $message = 'No Data in Database';
            $this->View()->assign(['message' => $message]);
            return;
        }
       
        $this->View()->assign(['ArticleFetchData' => $ArticleFetchData]);
    }
    //PDF Actions
    public function addpdfAction()
    {
        $ordernumber = $this->Request()->getParam('ordernumber');
        $this->View()->assign(['ordernumber' => $ordernumber]);

        //Language Dropdown
        $LanguageQuerydd = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";

        $FetchLanguageData = Shopware()->Db()->fetchAll($LanguageQuerydd);
        $this->View()->assign(['FetchLanguageData' => $FetchLanguageData]);
    }
    public function savepdfAction()
    {
        $ordernumber = $this->Request()->getParam('ordernumber');
        $pdftitle = $this->Request()->getParam('pdftitle');
        $localeid = $this->Request()->getParam('localeid');
        $position = $this->Request()->getParam('position');

        $pdf_file = basename($_FILES["file_source"]["name"]);
        $sts = $this->Request()->getParam('sts', 0);
        $imageName = $ordernumber . "-" . $pdf_file;

        $LocaleQuery = 'select locale from  s_core_locales where id =' . $localeid;
        $localeData = Shopware()->Db()->fetchRow($LocaleQuery);
        $locale = $localeData['locale'];

        $docPath = Shopware()->DocPath();
        $destinationDir = $docPath . 'files/PDF-File';
        $targetDir = $destinationDir . "/";
        $uploadPdfFile = $targetDir . $ordernumber . "-" . $pdf_file;
        $fileTypePdfFile = pathinfo($uploadPdfFile, PATHINFO_EXTENSION);

        if (!empty($_FILES["file_source"]["name"])) {
            if ($fileTypePdfFile == 'pdf') {
                move_uploaded_file($_FILES["file_source"]["tmp_name"], $uploadPdfFile);
                $InsertPdfData = 'Insert into bcgh_pdf_details (ordernumber, name,  pdf_file, extension,  active, position, language) 
		            values ("' . $ordernumber . '","' . $pdftitle . '","' . $imageName . '",
		            "' . $fileTypePdfFile . '","' . $sts . '","' . $position . '","' . $locale . '")';
                $executePdfData = Shopware()->Db()->exec($InsertPdfData);
                return $this->redirect(
                    array(
                        'controller' => 'MultiArticleTabsController',
                        'action' => 'listpdf')
                );
            }else{
                $messagedata = 'You can upload Just only PDF';
                $this->View()->assign(['messagedata' => $messagedata]);
            }
        }


    }
    public function listpdfAction()
    {
        $ddLanguageQuery = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";
        $FetchLanguageData = Shopware()->Db()->fetchAll($ddLanguageQuery);
        $this->View()->assign(['FetchLanguageData' => $FetchLanguageData]);
        $message = '';
        $PdfListQuery = "select * from bcgh_pdf_details";
        $PdfFetchData = Shopware()->Db()->fetchAll($PdfListQuery);
        if (!$PdfFetchData) {
            $message = 'No Data in Database';
            $this->View()->assign(['message' => $message]);
            return;
        }
       
        $this->View()->assign(['PdfFetchData' => $PdfFetchData]);
    }
    public function editpdfAction()
    {
        $pdfid = $this->Request()->getParam('pdfid');
        $EditPdfQuery = "select * from bcgh_pdf_details where id ='" . $pdfid . "'";
        $EditPdfFetchData = Shopware()->Db()->fetchAll($EditPdfQuery);
        $this->View()->assign(['EditPdfFetchData' => $EditPdfFetchData]);

        //Dropdown language Data
        $ddLanguageQuery = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";
        $FetchLanguageData = Shopware()->Db()->fetchAll($ddLanguageQuery);
        $this->View()->assign(['FetchLanguageData' => $FetchLanguageData]);

       
    }
    public function updatepdfAction()
    {
        $pdfid = $this->Request()->getParam('pdfid');
        $ordernumber = $this->Request()->getParam('ordernumber');
        $pdftitle = $this->Request()->getParam('pdffilename');
        $position = $this->Request()->getParam('position');
        $sts = $this->Request()->getParam('sts', 0);
        $pdfFile = basename($_FILES["file_source"]["name"]);
        $unlinkFile = $this->Request()->getParam('pdffiledata');

        $localeid = $this->Request()->getParam('localeid');
        $LocaleQuery = 'select locale from  s_core_locales where id =' . $localeid;
        $localeData = Shopware()->Db()->fetchRow($LocaleQuery);
        $locale = $localeData['locale'];
        if (!empty($pdfFile)){
            $imageName = $ordernumber . "-" . $pdfFile;
            $docPath = Shopware()->DocPath();
            $destinationDir = $docPath . 'files/PDF-File';
            $targetDir = $destinationDir . "/";
            $uploadPdfFile = $targetDir . $ordernumber . "-" . $pdfFile;
            $fileTypePdfFile = pathinfo($uploadPdfFile, PATHINFO_EXTENSION);

                if ($fileTypePdfFile == 'pdf') {
                    unlink($targetDir.$unlinkFile); 
                    move_uploaded_file($_FILES["file_source"]["tmp_name"], $uploadPdfFile);
                    $InsertPdfData = 'update bcgh_pdf_details set ordernumber = "' . $ordernumber . '",  name = "' . $pdftitle . '", 
              pdf_file = "' . $imageName . '",active = "' . $sts . '", position ="' . $position . '", language = "' . $locale . '"
              where id = "' .$pdfid .'"';
            $executePdfData = Shopware()->Db()->exec($InsertPdfData);
                    return $this->redirect(
                        array(
                            'controller' => 'MultiArticleTabsController',
                            'action' => 'listpdf')
                    );
                
                } else {
                    $messagedata = 'You can upload Just only PDF';
                    $this->View()->assign(['messagedata' => $messagedata]);
                }

        }else{
            $UpdatePdfData = 'update bcgh_pdf_details  set ordernumber = "' . $ordernumber . '", name = "' . $pdftitle . '",
            active = "' . $sts . '", position ="' . $position . '", language = "' . $locale . '" where id = "' .$pdfid . '"';
            $executePdfData = Shopware()->Db()->exec($UpdatePdfData);
            return $this->redirect(
                array(
                    'controller' => 'MultiArticleTabsController',
                    'action' => 'listpdf')
            );
        }

    }
    public function deletepdfAction()
    {
        $pdfid = $this->Request()->getParam('pdfid');
        $selQuery = "select pdf_file from bcgh_pdf_details where id =". $pdfid;
        $fetchPdfFile = Shopware()->Db()->fetchOne($selQuery);
        $fileName = $fetchPdfFile;
        if (!empty($fileName)){
            $basePath = Shopware()->DocPath();
            $unlinkPath = $basePath . 'files/PDF-File/'.$fetchPdfFile;
            unlink($unlinkPath);
        }
        $DeletePdfQuery = "delete from bcgh_pdf_details  where id =" . $pdfid;
        $ExecuteQuery = Shopware()->Db()->exec($DeletePdfQuery);
        return $this->redirect(
            array(
                'controller' => 'MultiArticleTabsController',
                'action' => 'listpdf')

        );
    }
    //Faq Action
    public function addfaqAction()
    {
        $ordernumber = $this->Request()->getParam('ordernumber');
        $this->View()->assign(['ordernumber' => $ordernumber]);
        //Language Dropdown
        $LanguageQuerydd = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";

        $FetchLanguageData = Shopware()->Db()->fetchAll($LanguageQuerydd);
        $this->View()->assign(['FetchLanguageData' => $FetchLanguageData]);
    }
    public function savefaqAction()
    {
        $ordernumber = $this->Request()->getParam('ordernumber');
        $position = $this->Request()->getParam('position');
        $sts = $this->Request()->getParam('sts', 0);
        $question = $this->Request()->getParam('question');
        $answer = $this->Request()->getParam('answer');

        //Fetch Locale ID & Execute
        $localeid = $this->Request()->getParam('localeid');
        $LocaleQuery = 'select locale from  s_core_locales where id =' . $localeid;
        $localeData = Shopware()->Db()->fetchRow($LocaleQuery);
        $locale = $localeData['locale'];
        //Save Data
        $InsertFaqData = 'Insert into bcgh_faq_details
		(ordernumber, position, active, question, answer, language) values (?, ?, ?, ?, ?, ?)';
        $InsertFaqData = Shopware()->Db()->query($InsertFaqData, [$ordernumber, $position, $sts, $question, $answer, $locale]);
        return $this->redirect(
            array(
                'controller' => 'MultiArticleTabsController',
                'action' => 'listfaq')
        );
    }
    public function listfaqAction()
    {
        $ddLanguageQuery = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";
        $FetchLanguageData = Shopware()->Db()->fetchAll($ddLanguageQuery);
        $this->View()->assign(['FetchLanguageData' => $FetchLanguageData]);

        $message = '';
        $FaqListQuery = "select * from bcgh_faq_details";

        $FaqFetchData = Shopware()->Db()->fetchAll($FaqListQuery);
        if (!$FaqFetchData) {
            $message = 'No Data in Database';
            $this->View()->assign(['message' => $message]);
            return;
        }
        $this->View()->assign(['FaqFetchData' => $FaqFetchData]);
    }
    public function editfaqAction()
    {
        $faqid = $this->Request()->getParam('faqid');
        $EditFaqQuery = "select * from bcgh_faq_details where id =" . $faqid;
        $EditFaqFetchData = Shopware()->Db()->fetchAll($EditFaqQuery);

        $this->View()->assign(['EditFaqFetchData' => $EditFaqFetchData]);

        //Dropdown language Data
        $ddLanguageQuery = "select l.id, l.locale
							from s_core_locales l, s_core_shops s 
							where l.id = s.locale_id and 
							s.active = 1";

        $FetchLanguageData = Shopware()->Db()->fetchAll($ddLanguageQuery);
        $this->View()->assign(['FetchLanguageData' => $FetchLanguageData]);
    }
    public function updatefaqAction()
    {
        $faqid = $this->Request()->getParam('faqid');
        $position = $this->Request()->getParam('position');
        $sts = $this->Request()->getParam('sts', 0);
        $question = $this->Request()->getParam('question');
        $answer = $this->Request()->getParam('answer');

        //update Language
        $localeid = $this->Request()->getParam('localeid');
        $LocaleQuery = 'select locale from  s_core_locales where id =' . $localeid;
        $localeData = Shopware()->Db()->fetchRow($LocaleQuery);
        $locale = $localeData['locale'];
        $UpdateFaqQuery = "update bcgh_faq_details set position = ?, active = ?, question = ?, 
        answer = ?, language = ? where id = ?";
        $UpdateFaqQuery = Shopware()->Db()->query($UpdateFaqQuery, [$position, $sts, $question, $answer, $locale, $faqid]);
        return $this->redirect(
            array(
                'controller' => 'MultiArticleTabsController',
                'action' => 'listfaq')
        );
    }
    public function duplicatefaqAction()
    {
        $faqid = $this->Request()->getParam('faqid');
        $selDupDataQuery = "select * from  bcgh_faq_details where id ='" . $faqid . "'";

        $fetchDuplicateData = Shopware()->Db()->fetchRow($selDupDataQuery);



        $ordernumber = $fetchDuplicateData['ordernumber'];
        $position = $fetchDuplicateData['position'];
        $sts = $fetchDuplicateData['active'];
        $language = $fetchDuplicateData['language'];
        $question = $fetchDuplicateData['question'];
        $answer = $fetchDuplicateData['answer'];
        $position = $position+1;
        $question = $question ."-copy";
        $InsertDuplicateFaqData = 'Insert into bcgh_faq_details
		(ordernumber, position, active, question, answer, language) values (?, ?, ?, ?, ?, ?)';
        $InsertDuplicateFaqData = Shopware()->Db()->query($InsertDuplicateFaqData, [$ordernumber, $position, $sts, $question, $answer, $language]);

        return $this->redirect(
            array(
                'controller' => 'MultiArticleTabsController',
                'action' => 'listfaq')
        );

    }

    public function deletefaqAction()
    {
        $faqid = $this->Request()->getParam('faqid');
        $DeleteFaqQuery = "delete from bcgh_faq_details  where id =" . $faqid;
        $ExecuteQuery = Shopware()->Db()->exec($DeleteFaqQuery);
        return $this->redirect(
            array(
                'controller' => 'MultiArticleTabsController',
                'action' => 'listfaq')
        );
    }
}