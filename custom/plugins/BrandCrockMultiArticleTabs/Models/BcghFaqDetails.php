<?php

namespace BrandCrockMultiArticleTabs\Models;
use Shopware\Components\Model\ModelEntity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="bcgh_faq_details")
 */
class BcghFaqDetails extends ModelEntity
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
     * @var string $question
     *
     * @ORM\Column()
     */
    private $question;

    /**
     * @var string $answer
     *
     * @ORM\Column(name="answer", type="text", nullable=true)
     */
    private $answer;
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
     * @param string $tab
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }
    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->name;
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
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }
    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
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
