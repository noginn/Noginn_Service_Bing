<?php

/**
 * Related search source result set
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_RelatedSearchResultSet extends Noginn_Service_Bing_ResultSet
{
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('rs', Noginn_Service_Bing::API_NAMESPACE_RELATEDSEARCH);
        
        $this->_results = $xpath->query('//rs:RelatedSearchResult');
    }
    
    /**
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     */
    public function current()
    {
        return new Noginn_Service_Bing_RelatedSearchResult($this->_results->item($this->_currentIndex));
    }
}
