<?php

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

class Noginn_Service_Bing_OnlineTest extends PHPUnit_Framework_TestCase
{
    /**
     * Reference to Bind service consumer object
     *
     * @var Noginn_Service_Bing
     */
    protected $_bing;

    /**
     * Sets up this test case
     *
     * @return void
     */
    public function setUp()
    {
        $this->_bing = new Noginn_Service_Bing(constant('TESTS_NOGINN_SERVICE_BING_ONLINE_APIKEY'));
    }
}