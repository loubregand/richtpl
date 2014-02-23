richtpl
=======

A Simple but rich template engine for PHP 5.3+

USAGE

To test the richtpl,execute this from cli:

./main.php -f books.tpl

or access index.php from a web server with the following querystring:

index.php?tpl=books

---

Implemented tokens:

{for variable as [key_variable_name,]variable_name}{else [variable]}{endfor [variable]}
{if variable}{elseif variable}{else [variable]}{endif [variable]}
{set variable as variable_name}
{# comment #}
{# comment start}{comment end#}
