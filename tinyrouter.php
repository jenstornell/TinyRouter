<?php
class route
{
  public static function __callStatic($method, $args)
  {
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {

      $presets = [
        ':all' => '.*',
        ':alpha' => '[a-zA-Z]+',
        ':any' => '[^/]+',
        ':num' => '\d+|-\d+',
      ];

      $pattern = $args[0];

      foreach ($presets as $shortcode => $regex) {
        $pattern = strtr($pattern, [$shortcode => '(' . $regex . ')']);
      }
      $pattern = '~^' . $pattern . '$~';

      $uri = '/';
      $dir = dirname($_SERVER['SCRIPT_NAME']);

      if (isset($_SERVER['REDIRECT_URL']) && $dir != '/') {
        $uri = strtr($_SERVER['REDIRECT_URL'], [$dir => '']);
      }

      preg_match($pattern, $uri, $matches);

      if (!$matches) return;

      $output = $args[1]($matches);
      if (isset($output)) die($output);
    }
  }
}

function route($pattern, $method)
{
  route::get($pattern, $method);
}
