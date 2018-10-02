# TinyRouter

TinyRouter is perhaps the smallest router library on earth. Donate to [DevoneraAB](https://www.paypal.me/DevoneraAB) if you want.

A basic example, visit `/portfolio/archive/123` and it will output `archive and 123`.

```php
route('portfolio/:any/:num', function($matches) {
  return "$matches[1] and $matches[2]";
});

echo 'Error 404 - No route could be found';
```

If no match is found it will continue down, in this case print an error message.

## Patterns

### Predefined

- `:all` matches everyting from current position until the end `.*`
- `:alpha` matches any alphabetically character `[a-zA-Z]+`
- `:alphanum` matches any alphabetically character and number `[a-zA-Z0-9]+`
- `:any` matches anything within slashes `[^/]+`
- `:num` matches any number, even negative ones `\d+|-\d+`

The below will match for examlpe `blog/2010/01/my-story`.

```php
route('blog/:num/:num/:any', function() {
  // Do something
});
```

### Custom regular expressions

You can also create custom patterns. It will accept any regular expression with a few exceptions.

- You should not add a delimiter as `~` is used out of the box.
- You should not end your pattern with `$` as it is used out of the box.

The below will match for examlpe `assets/my/images/picture.jpg`.

```php
route('assets/(.*)\.(jpg|jpeg|png|gif|svg)', function() {
  // Do something
});
```

## Examples

### Function

If you use a string as a second argument, you will call a function.

```php
route($pattern, 'about');

function about() {
  return 'Basic function';
}
```

### Anonymous function

With the anonymous method you can do something when on match directly.

```php
route($pattern, function($matches){
  return $matches[1];
});
```

### Static function

To call a static function you need to include the class name like below.

```php
route($pattern, 'MyStatic::about');

class MyStatic {
  public static function about() {
    return 'Static function';
  }
}
```

### Object function

To use a function in a class, you need to create an object. Then you need to send the object and the class name as an array, like below.

```php
$object = new MyClass();

route($pattern, [$object, 'about']);

class MyClass {
  function about() {
    return 'Object function';
  }
}
```

### POST and GET

By default the route will match no matter what the request method is. There is a short way to only allow POST or GET request.

```php
route::get('/', function(){
  // Do something
});

route::post('/', function(){
  // Do something
});
```

### Multiple routes in one go

You can setup all your routes with a single array. The `key` of every row is the pattern and the `value` is the call. That way it works very similar to the `route` function.

```php
routes([
  '/' => 'myFunction',
  'about/:any' => function() {
    // Do something
  }
]);
```

### Hook

To hijack what will happend when a route matches a pattern, you can use a hook. It can be useful if you build a tool and want to call a controller instead of a function for example.

```php
route('about/:any', 'world');

function routeHook($input, $matches) {
  if(is_string($input)) {
    return "Hello $input! Hello $matches[1]".
  }
}
```


<!--

## Multiple routes in one go

You can also run all the routes in one go. Everything that works for single routes also works for multiple routes.

```php
routes([
    'preset_name',
    '/*/' => '_my_component',
    '/*/' => function() {
        return 'Something';
    },
]);
```
-->

## Additional notes

- To keep it dead simple, `route()` is used as function name. To be sure, it will check if it does not already exist.
- To keep it dead simple, namespaces is not used.
- In case of collision, you can roll out your own helper function by calling `TinyRouter` class directly.

## Requirements

- PHP 7
- Rewrite module enabled

## Inspiration

- [Tania Rascia](https://www.taniarascia.com/the-simplest-php-router/) - The starting point.
- [Laravel](https://laravel.com/docs/5.7/routing) - How to use methods like get and post.
- [Macow](https://github.com/noahbuscher/macaw/blob/master/Macaw.php) Good regular expressions.
- [Kirby CMS routes](https://getkirby.com/docs/developer-guide/advanced/routing) Naming conventions.
- [Flight routing](http://flightphp.com/learn/) Call as static class and objects.

## License

MIT