richtpl
=======

A Simple but rich template engine for PHP 5.3+

USAGE

To test the richtpl,execute this from cli:

./main.php -f books.tpl

or access index.php from a web server with the following querystring:

index.php?tpl=books

---

VARIABLES

A variable can be:
a variable name to be found in the current or, recursively, parent context optionally followed by a dot ad another name, to be searched in the context of the primary name, as follow:
- if the primary name identifies an array, the secondary name is searched as an index of the array
- if the primary name is an object, the secondary name is searched as a property of the object, than as a method that is invoked and the value returned is put on the stack (the method must be found by the function method_exists in order to be invoked).
If the secondary name is followed by a dot and another name, the process is started over, with the value returned from the first process substituted to the value of the primary variable.

A pipe simbol | can be inserted after a variable declaration. After the pipe must be inserted a variable declaration that resolves to a callable type. This callable will be invoked with the first variable value as input. The output of the callable will become the new value to be returned. If another pipe is found after the first, the process is repeated.

Added numeric literals: a variable name that consists only of numbers is not looked up but is returned as a literal integer.

Added `for' semantics to use numeric literals as a shortcut to execute a loop a defined number of times.

IMPLEMENTED TAGS

{for variable[ as key_variable_name[,variable_name]]}{else[ variable]}{endfor[ variable]}

{if variable[ as variable_name]}{elseif variable[ as variable_name]}{else[ variable]}{endif[ variable]}

implemented not in IF tag (if! or if ! and elseif! and elseif !)
{if ! variable[ as variable_name]}{elseif ! variable[ as variable_name]}{else[ variable]}{endif[ variable]}

{set variable as variable_name}

{while variable[ as variable_name]}{endwhile[ variable]}

{# comment #}
{# comment start}{comment end#}


PARTIALS

A variable can be an instantiated template. In this case, the template acts as a partial template: the current context is passed to the template as his base context, so it can render himself using the current context values as fallback for every value it cannot resolve in his own context. The result of the render is returned as the variable value.


TEMPLATE INHERITANCE

coming soon

HELPERS

Helpers are a huge part of the template mechanism. By demanding functionalities to helpers we are able to keep the template core to a minimum, so we have less bugs, it is easier to add functionalities, and everybody is happier. So, what are helpers? basically, they are variables that resolve to callables. They can be inserted after a variable by postponing the variable with a pipe character `|', es:

{= var_with_an_array|array.count}

will output the number of elements in the var_with_an_array array.

The array.iterate helper is particularly interesting: it creates a new object of type \Utils\ManualIterator. This object can be used inside for loops like this:

{for rows|array.iterate as ar}
	{= ar.fwd.key}: {= ar.value}
{endfor}

This object will not advance automatically when inside a for loop, unlike a normal iterator. Instead, you will need to call the fwd method, even to retrieve the first value. This is by design to allow nested for loops like the one in the books_multicol.tpl example, which presents a grid of results whitout having to handle differently the first cell of every row.

This iterator can also be used to cycle indefinetly between a list of values, ie suppose the colors array contains two values, grey and white. The following piece of code:

{set colors|array.iterate as cols}
{for 4}
{=cols.cycle.value}
{endfor}

will print:

grey
white
grey
white

Note that the {set} tag must be outside the for loop or the variable cols would be reinitialized at every loop, resulting in four `grey' rows.

TODOS

- refactoring of token methods: exec and prepare, to use the currect method for the current stage

- template parsing and syntax tree generation caching between renderings of the same template

- automatic escaping of variables

- ability to change default tag delimiters { and }

- default (and method to allow override) escape sequence for inserting literal tag delimiters

- pass the context to the callables (closures and class methods, not to the function calls) to allow setting of context variables from helper methods

- caching through serialization of parsed syntax trees

- generator for big numbers in automatic `for' integer loops.

- {filter} tag

- {=var} escaped by default {=!var} not escaped

- rendering of partials: autoescape disabled by default (allow forcing it? maybe using a filter)

- partials with filters applyed: they will not be rendered before filter application! must implement partial rendering at context level (with the context passing itself to the partial), but then how to inform the variable token that a partial has been rendered and thus it shouldn't escape the result?

- iterator should be able to tell if an element is the last one

- update automatic iterator with methods from manual interator (ie isFirst, isLast)

- change the way token are specialized: on request at lexing stage instead of everything at tokenizing stage. This way it could be possibile to allow a token to ecape every subsequent token till a closing token (to define a non-processing area) -> is this not similar to range comments? YES, so without this change syntax errors in tokens would cause the rendering to fail even if the tags are commented out.
Solution: to substitute the tokenization with an ad-hoc one customizable by the current node (this way it could be possible for a tag to declare new delimiters inside his context).
For this to work tokenization of the next token should be performed on-demand by a class that is context-sensitive, ideally the context itself.

- {unescape}{endunescape} to disable automatic escaping for the {= var} tag inside a context

-?- {ifvar} tag (semantic: {ifvar var_name}section executed if var_name is false (if is true the variable value is printed.{endifvar} (Need escape/unescape semantic, can be very confusing)

- ??? callables argument(s)?
