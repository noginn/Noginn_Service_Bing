<?php

/**
 * Image source result set
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_ImageResultSet extends Noginn_Service_Bing_ResultSet
{
    /**
     * The total number of images returned
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
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('mms', Noginn_Service_Bing::API_NAMESPACE_MULTIMEDIA);
        
        $this->_total = (int) $xpath->query('//mms:Total/text()', $dom)->item(0)->data;
        $this->_offset = (int) $xpath->query('//mms:Offset/text()', $dom)->item(0)->data;
        
        $this->_results = $xpath->query('//mms:ImageResult');
    }
    
    /**
     * Returns the total number of images returned
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
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     */
    public function current()
    {
        return new Noginn_Service_Bing_ImageResult($this->_results->item($this->_currentIndex));
    }
}
