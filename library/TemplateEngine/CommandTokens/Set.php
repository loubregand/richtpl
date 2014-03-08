<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class Set extends AbstractCommandTokens
{
	public function exec(\TemplateEngine\Context $context)
	{
		$context->setBind($this->_matches['as'], $context->getBind($this->_matches['var']));
	}
}