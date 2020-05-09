# TinyRouter

*Version: 2.0*

Probably the smallest PHP router library on earth.

## Files

### `.htaccess`

Add the `.htaccess` (code below).

```htaccess
Options -Indexes
RewriteEngine on
# RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*) index.php [L]
```

### `tinyrouter.php`

Add the `tinyrouter.php` to a folder (code below).

```php
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
```

## Usage

```php
include __DIR__ . '/tinyrouter.php';

route::post('form/:any', function($matches) {
  // Will only run with POST requests. You can PUT or whatever.
});

route(':all', function($matches) {
  // Will only run with GET requests
});

// When no match is found it will fall down here
header("HTTP/1.0 404 Not Found");
die('Error 404 - No route could be found');
```

## Patterns

### Predefined patterns

- `:all` matches everyting from current position until the end `.*`
- `:alpha` matches any alphabetically character `[a-zA-Z]+`
- `:any` matches anything within slashes `[^/]+`
- `:num` matches any number, even negative ones `\d+|-\d+`

The below will match for examlpe `blog/2010/01/my-story`.

```php
route('blog/:num/:num/:any', function($matches) {
  // Return something
});
```

### Custom patterns

The below will match for examlpe `assets/my/images/picture.jpg`.

```php
route('assets/(.*)\.(jpg|jpeg|png|gif|svg)$', function($matches) {
  // Return something
});
```

## Donate

Donate to [DevoneraAB](https://www.paypal.me/DevoneraAB) if you want.

## Requirements

- PHP 7
- Rewrite module enabled

## License

MIT