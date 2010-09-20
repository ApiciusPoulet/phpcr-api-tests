<?php

require_once(dirname(__FILE__) . '/../../../inc/baseCase.php');

/**
 * Covering jcr-283 spec $10.4
 */
class jackalope_tests_write_ManipulationTest_AddMethods extends jackalope_baseCase {

    protected $node;

    public function setUp() {
        parent::setUp();
        $this->node = $this->sharedFixture['session']->getNode('/tests_write_manipulation_base/emptyExample');
    }

    /**
     * @covers jackalope_Node::addNode
     * @covers jackalope_Session::getNode
     */
    public function testAddNode() {
        // should take the primaryType of emptyExample
        $this->node->addNode('newFolderNode');
        $this->assertNotNull($this->sharedFixture['session']->getNode('/tests_write_manipulation_base/emptyExample/newFolderNode'), 'Node newFolderNode was not created');
    }

    public function testAddNodeWithType() {
        $this->node->addNode('newFileNode', 'nt:file');
        $this->assertNotNull($this->sharedFixture['session']->getNode($this->node->getPath() . '/newFileNode'), 'Node newFileNode was not created');
    }

    /**
     * @expectedException PHPCR_ItemExistsException
     */
    public function testAddNodeExisting() {
        $this->markTestSkipped('TODO: implement');
    }

}




