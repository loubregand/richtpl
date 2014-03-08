<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class CommentOpen extends AbstractContextOpenerCommandTokens
{
	protected $_needClosingTag = false;
	
	public function exec()
	{
	}
	
	public function _checkToken($token)
	{
		if( $token instanceof CommentClose )
		{
			$this->close();
		}
		
		return true;
	}
}