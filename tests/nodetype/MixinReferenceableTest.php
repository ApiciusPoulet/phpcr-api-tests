<?php

require_once(dirname(__FILE__) . '/../../inc/baseCase.php');

/**
 * Testing that mix:referenceable nodes references work correctly
 *
 * Covering jcr-2.8.3 spec $10.4.2
 */
class NodeType_MixinReferenceableTest extends jackalope_baseCase
{
    static public function setupBeforeClass()
    {
        parent::setupBeforeClass();
        self::$staticSharedFixture['ie']->import('nodetype/base');
    }

    public function setUp()
    {
        $this->renewSession();
    }

    /**
     * Test that a node without mix:referenceable type cannot be referenced
     * @expectedException PHPCR\ValueFormatException
     * @expectedExceptionMessage Node /tests_nodetype_base/nonreferenceable/jcr:content is not referencable
     */
    public function testReferenceOnNonReferenceableNode()
    {
        // Load a non-referenceable node
        $referenced_node = $this->sharedFixture['session']->getNode('/tests_nodetype_base/nonreferenceable');

        // Try to reference it
        $source_node = $this->sharedFixture['session']->getNode('/tests_nodetype_base/index.txt/jcr:content');
        $source_node->setProperty('reference', $referenced_node, \PHPCR\PropertyType::WEAKREFERENCE);
        $this->sharedFixture['session']->save();
    }

    /**
     * Test that a node with newly set mix:referenceable type can be referenced
     */
    public function testReferenceOnNewlyReferenceableNode()
    {
        // Load a non-referenceable node and make it referenceable
        $referenced_node = $this->sharedFixture['session']->getNode('/tests_nodetype_base/nodetogetref');
        $referenced_node->addMixin('mix:referenceable');
        $this->sharedFixture['session']->save();

        // Reference it from another node
        $source_node = $this->sharedFixture['session']->getNode('/tests_nodetype_base/nonreferenceable');
        $source_node->setProperty('reference', $referenced_node, \PHPCR\PropertyType::WEAKREFERENCE);
        $this->sharedFixture['session']->save();

        $this->assertType('PHPCR\NodeInterface', $source_node->getPropertyValue('reference'));
    }

    /**
     * Test that a node that was imported as mix:referenceable can be referenced
     */
    public function testReferenceOnReferenceableNode()
    {
        // Load a referenceable node
        $referenced_node = $this->sharedFixture['session']->getNode('/tests_nodetype_base/idExample');

        // Reference it from another node
        $source_node = $this->sharedFixture['session']->getNode('/tests_nodetype_base/index.txt/jcr:content');
        $source_node->setProperty('reference', $referenced_node, \PHPCR\PropertyType::WEAKREFERENCE);
        $this->sharedFixture['session']->save();
    }

}
