<?php
/**
 * PHP5
 */
namespace EasyForex\Site;

/**
 * Site class
 * 
 * This is the simplest class for handling sites
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Site {
	
	protected $url;
	protected $name;
	protected $description;
	protected $cultures;

	protected $preview;

	/**
	 * Constructor
	 * 
	 * @param string $url Base URL of the site, like 'www.easy-forex.com'
	 * @param string $name Name of the site
	 * @param string $description Description of the site
	 */
	public function __construct($url, $name = '', $description = '') {
		$this->url = $url;
		$this->name = !empty($name) ? $name : $url;
		$this->description = $description;
		$this->cultures = new \SplObjectStorage();

		$this->preview = false;
	}

	/**
	 * Object-to-string conversion
	 * 
	 * @return string Site URL
	 */
	public function __toString() {
		return $this->url;
	}
	
	/**
	 * Add supported culture
	 * 
	 * @throws InvalidArgumentException
	 * @param Culture $culture Culture to add
	 */
	public function addCulture(Culture $culture) {
		if ($this->cultures->contains($culture)) {
			throw new InvalidArgumentException("Culture is already supported");
		}
		$this->cultures->attach($culture);
	}
	
	/**
	 * Remove supported culture
	 * 
	 * @throws InvalidArgumentException
	 * @param Culture $culture Culture to remove
	 */
	public function removeCulture(Culture $culture) {
		if (!$this->cultures->contains($culture)) {
			throw new InvalidArgumentException("Culture is already unsupported");
		}
		$this->cultures->dettach($culture);
	}

	/**
	 * Get a collection of supported cultures
	 * 
	 * @return \SplObjectStorage
	 */
	public function getCultures() {
		return $this->cultures;
	}

	/**
	 * Get default culture
	 * 
	 * @throws RuntimeException
	 * @return Culture
	 */
	public function getDefaultCulture() {
		$result = null;

		if ($this->cultures->count() == 0) {
			throw new RuntimeException("There are no cultures configured");
		}

		$this->cultures->rewind();
		$result = $this->cultures->current();

		return $result;
	}

	/**
	 * Get default language
	 * 
	 * @throws InvalidArgumentException
	 * @param Culture $culture (Optional) Culture to use for default language
	 * @return Language
	 */
	public function getDefaultLanguage(Culture $culture = null) {
		$result = null;

		if (empty($culture)) {
			$culture = $this->getDefaultCulture();
		}

		if (!$this->cultures->contains($culture)) {
			throw new InvalidArgumentException("Invalid culture");
		}

		$this->cultures->rewind();
		while ($this->cultures->valid()) {
			$current = $this->cultures->current();
			if ($current == $culture) {
				$result = $current->getDefaultLanguage();
				break;
			}
			$this->cultures->next();
		}

		return $result;
	}

	/**
	 * Set preview URL pattern
	 * 
	 * @param \EasyForex\Pattern\Pattern $pattern URL pattern to set
	 */
	public function setPreview(\EasyForex\Pattern\Pattern $preview) {
		$this->preview = $preview;
	}

	/**
	 * Get preview URL pattern with data filled placeholders
	 * 
	 * @throws RuntimeException
	 * @param array $data (Optional) Key=>Value list of placeholders and data values
	 * @return string
	 */
	public function getPreview(array $data = array()) {
		if (empty($this->preview)) {
			throw RuntimeException("Preview hasn't been set");
		}
		return $this->preview->parse($data);
	}

}
?>
