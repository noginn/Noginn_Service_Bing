<?php

/**
 * Image source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_ImageResult
{
    /**
     * The title of the image
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The URL of the image
     *
     * @var string
     */
    protected $_mediaUrl;
    
    /**
     * The URL of the page containing the image
     *
     * @var string
     */
    protected $_url;
    
    /**
     * undocumented variable
     *
     * @var string
     */
    protected $_displayUrl;
    
    /**
     * The width of the image
     *
     * @var int
     */
    protected $_width;
    
    /**
     * The height of the image
     *
     * @var int
     */
    protected $_height;
    
    /**
     * The size of the image in bytes
     *
     * @var int
     */
    protected $_fileSize;
    
    /**
     * The content type of the image
     *
     * @var string
     */
    protected $_contentType;
    
    /**
     * The URL of the Bing generated thumbnail preview
     *
     * @var string
     */
    protected $_thumbnailUrl;
    
    /**
     * The width of the thumbnail
     *
     * @var int
     */
    protected $_thumbnailWidth;
    
    /**
     * The height of the thumbnail
     *
     * @var int
     */
    protected $_thumbnailHeight;
    
    /**
     * The size of the thumbnail in bytes
     *
     * @var int
     */
    protected $_thumbnailFileSize;
    
    /**
     * The content type of the thumbnail
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
        
        $mediaUrl = $xpath->query('./mms:MediaUrl/text()', $dom);
        if ($mediaUrl->length == 1) {
            $this->_mediaUrl = (string) $mediaUrl->item(0)->data;
        }
        
        $url = $xpath->query('./mms:Url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
        
        $displayUrl = $xpath->query('./mms:DisplayUrl/text()', $dom);
        if ($displayUrl->length == 1) {
            $this->_displayUrl = (string) $displayUrl->item(0)->data;
        }
        
        $width = $xpath->query('./mms:Width/text()', $dom);
        if ($width->length == 1) {
            $this->_width = (int) $width->item(0)->data;
        }
        
        $height = $xpath->query('./mms:Height/text()', $dom);
        if ($height->length == 1) {
            $this->_height = (int) $height->item(0)->data;
        }
        
        $fileSize = $xpath->query('./mms:FileSize/text()', $dom);
        if ($fileSize->length == 1) {
            $this->_fileSize = (int) $fileSize->item(0)->data;
        }
        
        $contentType = $xpath->query('./mms:ContentType/text()', $dom);
        if ($contentType->length == 1) {
            $this->_contentType = (string) $contentType->item(0)->data;
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
     * Returns the image title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Returns the media URL
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->_mediaUrl;
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
     * Returns the image width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->_width;
    }
    
    /**
     * Returns the image height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->_height;
    }
    
    /**
     * Returns the image size in bytes
     *
     * @return int
     */
    public function getFileSize()
    {
        return $this->_fileSize;
    }
    
    /**
     * Returns the content type of the image
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->_contentType;
    }
    
    /**
     * Returns the URL of the thumbnail
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }
    
    /**
     * Returns the width of the thumbnail
     *
     * @return int
     */
    public function getThumbnailWidth()
    {
        return $this->_thumbnailWidth;
    }
    
    /**
     * Returns the height of the thumbnail
     *
     * @return int
     */
    public function getThumbnailHeight()
    {
        return $this->_thumbnailHeight;
    }
    
    /**
     * Returns the size of the thumbnail in bytes
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
