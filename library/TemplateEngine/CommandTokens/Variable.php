<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class Variable extends AbstractCommandTokens
{
	public function exec(\TemplateEngine\Context $context)
	{
		return $context->getBind($this->_matches['var']);
	}
}