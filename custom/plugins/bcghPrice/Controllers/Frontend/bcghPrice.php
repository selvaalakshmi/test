<?php
/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_bcghPrice extends Enlight_Controller_Action
{
    /**
     * To set the price from and to
     *
     * @param null
     * @retun null
     */
    public function bclistingAction()
    {
        $artId              = $this->Request()->getParam('sArticleId');
        $tax                = $this->Request()->getParam('sArticleTax');
        $sArticleDetailsId  = $this->Request()->getParam('sArticleDetailsId');
        $articlePrice = Shopware()->Db()->fetchRow(
            'SELECT MIN(price) as minPrice, MAX(price) as maxPrice FROM `s_articles_prices` WHERE `articleID` =?', $artId
        );
        $maxPriceCalFianl=''; 
        $maxPriceCalFianlNew='';
        if ($articlePrice['minPrice'] != $articlePrice['maxPrice'] && !$sArticleDetailsId) {
            $maxPrice = $articlePrice['maxPrice'];
            $maxPriceCalFianl = ((($tax/100)*$maxPrice)+$maxPrice);
        } else if($sArticleDetailsId && $articlePrice['minPrice'] != $articlePrice['maxPrice']) {
            $maxPrice = $articlePrice['minPrice'];
            $maxPriceCalFianl = ((($tax/100)*$maxPrice)+$maxPrice);
            $maxPriceCalFianl22 = number_format($maxPriceCalFianl, 2, ',', ' ');
            $sArticleDetailsId1 = number_format($sArticleDetailsId, 2, ',', ' ');
            $pieces = explode(",", $maxPriceCalFianl22);
            $pieces1 = explode(",", $sArticleDetailsId1);
            if( $pieces[0] == $pieces1[0]) {
                $maxPrice = $articlePrice['maxPrice'];
                $maxPriceCalFianl = ((($tax/100)*$maxPrice)+$maxPrice);
            }

        }
        if(!empty($maxPriceCalFianl)){
			$currency = Shopware()->Container()->get('Currency');
			$formattedValue = (float) str_replace(',', '.', $maxPriceCalFianl);
			$maxPriceCalFianlNew = $currency->toCurrency($formattedValue); 
		}
        $this->View()->assign('maxPrice', $maxPriceCalFianlNew);
    }
    /**
     * To get maximum price
     *
     * @param null
     * @retun null
     */
    public function bcdetailmaxAction()
    {
        $artId              = $this->Request()->getParam('sArticleId');
        $tax                = $this->Request()->getParam('sArticleTax');
        $sArticleDetailsId  = $this->Request()->getParam('sArticleDetailsId');
        $articlePrice = Shopware()->Db()->fetchRow(
        'SELECT MIN(price) as minPrice, MAX(price) as maxPrice FROM `s_articles_prices` WHERE `articleID` =?', $artId
        );
        $maxPriceCalFianl='';
        if ($articlePrice['minPrice'] != $articlePrice['maxPrice'] ) {
            $maxPrice = $articlePrice['maxPrice'];
            $maxPriceCalFianl = round((($tax/100)*$maxPrice)+$maxPrice);
			$currency = Shopware()->Container()->get('Currency');
			$formattedValue = (float) str_replace(',', '.', $maxPriceCalFianl);
			$maxPriceCalFianl = $currency->toCurrency($formattedValue); 
           
        }
        $this->View()->assign('maxPrice', $maxPriceCalFianl);

    }
    /**
     * To get minimum price
     *
     * @param null
     * @retun null
     */
    public function bcdetailminAction()
    {
        $artId              = $this->Request()->getParam('sArticleId');
        $tax                = $this->Request()->getParam('sArticleTax');
        $sArticleDetailsId  = $this->Request()->getParam('sArticleDetailsId');
        $maxPriceCalFianl='';
        $articlePrice = Shopware()->Db()->fetchRow(
        'SELECT MIN(price) as minPrice, MAX(price) as maxPrice FROM `s_articles_prices` WHERE `articleID` =?', $artId
        );
        $minPriceCalFianl = '';
        if ($articlePrice['minPrice'] != $articlePrice['maxPrice'] ) {
            $minPrice = $articlePrice['minPrice'];
            $minPriceCalFianl = round((($tax/100)*$minPrice)+$minPrice);
            $currency = Shopware()->Container()->get('Currency');
			$formattedValue = (float) str_replace(',', '.', $minPriceCalFianl);
			$minPriceCalFianl = $currency->toCurrency($formattedValue); 

        }
        $this->View()->assign('minPrice',   trim($minPriceCalFianl));
    }
}

