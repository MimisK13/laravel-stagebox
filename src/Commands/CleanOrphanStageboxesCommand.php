<?php

namespace Mimisk\Stagebox\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Mimisk\Stagebox\Models\Stagebox;

class CleanOrphanStageboxesCommand extends Command
{
    protected $signature = 'stagebox:clean-orphans';

    protected $description = 'Delete stageboxes that reference missing owners';

    public function handle(): int
    {
        $deleted = 0;

        $types = Stagebox::query()
            ->select('stageboxable_type')
            ->distinct()
            ->pluck('stageboxable_type');

        foreach ($types as $storedType) {
            if (! is_string($storedType) || $storedType === '') {
                continue;
            }

            $resolvedType = Relation::getMorphedModel($storedType) ?? $storedType;

            if (! class_exists($resolvedType) || ! is_subclass_of($resolvedType, Model::class)) {
                $deleted += Stagebox::query()
                    ->where('stageboxable_type', $storedType)
                    ->delete();

                continue;
            }

            $ownerModel = new $resolvedType;

            $deleted += Stagebox::query()
                ->where('stageboxable_type', $storedType)
                ->whereNotIn('stageboxable_id', $resolvedType::query()->select($ownerModel->getKeyName()))
                ->delete();
        }

        $this->info("Deleted {$deleted} orphan stagebox(es).");

        return self::SUCCESS;
    }
}
