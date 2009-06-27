<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Noginn_Service_Bing_AllTests::main');
}

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

/**
 * Exclude from code coverage report
 */
PHPUnit_Util_Filter::addFileToFilter(__FILE__);

require_once 'OfflineTest.php';
require_once 'OnlineTest.php';

class Noginn_Service_Bing_AllTests
{
    /**
     * Runs this test suite
     *
     * @return void
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Creates and returns this test suite
     *
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Noginn_Service_Bing');

        $suite->addTestSuite('Noginn_Service_Bing_OfflineTest');
        if (defined('TESTS_NOGINN_SERVICE_YAHOOBOSS_ONLINE_ENABLED') && constant('TESTS_NOGINN_SERVICE_YAHOOBOSS_ONLINE_ENABLED')) {
            $suite->addTestSuite('Noginn_Service_Bing_OnlineTest');
        }

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Noginn_Service_Bing_AllTests::main') {
    Noginn_Service_Bing_AllTests::main();
}
