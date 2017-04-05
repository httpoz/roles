When you are creating roles, there is optional parameter `group`. It is set as `default` by default, but you can overwrite it and then you can do something like this:

```php
if ($user->group() == 'application.managers') {
    //
}

if ($user->inGroup('application.managers')) {
    // if true do something
}
```

> If user has multiple roles, method `group` returns the first one in alphabetical order (a better implementation of this will be explored).

`Group` is intended to collectively organise and assign permissions (Laravel's built in authorization feature) to a role group that can be shared by multiple roles (examples and implementation to be added to documentation in future).
