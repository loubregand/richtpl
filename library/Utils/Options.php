<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace Utils;

class Options
{
	protected $_opz;
	protected $_conf;
	protected $_confKeys;
	
	public function __construct(array $conf)
	{
		$this->_conf = $conf;
		$this->_confKeys = array_keys($conf);
		$this->_opz = new \ArrayObject();
	}
	
	public function parse(Queue $par)
	{
		while( $par->count() )
		{
			$c = $par->next();

			if( in_array($c, $this->_confKeys) )
			{
				$par->shift();
				$return = call_user_func($this->_conf[$c], $par);
				
				if( is_array( $this->_opz[$c] ) )
				{
					$this->_opz[$c] = array_merge($this->_opz[$c], $return);
				}
				else
				{
					$this->_opz[$c] = $return;
				}
			}
			else
			{
				break;
			}
		}
		
		return $this;
	}
	
	public function getOpz()
	{
		return $this->_opz;
	}
}
