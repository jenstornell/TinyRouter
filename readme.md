# Routes

To determine what will happend on each url, you can use routes.

## Examples

### Numbers

>/user/123/321

```php
route("user/:num/:num", function($matches) {
  return "$matches[1] and $matches[1]";
});
```

### Component

To run a component you need to use a regex pattern as first argument that matches the uri. The second argument is the component name. Read more about [components](components).

```php
route('/*/', '_my_compoment');
```

### Method

Sometimes you don't need all the nuts and bolts of a component. In that case you can use an anonymous function as a second argument.

```php
route('/*/', function({
    return 'Something';
}));
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