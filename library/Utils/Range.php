<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace Utils;

class Range
{
	public function __get($k)
	{
		
		return range( 1, (int)$k );
	}
	
	public function __isset($k)
	{
		return true;
	}
}
