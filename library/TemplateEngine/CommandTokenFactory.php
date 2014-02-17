<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine;

class CommandTokenFactory
{
	protected $_tokenTypes;
	
	protected function _initTokenTypes()
	{
		$types = [];
		$expressions = [];
		$expressions['variable'] = '\w+(?:[.|]\w+)*';
		
		$types['ForLoop'] = 'for  (?<var>%variable%)(?:  as  (?<as1>\w+) ( , (?<as2>\w+))?)?';
		$types['EndForLoop'] = 'endfor(?:  (?<var>%variable%))?';
		
		$types['IfToken'] = 'if  (?<var>%variable%)';
		$types['ElseIfToken'] = 'elseif  (?<var>%variable%)';
		$types['EndIfToken'] = 'endif(?:  (?<var>%variable%))?';
	
		$types['ElseToken'] = 'else(?:  (?<var>%variable%))?';
		
		$types['Variable'] = '= (?<var>%variable%)';
		
		foreach( $types as &$t )
		{
			$t = preg_replace( '/  /', '\s+', $t);
			$t = preg_replace( '/ /', '\s*', $t);
			
			$t = preg_replace_callback( '/%(\w+)%/', function ($v) use ($expressions)
			{
				if( ! isset($expressions[$v[1]]) )
				{
					throw new \Exception( "Expression `$v[1]` is not defined." );
				}
				
				return $expressions[$v[1]];
			}, $t);
		}
		
		$this->_tokenTypes = $types;
	}
	
	public function __construct()
	{
		if( ! $this->_tokenTypes )
		{
			$this->_initTokenTypes();
		}
	}
	
	public function factory($token)
	{
		$k = 0;
		
		foreach( $this->_tokenTypes as $type => $expr )
		{
			if( preg_match( "/^\s*$expr\s*$/", $token, $matches ) )
			{
				$ok = 1;
				foreach( $matches as $k => $v )
				{
					if( is_int( $k ) )
					{
						unset($matches[$k]);
					}
				}
				
				break;
			}
		}
		
		if( ! $ok )
		{
			throw new \Exception( "No type was matched for Command Token `$token`." );
		}

		$class = __namespace__ . '\CommandTokens\\' . $type;
		
		return new $class($token, $type, $matches);
	}
}
