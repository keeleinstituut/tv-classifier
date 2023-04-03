<?php

namespace App\Models;

use App\Enums\ClassifierValueType;
use App\Traits\Uuid;
use Database\Factories\ClassifierValueFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ClassifierValue
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property ClassifierValueType $type
 * @property string $value
 * @property string $name
 * @property array|null $meta
 * @method static ClassifierValueFactory factory($count = null, $state = [])
 * @method static Builder|ClassifierValue newModelQuery()
 * @method static Builder|ClassifierValue newQuery()
 * @method static Builder|ClassifierValue onlyTrashed()
 * @method static Builder|ClassifierValue query()
 * @method static Builder|ClassifierValue whereCreatedAt($value)
 * @method static Builder|ClassifierValue whereDeletedAt($value)
 * @method static Builder|ClassifierValue whereId($value)
 * @method static Builder|ClassifierValue whereMeta($value)
 * @method static Builder|ClassifierValue whereName($value)
 * @method static Builder|ClassifierValue whereType($value)
 * @method static Builder|ClassifierValue whereUpdatedAt($value)
 * @method static Builder|ClassifierValue whereValue($value)
 * @method static Builder|ClassifierValue withTrashed()
 * @method static Builder|ClassifierValue withoutTrashed()
 * @mixin Eloquent
 */
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
