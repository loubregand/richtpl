#!/usr/bin/env php
<?

$path = (string) get_include_path();
$path .= (string) (PATH_SEPARATOR . dirname(__FILE__).'/library/');
set_include_path($path);

spl_autoload_extensions(".php");

// Il meccanismo di default non funziona con nomi di classi contenenti maiuscole
// spl_autoload_register();

// Meccanismo alternativo in attesa del bugfix di php
spl_autoload_register(
	function ($className)
	{
		$className = (string) str_replace('\\', DIRECTORY_SEPARATOR, $className);
		include_once($className . '.php');
	}
);

try
{
	$arguments = new \Utils\Queue($argv);
	
	$appName = $arguments->shift();
	$usage = "Usage: $appName -f file | $appName -c code";
	
	$options = (new \Utils\Options(array(
			'-f' => function (\Utils\Queue $arguments)
			{
				if( ! $arguments->count() )
				{
					throw new \Exception( "Option -f requires an argument." );
				}
				
				return $arguments->shift();
			},
			'-c' => function (\Utils\Queue $arguments)
			{
				if( ! $arguments->count() )
				{
					throw new \Exception( "Option -c requires an argument." );
				}
				
				return $arguments->shift();
			},
			'--print' => function (\Utils\Queue $arguments)
			{
				if( ! $arguments->count() )
				{
					throw new \Exception( "Option --print requires an argument." );
				}
				
				return [$arguments->shift() => 1];
			},
		)))
		->parse($arguments)
		->getOpz()
	;	

	$print = [];
	if( $options['--print'] )
	{
		$print = $options['--print'];
	}
	
	if( $arguments->count() )
	{
		throw new \Exception( "Extra arguments on command line." );
	}
	
	if( $options['-f'] )
	{
		if( ! is_file( $options['-f'] ) )
		{
			throw new \Exception( "File {$options['-f']} is not a regular file." );
		}
		
		$code = file_get_contents($options['-f']);
	}
	elseif( $options['-c'] )
	{
		$code = $options['-c'];
	}
	else
	{
		throw new \Exception( $usage );
	}

	$tpl = new \TemplateEngine\Engine();
	
	$tpl->setTemplate($code);
	
	$tpl->bind([
		'title' => "My books",
		'rows' => [
			[
				'title'     => "Linux in a nutshell",
				'pages'     => 100,
				'author'    => "Mel Gibson",
				'publisher' => 'O\' Reilly',
				'date_of_publication' => '2013-01-09T00:00:01',
			],
			[
				'title'     => "Python",
				'pages'     => 300,
				'author'    => "Stephen King",
				'publisher' => 'Hoeply',
				'date_of_publication' => '2013-01-09T00:00:01',
			],
		],
		// 'rows' => [],
		'number_of_books' => 20,
		'hasPrevious' => 0,
		'prevLink' => 'http://next/page',
		'hasNext'     => 1,
		'nextLink' => 'http://next/page',
		'str' => [
			'upper'   => 'strtoupper',
			'lower'   => 'strtolower',
			'ucfirst' => 'ucfirst',
			'ucwords' => 'ucwords',
		],
		'var' => [
			'castBoolean' => function ($v){return (bool)$v;},
		],
		'array' => [
			'count'      => 'count',
			'group_by_3' => function ($array)
			{
				$r = [];
				$c = 0;
				$b = [];
				
				foreach( $array as $k => $v )
				{
					$a = [];
					$a['index'] = $c+1;
					$a['key'] = $k;
					$a['value'] = $v;
					$b[] = $a;
					
					++$c;
					
					if( $c > 2 )
					{
						$c = 0;
						$r[] = $b;
						$b = [];
					}
				}
				
				if( $c )
				{
					$r[] = $b;
				}
				
				// die("");
				return $r;
			},
		],
	]);
	
	$tpl->parseTemplate();

	if( $print['tokens'] )
	{
		foreach( $tpl->getTokensStack()->getTokens() as $t )
		{
			echo get_class( $t ) . ": " . str_replace("\n", " ", $t->getToken() );
			
			if( $t instanceof TemplateEngine\CommandTokens\AbstractCommandTokens )
			{
				echo " ||| " . json_encode( $t->getMatches() );
			}
			
			echo "\n";
		}
	}
	
	$tpl->render();
	
	// echo "\nRENDERED TPL:\n";
	echo $tpl->getRender();
}
catch(Exception $e)
{
	printf( "$appName ERROR: %s\n\n", $e->getMessage() );
	echo "File: " . $e->getFile() . " (";
	echo "Line: " . $e->getLine() . ")\n";
	echo $e->getTraceAsString();
}
