<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 15 Oct 2018 10:57:13 +0000.
 */

namespace App\Models;

use App\Models\Traits\GeoTrait;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientTracking
 * 
 * @property int $id
 * @property int $client_id
 * @property point $coordinates
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Client $client
 *
 * @package App\Models
 */
class ClientTracking extends Eloquent
{
    use GeoTrait;

	protected $table = 'client_tracking';

	protected $casts = [
		'client_id' => 'int',
		'coordinates' => 'point'
	];

	protected $fillable = [
		'client_id',
		'coordinates'
	];

	protected $pointColumns = [
	    'coordinates'
    ];

	public function client() {
		return $this->belongsTo(Client::class);
	}

    /**
     * @param int $clientID
     * @param string $dateFrom
     * @param string $dateTo
     * @return \Illuminate\Database\Eloquent\Collection|ClientTracking[]
     */
	public static function getClientPathChain(int $clientID, string $dateFrom = '', string $dateTo = '') {
	    $dateFrom = trim($dateFrom);
	    $dateTo = trim($dateTo);

	    $dateFromObj = false;
	    $dateToObj = false;

	    $query = (self::query())->where('client_id', '=', $clientID);

        /**
         * @param \DateTime $date
         * @param string $dateStr
         *
         * @return \DateTime|false
         */
        $dateProcessor = function(\DateTime $date, string $dateStr) {
            if($dateStr !== '' && in_array(strlen($dateStr), [10, 16])) {
                $dateTimeParts = explode(' ', $dateStr);
                $dateParts = explode('-', $dateTimeParts[0]);

                if(count($dateParts) === 3) {
                    $date = $date->setDate($dateParts[0], $dateParts[1], $dateParts[2]);
                }

                if(count($dateTimeParts) === 2) {
                    $timeParts = explode(':', $dateTimeParts[1]);
                    $tpCount = count($timeParts);

                    if($tpCount > 1) {
                        $date = $date->setTime($timeParts[0], $timeParts[1], (($tpCount === 3) ? $timeParts[2] : 0));
                    }
                }
            }

            return $date;
        };

        if($dateFrom !== '') {
            $dateFromObj = $dateProcessor(
                (new \DateTime())->setTime(0, 0, 0),
                $dateFrom
            );
        }

        if($dateTo !== '') {
            $dateToObj = $dateProcessor(
                (new \DateTime())->setTime(23, 59, 59),
                $dateTo
            );
        }

        if($dateFromObj !== false && $dateToObj !== false) {
            $query->whereBetween('updated_at', [$dateFromObj->format('Y-m-d H:i:s'), $dateToObj->format('Y-m-d H:i:s')]);
        } elseif($dateFromObj !== false) {
            $query->where('updated_at', '>=', $dateFromObj->format('Y-m-d H:i:s'));
        } elseif($dateToObj !== false) {
            $query->where('updated_at', '<=', $dateToObj->format('Y-m-d H:i:s'));
        }

	    return $query->oldest('updated_at')->get();
    }
}
