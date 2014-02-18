<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine;

class Engine
{
	protected $_bindings = [];
	protected $_template;
	protected $_tokens;
	protected $_render;
	
	protected $_commandTokenFactory;
	
	public function __construct()
	{
		$this->_commandTokenFactory = new CommandTokenFactory();
	}
	
	public function setTemplate($par)
	{
		$this->_template = $par;
		
		return $this;
	}
	
	public function bind($par, $v = null)
	{
		if( ! is_array( $par ) )
		{
			$par = [$par => $v];
		}
		
		foreach( $par as $k => $v )
		{
			$this->_bindings[$k] = $v;
		}
		
		return $this;
	}
	
	public function parseTemplate()
	{
		$tokens = preg_split(
			# Aggiungiamo la rimozione delle righe per i commenti
			'/(?|(?:\t*\{([\w#][^}\n]+?)\}\n)|(?:\{([^}\n]+?)\}))/',
			# se un tag non sta su una linea solo non lo consideriamo
			// '/(?|(?:\t*\{(\w[^}\n]+?)\}\n)|(?:\{([^}\n]+?)\}))/',
			# con eliminazione degli a capo e tabulazioni solo per i tag che stanno da soli su una linea e iniziano con una word e non con un simbolo (es =)
			// '/(?|(?:\t*\{(\w[^}]+?)\}\n)|(?:\{([^}]+?)\}))/',
			# con eliminazione degli a capo e tabulazioni
			// '/(?|(?:\t*\{([^}]+?)\}\n)|(?:\{([^}]+?)\}))/',
			# senza eliminazione degli a capo e tabulazioni
			// '/\{([^}]+?)\}/',
			$this->_template, null, PREG_SPLIT_DELIM_CAPTURE );
		
		$c = -1;
		
		foreach( $tokens as &$t )
		{
			++$c;
			
			if( $c )
			{
				$c = -1;
				
				$t = $this->_commandTokenFactory->factory($t);
			}
			else
			{
				$t = new TextToken($t);
			}
		}
		
		$this->_tokens = new TokensStack($tokens);
		
		return $this;
	}
	
	public function render()
	{
		if( null === $this->_template )
		{
			throw new \Exception( "Template was not set." );
		}
		
		if( null === $this->_tokens )
		{
			$this->parseTemplate();
		}
		
		$context = ( new Context() )->setBindings($this->_bindings);
		
		$this->_render = (new CommandTokens\GlobalToken() )
			->prepare( $this->_tokens, $context )
			->exec()
		;
		
		return $this;
	}
	
	public function getTokensStack()
	{
		if( null === $this->_tokens )
		{
			throw new \Exception( "No tokens defined." );
		}
		
		return $this->_tokens;
	}
	
	public function getRender()
	{
		if( null === $this->_render )
		{
			throw new \Exception( "Render was not called." );
		}
		
		return $this->_render;
	}
}