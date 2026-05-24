<template>
    <div>
        <!-- <gmap-map ref="map" @click="clicked"
            :center="{ lat: lat, lng: long }"
            :zoom="12"
            map-type-id="roadmap"
            style="width: 100%; height: 400px"
        >
            <GmapMarker v-if="mapData" :position="mapData" label="S"/>
        </gmap-map> -->


        <gmap-map ref="map"
                :center="{ lat: coordinates.lat, lng: coordinates.lng }"
                :zoom="12"
                map-type-id="roadmap"
                class="form-group"
                style="width: 100%; height: 400px">
            <GmapMarker 
                v-if="coordinates" 
                :position="coordinates"
                :clickable="true"
                @click="showInfo(coordinates)"
                label="C">

                <GmapInfoWindow
                    :closeclick="true"
                    @closeclick="showInfo(null)"
                    :options="options"
                    :opened="selectedId === coordinates">
                    <div>
                        <span>emjay</span>
                    </div>
                </GmapInfoWindow>

            </GmapMarker>

        </gmap-map>
    </div> 
</template>
<script>
    export default {
        props: {
            long: {
                type: String,
                default: '-1.756994012507438'
            },
            lat: {
                type: String,
                default: '7.777799446548184'
            },
        },
        data() {
            return {
                selectedId: null,
                options: {
                    maxWidth: 700,
                    maxHeight: 500,
                },
            }
        },
        methods: {
            clicked(e) {
                
            },

            showInfo(data) {
                console.log('data', data)
                console.log('id', this.selectedId)
                // this.selectedId = !data ? null :data.id
            }
        },
        mounted() {
            
        },
        created() {
            this.coordinates
        },
        computed: {
            coordinates() {
                return {
                    lat: parseFloat(this.lat),
                    lng: parseFloat(this.long),
                };
            },
        },

    }
</script>
<style scoped>

</style>
