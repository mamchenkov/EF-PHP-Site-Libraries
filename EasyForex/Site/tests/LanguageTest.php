<?php
/**
 * PHP5
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Tests for Language class
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class LanguageTest extends PHPUnit_Framework_TestCase {

	public function test__toString() {
		$language = new \EasyForex\Site\Language('en');
		$result = (string) $language;
		$this->assertEquals('en', $result);
	}

	public function test__getCode() {
		$language = new \EasyForex\Site\Language('en');
		$result = $language->getCode();
		$this->assertEquals('en', $result);

	}
	
	public function test__getName() {
		$language = new \EasyForex\Site\Language('en');
		$result = $language->getName();
		$this->assertEquals('en', $result);
		
		$language = new \EasyForex\Site\Language('en', 'English');
		$result = $language->getName();
		$this->assertEquals('English', $result);

	}

}
