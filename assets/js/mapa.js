/**
 * Created by Matte on 25/05/2017.
 */
var geocoder;
var map;
var marker;
var autocomplete;

var componentFormTr = {
    street_number: 'numero',
    route: 'logradouro',
    locality: 'cidade',
    administrative_area_level_1: 'uf',
    sublocality_level_1: 'bairro',
    country: 'pais',
    postal_code: 'cep'
};
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    sublocality_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initialize() {

    var latitude = document.getElementById('latitude').value ;
    var longitude = document.getElementById('longitude').value ;
    var initZoom = 16;
    if ((latitude==0) &&(longitude==0)){
        latitude = -3.1190275
        longitude= -60.02173140000002;
        initZoom = 13;
    }
    var latlng = new google.maps.LatLng(latitude,longitude);
    var options = {
        zoom: initZoom,
        center: latlng  //,
        //mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
    });

    marker.setPosition(latlng);
};
function initAutocomplete() {
    $('#pesquisa').parent().addClass('focused');
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('pesquisa')),
        {types: ['geocode']});

    autocomplete.addListener('place_changed', fillInAddress);
}
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    var latitude = place.geometry.location.lat();
    var longitude = place.geometry.location.lng();

    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;

    var location = new google.maps.LatLng(latitude, longitude);
    marker.setPosition(location);
    map.setCenter(location);
    map.setZoom(16);

    for (var component in componentForm) {
        document.getElementById(componentFormTr[component]).value = '';
        document.getElementById(componentFormTr[component]).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        for (var j = 0; j < place.address_components[i].types.length; j++) {
            var addressType = place.address_components[i].types[j];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(componentFormTr[addressType]).value = val;
                $('#' + componentFormTr[addressType]).parent().addClass('focused');
            }
        }
    }
}

$(document).ready(function () {
    initialize();

    google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var place = results[0];

                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();
                    console.log('latitude:',latitude);
                    console.log('longitude:',longitude);
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    for (var component in componentForm) {
                        document.getElementById(componentFormTr[component]).value = '';
                        document.getElementById(componentFormTr[component]).disabled = false;
                    }
                    for (var i = 0; i < place.address_components.length; i++) {
                        for (var j = 0; j < place.address_components[i].types.length; j++) {
                            var addressType = place.address_components[i].types[j];
                            if (componentForm[addressType]) {
                                var val = place.address_components[i][componentForm[addressType]];
                                document.getElementById(componentFormTr[addressType]).value = val;
                                $('#' + componentFormTr[addressType]).parent().addClass('focused');
                            }
                        }
                    }
                }
            }
        });
    });
});