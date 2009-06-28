<?php

/**
 * News source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_NewsResult
{
    /**
     * The title
     *
     * @var string
     */
    protected $_title;
    
    /**
     * A snippet of the news article
     *
     * @var string
     */
    protected $_snippet;
    
    /**
     * The URL
     *
     * @var string
     */
    protected $_url;
    
    /**
     * The source
     *
     * @var string
     */
    protected $_source;
    
    /**
     * The date published
     *
     * @var string
     */
    protected $_date;
    
    /**
     * Whether the news article is breaking news
     *
     * @var bool
     */
    protected $_breakingNews;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
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
     * Returns a snippet of the news article
     *
     * @return string
     */
    public function getSnippet()
    {
        return $this->_snippet;
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
     * Returns the source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->_source;
    }
    
    /**
     * Returns the date published
     *
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }
    
    /**
     * Returns whether the news article is breaking news
     *
     * @return bool
     */
    public function getBreakingNews()
    {
        return $this->_breakingNews;
    }
}
