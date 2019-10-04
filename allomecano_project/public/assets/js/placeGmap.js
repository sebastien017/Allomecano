var placeSearch, autocomplete, geocoder;

var isPlaceChanged = false;

function initAutocomplete() {
  var options = {
    componentRestrictions: {country: 'fr'}
};
  geocoder = new google.maps.Geocoder();
  autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('user_input_autocomplete_address')), {
      types: ['geocode'],
      options
    });

  autocomplete.addListener('place_changed', fillInAddress);
}

function codeAddress(address) {
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == 'OK') {
      // This is the lat and lng results[0].geometry.location
      isPlaceChanged = true
      $('#gps-coord').val(results[0].geometry.location)
      $('#user_gps').val(results[0].geometry.location)
      $('#garage_gps').val(results[0].geometry.location)
      //  alert(results[0].geometry.location.lng)
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


$(function () {
  $("#user_input_autocomplete_address").keydown(function () {
      isPlaceChanged = false;
  });

  $("#button").click(function () {
      if (!isPlaceChanged) {
          $("#user_input_autocomplete_address").val('');
          //alert("Merci de choisir une adresse dans la liste déroulante");
      }
  });
});