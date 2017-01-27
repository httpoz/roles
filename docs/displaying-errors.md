Extending from the above, you can control the error page that your application users see when they try to open a page their role is not allowed to. This package already has a view bundled with it that should have been published to `resources/views/vendor/roles/error.blade.php` when you published the package. Simply add the below condition inside your `app\Exceptions\Handler.php`'s render function. Feel free to point to another view of your choice.

```php
/**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \HttpOz\Roles\Exceptions\RoleDeniedException || $exception instanceof \HttpOz\Roles\Exceptions\GroupDeniedException) {
            return response()->view('vendor.roles.error', compact('exception'), 403);
        }

        return parent::render($request, $exception);
    }
```