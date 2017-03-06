## Attaching, Syncing And Detaching Roles

It's really simple. You fetch a user from database and call `attachRole` method. There is `BelongsToMany` relationship between `User` and `Role` model.
Learn about [Many To Many Relationships](https://laravel.com/docs/5.3/eloquent-relationships#updating-many-to-many-relationships)

```php
use App\User;

$user = User::find($id);

$user->attachRole($adminRole); // you can pass whole object, or just an id
$user->detachRole($adminRole); // in case you want to detach role
$user->detachAllRoles(); // in case you want to detach all roles
$user->syncRoles($roles); // you can pass Eloquent collection, or just an array of ids
```