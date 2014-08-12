<?php
/**
 * PHP5
 */
namespace EasyForex\Widget;

/**
 * BaseWidget class
 * 
 * This is an abstract class that implements the iWidget
 * interface.  All widgets should extends it.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
abstract class BaseWidget implements iWidget {

	protected $config;
	
	/**
	 * Constructor
	 * 
	 * Most widgets would need to accept some configuration parameters.
	 * To make the processing simpler, we just use an associative array here.
	 * 
	 * @param array $config (Optional) Associative array of widget options
	 */
	public function __construct(array $config = array()) {
		$this->config = $config;
	}

	/**
	 * Object to string conversion
	 * 
	 * Since the main purpose of the widget is to render some text, we
	 * can just do that from here.
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}
	
	/**
	 * Abstract render method required by the iWidget interface
	 */
	abstract public function render();

	/**
	 * Abstract getParams method required by the iWidget interface
	 */
	abstract public function getParams();

}
?>
