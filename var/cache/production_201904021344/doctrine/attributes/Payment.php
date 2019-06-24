<?php

/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */


namespace Shopware\Models\Attribute;
use Shopware\Components\Model\ModelEntity,
    Doctrine\ORM\Mapping AS ORM,
    Symfony\Component\Validator\Constraints as Assert,
    Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="s_core_paymentmeans_attributes")
 */
class Payment extends ModelEntity
{
    

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
     protected $id;


    /**
     * @var integer $paymentId
     *
     * @ORM\Column(name="paymentmeanID", type="integer", nullable=true)
     */
     protected $paymentId;


    /**
     * @var integer $swagPaypalUnifiedDisplayInPlusIframe
     *
     * @ORM\Column(name="swag_paypal_unified_display_in_plus_iframe", type="integer", nullable=true)
     */
     protected $swagPaypalUnifiedDisplayInPlusIframe;


    /**
     * @var string $swagPaypalUnifiedPlusIframePaymentLogo
     *
     * @ORM\Column(name="swag_paypal_unified_plus_iframe_payment_logo", type="text", nullable=true)
     */
     protected $swagPaypalUnifiedPlusIframePaymentLogo;


    /**
     * @var string $bestitKlarnaPaymentImage
     *
     * @ORM\Column(name="bestit_klarna_payment_image", type="text", nullable=true)
     */
     protected $bestitKlarnaPaymentImage;


    /**
     * @var string $bestitKlarnaCheckoutImage
     *
     * @ORM\Column(name="bestit_klarna_checkout_image", type="text", nullable=true)
     */
     protected $bestitKlarnaCheckoutImage;


    /**
     * @var \Shopware\Models\Payment\Payment
     *
     * @ORM\OneToOne(targetEntity="Shopware\Models\Payment\Payment", inversedBy="attribute")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="paymentmeanID", referencedColumnName="id")
     * })
     */
    protected $payment;
    

    public function __construct()
    {
        $this->swagPaypalUnifiedDisplayInPlusIframe = 0;
    }
    

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    

    public function getPaymentId()
    {
        return $this->paymentId;
    }

    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
        return $this;
    }
    

    public function getSwagPaypalUnifiedDisplayInPlusIframe()
    {
        return $this->swagPaypalUnifiedDisplayInPlusIframe;
    }

    public function setSwagPaypalUnifiedDisplayInPlusIframe($swagPaypalUnifiedDisplayInPlusIframe)
    {
        $this->swagPaypalUnifiedDisplayInPlusIframe = $swagPaypalUnifiedDisplayInPlusIframe;
        return $this;
    }
    

    public function getSwagPaypalUnifiedPlusIframePaymentLogo()
    {
        return $this->swagPaypalUnifiedPlusIframePaymentLogo;
    }

    public function setSwagPaypalUnifiedPlusIframePaymentLogo($swagPaypalUnifiedPlusIframePaymentLogo)
    {
        $this->swagPaypalUnifiedPlusIframePaymentLogo = $swagPaypalUnifiedPlusIframePaymentLogo;
        return $this;
    }
    

    public function getBestitKlarnaPaymentImage()
    {
        return $this->bestitKlarnaPaymentImage;
    }

    public function setBestitKlarnaPaymentImage($bestitKlarnaPaymentImage)
    {
        $this->bestitKlarnaPaymentImage = $bestitKlarnaPaymentImage;
        return $this;
    }
    

    public function getBestitKlarnaCheckoutImage()
    {
        return $this->bestitKlarnaCheckoutImage;
    }

    public function setBestitKlarnaCheckoutImage($bestitKlarnaCheckoutImage)
    {
        $this->bestitKlarnaCheckoutImage = $bestitKlarnaCheckoutImage;
        return $this;
    }
    

    public function getPayment()
    {
        return $this->payment;
    }

    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }
    
}