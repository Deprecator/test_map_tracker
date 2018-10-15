<template>
    <div class="row">
        <div class="col col-5" id="treeList">

            <ul v-if="countryList.length">

                <li v-for="country in countryList">

                    <a href="#" @click.prevent="toggle('country', {id: country.data.id}, country.isOpen)">[{{ ((country.isOpen) ? '-' : '+') }}] {{country.data.name}} ({{country.data.clients_count}})</a>

                    <ul v-show="country.isOpen" v-if="cityList[country.data.id] !== undefined && cityList[country.data.id].length">

                        <li v-for="city in cityList[country.data.id]">
                            <a href="#" @click.prevent="toggle('city', {id: city.data.id, parentID: country.data.id}, city.isOpen)">[{{ ((city.isOpen) ? '-' : '+') }}] {{city.data.name}} ({{city.data.clients_count}})</a>
                            <ul v-show="city.isOpen" v-if="clientList[city.data.id] !== undefined && clientList[city.data.id].length">
                                <li v-for="client in clientList[city.data.id]">
                                    <a href="#" @click.prevent="toggle('client', {id: client.data.id, parentID: city.data.id}, false)">{{client.data.full_name}}</a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </li>
            </ul>
        </div>
        <div class="col col-7">
            <yandex-map
                    ref="ymap"
                    :coords="[0, 0]"
                    zoom="10"
                    style="width: 100%; height: 600px;"
                    :cluster-options="{}"
                    :behaviors="['default']"
                    :controls="['default']"
                    :placemarks="placeMarks"
                    map-type="map"
                    @map-was-initialized="initHandler"
            >
            </yandex-map>
        </div>
    </div>
</template>

<script>
    import http from 'vue-resource';

    const merge_objects = (obj1, obj2) => {
        let obj3 = {};
        for (let attrName in obj1) {
            obj3[attrName] = obj1[attrName];
        }
        for (let attrName in obj2) {
            obj3[attrName] = obj2[attrName];
        }
        return obj3;
    };

    const getNestedValue = (obj, path) => {
        let originalPath = path;
        path = path.split('.');
        let res = obj;
        for (let i = 0; i < path.length; i++) {
            res = res[path[i]]
        }
        if(typeof res === 'undefined') {
            console.log(`[TrackComponent] Response doesn't contain key ${originalPath}!`);
        }
        return res;
    };

    export const utils = { merge_objects, getNestedValue };

    export default {
        name: 'TrackComponent',
        props: {
            resourceUrl: {
                type: String,
                required: true
            },
            custom_template : '',
            options: {
                type: Object,
                required: false,
                default () {
                    return {};
                }
            }
        },
        data () {
            return {
                countryList: [],
                cityList: {},
                clientList: {},
                trackingList: {},
                placeMarks: [],
                routePoints: [],
                yMap: {},
                route: {},
                currentCountry: 0,
                currentCity: 0,
                currentClient: 0,
                config: {
                    remoteData: 'data',
                    countryListUrl: '/api/country',
                    cityListUrl: '/api/city/{countryID}',
                    clientListUrl: '/api/client/list/{cityID}',
                    trackingListUrl: '/api/tracking/{clientID}',
                    clientInfoUrl: '/api/client/{clientID}'
                }
            };
        },
        computed: {
            //
        },
        watch: {
            clientList () {
                this.populatePlaceMarks();
            },
            trackingList () {
                this.populateRoutePoints();
            }
        },
        methods: {
            initGeoList () {
                this.loadCountyList();
            },
            toggle (type, opts, isOpen) {
                if(type === 'country') {
                    if(!isOpen) {
                        this.loadCityList(opts.id);
                    }

                    this.$set(this, 'countryList', this.countryList.map(c => {
                        return {
                            isOpen: ((opts.id === c.data.id) ? !isOpen : c.isOpen),
                            data: c.data
                        };
                    }));
                } else if(type === 'city') {
                    if(!isOpen) {
                        this.loadClientList(opts.id);
                    }

                    this.$set(this.cityList, this.currentCountry, this.cityList[this.currentCountry].map(c => {
                        return {
                            isOpen: ((opts.id === c.data.id) ? !isOpen : c.isOpen),
                            data: c.data
                        };
                    }));
                } else if(type === 'client') {
                    this.loadTrackingList(opts.id, opts.parentID);
                }
            },
            loadCountyList () {
                this.fetchData(this.config.countryListUrl, {
                    type: 'country_list',
                    dataObj: 'countryList'
                });
            },
            loadCityList (countryID) {
                this.currentCountry = countryID;
                this.fetchData(this.config.cityListUrl.replace(/{countryID}/g, countryID), {
                    type: 'city_list',
                    dataObj: 'cityList',
                    dataKey: countryID
                });
            },
            loadClientList (cityID) {
                this.currentCity = cityID;
                this.placeMarks = [];
                this.routePoints = [];

                let callBackList = [];

                if(this.clientList[cityID] !== undefined) {
                    callBackList.push(this.populatePlaceMarks);
                }

                this.fetchData(this.config.clientListUrl.replace(/{cityID}/g, cityID), {
                    type: 'client_list',
                    dataObj: 'clientList',
                    dataKey: cityID,
                    callBackList: callBackList
                });
            },
            loadTrackingList (clientID, cityID) {
                this.currentClient = clientID;
                this.routePoints = [];

                let callBackList = [];

                if(this.currentCity !== cityID) {
                    this.currentCity = cityID;
                    callBackList.push(this.populatePlaceMarks);
                }

                if(this.trackingList[clientID] !== undefined) {
                    callBackList.push(this.populateRoutePoints);
                }

                this.fetchData(this.config.trackingListUrl.replace(/{clientID}/g, clientID), {
                    type: 'tracking_list',
                    dataObj: 'trackingList',
                    dataKey: clientID,
                    callBackList: callBackList
                });
            },
            fetchData (url, typeOpts) {
                this.$emit('request_start');
                url = url || this.resourceUrl;
                let self = this,
                    config = {};
                if(this.config.headers) {
                    config.headers = this.config.headers;
                }
                this.$http.get(url, config)
                    .then(function (response) {
                        self.$emit('request_finish', response);
                        self.handleResponseData(response.data, typeOpts);
                    }).catch(function (response) {
                        self.$emit('request_error', response);
                        console.log('Fetching data failed.', response);
                    });
            },
            handleResponseData (response, typeOpts) {
                let data = utils.getNestedValue(response, this.config.remoteData),
                    self = this;

                if(typeOpts.dataKey !== undefined) {
                    self.$set(self[typeOpts.dataObj], typeOpts.dataKey, data.map(d => {
                        return {
                            isOpen: false,
                            data: d
                        };
                    }));
                } else {
                    self[typeOpts.dataObj] = data.map(d => {
                        return {
                            isOpen: false,
                            data: d
                        };
                    });
                }

                this.$emit(typeOpts.type + '_loaded', data);

                this.$emit('update', data);

                if(typeOpts.callBackList !== undefined && typeOpts.callBackList.length) {
                    typeOpts.callBackList.forEach(cb => {
                        if(typeof cb === 'function') {
                            cb();
                        }
                    });
                }
            },
            initHandler (yMap) {
                this.yMap = yMap;
                this.$emit('map_initialized', yMap);
            },
            populatePlaceMarks () {
                let placeMarks = [],
                    self = this;

                if(self.clientList && self.clientList[self.currentCity]) {
                    this.clientList[self.currentCity].forEach(c => {
                        if (typeof c.data.latest_client_tracking === 'object' && c.data.latest_client_tracking !== null) {
                            placeMarks.push({
                                properties: {
                                    balloonContent: `<h4 class="text-center">${c.data.full_name}</h4>
                                    <br>
                                    <p>Последнее обновление координат:<br>${c.data.updated_at}</p>
                                    <br>
                                    <a href="#" class="btn btn-info" id="routeButton${c.data.id}" data-id="${c.data.id}">Маршрут</a>`,
                                    iconCaption: c.data.full_name
                                },
                                options: {},
                                coords: [c.data.latest_client_tracking.coordinates_LON, c.data.latest_client_tracking.coordinates_LAT],
                                clusterName: '',
                                callbacks: {
                                    balloonopen(e) {
                                        let routeButton = document.querySelector('#routeButton' + c.data.id);
                                        if (routeButton) {
                                            document.querySelector('#routeButton' + c.data.id).addEventListener('click', function (event) {
                                                event.preventDefault();
                                                self.loadTrackingList(c.data.id);
                                            });
                                        }
                                    },
                                    balloonclose(e) {
                                        // remove route
                                    }
                                },
                                balloonTemplate: ''
                            });
                        }
                    });

                    self.placeMarks = placeMarks;
                }
            },
            populateRoutePoints () {
                let routePoints = [];

                this.trackingList[this.currentClient].forEach(t => {
                    routePoints.push([t.data.coordinates_LON, t.data.coordinates_LAT]);
                });

                this.$set(this, 'routePoints', routePoints);

                this.makeRoute();
                //this.populatePlaceMarks();

                //this.$forceUpdate();
            },
            makeRoute () {
                let self = this,
                    viaIndexes = [];

                if(self.routePoints.length > 2) {
                    viaIndexes = [...self.routePoints].splice(1, (self.routePoints.length - 2)).map(el => {
                        return self.routePoints.indexOf(el);
                    });
                }

                self.yMap.geoObjects.remove(self.route);

                self.route = new ymaps.multiRouter.MultiRoute({
                    referencePoints: self.routePoints,
                    params: ((viaIndexes.length) ? {viaIndexes: viaIndexes} : {})
                }, {
                    wayPointStartIconColor: '#333',
                    wayPointStartIconFillColor: '#B3B3B3',
                    viaPointIconRadius: 7,
                    viaPointIconFillColor: '#000088',
                    viaPointActiveIconFillColor: '#E63E92',
                    viaPointVisible: false,

                    pinIconFillColor: '#000088',
                    pinActiveIconFillColor: '#B3B3B3',
                    // pinVisible:false,

                    routeStrokeWidth: 2,
                    routeStrokeColor: '#000088',
                    routeActiveStrokeWidth: 6,
                    routeActiveStrokeColor: '#E63E92',

                    routeActivePedestrianSegmentStrokeStyle: 'solid',
                    routeActivePedestrianSegmentStrokeColor: '#00CDCD',

                    boundsAutoApply: true
                });

                self.yMap.geoObjects.add(self.route);
            }
        },
        created () {
            this.initGeoList();
        },
        updated () {
            this.$nextTick(function () {
                let self = this;

                if(self.routePoints.length) {
                    self.makeRoute();
                } else if(self.placeMarks.length) {
                    self.yMap.setBounds(self.yMap.geoObjects.getBounds());
                }
            })
        }
    }
</script>

<style scoped>

</style>