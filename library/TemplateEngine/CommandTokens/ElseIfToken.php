<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class ElseIfToken extends AbstractCommandTokens
{
	public function exec(AbstractContextOpenerCommandTokens $openerToken)
	{
		$openerType = $openerToken->getType();
		
		if( 'IfToken' !== $openerType )
		{
			throw new \Exception( "Opener and Closer type do not match (Opener: $openerType Atteso: IfToken)." );
		}
		
		return $this->_matches['var'];
	}
}