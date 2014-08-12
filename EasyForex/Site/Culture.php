<?php
/**
 * PHP5
 */
namespace EasyForex\Site;

/**
 * Culture class
 * 
 * This is the simplest class for handling a site culture
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Culture {

	const VISIBLE = true;
	const INVISIBLE = false;	

	protected $name;
	protected $visible;
	protected $languages;

	/**
	 * Constructor
	 * 
	 * @param string $name Culture name, like 'global'
	 * @param boolean $visible If culture is visible or internal
	 */
	public function __construct($name, $visible = self::VISIBLE) {
		$this->name = (string) $name;
		$this->visible = (boolean) $visible;
		$this->languages = new \SplObjectStorage();
	}

	/**
	 * Object-to-string conversion
	 * 
	 * @return string Culture name
	 */
	public function __toString() {
		return $this->name;
	}

	/**
	 * Check if the culture is visible
	 * 
	 * @return boolean True if visible, false otherwise
	 */
	public function isVisible() {
		return $this->visible;
	}
	
	/**
	 * Add supported language
	 * 
	 * @throws InvalidArgumentException
	 * @param Language $language Language to add
	 */
	public function addLanguage(Language $language) {
		if ($this->languages->contains($language)) {
			throw new InvalidArgumentException("Language is already supported");
		}
		$this->languages->attach($language);
	}

	/**
	 * Remove supported language
	 * 
	 * @throws InvalidArgumentException
	 * @param Language $language Language to remove
	 */
	public function removeLanguage(Language $language) {
		if (!$this->languages->contains($language)) {
			throw new InvalidArgumentException("Language is already unsupported");
		}
		$this->languages->detach($language);
	}

	/**
	 * Get a collection of supported languages
	 * 
	 * @return \SplObjectStorage
	 */
	public function getLanguages() {
		return $this->languages;
	}

	/**
	 * Get default language
	 * 
	 * @throws RuntimeException
	 * @return Language
	 */
	public function getDefaultLanguage() {
		$result = null;
		
		if ($this->languages->count() == 0) {
			throw new RuntimeException("There are no languages configured");
		}

		$this->languages->rewind();
		$result = $this->languages->current();

		return $result;
	}
}
?>
