<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

abstract class AbstractContextOpenerCommandTokens extends AbstractCommandTokens
{
	protected $_needClosingTag = true;
	protected $_closed = false;
	protected $_elseContext;
	
	public function prepare(
		\TemplateEngine\TokensStack $stack,
		\TemplateEngine\Context $parentContext
	)
	{
		/**
		* Creiamo il context, lo popoliamo con i token di sua pertinenza
		*/
		
		$this->_context = $context = new \TemplateEngine\Context();
		$context->setParent($parentContext);
		
		$tokens = [];
		
		while( $stack->hasTokens() )
		{
			$token = $stack->shiftToken();
			
			// Implemented to enable elseif tokens
			if( ( $_tmpContext = $this->_checkToken( $token ) ) instanceof \TemplateEngine\Context )
			{
				$context = $_tmpContext;
				$context->setParent($parentContext);
			}
			// Implemented to enable range comments
			elseif( $_tmpContext );
			elseif( $token instanceof AbstractContextOpenerCommandTokens )
			{
				$token->prepare($stack, $context);
				$context->addToken($token);
			}
			elseif( $token instanceof AbstractContextCloserCommandTokens )
			{
				$token->exec($this);
			}
			elseif( $token instanceof AbstractContextElseCommandTokens )
			{
				$token->exec($this);
				$this->_elseContext = $context = new \TemplateEngine\Context();
				$context->setParent($parentContext);
			}
			else
			{
				$context->addToken($token);
			}
			
			if( $this->_closed )
			{
				break;
			}
		}
		
		if( ! $this->_closed && $this->_needClosingTag )
		{
			throw new \Exception( "Closing tag was not found before end of tokens for token: `$this->_token`." );
		}
		
		return $this;
	}
	
	public function _checkToken($token)
	{
		return false;
	}
	
	public function close()
	{
		$this->_closed = true;
	}
	
	public function exec()
	{
		return $this->_context->render();
	}
}
