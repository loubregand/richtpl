<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class WhileLoop extends AbstractContextOpenerCommandTokens
{
	public function exec(\TemplateEngine\Context $context)
	{
		$render = "";
		
		$varName = $this->_matches['var'];
		
		$val = $this->_context->getBind($varName);
		
		if( $this->_checker( $val ) )
		{
			do
			{
				if( $this->_matches['as1'] )
				{
					$vName = $this->_matches['as1'];
					
					$this->_context->setBindings([
						$vName => $val,
					]);
				}
	
				$render .= $this->_context->render();
			}
			while( $this->_checker( $val = $this->_context->getBind($varName) ) );
		}
		else
		{
			if( $this->_elseContext )
			{
				$render = $this->_elseContext->render();
			}
		}
		
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
}