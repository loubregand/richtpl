<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

abstract class AbstractContextCloserCommandTokens extends AbstractCommandTokens
{
	public function exec(AbstractContextOpenerCommandTokens $openerToken)
	{
		$openerType = $openerToken->getType();
		
		if( substr($this->_type, 3) !== $openerType )
		{
			throw new \Exception( "Opener and Closer type do not match (Opener: $openerType Closer: $this->_type)." );
		}
		
		if( $v = $this->_matches['var'] )
		{
			$openerVar = $openerToken->getMatches()['var'];
			
			if( $openerVar !== $v )
			{
				throw new \Exception( "Opener and Closer variables do not match (Opener: $openerVar Closer: $v)." );
			}
		}
		
		$openerToken->close();
	}
}
