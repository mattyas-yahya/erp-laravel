<?php

namespace App\Traits\Eloquent;

trait EloquentSetCreatedBy {
    public static function booted() {
        parent::booted();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }
}
