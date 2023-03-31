<?php

namespace App\Models;

use App\Enums\ClassifierValueType;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassifierValue extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $fillable = [
        'name', 'value', 'type', 'meta'
    ];

    protected $casts = [
        'type' => ClassifierValueType::class,
        'meta' => 'array'
    ];
}
