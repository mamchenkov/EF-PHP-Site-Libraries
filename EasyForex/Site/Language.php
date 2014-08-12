<?php
/**
 * PHP5
 */
namespace EasyForex\Site;

/**
 * Language class
 * 
 * This is the simplest class for handling a human language
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Language {
	
	protected $code;
	protected $name;

	/**
	 * Constructor
	 * 
	 * @param string $code Language code, like 'en'
	 * @param string $name (Optional) Name of the language, like 'English'
	 */
	public function __construct($code, $name = null) {
		$this->code = (string) $code;
		$this->name = !empty($name) ? (string) $name : (string) $code;
	}

	/**
	 * Object-to-string conversion
	 * 
	 * @return string Language code
	 */
	public function __toString() {
		return $this->code;
	}

	/**
	 * Get language code
	 * 
	 * @return string Language code
	 */
	public function getCode() {
		return $this->code;
	}
	
	/**
	 * Get language name
	 * 
	 * @return language name
	 */
	public function getName() {
		return $this->name;
	}
}
?>
