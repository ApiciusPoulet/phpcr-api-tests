<?php
namespace PHPCR\Tests\Connecting;

require_once(dirname(__FILE__) . '/../../inc/BaseCase.php');

class RepositoryFactoryTest extends \PHPCR\Test\BaseCase
{
    public static function setupBeforeClass()
    {
        //don't care about fixtures
        parent::setupBeforeClass(false);
    }

    // 4.1 Repository
    public function testRepositoryFactory()
    {
        $class = self::$loader->getRepositoryFactoryClass();
        $factory = new $class;
        $this->assertInstanceOf('PHPCR\RepositoryFactoryInterface', $factory);

        $repo = $factory->getRepository(self::$loader->getRepositoryFactoryParameters());
        $this->assertInstanceOf('PHPCR\RepositoryInterface', $repo);
    }

}
