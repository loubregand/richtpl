<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class ForLoop extends AbstractContextOpenerCommandTokens
{
	public function exec()
	{
		$render = "";
		
		$varName = $this->_matches['var'];
		$varToLoop = $this->_context->getBind($varName);
		
		if( 
			(
				! is_array( $varToLoop ) 
			||
				! $varToLoop
			)
		&&
			! $varToLoop instanceof \Traversable
		)
		{
			if( $this->_elseContext )
			{
				$render = $this->_elseContext->render();
			}
		}
		else
		{
			foreach( $varToLoop as $k => $v )
			{
				if( $this->_matches['as2'] )
				{
					$kName = $this->_matches['as1'];
					$vName = $this->_matches['as2'];
					
					$bindings = [
						$kName => $k,
						$vName => $v,
					];
				}
				else
				{
					$vName = $this->_matches['as1'];
					
					$bindings = [
						$vName => $v,
					];
				}
				
				$this->_context->setBindings( $bindings );
	
				$render .= $this->_context->render();
			}
		}
		
		return $render;
	}
}