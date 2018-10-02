<?php
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
  'num-child',
  'post',
  'get',
  'asset',
  'routes'
];

function uset($value) {
  $fields = array_flip($GLOBALS['tests']);
  unset($fields[$value]);
  $GLOBALS['tests'] = array_flip($fields);
}

function doset($value) {
  $GLOBALS['tests'][] = $value;
}

// Anonymous function
route($pattern, function($matches) {
  if(is_array($matches)) uset('anonymous');
});

// Function
route($pattern, 'my_function');
function my_function($matches) {
  if(is_array($matches)) uset('function');
}

// Static function
route($pattern, 'MyStatic::myFunction');
class MyStatic {
  public static function myFunction($matches) {
    if(is_array($matches)) uset('static');
  }
}

// Object function
$object = new MyClass();
route($pattern, [$object, 'myFunction']);
class MyClass {
  function myFunction($matches) {
    if(is_array($matches)) uset('object');
  }
}

// REGEX

// Home
$_SERVER['REDIRECT_URL'] = null;
route('/', function($matches) {
  if($matches[0] == '/') uset('home');
});

// Home - false
$_SERVER['REDIRECT_URL'] = 'test/';
route('/', function($matches) {
  doset('home-false');
});

// Custom root
$_SERVER['REDIRECT_URL'] = $root . '123';
route('([0-9]+)', function($matches) {
  if($matches[1] == '123') uset('custom-root');
});

// Custom child
$_SERVER['REDIRECT_URL'] = $root . 'custom/123/hello';
route('custom/(\d+|-\d+)/hello', function($matches) {
  if($matches[1] == '123') uset('custom-child');
});

// Custom false
$_SERVER['REDIRECT_URL'] = $root . 'custom/123m/hello';
route('custom/(\d+|-\d+)/hello', function($matches) {
  doset('custom-child');
});

// All root
$_SERVER['REDIRECT_URL'] = $root . 'user/123/321';
route(':all', function($matches) {
  if($matches[0] == 'user/123/321') uset('all-root');
});

// All child
$_SERVER['REDIRECT_URL'] = $root . 'all/123/321_#-';
route('all/:all', function($matches) {
  if($matches[1] == '123/321_#-') uset('all-child');
});

// Alpha root
$_SERVER['REDIRECT_URL'] = $root . 'alpha';
route(':alpha', function($matches) {
  if($matches[1] == 'alpha') uset('alpha-root');
});

// Alpha child
$_SERVER['REDIRECT_URL'] = $root . 'alpha/art/hello';
route('alpha/:alpha/hello', function($matches) {
  if($matches[1] == 'art') uset('alpha-child');
});

// Alpha false
$_SERVER['REDIRECT_URL'] = $root . 'alpha/art123/hello';
route('alpha/:alpha/hello', function($matches) {
  doset('alpha-false');
});

// Alphanum root
$_SERVER['REDIRECT_URL'] = $root . 'abc123/hello';
route(':alphanum/hello', function($matches) {
  if($matches[1] == 'abc123') uset('alphanum-root');
});

// Alphanum child
$_SERVER['REDIRECT_URL'] = $root . 'alphanum/abc123/hello';
route('alphanum/:alphanum/hello', function($matches) {
  if($matches[1] == 'abc123') uset('alphanum-child');
});

// Alphanum false
$_SERVER['REDIRECT_URL'] = $root . 'alphanum/abc123_/hello';
route('alphanum/:alphanum/hello', function($matches) {
  doset('alphanum-false');
});

// Any root
$_SERVER['REDIRECT_URL'] = $root . 'any/123';
route(':any/:any', function($matches) {
  if($matches[1] == 'any' && $matches[2] == '123') uset('any-root');
});

// Any child
$_SERVER['REDIRECT_URL'] = $root . 'any/123/abc';
route('any/:any/:any', function($matches) {
  if($matches[1] == '123' && $matches[2] == 'abc') uset('any-child');
});

// Any false
$_SERVER['REDIRECT_URL'] = $root . 'any/123/abc';
route('any/:any/:any', function($matches) {
  if($matches[1] == '123/abc') doset('any-false');
});

// Num root
$_SERVER['REDIRECT_URL'] = $root . '123/hello';
route(':num/hello', function($matches) {
  if($matches[1] == '123') uset('num-root');
});

// Num child
$_SERVER['REDIRECT_URL'] = $root . 'num/123/hello';
route('num/:num/hello', function($matches) {
  if($matches[1] == '123') uset('num-child');
});

// Num false
$_SERVER['REDIRECT_URL'] = $root . 'num/123a/hello';
route('num/:num/hello', function($matches) {
  doset('num-false');
});

// POST
$_SERVER['REDIRECT_URL'] = null;
$_SERVER['REQUEST_METHOD'] = 'POST';
route::post('/', function($matches) {
  if($matches[0] == '/') uset('post');
});

// GET
$_SERVER['REDIRECT_URL'] = null;
$_SERVER['REQUEST_METHOD'] = 'GET';
route::get('/', function($matches) {
  if($matches[0] == '/') uset('get');
});

// Advanced example
$_SERVER['REDIRECT_URL'] = $root . 'assets/my/folder/image.jpg';
route('assets/(.*)\.(jpg|jpeg|png|gif|svg)', function($matches) {
  if($matches[1] == 'my/folder/image' && $matches[2] == 'jpg') uset('asset');
});

$_SERVER['REDIRECT_URL'] = null;
routes([
  'something' => 'aFunction',
  '/' => function($matches) {
    if($matches[0] == '/') uset('routes');
  },
]);

print_r($GLOBALS['tests']);