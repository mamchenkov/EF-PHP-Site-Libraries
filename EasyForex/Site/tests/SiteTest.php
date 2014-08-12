<?php
/**
 * PHP5
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Test for Site class
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */
class SiteTest extends PHPUnit_Framework_TestCase {

	public function test__toString() {
		$site = new \EasyForex\Site\Site('www.easy-forex.com');
		$result = (string) $site;
		$this->assertEquals('www.easy-forex.com', $result);
	}

	public function test__cultures() {
		$site = new \EasyForex\Site\Site('www.easy-forex.com');
		$site->addCulture(new \EasyForex\Site\Culture('global'));

		$result = (string) $site->getDefaultCulture();
		$this->assertEquals('global', $result);
	}
	
	public function test__languages() {
		$site = new \EasyForex\Site\Site('www.easy-forex.com');
		$culture = new \EasyForex\Site\Culture('global');
		$culture->addLanguage(new \EasyForex\Site\Language('en'));
		$site->addCulture($culture);

		$result = (string) $site->getDefaultLanguage();
		$this->assertEquals('en', $result);
	}

	public function test__preview() {
		$site = new\EasyForex\Site\Site('www.easy-forex.com');
		$site->setPreview(new \EasyForex\Pattern\Pattern('this is pattern %%id%%'));

		$result = $site->getPreview(array('id' => 'foobar'));
		$this->assertEquals('this is pattern foobar', $result);
	}
}
?>
