<?php
class Shopware_Controllers_Backend_ConnectorYategoCheck extends Shopware_Controllers_Backend_ExtJs
{
	public function checkExternalOrderAction()
	{
		$minExternalOrderVersion = '2.6.5';

		$sql = "SELECT * FROM s_core_plugins WHERE name = ?";
		$data = Shopware()->Db()->fetchRow($sql, 'CbaxExternalOrder');

		if (!$data['id'] || $data['active'] != 1) {
			$this->View()->assign(array('success' => false, 'message' => 'Sie müssen die "Externe Bestellverwaltung" installieren und aktivieren'));
			return;
		} elseif ($data['version'] < $minExternalOrderVersion) {
			$this->View()->assign(array('success' => false, 'message' => 'Aktualisieren Sie die "Externe Bestellverwaltung" mindestens auf Version ' . $minExternalOrderVersion));
			return;
		} else {
			$this->View()->assign(array('success' => true,));
			return;
		}
	}
}