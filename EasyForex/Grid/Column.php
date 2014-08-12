<?php
/**
 * PHP5
 */
namespace EasyForex\Grid;

/**
 * Grid column class
 * 
 * This is the smallest unit of the grid building, which actually
 * holds content and can vary in width.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Column extends Renderable {

	/**
	 * Constructor
	 * 
	 * @param string $id ID of the cell (used for targeting in CSS and JavaScript)
	 * @param integer $width Width of the column (in grid units)
	 * @param mixed $content Default content of the column (null|string|iRenderable)
	 */
	public function __construct($id, $width, $content = null) {
		parent::__construct($id);
		$this->setWidth($width);
		$this->setContent($content);
		$this->addRenderFormats();
	}

	/**
	 * Add supported rendering formats
	 * 
	 * @return void
	 */
	protected function addRenderFormats() {
		parent::addRenderFormats();
		$this->addRenderFormat('bootstrap2', new \EasyForex\Pattern\Pattern('<div id="%%id%%" class="span%%width%%">%%content%%</div>'));
		$this->addRenderFormat('bootstrap3', new \EasyForex\Pattern\Pattern('<div id="%%id%%" class="col-md-%%width%%">%%content%%</div>'));
	}
	
}
?>
