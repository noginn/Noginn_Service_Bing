<?php

/**
 * Spelling source result set
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_SpellResultSet extends Noginn_Service_Bing_ResultSet
{
    /**
     * The total number of results
     *
     * @var string
     */
    protected $_total = 0;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('spl', Noginn_Service_Bing::API_NAMESPACE_SPELL);
        
        $this->_total = (int) $xpath->query('//spl:Total/text()', $dom)->item(0)->data;
        
        $this->_results = $xpath->query('//spl:SpellResult');
    }
    
    /**
     * Returns the total number of results
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->_total;
    }
    
    /**
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     */
    public function current()
    {
        return new Noginn_Service_Bing_SpellResult($this->_results->item($this->_currentIndex));
    }
}
