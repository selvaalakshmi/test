<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shopware\SwagMigration\Components\DbServices\Import;

use Enlight_Components_Db_Adapter_Pdo_Mysql as PDOConnection;

class PriceImporter
{
    /**
     * @var PDOConnection
     */
    private $db;

    /**
     * @param PDOConnection $db
     */
    public function __construct(PDOConnection $db)
    {
        $this->db = $db;
    }

    /**
     * @param array $price
     *
     * @return bool|int
     */
    public function importArticlePrice(array $price)
    {
        $price = $this->preparePriceData($price);
        $article = $this->getArticleNumbers($price);
        if (empty($article)) {
            return false;
        }

        if (empty($price['price']) && empty($price['percent'])) {
            return false;
        }

        if ($price['from'] <= 1 && empty($price['price'])) {
            return false;
        }

        $this->deleteOldPrices($price['pricegroup'], $price['from'], $article['articledetailsID']);

        if (empty($price['price'])) {
            $price['price'] = $this->getPrice(
                $price['pricegroup'],
                $price['percent'],
                $article['articleID'],
                $article['articledetailsID']
            );
            if ($price['price'] === false) {
                return false;
            }
        }

        if ($price['from'] != 1) {
            $result = $this->setTo(
                $price['from'],
                $price['pricegroup'],
                $article['articleID'],
                $article['articledetailsID']
            );
            if ($result === false) {
                return false;
            }
        }

        $created = $this->createPrice($price, $article);
        if (empty($created)) {
            return false;
        }

        return (int) $this->db->lastInsertId();
    }

    /**
     * @param array $price
     *
     * @return array
     */
    private function preparePriceData(array $price)
    {
        if (isset($price['price'])) {
            $price['price'] = $this->toFloat($price['price']);
        }
        if (isset($price['tax'])) {
            $price['tax'] = $this->toFloat($price['tax']);
        }
        $price['pseudoprice'] = isset($price['pseudoprice']) ? $this->toFloat($price['pseudoprice']) : 0;
        $price['baseprice'] = isset($price['baseprice']) ? $this->toFloat($price['baseprice']) : 0;
        $price['percent'] = isset($price['percent']) ? $this->toFloat($price['percent']) : 0;
        $price['from'] = empty($price['from']) ? 1 : (int) $price['from'];
        if (empty($price['pricegroup'])) {
            $price['pricegroup'] = 'EK';
        }
        $price['pricegroup'] = $this->db->quote($price['pricegroup']);
        if (!empty($price['tax'])) {
            $price['price'] = $price['price'] / (100 + $price['tax']) * 100;
        }
        if (isset($price['pseudoprice']) && !empty($price['tax'])) {
            $price['pseudoprice'] = $price['pseudoprice'] / (100 + $price['tax']) * 100;
        }

        return $price;
    }

    /**
     * @param array $price
     *
     * @return bool|array
     */
    private function getArticleNumbers(array $price)
    {
        if (empty($price['articleID']) && empty($price['articledetailsID']) && empty($price['ordernumber'])) {
            return false;
        }

        if (!empty($price['articledetailsID'])) {
            $price['articledetailsID'] = (int) $price['articledetailsID'];
            $where = "id = {$price['articledetailsID']}";
        } elseif (!empty($price['articleID'])) {
            $price['articleID'] = (int) $price['articleID'];
            $where = "articleID = {$price['articleID']} AND kind = 1";
        } else {
            $price['ordernumber'] = $this->db->quote((string) $price['ordernumber']);
            $where = "ordernumber = {$price['ordernumber']}";
        }

        $sql = "SELECT id as articledetailsID, ordernumber, articleID
                FROM s_articles_details
                WHERE {$where}";
        $numbers = $this->db->fetchRow($sql);
        if (empty($numbers['articledetailsID'])) {
            return false;
        }

        return $numbers;
    }

    /**
     * @param string $priceGroup
     * @param int    $from
     * @param int    $detailId
     */
    private function deleteOldPrices($priceGroup, $from, $detailId)
    {
        $sql = "DELETE FROM s_articles_prices
                WHERE pricegroup = {$priceGroup}
                    AND articledetailsID = {$detailId}
                    AND CAST(`from` AS UNSIGNED) >= {$from}";
        $this->db->query($sql);
    }

    /**
     * @param string $priceGroup
     * @param float  $percent
     * @param int    $articleId
     * @param int    $detailId
     *
     * @return bool|float
     */
    private function getPrice($priceGroup, $percent, $articleId, $detailId)
    {
        $sql = "SELECT price
                FROM s_articles_prices
                WHERE pricegroup = {$priceGroup}
                    AND `from` = 1
                    AND articleID =  {$articleId}
                    AND articledetailsID = {$detailId}";

        $price = $this->db->fetchOne($sql);
        if (empty($price)) {
            return false;
        }

        return $price * (100 - $percent) / 100;
    }

    /**
     * @param int    $from
     * @param string $priceGroup
     * @param int    $articleId
     * @param int    $detailId
     *
     * @return bool
     */
    private function setTo($from, $priceGroup, $articleId, $detailId)
    {
        $to = $from - 1;
        $sql = "UPDATE s_articles_prices
                SET `to` = {$to}
                WHERE pricegroup = {$priceGroup}
                  AND articleID =  {$articleId}
                  AND articledetailsID = {$detailId}
                ORDER BY `from` DESC LIMIT 1";
        $result = $this->db->query($sql);

        if (empty($result) || !$result->rowCount()) {
            return false;
        }

        return true;
    }

    /**
     * @param array $price
     * @param array $article
     *
     * @return bool
     */
    private function createPrice(array $price, array $article)
    {
        $sql = "INSERT INTO s_articles_prices (
                  pricegroup,
                  `from`,
                  `to`,
                  articleID,
                  articledetailsID,
                  price,
                  pseudoprice,
                  baseprice,
                  percent
                )
                VALUES (
                  {$price['pricegroup']},
                  {$price['from']},
                  'beliebig',
                  {$article['articleID']},
                  {$article['articledetailsID']},
                  {$price['price']},
                  {$price['pseudoprice']},
                  {$price['baseprice']},
                  {$price['percent']}
                )";

        return (bool) $this->db->query($sql);
    }

    /**
     * Replace comma with point for decimal delimiter
     *
     * @param string $value
     *
     * @return float
     */
    private function toFloat($value)
    {
        return (float) str_replace(',', '.', $value);
    }
}
