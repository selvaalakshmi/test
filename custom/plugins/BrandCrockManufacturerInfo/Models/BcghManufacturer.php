<?php

namespace BrandCrockManufacturerInfo\Models;
use Shopware\Components\Model\ModelEntity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="bcgh_manufacturer_details")
 */
class BcghManufacturer extends ModelEntity
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
     * @var string
     * @ORM\Column(name="img_path", type="string", length=255, nullable=false)
     */
    private $img_path = '';
	
    /**
     * @var integer $active
     *
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @var string $description
     *
     * @ORM\Column()
     */
    private $description;
	
	
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
     * @param string $img_path
     */
    public function setImg_Path($img_path)
    {
        $this->img_path = $img_path;
    }
    /**
     * @return string
     */
    public function getImg_Path()
    {
        return $this->img_path;
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
    public function getOrdernumber()
    {
        return $this->ordernumber;
    }

    /**
     * @param string $name
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @return string
     */

    public function getDescription()
    {
        return $this->description;
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
