<?

ob_start();
$argv = ['appname', '-f', $_GET['tpl'] . ".tpl"];
require_once('main.php');
$out = ob_get_clean();

$out = preg_replace( '/^.*?\n/', '', $out);

echo $out;
