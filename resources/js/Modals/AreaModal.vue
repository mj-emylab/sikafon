<template>
    <div>
         <modal ref="woModal" modal-class-name="AddArea" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>{{ addOrUpdate ? 'Edit' : 'Add' }}</b></span>
                    </h2>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <!-- <i class="fa fa-window-close"></i> -->
                    <span>&times;</span>
                </button>
            </template>
            <template>

                <form @submit.prevent="saveData" id="myForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>


                    

                    <gmap-map ref="map" @click="clicked"
                        :center="{ lat: mapData.lat, lng: mapData.lng }"
                        :zoom="12"
                        map-type-id="roadmap"
                        style="width: 100%; height: 400px">
                        <GmapMarker v-if="mapData" :position="mapData" label="S"/>
                    </gmap-map>

                    <div class="col-md-12 mb-3">
                        <label><b>District</b></label>
                        <v-select
                            :options="getDistricts"
                            :label="'name'"
                            :reduce="getDistricts => getDistricts.id"
                            v-model="formData.district_id"
                            placeholder="Select District">

                            <template #search="{attributes, events}">
                                <input
                                    class="vs__search"
                                    :required="!formData.district_id"
                                    v-bind="attributes"
                                    v-on="events" />
                            </template>
                        </v-select>
                    </div>

                    <div class="row mt-3 mb-3">
                        
                        
                        <div class="col-md-12">
                            <custom-input
                                :label="'Name'"
                                v-model="formData.name"
                                :required="true"
                                type="text"
                                placeholder="Enter name"/>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label><b>Description</b></label>
                            <textarea
                                placeholder="Enter Description"
                                cols="30"
                                class="form-control"
                                rows="3"
                                style="resize:none"
                                v-model="formData.description"
                                required
                            ></textarea>
                        </div>

                    </div>


                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="myForm" type="submit" title="Click to save data" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span>Save</span>
                </button>
            </template>
         </modal>
    </div>
</template>
<script>
import Modal from "../components/CustomModal.vue";
import helper from '../helpers/helpers';
import { createNamespacedHelpers } from 'vuex';
import CustomInput from '../components/CustomInput.vue';
const { mapActions, mapGetters } = createNamespacedHelpers('administration');

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,


            formData: {
                id: 0,
                name: "",
                lat: 7.777799446548184,
                long: -1.756994012507438,
                district_id: 0,
                
                description: '',

            },
        }
    },
    methods: {
        ...mapActions(['updateAreaAction', 'saveAreaAction', 'allAreaAction', 'allDistrictAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            // helper.openModal(".AddArea");
            $(".AddArea").modal('show');
        },

        openEditModal(row) {
            this.clearData();
            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description;
            this.formData.district_id= row.district_id;



            this.addOrUpdate = true;
            helper.openModal(".AddArea");
            // $(".AddArea").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddArea");
            // $(".AddArea").modal('hide');
        },

        clearData(){
            this.formData.id = "";
            this.formData.name = "";
            this.formData.description= "";
            this.formData.district_id = 0;
            this.geolocation();
        },

        
        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateAreaAction(data).then((res) => {
                    this.saveLoading = false;
                    helper.successAlert("Updated Successfully");
                    this.clearData()
                    this.hideModal();
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            } else {
                const data = this.formData;
                this.saveAreaAction(data).then((res) => {
                    this.saveLoading = false;
                    this.allAreaAction();
                    this.hideModal();
                    helper.successAlert("Created Successfully");
                    this.clearData()
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            }

        },

        clicked(e) {
           this.formData.lat = e.latLng.lat();
           this.formData.long = e.latLng.lng();
        },

        geolocation (){
            navigator.geolocation.getCurrentPosition((position) => {
                this.formData.lat =  position.coords.latitude
                this.formData.long = position.coords.longitude
            });
        }

    },
    created() {
        if (!this.addOrUpdate) {
            this.geolocation()
        }
        this.allDistrictAction()
    },
    computed: {
        ...mapGetters(['getDistricts']),

        mapData() {
            return {
                lat: parseFloat(this.formData.lat),
                lng: parseFloat(this.formData.long),
            };
        }
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
