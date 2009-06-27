<?php

/**
 * Bing API wrapper
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @author Tom Graham
 */
class Noginn_Service_Bing
{
    /**
     * The base URI of the API
     */
    const API_URI_BASE = 'http://api.bing.net/xml.aspx';
    
    /**
     * The API version number, used for the "Version" search request argument
     */
    const API_VERSION = '2.1';
    
    /**
     * Response XML namespaces
     */
    const API_NAMESPACE = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/element';
    const API_NAMESPACE_MULTIMEDIA = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/multimedia';
    const API_NAMESPACE_MOBILEWEB = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/mobileweb';
    const API_NAMESPACE_NEWS = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/news';
    const API_NAMESPACE_RELATEDSEARCH = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/relatedsearch';
    const API_NAMESPACE_SPELL = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/spell';
    const API_NAMESPACE_WEB = 'http://schemas.microsoft.com/LiveSearch/2008/04/XML/web';
    
    /**
     * The application ID
     *
     * @var string
     */
    protected $_appId;
    
    /**
     * The HTTP client used to make the API requests
     *
     * @var Zend_Http_Client
     */
    protected $_httpClient;
    
    /**
     * Constructor
     *
     * @param string $appId The application ID
     */
    public function __construct($appId)
    {
        $this->_appId = $appId;
    }
    
    /**
     * Queries the Bing search API
     *
     * @param string $query 
     * @param array $sources The requested sources
     * @param array $options Common options that affect all sources
     * @return Noginn_Service_Bing_ResultSet
     * @throws Zend_Service_Exception
     */
    public function search($query, array $sources, array $options = array())
    {
        $arguments = $this->_prepareCommonArguments($query, $options);
        
        $selectedSources = array();
        foreach ($sources as $source => $sourceOptions) {
            if (is_string($sourceOptions)) {
                // The sources passed as array of strings
                $source = $sourceOptions;
                $sourceOptions = array();
            }
            
            // Convert source to lowercase
            $source = strtolower($source);
            
            // Prepare the arguments for each of the sources
            switch ($source) {
                case 'ad':
                    throw new Zend_Service_Exception('Support for the "Ad" source not yet implemented');
                    // $arguments = array_merge($this->_prepareAdSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'image':
                    $arguments = array_merge($this->_prepareImageSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'instantanswer':
                    throw new Zend_Service_Exception('Support for the "InstantAnswer" source not yet implemented');
                    break;
                    
                case 'mobileweb':
                    $arguments = array_merge($this->_prepareMobileWebSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'news':
                    $arguments = array_merge($this->_prepareNewsSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'phonebook':
                    throw new Zend_Service_Exception('Support for the "Phonebook" source not yet implemented');
                    // $arguments = array_merge($this->_preparePhonebookSourceArguments($sourceOptions), $arguments);
                    break;
                
                case 'translation':
                    throw new Zend_Service_Exception('Support for the "Translation" source not yet implemented');
                    // $arguments = array_merge($this->_prepareTranslationSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'web':
                    $arguments = array_merge($this->_prepareWebSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'video':
                    $arguments = array_merge($this->_prepareVideoSourceArguments($sourceOptions), $arguments);
                    break;
                    
                case 'relatedsearch':
                case 'spell':
                    // Valid source but no additional arguments
                    break;
                    
                default:
                    throw new Zend_Service_Exception('The source "' . $source . '" is not valid.');
            }
            
            $selectedSources[] = $source;
        }
        
        if (count($selectedSources) == 0) {
            throw new Zend_Service_Exception('At least one search source must be provided');
        }
        
        // Set the sources argument from the selected sources
        $arguments['Sources'] = implode(' ', $selectedSources);
        
        $response = $this->_makeRequest($arguments);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        return new Noginn_Service_Bing_Result($dom, $selectedSources);
    }
    
    /**
     * Prepares the common arguments for the given query string and options.
     *
     * @param string $query 
     * @param array $options 
     * @return array Arguments the Bing API understands
     */
    protected function _prepareCommonArguments($query, array $options = array())
    {
        $arguments = array(
            'AppId' => $this->getAppId(),
            'Version' => self::API_VERSION,
            'Query' => $query,
        );
        
        if (isset($options['market'])) {
            $arguments['Market'] = $options['market'];
        }
        
        if (isset($options['adult'])) {
            $arguments['Adult'] = $options['adault'];
        }
        
        $searchOptions = array();
        if (isset($options['disableLocationDetection']) && $options['disableLocationDetection']) {
            $searchOptions[] = 'DisableLocationDetection';
        }
        
        if (isset($options['enableHighlighting']) && $options['enableHighlighting']) {
            $searchOptions[] = 'EnableHighlighting';
        }
        
        if (count($searchOptions) > 0) {
            $arguments['Options'] = implode('+', $searchOptions);
        }
        
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "Ad" source
     *
     * @param array $options 
     * @return array
     * @todo
     */
    protected function _prepareAdSourceArguments(array $options = array())
    {
        $arguments = array();
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "Image" source
     *
     * @param array $options 
     * @return array
     */
    protected function _prepareImageSourceArguments(array $options = array())
    {
        $arguments = array();
        
        if (isset($options['count'])) {
            $between = new Zend_Validate_Between(1, 50, true);
            if (!$between->isValid($options['count'])) {
                throw new Zend_Service_Exception($options['count'] . ' is not valid for the "count" option');
            }
            $arguments['Image.Count'] = (int) $options['count'];
        }
        
        if (isset($options['offset'])) {
            $between = new Zend_Validate_Between(0, 1000, true);
            if (!$between->isValid($options['offset'])) {
                throw new Zend_Service_Exception($options['offset'] . ' is not valid for the "offset" option');
            }
            $arguments['Image.Offset'] = (int) $options['offset'];
        }
        
        if (isset($options['adult'])) {
            $arguments['Image.Adult'] = $options['adult'];
        }
        
        if (isset($options['filters'])) {
            if (is_string($options['filters'])) {
                $options['filters'] = array($options['filters']);
            }
            
            if (!is_array($options['filters'])) {
                throw new Zend_Service_Exception('The "filters" option must be a string or array of strings');
            }
            
            $arguments['Image.Filters'] = implode(',', $options['filters']);
        }
        
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "MobileWeb" source
     *
     * @param array $options 
     * @return array
     */
    protected function _prepareMobileWebSourceArguments(array $options = array())
    {
        $arguments = array();
        
        if (isset($options['count'])) {
            $between = new Zend_Validate_Between(1, 50, true);
            if (!$between->isValid($options['count'])) {
                throw new Zend_Service_Exception($options['count'] . ' is not valid for the "count" option');
            }
            $arguments['MobileWeb.Count'] = (int) $options['count'];
        }
        
        if (isset($options['offset'])) {
            $between = new Zend_Validate_Between(0, 1000, true);
            if (!$between->isValid($options['offset'])) {
                throw new Zend_Service_Exception($options['offset'] . ' is not valid for the "offset" option');
            }
            $arguments['MobileWeb.Offset'] = (int) $options['offset'];
        }
        
        $sourceOptions = array();
        if (isset($options['disableHostCollapsing']) && $options['disableHostCollapsing']) {
            $sourceOptions[] = 'DisableHostCollapsing';
        }
        
        if (isset($options['disableQueryAlterations']) && $options['disableQueryAlterations']) {
            $sourceOptions[] = 'DisableQueryAlterations';
        }
        
        if (count($sourceOptions) > 0) {
            $arguments['MobileWeb.Options'] = implode('+', $sourceOptions);
        }
        
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "News" source
     *
     * @param array $options 
     * @return array
     */
    protected function _prepareNewsSourceArguments(array $options = array())
    {
        $arguments = array();
        
        if (isset($options['offset'])) {
            $between = new Zend_Validate_Between(0, 1000, true);
            if (!$between->isValid($options['offset'])) {
                throw new Zend_Service_Exception($options['offset'] . ' is not valid for the "offset" option');
            }
            $arguments['News.Offset'] = (int) $options['offset'];
        }
        
        if (isset($options['locationOverride'])) {
            $arguments['News.LocationOverride'] = (string) $options['locationOverride'];
        } else if (isset($options['category'])) {
            $arguments['News.Category'] = (string) $options['category'];
        } else if (isset($options['sortby'])) {
            $arguments['News.SortBy'] = (string) $options['sortby'];
        }
        
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "Phonebook" source
     *
     * @param array $options 
     * @return void
     * @todo
     */
    protected function _preparePhonebookSourceArguments(array $options = array())
    {
        $arguments = array();
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "Translation" source
     *
     * @param array $options 
     * @return array
     * @todo
     */
    protected function _prepareTranslationSourceArguments(array $options = array())
    {
        $arguments = array();
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "Web" source
     *
     * @param array $options 
     * @return array
     */
    protected function _prepareWebSourceArguments(array $options = array())
    {
        $arguments = array();
        
        if (isset($options['count'])) {
            $between = new Zend_Validate_Between(1, 50, true);
            if (!$between->isValid($options['count'])) {
                throw new Zend_Service_Exception($options['count'] . ' is not valid for the "count" option');
            }
            $arguments['Web.Count'] = (int) $options['count'];
        }
        
        if (isset($options['offset'])) {
            $between = new Zend_Validate_Between(0, 1000, true);
            if (!$between->isValid($options['offset'])) {
                throw new Zend_Service_Exception($options['offset'] . ' is not valid for the "offset" option');
            }
            $arguments['Web.Offset'] = (int) $options['offset'];
        }
        
        $sourceOptions = array();
        if (isset($options['disableHostCollapsing']) && $options['disableHostCollapsing']) {
            $sourceOptions[] = 'DisableHostCollapsing';
        }
        
        if (isset($options['disableQueryAlterations']) && $options['disableQueryAlterations']) {
            $sourceOptions[] = 'DisableQueryAlterations';
        }
        
        if (count($sourceOptions) > 0) {
            $arguments['Web.Options'] = implode('+', $sourceOptions);
        }
        
        return $arguments;
    }
    
    /**
     * Prepares the arguments for the "Video" source
     *
     * @param array $options 
     * @return array
     */
    protected function _prepareVideoSourceArguments(array $options = array())
    {
        $arguments = array();
        
        if (isset($options['count'])) {
            $between = new Zend_Validate_Between(1, 50, true);
            if (!$between->isValid($options['count'])) {
                throw new Zend_Service_Exception($options['count'] . ' is not valid for the "count" option');
            }
            $arguments['Video.Count'] = (int) $options['count'];
        }
        
        if (isset($options['offset'])) {
            $between = new Zend_Validate_Between(0, 1000, true);
            if (!$between->isValid($options['offset'])) {
                throw new Zend_Service_Exception($options['offset'] . ' is not valid for the "offset" option');
            }
            $arguments['Video.Offset'] = (int) $options['offset'];
        }
        
        if (isset($options['adult'])) {
            $arguments['Video.Adult'] = $options['adult'];
        }
        
        if (isset($options['filters'])) {
            if (is_string($options['filters'])) {
                $options['filters'] = array($options['filters']);
            }
            
            if (!is_array($options['filters'])) {
                throw new Zend_Service_Exception('The "filters" option must be a string or array of strings');
            }
            
            $arguments['Video.Filters'] = implode(',', $options['filters']);
        }
        
        if (isset($options['sortby'])) {
            $arguments['Video.SortBy'] = $options['sortby'];
        }
        
        return $arguments;
    }
    
    /**
     * Makes a request
     *
     * @param string $path 
     * @param array $parameters 
     * @return Zend_Http_Response_Abstract
     * @throws Zend_Service_Exception
     */
    protected function _makeRequest(array $parameters = array())
    {
        $httpClient = $this->getHttpClient();
        $httpClient->resetParameters();
        $httpClient->setParameterGet($parameters);
        $response = $httpClient->request('GET');
        
        if ($response->isError()) {
            throw new Zend_Service_Exception(sprintf(
                'Invalid response status code (HTTP/%s %s %s)',
                $response->getVersion(), $response->getStatus(), $response->getMessage()
            ));
        }
        
        return $response;
    }
    
    /**
     * Converts the response to a DOM object and checks it for errors.
     *
     * @param Zend_Http_Response $response 
     * @return DOMDocument
     */
    protected function _convertResponseAndCheckContent(Zend_Http_Response $response)
    {
        $dom = new DOMDocument();
        $dom->loadXML($response->getBody());
        $this->_checkErrors($dom);
        
        return $dom;
    }
    
    /**
     * Checks the response for errors
     *
     * @param DOMDocument $dom 
     * @return void
     */
    protected function _checkErrors(DOMDocument $dom)
    {
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('element', Noginn_Service_Bing::API_NAMESPACE);
        
        $errors = $xpath->query('//element:Error');
        if ($errors->length > 0) {
            $errorMessages = array();
            foreach ($errors as $error) {
                $code = (string) $xpath->query('./element:Code/text()', $error)->item(0)->data;
                $errorMessages[] = '#' . $code;
            }
            
            throw new Zend_Service_Exception('Search failed due to error(s): ' . implode(', ', $errorMessages));
        }
    }
    
    /**
     * Sets the application ID
     *
     * @param string $appId 
     * @return Noginn_Service_Bing
     */
    public function setAppId($appId)
    {
        $this->_appId = $appId;
        return $this;
    }
    
    /**
     * Returns the application ID
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->_appId;
    }
    
    /**
     * Returns the REST client used to perform API requests.
     *
     * @return Zend_Rest_Client
     */
    public function getHttpClient()
    {
        if ($this->_httpClient === null) {
            $this->_httpClient = new Zend_Http_Client(self::API_URI_BASE);
        }

        return $this->_httpClient;
    }
}