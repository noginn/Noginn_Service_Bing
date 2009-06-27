<?php
// Set the error reporting
error_reporting(E_ALL | E_STRICT);

// Set up the include paths
$libraryPath = dirname(__FILE__) . '/library';
set_include_path(implode(PATH_SEPARATOR, array($libraryPath, get_include_path())));

// Setup the autoloader
require_once $libraryPath . '/Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Noginn_');

if (isset($_POST['query']) && trim($_POST['query']) != '') {
    $bing = new Noginn_Service_Bing('__YOUR_APP_ID__');
    $searchResult = $bing->search($_POST['query'], array(
        'web' => array(
            'count' => 25,
            'offset' => 0,
        )
    ));
    
    if ($searchResult->hasSource('web')) {
        $webResults = $searchResult->getSource('web');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Search</title>
</head>
<body>
    <form action="example.php" method="post">
        <input type="text" name="query" id="query" value="<?php if (isset($_POST['query'])) { echo htmlentities($_POST['query'], ENT_QUOTES, 'UTF-8'); } ?>" /> 
        <button type="submit">Search</button>
    </form>
    
<?php if (isset($webResults) && count($webResults) > 0):  ?>
    <ul>
    <?php foreach ($webResults as $result): ?>
        <li><a href="<?php echo htmlentities($result->getUrl(), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlentities($result->getTitle(), ENT_QUOTES, 'UTF-8'); ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>