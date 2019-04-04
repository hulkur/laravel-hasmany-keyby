# Extend Laravel HasMany relationship with KeyBy method

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
    {{optional($user->accesslevels[$groupId])->level}}
  @endforeach
@endforeach
```

