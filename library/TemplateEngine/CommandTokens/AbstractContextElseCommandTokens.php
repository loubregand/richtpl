<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class AbstractContextElseCommandTokens extends AbstractCommandTokens
{
	public function exec(AbstractContextOpenerCommandTokens $openerToken)
	{
		if( $v = $this->_matches['var'] )
		{
			$openerVar = $openerToken->getMatches()['var'];
			
			if( $openerVar !== $v )
			{
				throw new \Exception( "Opener and Else variables do not match (Opener: $openerVar Else: $v)." );
			}
		}
	}
}