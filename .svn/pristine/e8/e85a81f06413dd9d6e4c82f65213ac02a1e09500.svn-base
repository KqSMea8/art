<?php

namespace Symfony\Component\Translation\Tests\Loader;

class XliffFileLoaderTest extends \PHPUnit\Framework\TestCase
{
	public function testLoad()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = __DIR__ . '/../fixtures/resources.xlf';
		$catalogue = $loader->load($resource, 'en', 'domain1');
		$this->assertEquals('en', $catalogue->getLocale());
		$this->assertEquals(array(new \Symfony\Component\Config\Resource\FileResource($resource)), $catalogue->getResources());
		$this->assertSame(array(), libxml_get_errors());
		$this->assertContainsOnly('string', $catalogue->all('domain1'));
	}

	public function testLoadWithInternalErrorsEnabled()
	{
		$internalErrors = libxml_use_internal_errors(true);
		$this->assertSame(array(), libxml_get_errors());
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = __DIR__ . '/../fixtures/resources.xlf';
		$catalogue = $loader->load($resource, 'en', 'domain1');
		$this->assertEquals('en', $catalogue->getLocale());
		$this->assertEquals(array(new \Symfony\Component\Config\Resource\FileResource($resource)), $catalogue->getResources());
		$this->assertSame(array(), libxml_get_errors());
		libxml_clear_errors();
		libxml_use_internal_errors($internalErrors);
	}

	public function testLoadWithExternalEntitiesDisabled()
	{
		$disableEntities = libxml_disable_entity_loader(true);
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = __DIR__ . '/../fixtures/resources.xlf';
		$catalogue = $loader->load($resource, 'en', 'domain1');
		libxml_disable_entity_loader($disableEntities);
		$this->assertEquals('en', $catalogue->getLocale());
		$this->assertEquals(array(new \Symfony\Component\Config\Resource\FileResource($resource)), $catalogue->getResources());
	}

	public function testLoadWithResname()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$catalogue = $loader->load(__DIR__ . '/../fixtures/resname.xlf', 'en', 'domain1');
		$this->assertEquals(array('foo' => 'bar', 'bar' => 'baz', 'baz' => 'foo'), $catalogue->all('domain1'));
	}

	public function testIncompleteResource()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$catalogue = $loader->load(__DIR__ . '/../fixtures/resources.xlf', 'en', 'domain1');
		$this->assertEquals(array('foo' => 'bar', 'extra' => 'extra', 'key' => '', 'test' => 'with'), $catalogue->all('domain1'));
	}

	public function testEncoding()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$catalogue = $loader->load(__DIR__ . '/../fixtures/encoding.xlf', 'en', 'domain1');
		$this->assertEquals(utf8_decode('föö'), $catalogue->get('bar', 'domain1'));
		$this->assertEquals(utf8_decode('bär'), $catalogue->get('foo', 'domain1'));
		$this->assertEquals(array(
	'notes' => array(
		array('content' => utf8_decode('bäz'))
		),
	'id'    => '1'
	), $catalogue->getMetadata('foo', 'domain1'));
	}

	public function testTargetAttributesAreStoredCorrectly()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$catalogue = $loader->load(__DIR__ . '/../fixtures/with-attributes.xlf', 'en', 'domain1');
		$metadata = $catalogue->getMetadata('foo', 'domain1');
		$this->assertEquals('translated', $metadata['target-attributes']['state']);
	}

	public function testLoadInvalidResource()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$loader->load(__DIR__ . '/../fixtures/resources.php', 'en', 'domain1');
	}

	public function testLoadResourceDoesNotValidate()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$loader->load(__DIR__ . '/../fixtures/non-valid.xlf', 'en', 'domain1');
	}

	public function testLoadNonExistingResource()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = __DIR__ . '/../fixtures/non-existing.xlf';
		$loader->load($resource, 'en', 'domain1');
	}

	public function testLoadThrowsAnExceptionIfFileNotLocal()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = 'http://example.com/resources.xlf';
		$loader->load($resource, 'en', 'domain1');
	}

	public function testDocTypeIsNotAllowed()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$loader->load(__DIR__ . '/../fixtures/withdoctype.xlf', 'en', 'domain1');
	}

	public function testParseEmptyFile()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = __DIR__ . '/../fixtures/empty.xlf';

		if (method_exists($this, 'expectException')) {
			$this->expectException('Symfony\\Component\\Translation\\Exception\\InvalidResourceException');
			$this->expectExceptionMessage(sprintf('Unable to load "%s":', $resource));
		}
		else {
			$this->setExpectedException('Symfony\\Component\\Translation\\Exception\\InvalidResourceException', sprintf('Unable to load "%s":', $resource));
		}

		$loader->load($resource, 'en', 'domain1');
	}

	public function testLoadNotes()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$catalogue = $loader->load(__DIR__ . '/../fixtures/withnote.xlf', 'en', 'domain1');
		$this->assertEquals(array(
	'notes' => array(
		array('priority' => 1, 'content' => 'foo')
		),
	'id'    => '1'
	), $catalogue->getMetadata('foo', 'domain1'));
		$this->assertEquals(array(
	'notes' => array(
		array('content' => 'bar', 'from' => 'foo')
		),
	'id'    => '2'
	), $catalogue->getMetadata('extra', 'domain1'));
		$this->assertEquals(array(
	'notes' => array(
		array('content' => 'baz'),
		array('priority' => 2, 'from' => 'bar', 'content' => 'qux')
		),
	'id'    => '123'
	), $catalogue->getMetadata('key', 'domain1'));
	}

	public function testLoadVersion2()
	{
		$loader = new \Symfony\Component\Translation\Loader\XliffFileLoader();
		$resource = __DIR__ . '/../fixtures/resources-2.0.xlf';
		$catalogue = $loader->load($resource, 'en', 'domain1');
		$this->assertEquals('en', $catalogue->getLocale());
		$this->assertEquals(array(new \Symfony\Component\Config\Resource\FileResource($resource)), $catalogue->getResources());
		$this->assertSame(array(), libxml_get_errors());
		$domains = $catalogue->all();
		$this->assertCount(3, $domains['domain1']);
		$this->assertContainsOnly('string', $catalogue->all('domain1'));
		$this->assertEquals(array(
	'target-attributes' => array('order' => 1)
	), $catalogue->getMetadata('bar', 'domain1'));
	}
}

?>
