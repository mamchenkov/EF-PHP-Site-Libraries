<?php
/**
 * PHP5
 */
namespace EasyForex\Grid;

/**
 * Grid row class
 * 
 * This is a container for grid cells/columns. It does
 * not actually hold any content
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Row extends Renderable {
	
	/**
	 * Add supported rendering formats
	 * 
	 * @return void
	 */
	protected function addRenderFormats() {
		parent::addRenderFormats();
		$this->addRenderFormat('bootstrap2', new \EasyForex\Pattern\Pattern('<div id="%%id%%" class="row">%%content%%</div>'));
		$this->addRenderFormat('bootstrap3', new \EasyForex\Pattern\Pattern('<div id="%%id%%" class="row">%%content%%</div>'));
	}
	
	/**
	 * Add column
	 * 
	 * @param Column $column Column object to add
	 */
	public function addColumn(Column $column) {
		parent::addChild($column);
	}

	/**
	 * Remove column
	 * 
	 * @param Column $column Column object to remove
	 */
	public function removeColumn(Column $column) {
		parent::removeChild($column);
	}

}
?>
