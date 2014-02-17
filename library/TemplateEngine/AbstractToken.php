<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine;

abstract class AbstractToken
{
	protected $_token;
	
	public function __construct($par)
	{
		$this->_token = $par;
	}
	
	public function getToken()
	{
		return $this->_token;
	}
}
