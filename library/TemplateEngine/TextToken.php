<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine;

class TextToken extends AbstractToken
{
	public function exec($par)
	{
		return $this->_token;
	}
}
