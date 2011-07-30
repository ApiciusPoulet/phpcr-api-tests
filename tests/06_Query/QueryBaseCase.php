<?php
require_once(dirname(__FILE__) . '/../../inc/baseCase.php');

/**
 * a base class for all query tests
 */
abstract class QueryBaseCase extends phpcr_suite_baseCase
{
    /**
     * in addition to base stuff, prepare the query manager and load general/query fixture
     *
     * @param string $fixture name of the fixture to load, defaults to general/base
     */
    public static function setupBeforeClass($fixture = 'general/base')
    {
        parent::setupBeforeClass($fixture);
        self::$staticSharedFixture['qm'] = self::$staticSharedFixture['session']->getWorkspace()->getQueryManager();
    }

    /**
     * in addition to base stuff, prepare $this->query with a simple select query
     */
    public function setUp()
    {
        parent::setUp();

        $this->query = $this->sharedFixture['qm']->createQuery("SELECT * FROM [nt:unstructured]", \PHPCR\Query\QueryInterface::JCR_SQL2);
    }
}
