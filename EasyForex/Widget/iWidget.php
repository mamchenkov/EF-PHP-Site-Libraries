<?php
/**
 * PHP5
 */
namespace EasyForex\Widget;

/**
 * iWidget interface
 * 
 * This interface defines the functionality necessary
 * for site widgets
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
interface iWidget {

	/**
	 * Render widget
	 * 
	 * @return string
	 */
	public function render();

	/**
	 * Get widget parameters configuration
	 * 
	 * This should return the list of available/required parameters
	 * that the widget accepts, in such a format that is suitable
	 * for creating user interfaces and automatic validations.
	 * Think: CakePHP FormHelper
	 * 
	 * @return array
	 */
	public function getParams();
}
?>
