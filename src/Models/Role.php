<?php

namespace HttpOz\Roles\Models;


use HttpOz\Roles\Database\Factories\RoleFactory;
use HttpOz\Roles\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use HttpOz\Roles\Traits\RoleHasRelations;
use HttpOz\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;

class Role extends Model implements RoleHasRelationsContract {

  use Sluggable, RoleHasRelations, HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'slug', 'description', 'group'];

  /**
   * Create a new model instance.
   *
   * @param array $attributes
   *
   * @return void
   */
  public function __construct(array $attributes = []) {
    parent::__construct($attributes);
    if ($connection = config('roles.connection')) {
      $this->connection = $connection;
    }
  }

  /**
   * @param $slug
   * @return mixed
   */
  public static function findBySlug($slug) {
    return self::where('slug', $slug)->first();
  }

  protected static function newFactory()
  {
      return new RoleFactory();
  }

}
