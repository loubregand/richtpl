<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine;

class TokensStack
{
	protected $_stack;
	
	public function __construct(array $par)
	{
		$this->_stack = $par;
	}
	
	public function hasTokens()
	{
		return (bool)count($this->_stack);
	}
	
	public function getToken()
	{
		return reset($this->_stack);
	}
	
	public function shiftToken()
	{
		return array_shift($this->_stack);
	}
	
	public function getTokens()
	{
		return $this->_stack;
	}
}
