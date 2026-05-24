<template>
    <div>
        <modal ref="woModal" modal-class-name="User" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h4><span><b>User Profile</b></span></h4>
                    <div class="col-12 form-group flex-fill" v-if="showImage1">
                        <img :src="showImage1" alt="Image"
                            class="img img-thumbnail" style="width: 80px; height: 80px">
                    </div>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <!-- <i class="fa fa-window-close"></i> -->
                    <span>&times;</span>
                </button>
            </template>
            <template v-if="show">
                <form @submit.prevent="updateUser" id="profileForm">

                    <loading
                        :active="pIsLoading"
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

                    <div id="printDiv" class="row">

                        <div class="col-md-12">
                           <custom-input v-model="user.first_name"
                                label="First Name"
                                type="text"
                                :disabled="true"
                                placeholder="Enter first name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.middle_name"
                                label="Last Name"
                                type="text"
                                :disabled="true"
                                placeholder="Enter last name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.last_name"
                                label="Last Name"
                                type="text"
                                :disabled="true"
                                placeholder="Enter last name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.email"
                                label="Email Address"
                                type="email"
                                :disabled="true"
                                placeholder="Enter email address"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.findMeId"
                                label="Findme ID"
                                type="text"
                                :disabled="true"
                                placeholder="Enter Findme ID"/>
                        </div>
                        <div class="col-md-12">
                            <custom-input v-model="user.area"
                                label="Area"
                                type="text"
                                :disabled="true"
                                placeholder="Enter Area"/>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label><b>Phone number</b></label>
                            <vue-tel-input @validate="checkNumber" v-bind="vueTelProps" v-model="user.phone"></vue-tel-input>
                            
                        </div>
                        <div class="col-md-12 mb-3" id="num_val" style="display:none">
                            <span id="num_error" class="text-danger "></span>
                        </div>

                        <div>
                            <custom-input
                                :label="'latitude'"
                                v-model="user.lat"
                                :required="true"
                                type="text"
                                :disabled="true"
                                placeholder="Enter latitude"/>
                        </div>
                        <div>
                            <custom-input
                                :label="'Longitude'"
                                v-model="user.long"
                                type="text"
                                :required="true"
                                :disabled="true"
                                placeholder="Enter Longitude"/>
                        </div>

                    </div>

                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button @click.prevent="printDetail" title="Click to print data" class="btn btn-primary">
                    <i class="fa fa-print"></i>
                    <span>Print</span>
                </button>
            </template>
        </modal>
    </div>
</template>
<script>
import Modal from "../components/CustomModal.vue";
import helper from '../helpers/helpers';
import CustomInput from '../components/CustomInput.vue';

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            pIsLoading: false,

            vueTelProps: {
                // mode: "international",
                defaultCountry: "GH",
                disabledFetchingCountry: true,
                disabled: true,
                // disabledFormatting: false,
                placeholder: "Enter a phone number",
                required: true,
                // enabledCountry_code: false,
                // enabledFlags: true,
                preferredCountries: ["GH", "NG"],
                // invalidMsg: "Wrong number",
                // onlyCountries: [],
                // ignoredCountries: [],
                // autocomplete: "off",
                // name: "telephone",
                // maxLen: 25,
                // wrapperClasses: "",
                // inputClasses: "",
                // dropdownOptions: {
                //   disabledDial_code: false
                // },
                // inputOptions: {
                //   showDial_code: false
                // }
            },

            showImage: [],
            showImage1: "",
            show:false,

            user: {
                id: 0,
                email: "",
                phone: '',
                area: '',
                country: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                findMeId: '',
                country_code: '',
                dial_code: '',
                lat: 7.777799446548184,
                long: -1.756994012507438,
                pic: '',


            },
        }


    },
    methods: {

        editModal(row){
            this.user= {};
            this.show = false;

            this.user.id = row.id;
            this.user.first_name = row.first_name;
            this.user.middle_name = row.middle_name;
            this.user.last_name = row.last_name;
            this.user.email = row.email;
            this.user.phone = row.phone;
            this.user.country_code = row.country_code;
            this.user.dial_code = row.dial_code;
            this.user.country = row.country;
            this.user.findMeId = row.findme_id;
            this.user.lat = row.lat;
            this.user.long = row.long;
            this.user.pic = row.pic;
            this.showImage1 = row.pic;

            this.show = true;

            helper.openModal('.User');
        },

        hideModal() {
            helper.hideModal('.User');
            this.show = false;
        },

        checkNumber(){},

        clicked(e) {
            //    this.user.lat = e.latLng.lat();
            //    this.user.long = e.latLng.lng();
        },

        printDetail() {
            printJSData({
                printable: 'printDiv',
                scanStyles: true,
                targetStyles: ['*'],
                type: 'html',
                header: 'User Detail',
                headerStyle: 'font-size: 2em; font-weight: bolder; text-align: center; text-decoration: underline; margin-bottom:30px',
                maxWidth: 1200,
                documentTitle: 'Egal GH'
            });
        },

    },

    created() {

    },
    computed: {
        mapData() {
            return {
                lat: parseFloat(this.user.lat),
                lng: parseFloat(this.user.long),
            };
        }
    },
    
}
</script>
<style scoped>

</style>
