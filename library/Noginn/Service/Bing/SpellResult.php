<?php

/**
 * Spelling source result
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_Bing_SpellResult
{
    /**
     * The corrected spelling
     *
     * @var string
     */
    protected $_value;
    
    /**
     * Constructor.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('spl', Noginn_Service_Bing::API_NAMESPACE_SPELL);
        
        $value = $xpath->query('./spl:Value/text()', $dom);
        if ($value->length == 1) {
            $this->_value = (string) $value->item(0)->data;
        }
    }
    
    /**
     * Returns the corrected spelling
     *
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }
}
