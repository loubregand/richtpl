<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace Utils;

class TemplateIterator
{
	protected $_data;
	protected $_keys;
	protected $_index = -1;
	protected $_count;
	
	public function __construct(array $data)
	{
		$this->_data = array_values($data);
		$this->_keys = array_keys($data);
		$this->_count = count($data);
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
	
	public function next()
	{
		++$this->_index;
		
		return $this;
	}
	
	public function validOrNew()
	{
		if( $this->_index >= $this->_count )
		{
			return false;
		}
		
		return true;
	}
	
	public function valid()
	{
		if( $this->_index >= $this->_count || $this->_index < 0 )
		{
			return false;
		}
		
		return true;
	}
	
	public function reset()
	{
		$this->_index = 0;
		
		return $this;
	}
	
	public function nextOrReset()
	{
		++$this->_index;
		
		if( $this->_index >= $this->_count )
		{
			$this->_index = 0;
		}
		
		return $this;
	}
	
	public function __toString()
	{
		return "";
	}
}
