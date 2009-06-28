<?php

class SearchController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $query = trim($this->getRequest()->getQuery('q', ''));
        $this->view->query = $query;
        if (!empty($query)) {
            $count = 10;
            $page = (int) $this->getRequest()->getQuery('p', 1);
            if ($page < 1) {
                $page = 1;
            }
            
            // Prepare the common options
            $options = array(
                'market' => 'en-GB',
            );
            
            // We want web and image search results
            $sources = array(
                'web' => array(
                    'count' => $count,
                    'offset' => $count * ($page - 1)
                )
            );
            
            // Adjust the query to only search the noginn.com domain
            //$query .= ' site:noginn.com';
            
            // Perform the search!
            $bing = new Noginn_Service_Bing('C1851383F294308AC87D74720514432296CBE4C7');
            $result = $bing->search($query, $sources, $options);
            
            $webResults = $result->getSource('web');
            $this->view->webResults = $webResults;
            
            // Paginate the results
            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Null($webResults->getTotal()));
            $paginator->setCurrentPageNumber($page);
            $paginator->setItemCountPerPage($count);
            $this->view->paginator = $paginator;
        }
    }
}
