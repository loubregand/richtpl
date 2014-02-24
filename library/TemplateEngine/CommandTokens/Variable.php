<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class Variable extends AbstractCommandTokens
{
	public function exec(\TemplateEngine\Context $context)
	{
		$ret = $context->getBind($this->_matches['var']);
		
		if( $ret instanceof \TemplateEngine\Engine )
		{
			$ret = $ret->render($context)->getRender();
		}
		
		return $ret;
	}
}