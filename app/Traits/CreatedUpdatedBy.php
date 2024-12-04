<?php

namespace App\Traits;

// From https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = Auth::user()->name;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = Auth::user()->name;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }
}
