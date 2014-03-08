<?php

/**
* @author Pier Paolo Grassi <p.grassi@tekkalab.com>
*/

namespace TemplateEngine\CommandTokens;

class Comment extends AbstractCommandTokens
{
	public function exec(\TemplateEngine\Context $context)
	{
		return "";
	}
}