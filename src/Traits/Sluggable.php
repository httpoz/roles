<?php

namespace HttpOz\Roles\Traits;

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

    public function setGroupAttribute($value)
    {
        $this->attributes['group'] = str_slug($value, config('roles.separator'));
    }

}
