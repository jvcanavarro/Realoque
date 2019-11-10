var geocoder;
var map;
var address = "68400000";

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 11 ,
    center: {lat: -34.397, lng: 150.644}
    });
    geocoder = new google.maps.Geocoder();
    codeAddress(geocoder, map);
}

function codeAddress(geocoder, map) {
    geocoder.geocode({'address': address}, function(results, status) {
    if (status === 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
        });
    } else {
        alert('Geocode was not successful for the following reason: ' + status);
    }
    });
}

function load(index){

    $.ajax({

        url : `http://localhost:5000/index/${index}`,
        crossDomain: true,
        type: 'get',
    
        erro : (xhr, status, error) => console.log(error),
    
        success : (sample) => {

            console.log(sample);
            
    
            
            let sampleCOntainer = document.getElementsByClassName('sample')[0]

            let tit = document.createElement('h2')
            tit.innerHTML = 'Imóvel em '+sample.municipio

            let end = document.createElement('h3')
            end.innerHTML = '<i class="fas fa-map-marker-alt"></i> '+sample.endereco




            let blocks = [tit, end]

            for (let i of blocks) sampleCOntainer.appendChild(i)

            address = sample.endereco;

            initMap()
            
        }
    });

}


