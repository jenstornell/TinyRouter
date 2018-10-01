<?php
/*
/* CALLS
*/
$root = '/misc/tinyrouter/';
$url = $root . 'about/me';
$pattern = 'about/:any';

$_SERVER['REDIRECT_URL'] = $url;

$GLOBALS['tests'] = [
  'anonymous',
  'function',
  'static',
  'object',
  'home',
  'custom-root',
  'custom-child',
  'all-root',
  'all-child',
  'alpha-root',
  'alpha-child',
  'alphanum-root',
  'alphanum-child',
  'any-root',
  'any-child',
  'num-root',
  'num-child'
];

function uset($value) {
  $fields = array_flip($GLOBALS['tests']);
  unset($fields[$value]);
  $GLOBALS['tests'] = array_flip($fields);
}

/*
/* Anonymous function
*/
route($pattern, function() {
  echo "Match anonymous function\n";
});

/*
/* Function
*/
route($pattern, 'my_function');

function my_function() {
  echo "My function\n";
}

/*
/* Static function
*/
route($pattern, 'MyStatic::myFunction');

class MyStatic {
  public static function myFunction() {
    echo "My static function\n";
  }
}

/*
/* Object function
*/
$object = new MyClass();
route($pattern, [$object, 'myFunction']);

class MyClass {
  function myFunction($matches) {
    echo "My object function\n";
  }
}

/*
/* REGEX
*/

/*
/* Home
*/
$_SERVER['REDIRECT_URL'] = null;

route('/', function($matches) {
  if($matches[0] == '/') uset('home');
});

/*
/* Custom root
*/
$_SERVER['REDIRECT_URL'] = $root . '123';
route('([0-9]+)', function($matches) {
  if($matches[1] == '123') uset('custom-root');
});

/*
/* Custom child
*/
$_SERVER['REDIRECT_URL'] = $root . 'custom/123/hello';
route('custom/(\d+|-\d+)/hello', function($matches) {
  if($matches[1] == '123') uset('custom-child');
});

/*
/* All root
*/
$_SERVER['REDIRECT_URL'] = $root . 'user/123/321';
route(':all', function($matches) {
  if($matches[0] == 'user/123/321') uset('all-root');
});

/*
/* All child
*/
$_SERVER['REDIRECT_URL'] = $root . 'all/123/321';
route('all/:all', function($matches) {
  if($matches[1] == '123/321') uset('all-child');
});

/*
/* Alpha root
*/
$_SERVER['REDIRECT_URL'] = $root . 'alpha';
route(':alpha', function($matches) {
  if($matches[1] == 'alpha') uset('alpha-root');
});

/*
/* Alpha child
*/
$_SERVER['REDIRECT_URL'] = $root . 'alpha/art/hello';
route('alpha/:alpha/hello', function($matches) {
  if($matches[1] == 'art') uset('alpha-child');
});

/*
/* Alphanum child
*/
$_SERVER['REDIRECT_URL'] = $root . 'alphanum/abc123/hello';
route('alphanum/:alphanum/hello', function($matches) {
  if($matches[1] == 'abc123') uset('alphanum-child');
});

/*
/* Any root
*/
$_SERVER['REDIRECT_URL'] = $root . 'any/123';
route(':any/:any', function($matches) {
  if($matches[1] == 'any' && $matches[2] == '123') uset('any-root');
});

/*
/* Any child
*/
$_SERVER['REDIRECT_URL'] = $root . 'any/123/abc';
route('any/:any/:any', function($matches) {
  if($matches[1] == '123' && $matches[2] == 'abc') uset('any-child');
});

/*
/* Num root
*/
$_SERVER['REDIRECT_URL'] = $root . '123/hello';
route(':num/hello', function($matches) {
  if($matches[1] == '123') uset('num-root');
});

/*
/* Num child
*/
$_SERVER['REDIRECT_URL'] = $root . 'num/123/hello';
route('num/:num/hello', function($matches) {
  if($matches[1] == '123') uset('num-child');
});

print_r($GLOBALS['tests']);