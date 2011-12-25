<?php
namespace ZendTest\Queue\Adapter;
use Zend\Queue\Adapter;

class MongoTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $mongo = new \Mongo('mongodb://127.0.0.1:27017');
        $db = $mongo->selectDB('testQueue');
        $db->createCollection('queue1');
    }

    public function getAdapter()
    {
        return new Adapter\Mongo(array(
            'driverOptions' => array(
                'host' => '127.0.0.1',
                'post' => 27017,
                'dbname' => 'testQueue',
            ),
        ));
    }

    public function testInit()
    {
        $mongo = new Adapter\Mongo(array(
            'driverOptions' => array(
                'host' => '127.0.0.1',
                'post' => 27017,
                'dbname' => 'testQueue',
            ),
        ));
    }

    public function testGetQueues()
    {
        $adapter = $this->getAdapter();
        $this->assertEquals(1, count($adapter->getQueues()));
    }
}

