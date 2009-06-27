<?php

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

class Noginn_Service_Bing_OfflineTest extends PHPUnit_Framework_TestCase
{
    /**
     * Reference to Bind service consumer object
     *
     * @var Noginn_Service_Bing
     */
    protected $_bing;

    /**
     * Path to test data files
     *
     * @var string
     */
    protected $_filesPath;

    /**
     * HTTP client adapter for testing
     *
     * @var Zend_Http_Client_Adapter_Test
     */
    protected $_httpClientAdapterTest;

    /**
     * Sets up this test case
     *
     * @return void
     */
    public function setUp()
    {
        $this->_bing = new Noginn_Service_Bing(constant('TESTS_NOGINN_SERVICE_BING_ONLINE_APIKEY'));
        $this->_filesPath = dirname(__FILE__) . '/_files';
        $this->_httpClientAdapterSocket = new Zend_Http_Client_Adapter_Socket();
        $this->_httpClientAdapterTest = new Zend_Http_Client_Adapter_Test();
    }
    
    public function testWebSourceSearch()
    {
        $this->_bing->getHttpClient()->setAdapter($this->_httpClientAdapterTest);
        $this->_httpClientAdapterTest->setResponse($this->_loadResponse(__FUNCTION__));
        
        $searchResult = $this->_bing->search('tom graham', 
            array('web' => array(
                'count' => 10,
                'offset' => 0,
            ))
        );
        
        $this->assertTrue($searchResult->hasSource('web'));
        
        // Check the source name isn't case sensitive
        $this->assertTrue($searchResult->hasSource('Web'));
        
        $resultSet = $searchResult->getSource('web');
        $this->assertType('Noginn_Service_Bing_WebResultSet', $resultSet);
        $this->assertEquals(10, count($resultSet));
        $this->assertEquals(25800000, $resultSet->getTotal());
        $this->assertEquals(0, $resultSet->getOffset());
        
        $this->assertEquals(0, $resultSet->key());
        
        // Attempt to seek below the lower bound
        try {
            $resultSet->seek(-1);
            $this->fail('Expected OutOfBoundsException not thrown');
        } catch (OutOfBoundsException $e) {
            $this->assertContains('Illegal index', $e->getMessage());
        }
        
        $resultSet->seek(9);
        
        // Attempt to seek above the upper bound
        try {
            $resultSet->seek(10);
            $this->fail('Expected OutOfBoundsException not thrown');
        } catch (OutOfBoundsException $e) {
            $this->assertContains('Illegal index', $e->getMessage());
        }
        
        $resultSet->rewind();
        $this->assertTrue($resultSet->valid());
        
        $result = $resultSet->current();
        $this->assertEquals('Thomas Graham and Sons', $result->getTitle());
        $this->assertEquals('Stockists of engineering fasteners and steel stock. The site gives information on the range of products and a history of the company.', $result->getDescription());
        $this->assertEquals('http://www.thomas-graham.co.uk/', $result->getUrl());
        $this->assertEquals('http://cc.bingj.com/cache.aspx?q=tom+graham&d=76275785218222&w=608c9417,5ee03831', $result->getCacheUrl());
        $this->assertEquals('www.thomas-graham.co.uk', $result->getDisplayUrl());
        $this->assertEquals('2009-06-21T09:09:36Z', $result->getDateTime());
    }

    /**
     * Utility method for returning a string HTTP response, which is loaded from a file
     *
     * @param  string $name
     * @return string
     */
    protected function _loadResponse($name)
    {
        return file_get_contents($this->_filesPath . '/' . $name . '.response');
    }
}