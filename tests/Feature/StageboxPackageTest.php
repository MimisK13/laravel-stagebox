<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Mimisk\Stagebox\Enums\StageboxColor;
use Mimisk\Stagebox\Models\Stagebox;

class TestOwner extends Model
{
    protected $table = 'owners';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function stageboxes(): MorphMany
    {
        return $this->morphMany(Stagebox::class, 'stageboxable');
    }
}

it('loads the package migration schema', function (): void {
    expect(Schema::hasTable('stageboxes'))->toBeTrue();

    expect(Schema::hasColumns('stageboxes', [
        'stageboxable_type',
        'stageboxable_id',
        'name',
        'slug',
        'channels',
        'returns',
        'color',
        'notes',
        'created_at',
        'updated_at',
    ]))->toBeTrue();
});

it('generates slug from name and attaches stagebox to owner morph', function (): void {
    $owner = TestOwner::query()->create(['name' => 'Owner A']);

    $stagebox = $owner->stageboxes()->create([
        'name' => 'Main Rack',
        'channels' => 12,
        'returns' => 2,
        'color' => StageboxColor::BLACK,
    ]);

    expect($stagebox->slug)->toBe('main-rack')
        ->and($stagebox->stageboxable_type)->toBe($owner->getMorphClass())
        ->and($stagebox->stageboxable_id)->toBe($owner->id);
});

it('enforces slug uniqueness only inside the same morph owner scope', function (): void {
    $ownerA = TestOwner::query()->create(['name' => 'Owner A']);
    $ownerB = TestOwner::query()->create(['name' => 'Owner B']);

    $ownerA->stageboxes()->create([
        'name' => 'Rack One',
        'slug' => 'shared',
        'channels' => 12,
        'returns' => 0,
        'color' => StageboxColor::RED,
    ]);

    // Allowed on different owner
    $ownerB->stageboxes()->create([
        'name' => 'Rack One',
        'slug' => 'shared',
        'channels' => 12,
        'returns' => 0,
        'color' => StageboxColor::BLUE,
    ]);

    expect(Stagebox::query()->count())->toBe(2);

    // Blocked on same owner
    $this->expectException(QueryException::class);

    $ownerA->stageboxes()->create([
        'name' => 'Rack Two',
        'slug' => 'shared',
        'channels' => 24,
        'returns' => 4,
        'color' => StageboxColor::GREEN,
    ]);
});

it('casts color as stagebox color enum', function (): void {
    $owner = TestOwner::query()->create(['name' => 'Owner C']);

    $stagebox = $owner->stageboxes()->create([
        'name' => 'Color Rack',
        'channels' => 12,
        'returns' => 0,
        'color' => StageboxColor::GREEN,
    ])->refresh();

    expect($stagebox->color)->toBeInstanceOf(StageboxColor::class)
        ->and($stagebox->color)->toBe(StageboxColor::GREEN)
        ->and($stagebox->color->hex())->toBe('#008000');
});
