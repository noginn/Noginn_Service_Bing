<?php

/**
 * Related search source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_RelatedSearchResult
{
    /**
     * The title
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The URL
     *
     * @var string
     */
    protected $_url;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('rs', Noginn_Service_Bing::API_NAMESPACE_RELATEDSEARCH);
        
        $title = $xpath->query('./rs:Title/text()', $dom);
        if ($title->length == 1) {
            $this->_title = (string) $title->item(0)->data;
        }
        
        $url = $xpath->query('./rs:Url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
    }
    
    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Returns the URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }
}
