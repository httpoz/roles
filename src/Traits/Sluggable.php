<?php

namespace HttpOz\Roles\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    /**
     *  Set slug attribute.
     *
     * @param string $value
     * @return void
     */

    public function setSlugAttribute(string $value)
    {
        $this->attributes['slug'] = Str::slug($value, config('roles.separator'));
    }

    public function setGroupAttribute($value)
    {
        $this->attributes['group'] = Str::slug($value, config('roles.separator'));
    }

}
