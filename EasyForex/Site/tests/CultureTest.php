<?php
/**
 * PHP5
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Test for Culture class
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class CultureTest extends PHPUnit_Framework_TestCase {

	public function test__toString() {
		$culture = new \EasyForex\Site\Culture('global');
		$result = (string) $culture;
		$this->assertEquals('global', $result);
	}

	public function test__isVisible() {
		$culture = new \EasyForex\Site\Culture('global');
		$result = $culture->isVisible();
		$this->assertTrue($result);

		$culture = new \EasyForex\Site\Culture('global', \EasyForex\Site\Culture::VISIBLE);
		$result = $culture->isVisible();
		$this->assertTrue($result);
		
		$culture = new \EasyForex\Site\Culture('global', \EasyForex\Site\Culture::INVISIBLE);
		$result = $culture->isVisible();
		$this->assertFalse($result);
	}

	public function test__languages() {
		$culture = new \EasyForex\Site\Culture('global');
		$culture->addLanguage(new \EasyForex\Site\Language('en'));

		$result = (string) $culture->getDefaultLanguage();
		$this->assertEquals('en', $result);
	}
}
