<?php
include __DIR__ . '/tinyrouter.php';

route('/', function() {
  return 'Hello from home!';
});

route(':any/:num', function($matches) { // archive/123
  return "A message from $matches[1], page $matches[2].";
});

header("HTTP/1.0 404 Not Found");
die('Error 404! No route was found!');