/**
 * 
 * Friedmann Kommunikation GmbH
 * 
 * @category	Shopware
 * @package		Shopware_Plugins
 * @subpackage	FriedmBlank
 * @version		1.0.0
 * @copyright	Copyright (c) 2013, Friedmann Kommunikation GmbH
 * @license		
 * @author		Giuseppe Bottino
 * @link		http://www.friedmann-kommunikation.de
 * 
 */
Ext.define('Shopware.apps.FriedmBlank', {
	name: 'Shopware.apps.FriedmBlank',
    extend:'Enlight.app.SubApplication',
    bulkLoad: true,
    loadPath:'{url action=load}',
	controllers: ['Main'],
	stores: [],
	models: [],
	views: ['main.Window'],
	launch: function() {
		var me = this;		
		mainController = me.getController('Main');
		return mainController.mainWindow;
	}
});