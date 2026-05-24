<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <gmap-autocomplete class="form-control col-4"
                    @place_changed="setPlace">
                </gmap-autocomplete>
                <button class="btn btn-sm btn-success" @click="addMarker">Add</button>
                
            </div>
          <div class="card-body">
              <gmap-map
                :center="center"
                :zoom="12"
                style="width:100%;  height: 400px;"
                >
                    <gmap-marker
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        @click="center=m.position"
                    ></gmap-marker>
                </gmap-map>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
export default {
  name: "GoogleMap",
  data() {
    return {
      //Default setup
      center: { lat: 45.508, lng: -73.587 },
      markers: [],
      places: [],
      currentPlace: null
    };
  },

  mounted() {
    this.geolocate();
  },

  methods: {
    // receives a place object via the autocomplete component
    setPlace(place) {
      this.currentPlace = place;
    },
    addMarker() {
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        };
        this.markers.push({ position: marker });
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null;
      }
    },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      });
    }
  }
};
</script>
