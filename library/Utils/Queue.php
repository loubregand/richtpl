<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace Utils;

class Queue
{
	protected $_data;
	
	public function __construct(array $par)
	{
		$this->_data = $par;
	}
	
	public function next()
	{
		if( ! $this->count() )
		{
			throw new \Exception( "There are no elements in the queue." );
		}
		
		return array_values($this->_data)[0];
	}
	
	public function shift()
	{
		if( ! $this->count() )
		{
			throw new \Exception( "There are no elements in the queue." );
		}
		
		return array_shift($this->_data);
	}
	
	public function count()
	{
		return count($this->_data);
	}
}