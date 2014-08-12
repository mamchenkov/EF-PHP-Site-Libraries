<?php
/**
 * PHP5
 */
namespace EasyForex\Grid;

/**
 * Renderable class
 * 
 * This is the core of the grid rendering functionality.  While you can
 * use it on its own, it's better to extend this class with more specific
 * classes like Template, Row, and Column.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Renderable implements iRenderable {

	/**
	 * Minimum width for a grid container
	 */
	const MIN_WIDTH = 1;
	/**
	 * Maximum width for a grid container
	 */
	const MAX_WIDTH = 12;

	protected $id;
	protected $children;
	protected $width;
	protected $content;

	protected $isContainer;
	
	protected $renderFormats = array();
	protected $format;

	/**
	 * Constructor
	 * 
	 * @param string $id HTML id of the container
	 * @param array|iRenderable $content Content
	 */
	public function __construct($id, $content = null) {
		$this->id = $id;
		$this->isContainer = false;
		$this->children = new \SplObjectStorage();
		$this->addRenderFormats();

		if ($content) {
			if (!is_array($content)) {
				$content = array($content);
			}
			foreach ($content as $item) {
				$this->addChild($item);
			}
		}
	}

	/**
	 * Add rendering formats supported by default
	 * 
	 * @return void
	 */
	protected function addRenderFormats() {
		$this->addRenderFormat('blank', new \EasyForex\Pattern\Pattern('%%content%%'));
	}

	/**
	 * Get ID
	 * 
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set container width
	 * 
	 * @throws InvalidArgumentException
	 * @param integer $width Width to use
	 * @return void
	 */
	public function setWidth($width) {
		$width = (int) $width;
		if (($width < self::MIN_WIDTH) || ($width > self::MAX_WIDTH)) {
			throw new InvalidArgumentException("Width is out of bounds");
		}
		$this->width = $width;
	}

	/**
	 * Get container width
	 * 
	 * @return null|integer
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * Set container content
	 * 
	 * This also turns the continer into content container
	 * 
	 * @param mixed $content Content to set (null|string|iRenderable)
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
		$this->isContainer = true;
	}

	/**
	 * Get container content
	 * 
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Check if this is content container
	 * 
	 * @return boolean True if it is, false otherwise
	 */
	public function isContainer() {
		return $this->isContainer;
	}

	/**
	 * Add child container
	 * 
	 * @param iRenderable $child Child object to add
	 * @return void
	 */
	public function addChild(iRenderable $child) {
		if (!$this->children->contains($child)) {
			$this->children->attach($child);
		}
	}
	
	/**
	 * Remove child container
	 * 
	 * @param iRenderable $child Child object to remove
	 * @return void
	 */
	public function removeChild(iRenderable $child) {
		if ($this->children->contains($child)) {
			$this->children->deattach($child);
		}
	}
	
	/**
	 * Export template as serialized string
	 * 
	 * @return string
	 */
	public function export() {
		return serialize($this);
	}

	/**
	 * Import template from serialized string
	 * 
	 * @param string $string Serialized Template
	 * @return void
	 */
	public function import($string) {
		$templateObject = unserialize($string);
		$this->id = $templateObject->id;
		$this->children = $templateObject->children;
		$this->width = $templateObject->width;
		$this->content = $templateObject->content;
		$this->isContainer = $templateObject->isContainer;
		$this->renderFormats = $templateObject->renderFormats;
		$this->format = $templateObject->format;
	}

	/**
	 * Set the format for rendering
	 * 
	 * @param string $format Format to use
	 * @boolean force $force Overwrite existing selected format if true
	 * @return void
	 */
	public function setFormat($format, $force = false) {
		if (!empty($format) && ($force || empty($this->format))) {
			$this->format = $format;
		}
	}

	/**
	 * Get the format for rendering
	 * 
	 * @return string
	 */
	public function getFormat() {
		return $this->format;
	}
	
	/**
	 * Add supported rendering format
	 * 
	 * @param string $name Name of the format
	 * @param object $pattern Rendering pattern
	 * @return void
	 */
	public function addRenderFormat($name, \EasyForex\Pattern\Pattern $pattern) {
		$this->renderFormats[$name] = $pattern;
	}

	/**
	 * Get specified rendering pattern
	 * 
	 * @param string $name Name of the pattern to return
	 * @return object|null
	 */
	public function getRenderFormat($name) {
		$result = null;

		if (!empty($this->renderFormats[$name])) {
			$result = $this->renderFormats[$name];
		}

		return $result;
	}

	/**
	 * Render container
	 * 
	 * @param array $data Data associative array (key=>value) to use for rendering
	 * @param string $format Name of the format to use
	 * @return string
	 */
	public function render(array $data = array(), $format = null) {
		$result = null;

		$this->setFormat($format);
		
		$content = '';
		if ($this->isContainer()) {
			if (is_object($this->content) && (in_array('EasyForex\Grid\iRenderable', class_implements($this->content)))) {
				$content .= $this->content->render($data, $format);
			}
			elseif (!empty($data[ $this->id ])) {
				$content .= $data[ $this->id ];
			}
			else {
				$content .= (string) $this->content;
			}
		}
		else {
			$this->children->rewind();
			while($this->children->valid()) {
				$content .= $this->children->current()->render($data, $format);
				$this->children->next();
			}
		}

		$template = $this->getRenderFormat($this->getFormat());
		$result = ($template) ? $template->parse(array('id'=>$this->id,'width'=>$this->width,'content'=>$content)) : $content;

		return $result;
	}

	/**
	 * Get list of IDs for content containers
	 * 
	 * @return array
	 */
	public function getContainerIds() {
		$result = array();

		if ($this->isContainer()) {
			if (is_object($this->content) && (in_array('EasyForex\Grid\iRenderable', class_implements($this->content)))) {
				$childrenIds = $this->content->getContainerIds();
				$result = array_merge($result, $childrenIds);
			}
			else {
				$result[] = $this->id;
			}
		}
		else {
			$this->children->rewind();
			while ($this->children->valid()) {
				$childrenIds = $this->children->current()->getContainerIds();
				$result = array_merge($result, $childrenIds);
				$this->children->next();
			}
		}

		return $result;
	}
}
?>
