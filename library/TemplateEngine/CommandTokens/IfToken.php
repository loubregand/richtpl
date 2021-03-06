<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class IfToken extends AbstractContextOpenerCommandTokens
{
	protected $_elseIfContext = [];
	
	public function exec(\TemplateEngine\Context $parentContext)
	{
		$render = "";
		
		$varName = $this->_matches['var'];
		
		$bool = $this->_checker( $v = $parentContext->getBind($varName) );
		
		if( $this->_matches['not'] )
		{
			$bool = ! $bool;
		}
		
		if( $bool )
		{
			$bindings = array();
			
			if( isset( $this->_matches['as1'] ) )
			{
				$vName = $this->_matches['as1'];
				
				$bindings[$vName] = $v;
			}
			
			$render = $this->_context->render($bindings);
			
			goto end;
		}
		elseif( $this->_elseIfContext )
		{
			/**
			* @TODO registrare gli as1 dei vari elseif se presenti
			*/
			foreach( $this->_elseIfContext as $varName => $par )
			{
				$elseIfContext = $par['context'];
				$vName = $par['as1'];
				
				$bool = $this->_checker( $v = $parentContext->getBind($varName) );
				
				if( $par['not'] )
				{
					$bool = ! $bool;
				}
				
				if( $bool )
				{
					$bindings = array();
					
					if( null !== $vName )
					{
						$bindings[$vName] = $v;
					}
					
					$render = $elseIfContext->render($bindings);
					
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
			$this->_elseIfContext[$token->exec($this)] = [
				'context' => $context = new \TemplateEngine\Context(),
				'as1'     => $token->getMatches()['as1'],
				'not'     => $token->getMatches()['not'],
			];
			
			return $context;
		}
	}
}