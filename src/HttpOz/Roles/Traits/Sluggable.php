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

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value, config('roles.separator'));
    }

}