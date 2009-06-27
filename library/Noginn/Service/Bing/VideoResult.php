<?php

/**
 * Video source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_VideoResult
{
    /**
     * The title
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The play URL
     *
     * @var string
     */
    protected $_playUrl;
    
    /**
     * The click through page URL
     *
     * @var string
     */
    protected $_clickThroughPageUrl;
    
    /**
     * The source title
     *
     * @var string
     */
    protected $_sourceTitle;
    
    /**
     * The run time of the video in seconds
     *
     * @var int
     */
    protected $_runTime;
    
    /**
     * The generated thumbnail URL
     *
     * @var string
     */
    protected $_thumbnailUrl;
    
    /**
     * The thumbnail width
     *
     * @var int
     */
    protected $_thumbnailWidth;
    
    /**
     * The thumbnail height
     *
     * @var int
     */
    protected $_thumbnailHeight;
    
    /**
     * The thumbnail file size in bytes
     *
     * @var int
     */
    protected $_thumbnailFileSize;
    
    /**
     * The thumbnail content type
     *
     * @var string
     */
    protected $_thumbnailContentType;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('mms', Noginn_Service_Bing::API_NAMESPACE_MULTIMEDIA);
        
        $title = $xpath->query('./mms:Title/text()', $dom);
        if ($title->length == 1) {
            $this->_title = (string) $title->item(0)->data;
        }
        
        $sourceTitle = $xpath->query('./mms:SourceTitle/text()', $dom);
        if ($sourceTitle->length == 1) {
            $this->_sourceTitle = (string) $sourceTitle->item(0)->data;
        }
        
        $playUrl = $xpath->query('./mms:PlayUrl/text()', $dom);
        if ($playUrl->length == 1) {
            $this->_playUrl = (string) $playUrl->item(0)->data;
        }
        
        $clickThroughPageUrl = $xpath->query('./mms:ClickThroughPageUrl/text()', $dom);
        if ($clickThroughPageUrl->length == 1) {
            $this->_clickThroughPageUrl = (string) $clickThroughPageUrl->item(0)->data;
        }
        
        $runTime = $xpath->query('./mms:RunTime/text()', $dom);
        if ($runTime->length == 1) {
            $this->_runTime = (int) $runTime->item(0)->data;
        }
        
        $thumbnail = $xpath->query('./mms:Thumbnail', $dom);
        if ($thumbnail->length == 1) {
            // There is a thumbnail
            $thumbnailUrl = $xpath->query('./mms:Url/text()', $thumbnail->item(0));
            if ($thumbnailUrl->length == 1) {
                $this->_thumbnailUrl = (string) $thumbnailUrl->item(0)->data;
            }
            
            $thumbnailWidth = $xpath->query('./mms:Width/text()', $thumbnail->item(0));
            if ($thumbnailWidth->length == 1) {
                $this->_thumbnailWidth = (int) $thumbnailWidth->item(0)->data;
            }
            
            $thumbnailHeight = $xpath->query('./mms:Height/text()', $thumbnail->item(0));
            if ($thumbnailHeight->length == 1) {
                $this->_thumbnailHeight = (int) $thumbnailHeight->item(0)->data;
            }
            
            $thumbnailFileSize = $xpath->query('./mms:FileSize/text()', $thumbnail->item(0));
            if ($thumbnailFileSize->length == 1) {
                $this->_thumbnailFileSize = (int) $thumbnailFileSize->item(0)->data;
            }
            
            $thumbnailContentType = $xpath->query('./mms:ContentType/text()', $thumbnail->item(0));
            if ($thumbnailContentType->length == 1) {
                $this->_thumbnailContentType = (string) $thumbnailContentType->item(0)->data;
            }
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
     * Returns the source title
     *
     * @return string
     */
    public function getSourceTitle()
    {
        return $this->_sourceTitle;
    }
    
    /**
     * Returns the video playback URL
     *
     * @return string
     */
    public function getPlayUrl()
    {
        return $this->_playUrl;
    }
    
    /**
     * Returns the click through page URL
     *
     * @return string
     */
    public function getClickThroughPageUrl()
    {
        return $this->_clickThroughPageUrl;
    }
    
    /**
     * Returns the video runtime in seconds
     *
     * @return int
     */
    public function getRunTime()
    {
        return $this->_runTime;
    }
    
    /**
     * Returns the thumbnail URL
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }
    
    /**
     * Returns the thumbnail width
     *
     * @return int
     */
    public function getThumbnailWidth()
    {
        return $this->_thumbnailWidth;
    }
    
    /**
     * Returns the thumbnail height
     *
     * @return int
     */
    public function getThumbnailHeight()
    {
        return $this->_thumbnailHeight;
    }
    
    /**
     * Returns the thumbnail file size in bytes
     *
     * @return int
     */
    public function getThumbnailFileSize()
    {
        return $this->_thumbnailFileSize;
    }
    
    /**
     * Returns the thumbnail content type
     *
     * @return string
     */
    public function getThumbnailContentType()
    {
        return $this->_thumbnailContentType;
    }
}
