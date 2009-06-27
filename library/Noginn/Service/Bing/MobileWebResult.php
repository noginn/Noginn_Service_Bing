<?php

/**
 * Mobile web source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_MobileWebResult
{
    /**
     * The title
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The description
     *
     * @var string
     */
    protected $_description;
    
    /**
     * The URL
     *
     * @var string
     */
    protected $_url;
    
    /**
     * The display URL
     *
     * @var string
     */
    protected $_displayUrl;
    
    /**
     * The date/time the page was last changed
     *
     * @var string
     */
    protected $_dateTime;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('mw', Noginn_Service_Bing::API_NAMESPACE_MOBILEWEB);
        
        $title = $xpath->query('./mw:Title/text()', $dom);
        if ($title->length == 1) {
            $this->_title = (string) $title->item(0)->data;
        }
        
        $description = $xpath->query('./mw:Description/text()', $dom);
        if ($description->length == 1) {
            $this->_description = (string) $description->item(0)->data;
        }
        
        $url = $xpath->query('./mw:Url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
        
        $displayUrl = $xpath->query('./mw:DisplayUrl/text()', $dom);
        if ($displayUrl->length == 1) {
            $this->_displayUrl = (string) $displayUrl->item(0)->data;
        }
        
        $dateTime = $xpath->query('./mw:DateTime/text()', $dom);
        if ($dateTime->length == 1) {
            $this->_dateTime = (string) $dateTime->item(0)->data;
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
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
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
    
    /**
     * Returns the display URL
     *
     * @return string
     */
    public function getDisplayUrl()
    {
        return $this->_displayUrl;
    }
    
    /**
     * Returns the date/time
     *
     * @return string
     */
    public function getDateTime()
    {
        return $this->_dateTime;
    }
}
