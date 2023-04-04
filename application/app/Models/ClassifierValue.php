<?php

namespace App\Models;

use App\Enums\ClassifierValueType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassifierValue extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name', 'value', 'type', 'meta',
    ];

    protected $casts = [
        'type' => ClassifierValueType::class,
        'meta' => 'array',
    ];
}
