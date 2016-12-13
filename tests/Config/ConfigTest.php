<?php

namespace XhprofEmbed\Tests\Config;

use XhprofEmbed\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

	const INI_STRING = "[section1]\nkey1='value1'\na['2']='a2'\na['3']='a3'";

	public function testCreate() {
		$config = Config::create();
		$this->assertInternalType('string', $config->getValue('common', 'storage'));
	}

	public function testCreateFromFile() {
		$config = Config::create(__DIR__ . '/../../config.ini');
		$this->assertInternalType('string', $config->getValue('common', 'storage'));
	}

	public function testRead() {
		$config = Config::create();
		$config->read(self::INI_STRING);
		$this->assertEquals('value1', $config->getValue('section1', 'key1'));
	}

	public function testWrite() {
		$config = Config::create();
		$config->read(self::INI_STRING);
		$ini = parse_ini_string($config->write(), true);
		$this->assertEquals('value1', $ini['section1']['key1']);
		$this->assertEquals('a2', $ini['section1']['a'][2]);
		$this->assertEquals('a3', $ini['section1']['a'][3]);
	}
}
