<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 15 Oct 2018 10:57:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\Traits\GeoTrait;

/**
 * Class City
 * 
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Country $country
 * @property \Illuminate\Database\Eloquent\Collection $clients
 *
 * @package App\Models
 */
class City extends Eloquent
{
    use GeoTrait;

	protected $table = 'city';

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'name',
		'country_id'
	];

	protected $pointColumns = [
	    'coordinates'
    ];

	public function country() {
		return $this->belongsTo(Country::class);
	}

	public function clients() {
		return $this->hasMany(Client::class);
	}

    /**
     * @param int $countryID
     *
     * @return \Illuminate\Database\Eloquent\Collection|City[]
     */
    public static function getAll(int $countryID = 0) {
        $query = (self::query())->withCount('clients');

        if($countryID) {
            $query = $query->where('country_id', '=', $countryID);
        }

        return $query->get();
    }
}
