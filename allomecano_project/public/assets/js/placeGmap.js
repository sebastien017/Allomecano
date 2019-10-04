var placeSearch, autocomplete, geocoder;

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


var currentAddress = {
  line_1: "",
  line_2: "",
  zipcode: "",
  city: "",
  country: "",
  lat: "",
  lng: "",
  one_liner: ""
};

function fillInAddress() {
  var place = this.autocomplete.getPlace();
  // reset the address
  currentAddress = {
      line_1: "",
      line_2: "",
      zipcode: "",
      city: "",
      country: "",
      lat: "",
      lng: "",
      one_liner: place.formatted_address
  };
  // store relevant info in currentAddress
  var results = place.address_components.reduce(function(prev, current) {
      prev[current.types[0]] = current['long_name'];
      return prev;
  }, {})
  if (results.hasOwnProperty('route')) {
      currentAddress.line_1 = results.route;
  }
  if (results.hasOwnProperty('street_number')) {
      currentAddress.line_1 = results.street_number + " " + currentAddress.line_1;
  }
  if (results.hasOwnProperty('postal_code')) {
      currentAddress.zipcode = results.postal_code;
  }
  if (results.hasOwnProperty('locality')) {
      currentAddress.city = results.locality;
  }
  if (results.hasOwnProperty('country')) {
      currentAddress.country = results.country;
  }
  currentAddress.lat = Number(place.geometry.location.lat()).toFixed(6);
  currentAddress.lng = Number(place.geometry.location.lng()).toFixed(6);
}

$('#user_input_autocomplete_address').blur(function() {
  var address = $('#user_input_autocomplete_address').val();
  // we set a timeout to prevent conflicts between blur and place_changed events
  var timeout = setTimeout(function() {
      // release timeout
      clearTimeout(timeout);
      if (address !== currentAddress.one_liner) {
          $('#user_input_autocomplete_address').val(currentAddress.one_liner);
      }
  }, 500);
});