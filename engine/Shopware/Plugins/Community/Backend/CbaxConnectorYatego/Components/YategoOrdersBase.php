<?php
class Shopware_Components_YategoOrdersBase
{
	private $constants;
	
	private $settings;

	/** @var Shopware_Components_ExternalOrderBase */
	private $externalOrderBase;
	
	public function __construct($constants, $settings)
    {
		$this->externalOrderBase = Shopware()->ExternalOrderBase();
		
        $this->constants 	= $constants;
        $this->settings 	= $settings;
    }

	public function getSalutionFromYategoSalution($gender)
	{
		if(strcasecmp(trim($gender),"Frau") == 0)
			return "ms";
		else
			return "mr";
	}
	
	public function getPaymentIdByYategoName($paymentName)
	{
		// Auch Leerzeichen in der Zahlungsart entfernen, da Yatego zu dämlich ist
		$paymentName = str_replace(" ", "", $paymentName);
		$paymentName = trim(strtolower($paymentName));

		foreach($this->settings as $key=>$value)
		{
			$name = explode("_", $key);
			
			if(strpos($paymentName, $name[1]) !== false)
				return $value;
		}
		return -1;
	}
	
	public function getPrice($value)
	{
		/* Tausender-Trennzeichen entfernen */
		$value = str_replace('.','',$value);
		/* Kamma in Punkt umwandeln */
		$value = str_replace(',','.',$value);
		return doubleval($value);
	}
}