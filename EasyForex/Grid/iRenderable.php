<?php
/**
 * PHP5
 */
namespace EasyForex\Grid;

/**
 * iRenderable interface
 * 
 * This interface defines a renderable functionality,
 * which is used by things like templates, rows, and columns.
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
interface iRenderable {

	/**
	 * Render container
	 * 
	 * @param array $data Associative array of data to populate container with
	 * @param string $format Format to use for rendering, such as bootstrap3 or blank
	 * @return string
	 */
	public function render(array $data = array(), $format = null);

	/**
	 * Get container IDs
	 * 
	 * Get a list of all embeded container IDs, which can be provided with content
	 * 
	 * @return array
	 */
	public function getContainerIds();
}
?>
