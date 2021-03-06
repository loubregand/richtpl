<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine;

class Context
{
	protected $_parent;
	protected $_tokens;
	protected $_bindings = [];
	
	public function addToken(AbstractToken $token)
	{
		$this->_tokens[] = $token;
	}
	
	public function setParent(Context $par)
	{
		$this->_parent = $par;
		
		return $this;
	}
	
	public function setBindings(array $par)
	{
		$this->_bindings = $par;
		
		return $this;
	}
	
	public function setBind($k, $v)
	{
		$this->_bindings[$k] = $v;
		
		return $this;
	}
	
	public function render(array $bindings = array())
	{
		$this->setBindings( $bindings );
		
		$render = '';
		
		foreach( $this->_tokens as $token )
		{
			$render .= $token->exec($this);
		}
		
		return $render;
	}
	
	public function getBind($k)
	{
		$askedFor = $k;
		
		if( preg_match( '/^\d+$/', $k ) )
		{
			return (int)$k;
		}
		
		$pipes = explode('|', $k);
		
		$val = $this->getBindVar(array_shift($pipes));
		foreach( $pipes as $pipe )
		{
			if( is_callable( $callable = $this->getBindVar( $pipe ) ) )
			{
				$val = call_user_func($callable, $val);
			}
			else
			{
				throw new \Exception( "Pipe variable `$pipe` is not callable (Asked: $k)." );
			}
		}
		
		return $val;
	}
	
	public function getBindVar($k)
	{
		$askedFor = $k;
		
		$ak = explode('.', $k);
		$k = array_shift( $ak );
		
		if( preg_match( '/^[0-9]+$/', $k ) )
		{
			$k = (int)$k;
		}
		
		if( array_key_exists( $k, $this->_bindings ) )
		{
			$return = $this->_bindings[$k];
		}
		elseif( null !== $this->_parent )
		{
			$return = $this->_parent->getParentBind($k);
		}
		else
		{
			throw new \Exception( "Binding `$k` was not defined." );
		}
		
		while( count( $ak ) )
		{
			$k = array_shift($ak);
			
			if( preg_match( '/^[0-9]+$/', $k ) )
			{
				$k = (int)$k;
			}
			
			if( is_array( $return ) || $return instanceof \ArrayAccess )
			{
				$return = $return[$k];
			}
			elseif( is_object( $return ) && isset( $return->$k ) )
			{
				$return = $return->$k;
			}
			elseif( is_object( $return ) && method_exists( $return, $k ) )
			{
				$return = $return->$k();
			}
			else
			{
				// throw new \Exception( "Cannot find element $k (Asked for: `$askedFor`)." );
				
				return null;
			}
		}
		
		return $return;
	}
	
	public function getParentBind($k)
	{
		if( array_key_exists( $k, $this->_bindings ) )
		{
			return $this->_bindings[$k];
		}
		elseif( null !== $this->_parent )
		{
			return $this->_parent->getParentBind($k);
		}
		else
		{
			// throw new \Exception( "Binding `$k` was not defined." );
			
			return null;
		}
	}
}	
