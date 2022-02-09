<?php

namespace HttpOz\Roles\Models;


use HttpOz\Roles\Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use HttpOz\Roles\Traits\RoleHasRelations;
use HttpOz\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;
use Illuminate\Support\Str;

class Role extends Model implements RoleHasRelationsContract
{

    use RoleHasRelations, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'group'];

    /**
     * Create a new model instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * @param $slug
     * @return mixed
     */
    public static function findBySlug($slug): self
    {
        return self::where('slug', $slug)->first();
    }

    protected static function newFactory(): RoleFactory
    {
        return new RoleFactory();
    }

    public function Slug(): Attribute
    {
        return new Attribute(
          set: fn ($value) => Str::slug($value, config('roles.separator')),
        );
    }

    public function Group(): Attribute
    {
        return new Attribute(
          set: fn ($value) => Str::slug($value, config('roles.separator')),
        );
    }
}
