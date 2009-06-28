<?php

/**
 * Represents a search result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_Result
{
    /**
     * The altered search term, if Bing altered it.
     *
     * @var string
     */
    protected $_alteredQuery;
    
    /**
     * The query string to use to override the alternation
     *
     * @var string
     */
    protected $_alterationOverrideQuery;
    
    /**
     * Each of the source result sets
     *
     * @var array
     */
    protected $_sources = array();
    
    /**
     * Constructor
     *
     * @param DOMDocument $dom 
     * @param array $sources 
     */
    public function __construct(DOMDocument $dom, array $sources)
    {
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('mms', Noginn_Service_Bing::API_NAMESPACE_MULTIMEDIA);
        $xpath->registerNamespace('mw', Noginn_Service_Bing::API_NAMESPACE_MOBILEWEB);
        $xpath->registerNamespace('news', Noginn_Service_Bing::API_NAMESPACE_NEWS);
        $xpath->registerNamespace('rs', Noginn_Service_Bing::API_NAMESPACE_RELATEDSEARCH);
        $xpath->registerNamespace('spl', Noginn_Service_Bing::API_NAMESPACE_SPELL);
        $xpath->registerNamespace('web', Noginn_Service_Bing::API_NAMESPACE_WEB);
        
        // Did Bing automatically alter the query?
        $alteredQuery = $xpath->query('//Query/AlteredQuery/text()');
        if ($alteredQuery->length == 1) {
            $this->_alteredQuery = (string) $alteredQuery->item(0)->data;
        }
        
        $alterationOverrideQuery = $xpath->query('//Query/AlterationOverrideQuery/text()');
        if ($alterationOverrideQuery->length == 1) {
            $this->_alterationOverrideQuery = (string) $alterationOverrideQuery->item(0)->data;
        }
        
        // Process sources that were requested
        if (in_array('image', $sources)) {
            $this->_sources['image'] = new Noginn_Service_Bing_ImageResultSet();
            $image = $xpath->query('//mms:Image');
            if ($image->length == 1) {
                $this->_sources['image']->init($image->item(0));
            }
        }
        
        if (in_array('mobileweb', $sources)) {
            $this->_sources['mobileweb'] = new Noginn_Service_Bing_MobileWebResultSet();
            $mobileWeb = $xpath->query('//mw:MobileWeb');
            if ($mobileWeb->length == 1) {
                $this->_sources['mobileweb']->init($mobileWeb->item(0));
            }
        }
        
        if (in_array('news', $sources)) {
            $this->_sources['news'] = new Noginn_Service_Bing_NewsResultSet();
            $news = $xpath->query('//news:News');
            if ($news->length == 1) {
                $this->_sources['news']->init($news->item(0));
            }
        }
        
        if (in_array('relatedsearch', $sources)) {
            $this->_sources['relatedsearch'] = new Noginn_Service_Bing_RelatedSearchResultSet();
            $relatedSearch = $xpath->query('//rs:RelatedSearch');
            if ($relatedSearch->length == 1) {
                $this->_sources['relatedsearch']->init($relatedSearch->item(0));
            }
        }
        
        if (in_array('spell', $sources)) {
            $this->_sources['spell'] = new Noginn_Service_Bing_SpellResultSet();
            $spell = $xpath->query('//spl:Spell');
            if ($spell->length == 1) {
                $this->_sources['spell']->init($spell->item(0));
            }
        }
        
        if (in_array('web', $sources)) {
            $this->_sources['web'] = new Noginn_Service_Bing_WebResultSet();
            $web = $xpath->query('//web:Web');
            if ($web->length == 1) {
                $this->_sources['web']->init($web->item(0));
            }
        }
        
        if (in_array('video', $sources)) {
            $this->_sources['video'] = new Noginn_Service_Bing_VideoResultSet();
            $video = $xpath->query('//mms:Video');
            if ($video->length == 1) {
                $this->_sources['video']->init($video->item(0));
            }
        }
    }
    
    /**
     * Returns the altered search term
     *
     * @return void
     * @author Tom Graham
     */
    public function getAlteredQuery()
    {
        return $this->_alteredQuery;
    }
    
    /**
     * Whether the search term was automatically altered by the Bing API
     *
     * @return void
     * @author Tom Graham
     */
    public function isQueryAltered()
    {
        return $this->_alteredQuery !== null;
    }
    
    /**
     * Returns the alteration override query
     *
     * @return void
     * @author Tom Graham
     */
    public function getAlterationOverrideQuery()
    {
        return $this->_alterationOverrideQuery;
    }
    
    /**
     * Returns all of the sources
     *
     * @return array
     */
    public function getSources()
    {
        return $this->_sources;
    }
    
    /**
     * Whether the given source is with in the result set
     *
     * @param string $name 
     * @return bool
     */
    public function hasSource($name)
    {
        return isset($this->_sources[strtolower($name)]);
    }
    
    /**
     * Returns the given source result set
     *
     * @param string $name 
     * @return Noginn_Service_Bing_SourceResultSet
     */
    public function getSource($name)
    {
        $name = strtolower($name);
        if (isset($this->_sources[$name])) {
            return $this->_sources[$name];
        }
        
        return false;
    }
}
