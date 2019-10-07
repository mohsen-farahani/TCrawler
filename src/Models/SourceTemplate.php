<?php

declare (strict_types = 1);

namespace Mfarahani\TCrawl\Models;

use Illuminate\Database\Eloquent\Model;

class SourceTemplate extends Model
{
    public $table = 'source_templates';

    public $fillable = [
        'title',
        'username',
        'url',
        'template',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title'    => 'string',
        'username' => 'string',
        'url'      => 'string',
        'template' => 'string',
        'status'   => 'bool',
    ];

}
