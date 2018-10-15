<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 15 Oct 2018 10:57:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Country
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $cities
 *
 * @package App\Models
 */
class Country extends Eloquent
{
	protected $table = 'country';

	protected $fillable = [
		'name'
	];

	public function cities() {
		return $this->hasMany(\App\Models\City::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Country[]
     */
	public static function getAll() {
	    return (self::query())->select()->selectSub('SELECT COUNT(*) FROM client WHERE city_id IN(SELECT id FROM city WHERE country_id = country.id)', 'clients_count')->get();
    }
}
