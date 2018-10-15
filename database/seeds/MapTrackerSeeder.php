<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapTrackerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $createdAt = date('Y-m-d H:i:s');
        $createdAtHandler = function($lastTimeStamp) {
            return $lastTimeStamp;
        };

        $data = [
            [
                'table' => 'country',
                'data' => [
                    'name' => 'США',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt
                ],
                'children' => [
                    [
                        'table' => 'city',
                        'data' => [
                            'name' => 'Нью-Йорк',
                            'country_id' => [
                                'handler' => function($foreignID) {
                                    return $foreignID;
                                },
                                'arg' => 'countryID'
                            ],
                            'coordinates' => DB::raw('PointFromText("POINT(40.71598 -74.002881)")'),
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt
                        ],
                        'children' => [
                            [
                                'table' => 'client',
                                'data' => [
                                    'full_name' => 'Фамилия5 Имя5 Отчество5',
                                    'email' => str_random(10).'@example.com',
                                    'phone' => '88005553535',
                                    'city_id' => [
                                        'handler' => function($foreignID) {
                                            return $foreignID;
                                        },
                                        'arg' => 'cityID'
                                    ],
                                    'created_at' => $createdAt,
                                    'updated_at' => $createdAt
                                ]
                            ]
                        ]
                    ],
                    [
                        'table' => 'city',
                        'data' => [
                            'name' => 'Вашингтон',
                            'country_id' => [
                                'handler' => function($foreignID) {
                                    return $foreignID;
                                },
                                'arg' => 'countryID'
                            ],
                            'coordinates' => DB::raw('PointFromText("POINT(38.899513 -77.036527)")'),
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt
                        ]
                    ]
                ]
            ],
            [
                'table' => 'country',
                'data' => [
                    'name' => 'Россия',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt
                ],
                'children' => [
                    [
                        'table' => 'city',
                        'data' => [
                            'name' => 'Москва',
                            'country_id' => [
                                'handler' => function($foreignID) {
                                    return $foreignID;
                                },
                                'arg' => 'countryID'
                            ],
                            'coordinates' => DB::raw('PointFromText("POINT(55.753215 37.622504)")'),
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt
                        ],
                        'children' => [
                            [
                                'table' => 'client',
                                'data' => [
                                    'full_name' => 'Фамилия1 Имя1 Отчество1',
                                    'email' => str_random(10).'@example.com',
                                    'phone' => '88005553535',
                                    'city_id' => [
                                        'handler' => function($foreignID) {
                                            return $foreignID;
                                        },
                                        'arg' => 'cityID'
                                    ],
                                    'created_at' => $createdAt,
                                    'updated_at' => $createdAt
                                ],
                                'children' => [
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.752536 37.626295)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.746114 37.622876)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.746719 37.619969)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.745406 37.616482)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            //
                            [
                                'table' => 'client',
                                'data' => [
                                    'full_name' => 'Фамилия2 Имя2 Отчество2',
                                    'email' => str_random(10).'@example.com',
                                    'phone' => '88005553535',
                                    'city_id' => [
                                        'handler' => function($foreignID) {
                                            return $foreignID;
                                        },
                                        'arg' => 'cityID'
                                    ],
                                    'created_at' => $createdAt,
                                    'updated_at' => $createdAt
                                ],
                                'children' => [
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.745175 37.590943)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.744304 37.588453)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(55.741036 37.587767)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            //
                            [
                                'table' => 'client',
                                'data' => [
                                    'full_name' => 'Фамилия6 Имя6 Отчество6',
                                    'email' => str_random(10).'@example.com',
                                    'phone' => '88005553535',
                                    'city_id' => [
                                        'handler' => function($foreignID) {
                                            return $foreignID;
                                        },
                                        'arg' => 'cityID'
                                    ],
                                    'created_at' => $createdAt,
                                    'updated_at' => $createdAt
                                ]
                            ]
                        ]
                    ],
                    //
                    [
                        'table' => 'city',
                        'data' => [
                            'name' => 'Санкт-Петербург',
                            'country_id' => [
                                'handler' => function($foreignID) {
                                    return $foreignID;
                                },
                                'arg' => 'countryID'
                            ],
                            'coordinates' => DB::raw('PointFromText("POINT(59.939095 30.315868)")'),
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt
                        ],
                        'children' => [
                            [
                                'table' => 'client',
                                'data' => [
                                    'full_name' => 'Фамилия3 Имя3 Отчество3',
                                    'email' => str_random(10).'@example.com',
                                    'phone' => '88005553535',
                                    'city_id' => [
                                        'handler' => function($foreignID) {
                                            return $foreignID;
                                        },
                                        'arg' => 'cityID'
                                    ],
                                    'created_at' => $createdAt,
                                    'updated_at' => $createdAt
                                ],
                                'children' => [
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(59.91518 30.304834)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(59.911624 30.313331)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(59.903994 30.321485)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            //
                            [
                                'table' => 'client',
                                'data' => [
                                    'full_name' => 'Фамилия4 Имя4 Отчество4',
                                    'email' => str_random(10).'@example.com',
                                    'phone' => '88005553535',
                                    'city_id' => [
                                        'handler' => function($foreignID) {
                                            return $foreignID;
                                        },
                                        'arg' => 'cityID'
                                    ],
                                    'created_at' => $createdAt,
                                    'updated_at' => $createdAt
                                ],
                                'children' => [
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(59.884828 30.361163)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(59.870787 30.3781)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ],
                                    [
                                        'table' => 'client_tracking',
                                        'data' => [
                                            'client_id' => [
                                                'handler' => function($foreignID) {
                                                    return $foreignID;
                                                },
                                                'arg' => 'clientID'
                                            ],
                                            'coordinates' => DB::raw('PointFromText("POINT(59.870468 30.373519)")'),
                                            'created_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ],
                                            'updated_at' => [
                                                'handler' => $createdAtHandler,
                                                'arg' => 'lastTimeStamp'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        DB::beginTransaction();

        foreach($data AS $countryInd => $country) {
            $countryID = DB::table($country['table'])->insertGetId($country['data']);
            if(array_key_exists('children', $country) && is_array($country['children'])) {
                foreach ($country['children'] AS $cityInd => $city) {
                    $cityID = DB::table($city['table'])->insertGetId(array_map(function($v) use($countryID) {
                        if(is_array($v)) {
                            return $v['handler'](${$v['arg']});
                        }

                        return $v;
                    }, $city['data']));
                    if(array_key_exists('children', $city) && is_array($city['children'])) {
                        foreach ($city['children'] AS $clientInd => $client) {
                            $clientID = DB::table($client['table'])->insertGetId(array_map(function($v) use($cityID) {
                                if(is_array($v)) {
                                    return $v['handler'](${$v['arg']});
                                }

                                return $v;
                            }, $client['data']));
                            if(array_key_exists('children', $client) && is_array($client['children'])) {
                                $lastTimeStamp = $createdAt;
                                foreach ($client['children'] AS $trackingInd => $tracking) {
                                    $lastTimeStamp = (new DateTime($lastTimeStamp))->modify('+10 minutes')->format('Y-m-d H:i:s');
                                    $trackingID = DB::table($tracking['table'])->insertGetId(array_map(function($v) use($lastTimeStamp, $clientID) {
                                        if(is_array($v)) {
                                            return $v['handler'](${$v['arg']});
                                        }

                                        return $v;
                                    }, $tracking['data']));
                                }
                            }
                        }
                    }
                }
            }
        }

        DB::commit();
    }
}
