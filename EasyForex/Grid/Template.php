<?php
/**
 * PHP5
 */
namespace EasyForex\Grid;

/**
 * Grid template class
 * 
 * This is the container for the whole template.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class Template extends Renderable {
	
	/**
	 * Add supported rendering formats
	 * 
	 * @return void
	 */
	protected function addRenderFormats() {
		parent::addRenderFormats();
		$this->addRenderFormat('bootstrap2', new \EasyForex\Pattern\Pattern('<div class="container">%%content%%</div>'));
		$this->addRenderFormat('bootstrap3', new \EasyForex\Pattern\Pattern('<div class="container">%%content%%</div>'));
	}
	
	/**
	 * Add row
	 * 
	 * @param Row $row Row object to add
	 */
	public function addRow(Row $row) {
		parent::addChild($row);
	}

	/**
	 * Remove row
	 * 
	 * @param Row $row Row object to remove
	 */
	public function removeRow(Row $row) {
		parent::removeChild($row);
	}

}
?>
