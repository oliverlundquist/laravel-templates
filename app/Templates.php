<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    /**
     * Table definition variable.
     *
     * @var string
     */
    protected $table = 'templates';

    /**
     * Mass-assign guarded keys.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get content from template entry.
     *
     * @param  string  $contents
     * @return string
     */
    public function getContentsAttribute($contents)
    {
        return is_string($contents) ? json_decode($contents) : $contents;
    }
}
