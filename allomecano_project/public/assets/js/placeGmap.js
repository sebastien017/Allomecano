var placeSearch, autocomplete, geocoder;

function initAutocomplete() {
  geocoder = new google.maps.Geocoder();
  autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('user_input_autocomplete_address')), {
      types: ['geocode']
    });

  autocomplete.addListener('place_changed', fillInAddress);
}

function codeAddress(address) {
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == 'OK') {
      // This is the lat and lng results[0].geometry.location
      $('#gps-coord').val(results[0].geometry.location)
      // alert(results[0].geometry.location);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function fillInAddress() {
  var place = autocomplete.getPlace();

  codeAddress(document.getElementById('user_input_autocomplete_address').value);
}