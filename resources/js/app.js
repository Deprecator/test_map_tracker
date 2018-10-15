
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const TrackComponent = Vue.component('track-component', require('./components/TrackComponent.vue'));

//const {TrackComponent} = require('./components/TrackComponent.vue');
const { yandexMap } = require('vue-yandex-maps');

//Vue.component('track-component', TrackComponent);

const app = new Vue({
    el: '#app',
    components: {
        TrackComp: TrackComponent,
        yandexMap
    },
    data: {},
    methods: {
        updateCountryList (data) {
            // console.log(this.countryList);
            // this.countryList = data;
            // console.log(this.countryList);
        },
        updateCityList (data) {
            this.cityList = data;
        },
        updateClientList (data) {
            // add placemarks marking the clients
            this.clientList = data;
        },
        updateTrackingList (data) {
            // make routes and center the map on the selected client
            this.trackingList = data;
        },
        initHandler (yMap) {
            //this.yMap = yMap;
        }
    }
});
