<?php

namespace BrandCrockMultiArticleTabs\Models;
use Shopware\Components\Model\ModelEntity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="bcgh_pdf_details")
 */
class BcghPdfDetails extends ModelEntity
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
   
    /**
     * @var string $ordernumber
     *
     * @ORM\Column()
     */
	private $ordernumber;

    /**
     * @var string $name
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var string $extension
     *
     * @ORM\Column()
     */
    private $extension;
	 
	 /**
     * @var string
     * @ORM\Column(name="pdf_file", type="string", length=255, nullable=false)
     */
    private $pdf_file = '';
	
    /**
     * @var integer $active
     *
     * @ORM\Column(type="boolean")
     */
    private $active = false;
	
	
	/**
     * @var integer $position
     *
     * @ORM\Column()
     */
	 
    private $position;	
  	
	/**
     * @var string $language
     *
     * @ORM\Column()
     */
	private $language;
	
   
   	 
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
	
    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }


	/**
     * @param string $pdf_file
     */
    public function setPdf_File($pdf_file)
    {
        $this->pdf_file = $pdf_file;
    }
    /**
     * @return string
     */
    public function getPdf_File()
    {
        return $this->pdf_file;
    }


    /**
     * @param string $ordernumber
     */
    public function setOrdernumber($ordernumber)
    {
        $this->ordernumber = $ordernumber;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $name
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getOrdernumber()
    {
        return $this->ordernumber;
    }
	
	/**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    /**
     * @return string
     */
    public function getPosition() 
    {
        return $this->position;
    }

	/**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
    /**
     * @return string
     */
    public function getLanguage() 
    {
        return $this->language;
    }

}
