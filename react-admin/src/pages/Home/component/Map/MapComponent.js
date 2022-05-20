import React from 'react';
import { Map, GoogleApiWrapper, Marker } from 'google-maps-react';

function MapComponent() {
    return (
        <div className='map-react'>
          <Map
            google = {window.google}
            style = {{width:'60%', height:'70%'}}
            zoom = {14}
            initialCenter = {
              {
                lat: 16.054407,
                lng: 108.202164 
              }
            }
          >
            <Marker 
              position={{lat:16.051740,lng:108.208520}}
            />
            <Marker 
              position={{lat:16.072550,lng:108.231500}}
            />
            <Marker 
              position={{lat:16.065500,lng:108.201280}}
            />
            <Marker 
              position={{lat:16.047440,lng:108.238890}}
            />
          </Map>
        </div>
    )
}

export default GoogleApiWrapper({
    apiKey:"AIzaSyCTV5MtXj4mnuMlwGJ3pYEDUxUAyMEJU5I"
})(MapComponent);