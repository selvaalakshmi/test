<?php

class Shopware_Controllers_Backend_CustomAdvanceMenu extends Shopware_Controllers_Backend_ExtJs
{

    public function getTopCategoriesAction(){

        $sql = "SELECT id, description FROM s_categories
                WHERE parent in (SELECT id FROM s_categories WHERE path IS NULL AND parent IS NOT  NULL)
                ORDER BY description ASC;";
        $rows = Shopware()->Db()->fetchAll($sql);
        $data = [];
        foreach ($rows as $row){
            $data[] = ['id' => $row['id'], 'name' => $row['description']];
        }



        $this->view->assign([
            'data' => $data,
            'total' => count($data),
        ]);
        return;

    }
}
