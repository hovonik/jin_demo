import './bootstrap';

window.base_url = 'http://jin30.am';

$('.visible i').click(function () {
    let icon = $(this);
    let item_id = $(this).data('item-id');
    let action = '';
    if ($(this).hasClass('product')) {
        action = 'products';
    } else if ($(this).hasClass('profession')) {
        action = 'professions';
    }else if ($(this).hasClass('category')) {
        action = 'categories';
    }
    let is_visible = +$(this).hasClass('fa-eye');
    $.ajax({
        url: base_url + `/${action}/${item_id}/visible`,
        method: 'POST',
        data: {
            is_visible: is_visible
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (is_visible) {
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }, error: function (err) {
            alert('Փործել ավելի ուշ');
        }
    });
})

$('.item-del-btn').on('click', function () {
    let item_id = $(this).data('item-id');
    let action = '';
    if ($(this).hasClass('product')) {
        action = 'products';
    } else if ($(this).hasClass('shop')) {
        action = 'shops';
    } else if ($(this).hasClass('page')) {
        action = 'pages';
    } else if ($(this).hasClass('service')) {
        action = 'services';
    } else if ($(this).hasClass('user')) {
        action = 'users';
    } else if ($(this).hasClass('master')) {
        action = 'master-verification-requests';
    } else if ($(this).hasClass('custom_field')) {
        action = 'custom-fields';
    } else if ($(this).hasClass('profession')) {
        action = 'professions';
        if ($(this).hasClass('parent')) {
            alert("Հիշեք ջնջվում են նաև իրեն պատկանող մասնագիտությունները!");
        }
    }else if ($(this).hasClass('category')) {
        action = 'categories';
        if ($(this).hasClass('parent')) {
            alert("Հիշեք ջնջվում են նաև իրեն պատկանող կատեգորիաները!");
        }
    }
    if (confirm('Դուք համոզված եք?')) {
        $.ajax({
            url: base_url + `/${action}/${item_id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.success) {
                    $('#main-div').prepend(`<div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    ${data.message}
                                    </div>`);
                    $(`[data-item-id = ${item_id}]`).remove();
                    if ($('tr').length <= 1) {
                        location.reload();
                    }
                } else {
                    $('#main-div').prepend(`<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                     ${data.error}
                                    </div>`);
                }
                setTimeout(function () {
                    $('.alert.alert-dismissible').hide();
                }, 5000)
            }, error: function (err) {
                alert('Попробуйте позже.');
            }
        });
    }
})

$('#main_image').on('input', function () {
    $('#main_image_preview').attr('src', URL.createObjectURL(event.target.files[0]));
})

$('body').on('click', 'span.remove', function () {
    let image_id = $(this).data('image-id');
    if ($(this).hasClass('new-image')) {
        const dt = new DataTransfer();
        let current_image_id = $(this).data('current-id');
        dt.items.remove(current_image_id);
        $(`div.image-${image_id}`).remove();
        return;
    }
    $.ajax({
        url: base_url + `/image/${image_id}`,
        method: 'DELETE',
        data: {
            image_id: image_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $(`div.image-${image_id}`).remove();
        }, error: function (err) {
            alert('Փործել ավելի ուշ');
        }
    });
})

var imagesPreview = function (input, placeToInsertImagePreview) {

    if (input.files) {
        let last_image_id = +$('.last_image_id').val();
        if (last_image_id == 0) {
            last_image_id = 999999;
        }
        var filesAmount = input.files.length;

        for (let i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            let html = '';
            reader.onload = function (event) {
                html += `<div class="image-${last_image_id}"><span data-current-id="${i}" class="remove new-image" data-image-id="${last_image_id}">X</span>`;
                html += `<img src="${event.target.result}" width="128" height="128"></div>`;
                $('.images').append(html);
                $('.last_image_id').val(last_image_id);
                last_image_id++;
            }

            reader.readAsDataURL(input.files[i]);
        }
    }

};

$('#images').on('change', function () {
    imagesPreview(this, 'div.images');
});

$('.request-form button').click(function () {
    let request_id = $('.request-id').val();
    if (!request_id) {
        return;
    }
    let accept;
    let reason = '';
    if ($(this).hasClass('accept')) {
        accept = 1;
    } else if ($(this).hasClass('reject')) {
        accept = 0;
        do {
            reason = prompt('Խնդրում ենք մուտքագրել պատճառը:');
        } while (reason !== null && reason === "")
        if (reason === null) {
            return;
        }
    }
    console.log(accept)
    $.ajax({
        url: base_url + `/master-verification-requests/${request_id}`,
        method: 'PUT',
        data: {
            accept: accept,
            reason: reason
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            alert('Գործողությունը հաջողությամբ կատարվել է։');
            window.location.reload();
        }, error: function (err) {
            alert('Փործել ավելի ուշ');
        }
    });
})
let i = 0;
$('.add_custom_field').click(function () {
    let custom_field_view = $('.custom_fields_view').clone().addClass(`custom_field_added`).removeClass('custom_fields_view').removeClass('d-none');
    $(this).before(custom_field_view);
    i++;
})

$('.product button[type=submit]').click(function (e) {
    let i = 0;
    $('.custom_field_added input').each(function (index) {
        if (!$(this).val()) {
            $(this).css('border', '1px solid red');
            if (i === 0) {
                alert('Խնդրում ենք լրացրեք բոլոր հավելյալ ինֆորմացիաները կամ ջնջեք!');
                i++;
            }
            e.preventDefault();
        }
    });
})

$('body').on('click', '.delete_custom_field', function () {
    $(this).parent().remove();
})

$('body').on('change', '.custom_field_added input', function () {
    $(this).css('border', '1px solid')
})

window.initMap = initMap;

// function initMap() {
//     var myLatlng = new google.maps.LatLng(40.158522, 44.520138);
//     var mapOptions =
//         {
//             zoom: 13,
//             center: myLatlng,
//             mapTypeId: google.maps.MapTypeId.ROADMAP
//         }
//
//     var map = new google.maps.Map(document.getElementById('map'), mapOptions);
//     var transitLayer = new google.maps.TransitLayer();
//     transitLayer.setMap(map);
//     google.maps.event.addListener(map, "click", function (event) {
//         processMarkerClick(event.latLng);
//     });
//
// var directions = {};
// var directionsDisplay = new google.maps.DirectionsRenderer();
// var directionsService = new google.maps.DirectionsService();
//
// // geoxml3 configuration
// var geoXml = new geoXML3.parser({
//     map: map,
//     createMarker: createMarker,
//     singleInfoWindow: true
// });
//
// // handle the directions service
// function processMarkerClick(latLng) {
//     if (!directions.start) {
//         directions.start = latLng;
//     } else if (!directions.end) {
//         directions.end = latLng;
//         directionsService.route({
//                 origin: directions.start,
//                 destination: directions.end,
//                 travelMode: google.maps.TravelMode.DRIVING
//             },
//             function (result, status) {
//                 if (status == google.maps.DirectionsStatus.OK) {
//                     let distance = result.routes[0].legs[0].distance.value
//                     let start_address = result.routes[0].legs[0].start_address
//                     let end_address = result.routes[0].legs[0].end_address
//                     directionsDisplay.setDirections(result);
//                     directionsDisplay.setMap(map);
//
//                 } else {
//                     alert("Directions Request failed:" + status);
//                 }
//                 directions.start = null;
//                 directions.end = null;
//             });
//     }
// }
//
// // custom createMarker function to add hook for the directions service
// // (modified from the version in the geoxml3 source)
// var createMarker = function (placemark, doc) {
//     // create a Marker to the map from a placemark KML object
//
//     // Load basic marker properties
//     var markerOptions = geoXML3.combineOptions(geoXml.options.markerOptions, {
//         map: geoXml.options.map,
//         position: new google.maps.LatLng(placemark.Point.coordinates[0].lat, placemark.Point.coordinates[0].lng),
//         title: placemark.name,
//         zIndex: Math.round(placemark.Point.coordinates[0].lat * -100000) << 5,
//         icon: placemark.style.icon,
//         shadow: placemark.style.shadow,
//     });
//
//     // Create the marker on the map
//     var marker = new google.maps.Marker(markerOptions);
//     if (!!doc) {
//         doc.markers.push(marker);
//     }
//
//     // Set up and create the infowindow if it is not suppressed
//     if (!geoXml.options.suppressInfoWindows) {
//         var infoWindowOptions = geoXML3.combineOptions(geoXml.options.infoWindowOptions, {
//             content: '<div class="geoxml3_infowindow"><h3>' +
//                 placemark.name +
//                 '</h3><div>' +
//                 placemark.description +
//                 '</div></div>',
//             pixelOffset: new google.maps.Size(0, 2)
//         });
//
//         if (geoXml.options.infoWindow) {
//             marker.infoWindow = geoXml.options.infoWindow;
//         } else {
//             marker.infoWindow = new google.maps.InfoWindow(infoWindowOptions);
//         }
//         marker.infoWindowOptions = infoWindowOptions;
//
//         // Infowindow-opening event handler
//         google.maps.event.addListener(marker, 'click', function () {
//             processMarkerClick(marker.getPosition());
//             this.infoWindow.close();
//             marker.infoWindow.setOptions(this.infoWindowOptions);
//             this.infoWindow.open(this.map, this);
//         });
//     }
//     placemark.marker = marker;
//     return marker;
// };
// }



function initMap() {
    if(!document.getElementById("map")){
        return;
    }
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: { lat: 40.177025, lng: 44.512654 }, // Australia.
    });
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        draggable: true,
        map,
    });

    directionsRenderer.addListener("directions_changed", () => {
        const directions = directionsRenderer.getDirections();

        if (directions) {
            computeTotalDistance(directions);
        }
    });

    if($('.order-edit').length){
        console.log({lat: +$('#end_lat').val(), lng: +$('#end_lng').val()});
        displayRoute(
            {lat: +$('#start_lat').val(), lng: +$('#start_lng').val()},
            {lat: +$('#end_lat').val(), lng: +$('#end_lng').val()},
            directionsService,
            directionsRenderer
        );
    }
    $('#shop_id').on('change', function(){
        $('#map').removeClass('d-none');
        const shop_id = $(this).val();
        let lat = parseFloat($(`#lat-${shop_id}`).val());
        let long = parseFloat($(`#long-${shop_id}`).val());
        displayRoute(
            {lat: lat, lng: long},
            {lat: 40.230151, lng: 44.569336},
            directionsService,
            directionsRenderer
        );
    })
}

function displayRoute(origin, destination, service, display) {
    service
        .route({
            origin: origin,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING,
            avoidTolls: true,
        })
        .then((result) => {
            display.setDirections(result);
        })
        .catch((e) => {
            alert("Could not display directions due to: " + e);
        });
}

function computeTotalDistance(result) {
    let total = 0;
    const myroute = result.routes[0];

    if (!myroute) {
        return;
    }
    let lat = 0;
    let lng = 0;
    let end_address = '';

    for (let i = 0; i < myroute.legs.length; i++) {
        total += myroute.legs[i].distance.value;
        lat = myroute.legs[i].end_location.lat()
        lng = myroute.legs[i].end_location.lng()
        end_address = myroute.legs[i].end_address
        $('#lat').val(lat)
        $('#lng').val(lng)
        $('#address').text(end_address)
        $('.address').val(end_address)
    }

    total = Math.ceil(total / 1000);
    $('#shipping_km').text(total);
    $('.shipping_km').val(total);
    let courier_shipping_price = +$('#courier_shipping_price').val(), shipping_price = 0;
    let courier_shipping_min_price = +$('#courier_shipping_min_price').val();
    let courier_shipping_min_km = +$('#courier_shipping_min_km').val();

    if(total <= courier_shipping_min_km){
        shipping_price = courier_shipping_min_price;
    }else{
        total = (total - courier_shipping_min_km);
        shipping_price = courier_shipping_min_price + (total * courier_shipping_price);
    }

    $('#shipping_price').text(shipping_price);
    $('.shipping_price').val(shipping_price);
}
