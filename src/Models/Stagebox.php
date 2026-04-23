<?php

namespace Laravel\Stagebox\Models;

use Illuminate\Database\Eloquent\Model;
use Mimisk\LaravelToolbox\Traits\HasSlug;

class Stagebox extends Model
{
    use HasSlug;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'channels',
        'returns',
        'color',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'channels' => 'integer',
            'returns' => 'integer',
        ];
    }

    protected function getSlugSourceColumn(): string
    {
        return 'name';
    }
}
