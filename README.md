# Extend Laravel HasMany relationship with KeyBy method

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hulkur/laravel-hasmany-keyby.svg)](https://packagist.org/packages/hulkur/laravel-hasmany-keyby)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/hulkur/laravel-hasmany-keyby/tests.yml?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/hulkur/laravel-hasmany-keyby.svg)](https://packagist.org/packages/hulkur/laravel-hasmany-keyby)

Adds possibility to have related models in many-to-many relationship attached to the parent model by defined key values.
Usually it would be related model `id`.

call: 
```php
$users = User::with('groups')->all()
```

laravel default: 
```php
$user->groups = [0 => $group];
```

New usage with keyBy:
```php
class User extends Model
{
  use HasManyKeyByRelationship;

  public function groups()
  {
    return $this->hasMany(Group::class)->keyBy('id'); // can be string or callable
  }
}
```

result: 
```php
$user->groups = [$group->id => $group];
```

This is specially useful in case there is a need to manipulate pivot records in mass.
Ex: users/groups grid where grid fields are some value in pivot record and not all pivot records exist

```php
@foreach($users as $user)
  @foreach($groups as $group)
    {{optional($user->accesslevels[$group->id])->level}}
  @endforeach
@endforeach
```

