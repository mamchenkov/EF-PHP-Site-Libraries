<?php
/**
 * PHP5
 */
namespace EasyForex\Widget;

/**
 * Image Widget
 * 
 * This widget is useful for generating IMG tags.  Added value for the 
 * developers is the integration with lorempixel.com for those cases
 * where images are necessary for layout testing but are not yet provided.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class ImageWidget extends BaseWidget {

	/**
	 * Render IMG tag
	 * 
	 * @return string
	 */
	public function render() {

		if (empty($this->config['src'])) {
			$this->setLoremPixelUrl();
		}

		$patternString = '<img';

		$params = array_keys($this->getParams());
		foreach ($params as $param) {
			$patternString .= empty($this->config[$param]) ? '' : ' ' . $param . '="%%' . $param . '%%"';
		}
		$patternString .= '>';
	
		$pattern = new \EasyForex\Pattern\Pattern($patternString);
		$result = $pattern->parse($this->config);

		return $result;
	}

	/**
	 * Set lorempixel.com URL
	 * 
	 * @return void
	 */
	protected function setLoremPixelUrl() {
		$result = 'http://lorempixel.com';
		
		// Set default width
		if (empty($this->config['width'])) {
			$this->config['width'] = 640;
		}
		$result .= '/' . $this->config['width'];
		
		// Set default height
		if (empty($this->config['height'])) {
			$this->config['height'] = 480;
		}
		$result .= '/' . $this->config['height'];

		// Set default category
		if (empty($this->config['category'])) {
			$this->config['category'] = 'abstract';
		}
		$result .= '/' . $this->config['category'];
		$result .= '/' . mt_rand(1,10);  // Random picture from category

		// Add title as text over the image
		if (!empty($this->config['title'])) {
			$result .= '/' . $this->config['title'];
		}

		$this->config['src'] = $result;
	}

	/**
	 * Get supported parameters
	 * 
	 * @return array
	 */
	public function getParams() {
		return array(
				'src' => array('type' => 'text'),
				'alt'  => array('type' => 'text'),
				'title'  => array('type' => 'text'),
				'height'  => array('type' => 'text'),
				'width'  => array('type' => 'text'),
				'id'  => array('type' => 'text'),
				'class'  => array('type' => 'text'),
			);
	}
}
?>
