<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace Utils;

class ManualIterator implements \Iterator, \Countable
{
	protected $_data;
	protected $_keys;
	protected $_index = -1;
	protected $_count;
	protected $_checkValid = 0;
	protected $_lastCheckIndex;
	
	public function __construct(array $data)
	{
		$this->_data = array_values($data);
		$this->_keys = array_keys($data);
		$this->_count = count($data);
	}
	
	public function current()
	{
		return $this;
	}
	
	public function value()
	{
		return $this->_data[$this->_index];
	}
	
	public function key()
	{
		return $this->_keys[$this->_index];
	}
	
	public function index()
	{
		return $this->_index;
	}
	
	/**
	* This method must be kept empty in order to be ignored when implicitly called from foreach at loop start
	*/
	public function next()
	{
	}
	
	public function isFirst()
	{
		if( $this->_index === 0 )
		{
			return true;
		}
		
		return false;
	}
	
	public function isLast()
	{
		if( $this->_index === ($this->_count - 1) )
		{
			return true;
		}
		
		return false;
	}
	
	/**
	* next re-implemented for manual advance
	*/
	public function fwd()
	{
		++$this->_index;
		$this->_checkValid = 0;
		
		return $this;
	}
	
	public function rewind()
	{
		$this->_index = -1;
		$this->_checkValid = 0;
		
		return $this;
	}
	
	public function valid()
	{
		if (
			null !== $this->_lastCheckIndex
		&&
			$this->_index === $this->_lastCheckIndex
		&&
			$this->_checkValid++ > 0
		)
		{
			throw new \Exception( "No advance since last check." );
		}
		
		$this->_lastCheckIndex = $this->_index;
		
		if( ! $this->_count || $this->_index >= ($this->_count-1) )
		{
			return false;
		}
		
		return true;
	}
	
	public function reset()
	{
		$this->_index = 0;
		$this->_checkValid = 0;
		
		return $this;
	}
	
	public function cycle()
	{
		return $this->nextOrReset();
	}
	
	public function nextOrReset()
	{
		++$this->_index;
		$this->_checkValid = 0;
		
		if( $this->_index >= $this->_count )
		{
			$this->_index = 0;
		}
		
		return $this;
	}
	
	public function count()
	{
		return $this->_count;
	}
	
	public function __toString()
	{
		return "";
	}
}
