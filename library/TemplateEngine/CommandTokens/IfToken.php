<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class IfToken extends AbstractContextOpenerCommandTokens
{
	protected $_elseIfContext = [];
	
	public function exec()
	{
		$render = "";
		
		$varName = $this->_matches['var'];
		$context = $this->_context;
		
		if( $this->_checker( $context->getBind($varName) ) )
		{
			$render = $context->render();
			
			goto end;
		}
		elseif( $this->_elseIfContext )
		{
			foreach( $this->_elseIfContext as $varName => $context )
			{
				if( $this->_checker( $context->getBind($varName) ) )
				{
					$render = $context->render();
					
					goto end;
				}
			}
		}
		
		if( $this->_elseContext )
		{
			$render = $this->_elseContext->render();
		}
		
		end:
		
		return $render;
	}
	
	protected function _checker($v)
	{
		if(
			null === $v
		||
			false === $v
		||
			(is_array($v) && ! $v)
		)
		{
			return false;
		}
		
		return true;
	}
	
	public function _checkToken($token)
	{
		if( $token instanceof ElseIfToken )
		{
			$this->_elseIfContext[$token->exec($this)] = $context = new \TemplateEngine\Context();
			
			return $context;
		}
	}
}