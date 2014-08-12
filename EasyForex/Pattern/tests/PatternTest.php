<?php
/**
 * PHP5
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Tests for Pattern class
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class PatternTest extends PHPUnit_Framework_TestCase {

	public function patterns() {
		return array(
				// Pattern,           data,                      expected result
				array('test',         array(),                   'test'),
				array('test%%one%%',  array(),                   'test%%one%%'),
				array('test%%one%%',  array('one'=>''),          'test'),
				array('test%%one%%',  array('test'=>''),         'test%%one%%'),
			);
	}
	
	public function patternsEdge() {
		return array(
				// Pattern,           data,                      expected result
				array('test',         array(),                   'test'),
				array('test**one**',  array(),                   'test**one**'),
				array('test**one**',  array('one'=>''),          'test'),
				array('test**one**',  array('test'=>''),         'test**one**'),
			);
	}

	/**
	 * Simple pattern tests
	 * 
	 * @dataProvider patterns
	 */
	public function test_simple($patternString, $data, $expected) {
		$pattern = new EasyForex\Pattern\Pattern($patternString);
		$this->assertEquals($expected, $pattern->parse($data));
	}
	
	/**
	 * Different edge tests
	 * 
	 * @dataProvider patternsEdge
	 */
	public function edge($patternString, $data, $expected) {
		$pattern = new EasyForex\Pattern\Pattern($patternString);
		$pattern->edge = '**';

		$this->assertEquals($expected, $pattern->parse($data));
	}

}
?>
