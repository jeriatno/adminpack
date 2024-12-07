<?php

namespace App\Traits;

use App\Models\GlobalNumbering;
use App\Utils\GenerateNumber;
use Illuminate\Support\Facades\DB;

trait AutoDocNumber
{
    /*
    | Generate document number
    |
    | This section handles the generation of the document number. It uses the
    | appropriate method based on the model type, and ensures the number follows
    | the required format and increments correctly.
    |
    */
    public static function generateNumber($module)
    {
        static::creating(function ($model) use ($module) {
            DB::transaction(function () use ($model, $module) {
                $data = GenerateNumber::get($module);

                $numbering = GlobalNumbering::where('prefix', $data->prefix)
                    ->lockForUpdate()
                    ->firstOr(function () use ($data) {
                        return GlobalNumbering::create(['prefix' => $data->prefix]);
                    });

                // Generate document number
                $model->{$model->docNo ?? 'doc_no' } = GenerateNumber::generate(
                    $model,
                    $numbering->sequence,
                    $data->clause,
                    $data->is_increment
                );

                $numbering->increment('sequence');
            });
        });
    }
}
