<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};
use Illuminate\Support\Facades\DB;

trait GeoTrait
{
    protected static function boot() {
        if(method_exists(parent::class, 'boot')) {
            parent::boot();
        }

        if(method_exists(static::class, 'addGlobalScope')) {
            static::addGlobalScope(new class implements Scope {
                public function apply(Builder $builder, Model $model) {
                    if($builder->getQuery()->columns === null || count($builder->getQuery()->columns) === 0) {
                        $builder->select(['*']);
                    }

                    /** @var array $pointColumns */
                    $pointColumns = $model->getPointColumns();

                    if(count($pointColumns) > 0) {
                        $selectColumns = [];
                        foreach ($pointColumns AS $pointColumn) {
                            $selectColumns[] = 'ST_X(' . $pointColumn . ') AS ' . $pointColumn . '_LON';
                            $selectColumns[] = 'ST_Y(' . $pointColumn . ') AS ' . $pointColumn . '_LAT';
                            $selectColumns[] = 'ST_AsText(' . $pointColumn . ') AS ' . $pointColumn;
                        }

                        $builder->addSelect(DB::raw(implode(', ', $selectColumns)));
                    }
                }
            });
        }
    }

    /**
     * @return array
     */
    public function getPointColumns() {
        return ((property_exists($this, 'pointColumns') && is_array($this->pointColumns)) ? $this->pointColumns : []);
    }
}