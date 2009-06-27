<?php

/**
 * An abstract result set
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage Bing
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
abstract class Noginn_Service_Bing_ResultSet implements SeekableIterator, Countable
{
    /**
     * The results
     *
     * @var string
     */
    protected $_results;
    
    /**
     * The iterator index
     *
     * @var string
     */
    protected $_currentIndex = 0;
    
    /**
     * Implements Countable::count()
     *
     * @return int
     */
    public function count()
    {
        return $this->_results->length;
    }
    
    /**
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     * @abstract
     */
    public function current()
    {
        throw new Zend_Service_Exception('The current() method must be overridden');
    }

    /**
     * Implements SeekableIterator::key().
     *
     * @return  int
     */
    public function key()
    {
        return $this->_currentIndex;
    }

    /**
     * Implements SeekableIterator::next().
     *
     * @return  void
     */
    public function next()
    {
        $this->_currentIndex += 1;
    }

    /**
     * Implements SeekableIterator::rewind().
     *
     * @return  bool
     */
    public function rewind()
    {
        $this->_currentIndex = 0;
        return true;
    }

    /**
     * Implement SeekableIterator::seek().
     *
     * @param   int $index
     * @return  void
     * @throws  OutOfBoundsException
     */
    public function seek($index)
    {
        $index = (int) $index;
        if ($index >= 0 && $index < $this->_results->length) {
            $this->_currentIndex = $index;
        } else {
            throw new OutOfBoundsException("Illegal index '$index'");
        }
    }

    /**
     * Implement SeekableIterator::valid().
     *
     * @return boolean
     */
    public function valid()
    {
        return null !== $this->_results && $this->_currentIndex < $this->_results->length;
    }
}