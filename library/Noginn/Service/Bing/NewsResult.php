<?php

/**
 * News source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing_NewsResult
{
    protected $_title;
    
    protected $_snippet;
    
    protected $_url;
    
    protected $_source;
    
    protected $_date;
    
    protected $_breakingNews;
    
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('news', Noginn_Service_Bing::API_NAMESPACE_NEWS);
        
        $title = $xpath->query('./news:Title/text()', $dom);
        if ($title->length == 1) {
            $this->_title = (string) $title->item(0)->data;
        }
        
        $snippet = $xpath->query('./news:Snippet/text()', $dom);
        if ($snippet->length == 1) {
            $this->_snippet = (string) $snippet->item(0)->data;
        }
        
        $url = $xpath->query('./news:Url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
        
        $source = $xpath->query('./news:Source/text()', $dom);
        if ($source->length == 1) {
            $this->_source = (string) $source->item(0)->data;
        }
        
        $date = $xpath->query('./news:Date/text()', $dom);
        if ($date->length == 1) {
            $this->_date = (string) $date->item(0)->data;
        }
        
        $breakingNews = $xpath->query('./news:BreakingNews/text()', $dom);
        if ($breakingNews->length == 1) {
            $this->_breakingNews = $breakingNews->item(0)->data == '1';
        }
    }
    
    public function getTitle()
    {
        return $this->_title;
    }
    
    public function getDescription()
    {
        return $this->_description;
    }
    
    public function getUrl()
    {
        return $this->_url;
    }
    
    public function getSource()
    {
        return $this->_source;
    }
}
