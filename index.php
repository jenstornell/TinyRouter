<?php
include __DIR__ . '/tinyrouter.php';
include __DIR__ . '/examples.php';

// Matches - /media/in/a/folder/image.jpg
route("media/(.*)\.(jpg|jpeg|png|gif|svg)$", function($matches) {
  print_r($matches);
});

// Matches - /media/in/a/folder/image.jpg
route("media/(.*)\.(jpg|jpeg|png|gif|svg)$", 'my_controller');

// Matches - /user/342
route("user/[0-9]+", function($matches) {
  print_r($matches);
});

route("user/:num/:num", function($matches) {
  return "$matches[1] and $matches[1]";
});

/*route("user/:all", function($matches) {
  print_r($matches);
  echo 'ALL';
});*/

route("user/:any/:any/hej", function($matches) {
  print_r($matches);
  echo 'ANY';
});

echo 'error';

// Home test
// class method http://flightphp.com/learn/
// object method
//route::post();
//route::get();
//'/user/[0-9]+'
//:any
//:all
//:num
//:letters
//:alphanum