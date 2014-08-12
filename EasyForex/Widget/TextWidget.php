<?php
/**
 * PHP5
 */
namespace EasyForex\Widget;

/**
 * Text Widget
 * 
 * This widget provides simple way to render text chunks, optionally
 * surrounded by a given tag.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class TextWidget extends BaseWidget {

	/**
	 * Render text
	 * 
	 * @return string
	 */
	public function render() {
		$startWrap = empty($this->config['tag']) ? '' : '<%%tag%%>';
		$endWrap   = '';
		// Cleanup closing tag from any attributes, just in case
		if (!empty($this->config['tag'])) {
			$this->config['tagClose'] = preg_replace('#\s+.*$#', '', $this->config['tag']);
			$endWrap = '</%%tagClose%%>';
		}
		
		$text      = empty($this->config['text']) ? '' : '%%text%%';

		$pattern = new \EasyForex\Pattern\Pattern($startWrap . $text . $endWrap);
		$result = $pattern->parse($this->config);

		return $result;
	}

	/**
	 * Get list of supported parameters
	 * 
	 * @return array
	 */
	public function getParams() {
		return array(
				'text' => array('type' => 'text'),
				'tag'  => array('type' => 'text'),
			);
	}
}
?>
