<?php
class TinyRouter {
  public $uri;
  public $presets = [
    ':all' => '.*',
    ':alpha' => '[a-zA-Z]+',
    ':alphanum' => '[a-zA-Z0-9]+',
    ':any' => '[^/]+',
    ':num' => '\d+|-\d+',
  ];

  function __construct() {
    $this->uri = $this->uri();
  }

  function init($pattern, $input = []) {
    $pattern = $this->replacements($pattern);

    if(!preg_match($pattern, $this->uri, $matches)) return;

    if(gettype($input) == 'object')
      return $input($matches);
    else {
      if(function_exists('routerHook'))
        return routerHook($input, $matches);
      else
        return call_user_func_array($input, [$input, $matches]);
    }
  }

  function replacements($pattern) {
    foreach($this->presets as $preset => $regex) {
      $pattern = str_replace($preset, '(' . $regex . ')', $pattern);
    }

    $pattern = '~' . $pattern . '$~';
    return $pattern;
  }

  function uri() {
    if(!isset($_SERVER['REDIRECT_URL'])) return '/';
    return substr($_SERVER['REDIRECT_URL'], 1);
  }
}

// Helper
function route($pattern, $input) {
  $Route = new TinyRouter();
  $output = $Route->init($pattern, $input);
  if(isset($output)) {
    echo $output;
    die;
  }
}