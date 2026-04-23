<?php

namespace Mimisk\Stagebox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Mimisk\LaravelToolbox\Traits\HasSlug;
use Mimisk\Stagebox\Enums\StageboxColor;

class Stagebox extends Model
{
    use HasSlug;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'stageboxable_type',
        'stageboxable_id',
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
            'color' => StageboxColor::class,
        ];
    }

    protected function getSlugSourceColumn(): string
    {
        return 'name';
    }

    public function stageboxable(): MorphTo
    {
        return $this->morphTo();
    }
}
