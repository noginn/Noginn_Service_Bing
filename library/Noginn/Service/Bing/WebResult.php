<?php

/**
 * Web source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_WebResult
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
     * The cache URL
     *
     * @var string
     */
    protected $_cacheUrl;
    
    /**
     * The date time
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
        $xpath->registerNamespace('web', Noginn_Service_Bing::API_NAMESPACE_WEB);
        
        $title = $xpath->query('./web:Title/text()', $dom);
        if ($title->length == 1) {
            $this->_title = (string) $title->item(0)->data;
        }
        
        $description = $xpath->query('./web:Description/text()', $dom);
        if ($description->length == 1) {
            $this->_description = (string) $description->item(0)->data;
        }
        
        $url = $xpath->query('./web:Url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
        
        $displayUrl = $xpath->query('./web:DisplayUrl/text()', $dom);
        if ($displayUrl->length == 1) {
            $this->_displayUrl = (string) $displayUrl->item(0)->data;
        }
        
        $cacheUrl = $xpath->query('./web:CacheUrl/text()', $dom);
        if ($cacheUrl->length == 1) {
            $this->_cacheUrl = (string) $cacheUrl->item(0)->data;
        }
        
        $dateTime = $xpath->query('./web:DateTime/text()', $dom);
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
     * Returns the URL of the cached page
     *
     * @return string
     */
    public function getCacheUrl()
    {
        return $this->_cacheUrl;
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
