# TinyRouter

TinyRouter is perhaps the smallest router library on earth.

Here is a really basic example: Visit `/portfolio/archive/123` and it will output `archive and 123`.

```php
route("portfolio/:any/:num", function($matches) {
  return "$matches[1] and $matches[2]";
});
```

## Patterns

### Predefined

- `:all` matches everyting from current position until the end `.*`
- `:alpha` matches any alphabetically character `[a-zA-Z]+`
- `:alphanum` matches any alphabetically character and number `[a-zA-Z0-9]+`
- `:any` matches anything within slashes `[^/]+`
- `:num` matches any number, even negative ones `\d+|-\d+`

### Custom

You can also create custom patterns. It will accept any regular expression with a few exceptions.

- You should not add a delimiter as `~` is used out of the box.
- You should not end your pattern with `$` as it is used out of the box.

The below will match `user/123` and output `User 123`.

```php
route('user/([0-9]+)', function($matches) {
  echo "User $matches[1]";
});
```

## Type of calls

### Anonymous function

With the anonymous method you can do something when on match directly.

```php
route($pattern, function($matches){
  return $matches[1];
});
```

### Function

If you use a string as a second argument, you will call a function.

```php
route($pattern, 'about');

function about() {
  return 'Basic function';
}
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

## Hook (optional)

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
### Presets

The IO CMS core includes some route presets. You can run these by using preset the name as argument.

```php
route('preset_name');
```

### Core presets

Below are the current IO CMS core route presets. You can also read about them in [route-presets.php](route-presets.php).

```php
route('asset');
```
-->
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