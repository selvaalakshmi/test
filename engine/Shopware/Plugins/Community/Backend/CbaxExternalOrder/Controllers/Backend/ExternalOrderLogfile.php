<?php
class Shopware_Controllers_Backend_ExternalOrderLogfile extends Shopware_Controllers_Backend_ExtJs
{
	public function init()
    {
        $this->View()->addTemplateDir(dirname(__FILE__) . "/../../Views/");
        parent::init();
    }
	
	public function indexAction()
    {
        $this->View()->loadTemplate("backend/external_order_logfile/app.js");
    }
	
	public function getLogfilesAction()
	{
		$request = $this->request();

		$filterAccount = $request->getParam('filterByAccount');
		
		$limit = (int)$request->getParam('limit', 30);
		$start = (int)$request->getParam('start', 0);

		// Tabelle sortieren
		$sort = $request->getParam('sort');
		$property = $sort[0]["property"];
		$direction = $sort[0]["direction"];
		if (empty($property)) $property = "date";
        if (empty($direction)) $direction = "DESC";
		
		$filterSql = "WHERE 1 = 1";

		// Nach Account filtern
		if ($filterAccount) {
			$filterSql .= " AND account = '$filterAccount'";
		}

		// Suchfeld
		$filterParams = $this->Request()->getParam('filter', array());
		$filters = array();
		foreach ($filterParams as $singleFilter) {
			$filters[$singleFilter['property']] = $singleFilter['value'];
		}

		if (isset($filters['search'])) {
			$search = "%" . trim($filters['search']) . "%";

			$filterSql .= "
	 		AND 
				(account LIKE '$search' 
			OR 
				msg LIKE '$search' 
			OR 
				action LIKE '$search'
			OR 
				debugdata LIKE '$search')
			";
		}
		
		$sql = "
		SELECT SQL_CALC_FOUND_ROWS eol.id,
			eol.account,
			eoa.description AS account_description,
			eol.date,
			eol.type,
			eol.msg,
			eol.action
		FROM 
			s_plugin_externalorder_log AS eol
		
		LEFT JOIN
			s_plugin_externalorder_account AS eoa
			ON eoa.name = eol.account
			
		$filterSql 
		
		ORDER BY {$property} {$direction} 
		LIMIT {$start},{$limit}
		";
		
		$data = Shopware()->Db()->fetchAll($sql);
		
		$sqlCount= "SELECT FOUND_ROWS()";
		$count = Shopware()->Db()->fetchOne($sqlCount);
		
		foreach ($data as $key => $value)
		{
			$data[$key]["date"] = $this->DateTimeFromDb($data[$key]["date"]);
		}
		
		$this->View()->assign(array("success"=>true, "data"=>$data, "total"=>$count));
	}

	public function getDebugDataAction()
	{
		$request = $this->request();

		$id = (int)$request->getParam('id');

		if ($id) {
			$sql = "SELECT `debugdata` FROM `s_plugin_externalorder_log` WHERE `id` = ?";
			$debugData = Shopware()->Db()->fetchOne($sql, array($id));

			$this->View()->assign(array('success' => true, 'debugData' => $debugData));
		} else {
			$this->View()->assign(array('success' => false));
		}
	}

	public function deleteLogfileAction()
	{
		$request = $this->request();

		$id = intval($request->getParam('id'));

		if ($id) {
			$sql = "DELETE FROM s_plugin_externalorder_log WHERE id = ?";
			Shopware()->Db()->query($sql, array($id));

			$this->View()->assign(array('success' => true));
		} else {
			$this->View()->assign(array('success' => false));
		}
	}
	
	public function DateTimeFromDb($date)
	{
    	$year		= substr($date,0,4);
    	$month		= substr($date,5,2);
    	$day		= substr($date,8,2);
		$hour		= substr($date,11,2);
    	$minute		= substr($date,14,2);
    	$second		= substr($date,17,2);
	
		if (checkdate ($month, $day, $year)) {
			return $date = $day . "." . $month . "." . $year . " " . $hour . ":" . $minute . ":" . $second;
		}
	}
}

