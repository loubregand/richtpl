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
		
		/**
		* @TODO usare un generatore per grandi numeri
		*/
		if( is_int( $varToLoop ) )
		{
			$varToLoop = range(1, $varToLoop);
		}
		
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
			$n = 0;
			foreach( $varToLoop as $k => $v )
			{
				++$n;
				$bindings = [];
				
				if( isset( $this->_matches['as2'] ) )
				{
					$kName = $this->_matches['as1'];
					$vName = $this->_matches['as2'];
					
					$bindings = [
						$kName => $k,
						$vName => $v,
					];
				}
				elseif( isset( $this->_matches['as1'] ) )
				{
					$vName = $this->_matches['as1'];
					
					$bindings = [
						$vName => $v,
					];
				}
				else
				{
					goto render;
				}
				
				$this->_context->setBindings( $bindings );
	
				render:
				
				$render .= $this->_context->render();
			}
			
			if( ! $n && $this->_elseContext )
			{
				$render = $this->_elseContext->render();
			}
		}
		
		return $render;
	}
}