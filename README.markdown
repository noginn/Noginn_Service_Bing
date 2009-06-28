## Noginn_Service_Bing ##
Noginn_Service_Bing is a Zend Framework component that wraps the Bing search API (http://www.bing.com/developers).

## How to ##
### Simple usage ###

    $bing = new Noginn_Service_Bing('APPID');
    $result = $bing->search('query string', 
        array(
            'image' => array(
                'count' => 10
            ),
            'web' => array(
                'count' => 10
            ),
        ),
        array(
            'adult' => 'Strict'
        )
    );

### What kind of query is supported? ###
The Bing API has a number of available source types, most of which are supported in this component. Here is a full list:

* Image
* MobileWeb
* News
* RelatedSearch
* Spell
* Web
* Video
