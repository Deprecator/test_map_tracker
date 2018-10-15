<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 15 Oct 2018 10:57:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Client
 * 
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property int $city_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\City $city
 * @property \Illuminate\Database\Eloquent\Collection $clientTracking
 *
 * @package App\Models
 */
class Client extends Eloquent
{
	protected $table = 'client';

	protected $casts = [
		'city_id' => 'int'
	];

	protected $fillable = [
		'full_name',
		'email',
		'phone',
		'city_id'
	];

	public function city() {
		return $this->belongsTo(City::class);
	}

	public function clientTracking() {
		return $this->hasMany(ClientTracking::class);
	}

	public function latestClientTracking() {
	    return $this->hasOne(ClientTracking::class)
            ->latest('updated_at')
            ->orderByDesc('id');
    }

    /**
     * @param int $cityID
     * @param bool $withLastCoordinates
     *
     * @return \Illuminate\Database\Eloquent\Collection|City[]
     */
    public static function getAll(int $cityID = 0, bool $withLastCoordinates = false) {
        $query = self::query();

        if($cityID) {
            $query = $query->where('city_id', '=', $cityID);
        }

        if($withLastCoordinates === true) {
            $query->with('latestClientTracking');
        }

        return $query->get();
    }
}
