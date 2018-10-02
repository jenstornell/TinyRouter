<?php
class TinyRouter {
  public $uri;
  public $presets = [
    ':all' => '.*',
    ':alphanum' => '[a-zA-Z0-9]+',
    ':alpha' => '[a-zA-Z]+',
    ':any' => '[^/]+',
    ':num' => '\d+|-\d+',
  ];

  function __construct() {
    $this->uri = $this->uri();
  }

  function init($pattern, $input = []) {
    $pattern = $this->replacements($pattern);
    $matches = $this->matchExpression($pattern);

    #echo $pattern . "\n";
    #print_r($matches);

    #echo "\n\n";

    if(!$matches) return;

    if(function_exists('routeHook'))
      return routeHook($input, $matches);

    return $this->call($input, $matches);
  }

  function call($input, $matches) {
    switch(gettype($input)) {
      case 'object':
        return $input($matches);
        break;
      case 'string':
        return call_user_func_array($input, [$matches]);
        break;
      case 'array':
        return call_user_func_array([$input[0], $input[1]], [$matches]);
        break;
    }
  }

  function matchExpression($pattern) {
    #echo $this->uri . "\n";
    $is_match = preg_match($pattern, $this->uri, $matches);
    if($is_match) return $matches;
  }

  function replacements($pattern) {
    $pattern = $this->fixHome($pattern);
    
    foreach($this->presets as $preset => $regex) {
      $pattern = str_replace($preset, '(' . $regex . ')', $pattern);
    }

    $pattern = '~^' . $pattern . '~';
    #echo $pattern . "\n";
    return $pattern;
  }

  function fixHome($pattern) {
    return $pattern == '/' ? '^/$' : $pattern;
  }

  function uri() {
    if(!isset($_SERVER['REDIRECT_URL'])) return '/';
    $skip_root = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $_SERVER['REDIRECT_URL']);
    return substr($skip_root, 1);
  }
}

// Helpers

if(!function_exists('route')) {
  function route($pattern, $input) {
    $Route = new TinyRouter();
    $output = $Route->init($pattern, $input);
    if(isset($output)) {
      die($output);
    }
  }
}