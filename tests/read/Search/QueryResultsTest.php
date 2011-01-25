<?php
require_once(dirname(__FILE__) . '/../../../inc/baseCase.php');

//6.6.8 Query API
class Read_Search_QueryResultsTest extends jackalope_baseCase
{
    public static $expect = array("jcr:createdBy","jcr:created","jcr:primaryType","jcr:path","jcr:score");
    public $query;

    public static function setupBeforeClass()
    {
        parent::setupBeforeClass();
        self::$staticSharedFixture['qm'] = self::$staticSharedFixture['session']->getWorkspace()->getQueryManager();
    }

    public function setUp()
    {
        parent::setUp();

        $this->query = $this->sharedFixture['qm']->createQuery("SELECT * FROM [nt:unstructured]", \PHPCR\Query\QueryInterface::JCR_SQL2);
        $this->qr = $this->query->execute();
        //sanity check
        $this->assertInstanceOf('PHPCR\Query\QueryResultInterface', $this->qr);
    }

    public function testBindValue()
    {
        $this->markTestSkipped(); //TODO: test with a SQL2 query
    }

    public function testGetBindVariableNames()
    {
        $this->markTestSkipped(); //TODO: test with a SQL2 query
    }

    public function testGetBindVariableNamesEmpty()
    {
        $this->markTestSkipped(); //TODO: test with a SQL2 query
    }

    public function testGetColumnNames()
    {
        $columnNames = $this->qr->getColumnNames();
        $columnNamesExpected = array('nt:unstructured.jcr:primaryType', 'jcr:path', 'jcr:score');

       $this->assertEquals($columnNamesExpected, $columnNames);
    }

    public function testGetNodes()
    {
        $nodes = $this->qr->getNodes();
        $count = 0;

        foreach ($nodes as $node) {
            //$this->assertInstanceOf('Jackalope\Node', $node);
            $this->assertInstanceOf('PHPCR\NodeInterface', $node);
            $count++;
        }
        $this->assertEquals(3, $count);
    }

    public function testGetSelectorNames()
    {
        $selectorNames = $this->qr->getSelectorNames();
        $selectorNamesExpected = array('nt:unstructured');

        $this->assertEquals($selectorNamesExpected, $selectorNames);
    }

    public function testIterateOverQueryResult()
    {
        $count = 0;

        foreach ($this->qr as $key => $row) {
            $this->assertInstanceOf('Jackalope\Query\Row', $row); // Test if the return element is an istance of row

            foreach ($row as $columnName => $value) { // Test if we can iterate over the columns inside a row
                $count++;
            }
        }
        $this->assertEquals(9, $count);
    }
}
