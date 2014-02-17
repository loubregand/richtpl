<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

abstract class AbstractCommandTokens extends \TemplateEngine\AbstractToken
{
	protected $_type;
	protected $_matches;
	
	public function __construct($token, $type, $matches)
	{
		parent::__construct($token);
		
		$this->_type    = $type;
		$this->_matches = $matches;
	}
	
	public function getMatches()
	{
		return $this->_matches;
	}
	
	public function getType()
	{
		return $this->_type;
	}
}
