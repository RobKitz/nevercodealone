var mapLocation = new google.maps.LatLng(51.938609, 7.627828); //change coordinates here
var marker;
var map;

function initialize() {
    var mapOptions = {
        zoom: 17, //change zoom here
        center: mapLocation,
				scrollwheel: false
    };
    
    map = new google.maps.Map(document.getElementById('map-canvas'), 
    mapOptions);
    
    var image = '/bundles/app/conference/img/flag.png';
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        title: 'InfluencerDB',
        icon: image,
        animation: google.maps.Animation.DROP,
        animation: google.maps.Animation.BOUNCE,
        position: mapLocation
    });
    google.maps.event.addListener(marker, 'click', toggleBounce);
}

function toggleBounce() {
    
    if (marker.getAnimation() != null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

google.maps.event.addDomListener(window, 'load', initialize);
