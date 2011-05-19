<?php
require_once('QueryBaseCase.php');

/**
 * test javax.jcr.QueryManager interface
 * todo: getQOMFactory
 */
class Query_6_QueryManagerTest extends QueryBaseCase
{
    public static function setupBeforeClass()
    {
        parent::setupBeforeClass('general/query');
    }

    public function testCreateQuery()
    {
        $ret = $this->sharedFixture['qm']->createQuery(null, PHPCR\Query\QueryInterface::JCR_SQL2);
        $this->assertType('PHPCR\Query\QueryInterface', $ret);
    }

    /**
     * @expectedException PHPCR\Query\InvalidQueryException
     */
    public function testCreateXpathQuery()
    {
        $this->sharedFixture['qm']->createQuery('/jcr:root', 'xpath');
    }

    public function testGetQuery()
    {
        $this->sharedFixture['ie']->import('general/query');
        try {
            $qnode = $this->sharedFixture['session']->getRootNode()->getNode('queryNode');
            $this->assertType('PHPCR\NodeInterface', $qnode);

            $query = $this->sharedFixture['qm']->getQuery($qnode);
            $this->assertTrue('PHPCR\Query\QueryInterface', $query);
        } catch(exception $e) {
            //FIXME: finally?
            $this->sharedFixture['ie']->import('general/query');
            throw $e;
        }
        $this->sharedFixture['ie']->import('general/query');
    }
    /**
     * @expectedException PHPCR\Query\InvalidQueryException
     */
    public function testGetQueryInvalid()
    {
        $this->sharedFixture['qm']->getQuery($this->sharedFixture['session']->getRootNode());
    }

    public function testGetSupportedQueryLanguages()
    {
        $ret = $this->sharedFixture['qm']->getSupportedQueryLanguages();
        $this->assertType('array', $ret);
        $this->assertContains('JCR-SQL2', $ret);
        $this->assertContains('JCR-JQOM', $ret);
    }
}
