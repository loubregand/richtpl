<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class GlobalToken extends AbstractContextOpenerCommandTokens
{
	protected $_needClosingTag = false;
	
	public function __construct()
	{
	}
}