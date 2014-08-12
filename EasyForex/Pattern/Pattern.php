<?php
/**
 * PHP5
 */
namespace EasyForex\Pattern;

/**
 * Pattern class
 * 
 * This class provides an easy way of creating patterns with
 * placeholders and then rendering them with given content.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Pattern {

	protected $pattern;
	protected $data;

	/**
	 * Placeholder edge separator
	 * 
	 * Use this in the pattern to set placeholders, for example: "Hello %%fullname%%".
	 * For simplicity reasons, the starting and ending edge separator is the same.
	 */
	public $edge = '%%';

	/**
	 * Constructor
	 * 
	 * @param string $pattern Pattern content
	 * @param string $data (Optional) Data to render with
	 */
	public function __construct($pattern, array $data = array()) {
		$this->pattern = $pattern;
		$this->data = $data;
	}
	
	/**
	 * Parse pattern, fill with data
	 * 
	 * This method will populate the pattern with provided data.  Placeholders are
	 * case sensitive.  Any placeholder that hasn't been provided the data for, will
	 * remain in result, to avoid any accidental loss of strings.
	 * 
	 * The data is optional, in case it was already provided via the constructor. If it
	 * is provided though, it will simply overwrite the earlier data.
	 * 
	 * @param array $data (Optional) Key=>Value list of placeholders and values
	 * @return string
	 */
	public function parse(array $data = array()) {
		$result = $this->pattern;

		if (!empty($data)) {
			$this->data = $data;
		}

		if (!empty($this->data)) {
			foreach ($this->data as $key => $value) {
				$keyPattern = $this->edge . $key . $this->edge;
				$result = str_replace($keyPattern, $value, $result);
			}
		}

		return $result;
	}

	/**
	 * Render the pattern
	 * 
	 * Note that if no data was provided via constructor, you'll get an initial pattern
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->parse();
	}

}
?>
