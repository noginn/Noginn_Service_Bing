<?php

/**
 * News source result set
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_NewsResultSet extends Noginn_Service_Bing_ResultSet
{
    /**
     * The total number of results
     *
     * @var int
     */
    protected $_total = 0;
    
    /**
     * The offset
     *
     * @var int
     */
    protected $_offset = 0;
    
    /**
     * Related searches
     *
     * @var Noginn_Service_Bing_NewsRelatedSearchResultSet
     */
    protected $_relatedSearches;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct($dom = null)
    {
        if ($dom !== null) {
            $this->init($dom);
        }
    }
    
    /**
     * Initialize the result set
     *
     * @param DOMElement $dom 
     * @return void
     */
    public function init(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('news', Noginn_Service_Bing::API_NAMESPACE_NEWS);
        
        $this->_total = (int) $xpath->query('//news:Total/text()', $dom)->item(0)->data;
        $this->_offset = (int) $xpath->query('//news:Offset/text()', $dom)->item(0)->data;
        
        $relatedSearches = $xpath->query('//news:RelatedSearches', $dom);
        if ($relatedSearches->length == 1) {
            $this->_relatedSearches = new Noginn_Service_Bing_NewsRelatedSearchResultSet($relatedSearches->item(0));
        }
        
        $this->_results = $xpath->query('//news:NewsResult');
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
     * Returns the offset
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->_offset;
    }
    
    /**
     * Returns the related searches
     *
     * @return Noginn_Service_Bing_NewsRelatedSearchResultSet
     */
    public function getRelatedSearches()
    {
        return $this->_relatedSearches;
    }
    
    /**
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     */
    public function current()
    {
        return new Noginn_Service_Bing_NewsResult($this->_results->item($this->_currentIndex));
    }
}
