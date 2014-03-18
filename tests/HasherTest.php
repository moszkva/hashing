<?php

namespace Moszkva\Hashing\Test;

use \Moszkva\Hashing;
use \Moszkva\Hashing\HashingServiceProvider;

class HasherTest extends \TestCase
{
	private $salt;
	
	public function setUp()
	{
		parent::setUp();
		
		$HashingServiceProvider = new HashingServiceProvider($this->app);
		
		$HashingServiceProvider->boot();
		
		$this->salt = \Config::get('Hashing::Hashing.salt');
	}
	/**
	 * A basic functional test example.
	 * @dataProvider testMakeProvider
	 * @return void
	 */
	public function testMake($value, $hash)
	{
		$hasher = new Hashing\Hasher;
		$this->assertEquals($hasher->make($value), $hash);
	}
	
	public function testMakeProvider()
	{		
		$salt = $this->salt;
		
		$params[] = array("alma", sha1('alma'.$salt));
        $params[] =	array("banán", sha1('banán'.$salt));
		$params[] = array("körte", sha1('körte'.$salt));
		$params[] = array("barack", sha1('barack'.$salt));
		
		return $params;
	}
	
	/**
	 * @dataProvider testCheckProvider
	 */
	public function testCheck($value, $hash, $return)
	{
		$hasher = new Hashing\Hasher;
		
		$this->assertEquals($hasher->check($value, $hash), $return);
	}
	
	public function testCheckProvider()
	{
		$salt = $this->salt;
		
		$params[] = array("alma", sha1('alma'.$salt), true);
        $params[] =	array("banán", sha1('banán'.$salt), true);
		$params[] = array("körte", sha1('körte.'), false);
		$params[] = array("barack", sha1('barac'.$salt), false);
		
		return $params;		
	}
			

}