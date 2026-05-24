<template>
    <div>
        <modal ref="woModal" modal-class-name="UserProfile" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h4><span><b>User Profile</b></span></h4>

                    <div class="col-12 form-group flex-fill" v-if="showImage.length > 0">
                        <img v-for="show in showImage" :key="show" :src="show" alt="Image"
                                class="img img-thumbnail" style="width: 80px; height: 80px">
                    </div>
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
            <template>
                <form @submit.prevent="saveProfile" id="profileForm">

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

                    <div class="row">

                        <div class="col-md-12">
                           <custom-input v-model="user.first_name"
                                label="First Name"
                                type="text"
                                placeholder="Enter first name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.middle_name"
                                label="Last Name"
                                type="text"
                                placeholder="Enter last name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.last_name"
                                label="Last Name"
                                type="text"
                                placeholder="Enter last name"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="user.email"
                                label="Email Address"
                                type="email"
                                placeholder="Enter email address"/>
                        </div>

                        <!-- <div class="col-md-12 mb-3">
                            <label><b>Select Country</b></label>
                            <v-select
                                :options="getCountries"
                                :label="'name'"
                                :reduce="getCountries => getCountries.id"
                                v-model="user.country_id"
                                placeholder="Select Country">
                                <template #search="{attributes, events}">
                                    <custom-input
                                        class="vs__search"
                                        :required="!user.country_id"
                                        v-bind="attributes"
                                        v-on="events" />
                                </template>
                            </v-select>
                        </div> -->

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
                                placeholder="Enter Area"/>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label><b>Phone number</b></label>
                            <vue-tel-input 
                                @validate="checkNumber" 
                                v-bind="vueTelProps" 
                                v-model="user.phone">
                            </vue-tel-input>
                            
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

                        <div class="form-group col-md-12">
                                <label><b>Add Profile Image</b></label>
                            <wo-file-uploader @onUpload="uploadProfile" :variant="'secondary'" :size="size"/>
                        </div>

                    </div>

                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="profileForm" type="submit" title="Click to save data" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span>Save</span>
                </button>
            </template>
        </modal>

        <modal ref="woModal" modal-class-name="UserPassword" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h4><span><b>User Password</b></span></h4>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hidePassModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <!-- <i class="fa fa-window-close"></i> -->
                    <span>&times;</span>
                </button>
            </template>
            <template>
                <form @submit.prevent="submitPassword" id="passwordForm">
                    <loading
                        :active="mIsLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row">
                        <div class="col-md-12">
                            <custom-input v-model="changePassword.findme_id"
                                label="Findme ID" :disabled="true"
                                type="text" placeholder="Findme ID"/>
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="changePassword.password"
                                label="Enter New Password" :id="'pass_new'"
                                type="password" placeholder="Enter Password" />
                        </div>

                        <div class="col-md-12">
                            <custom-input v-model="changePassword.confirmPassword"
                                label="Confirm New Password" :id="'pass_con'"
                                type="password" placeholder="Confirm Password" />
                        </div>

                        <div class="col-md-12">
                            <input type="checkbox" @change.prevent="showPassword" id="show_pass" />
                            <label class="ml-2" for="show_pass"> Show Password</label>
                        </div>
                    </div>
                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hidePassModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="passwordForm" type="submit" title="Click to save data" class="btn btn-primary">
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
import CustomInput from '../components/CustomInput.vue';
import WoFileUploader from '../components/WoFileUploader.vue';

import { createNamespacedHelpers } from 'vuex';
const {mapActions: adminMapActions } = createNamespacedHelpers('auth');
const { mapActions: mapActionsForSystem, mapGetters: mapGettersForSystem } = createNamespacedHelpers('system');

export default {
    components: {
        Modal,
        CustomInput,
        WoFileUploader,
    },
    data() {
        return {
            pIsLoading: false,
            mIsLoading: false,
            size: 'col-12',

            vueTelProps: {
                // mode: "international",
                defaultCountry: "GH",
                // disabledFetchingCountry: false,
                // disabled: false,
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
            changePassword:{
                confirmPassword: '',
                password: '',
                findme_id: ''
            },
            user: {
                id: 0,
                email: "",
                password: "",
                phone: '',
                area: '',
                country: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                findMeId: '',
                remember_me: false,
                country_code: '',
                dial_code: '',
                lat: 7.777799446548184,
                long: -1.756994012507438,
                pic: '',


            },
        }


    },
    methods: {
        ...adminMapActions(['updateUserProfile', 'updateUserPassAction']),
        ...mapActionsForSystem([]),

        showPassword() {
            helper.showPassword(document.getElementById("pass_new"));
            helper.showPassword(document.getElementById("pass_con"));
        },

        myProfile(){
            // console.log('profile')
            helper.openModal('.UserProfile');
        },

        hideModal() {
            helper.hideModal('.UserProfile');
        },

        myPassword() {
            helper.openModal('.UserPassword');
        },

        hidePassModal() {
            helper.hideModal('.UserPassword');
        },

        checkNumber({ number, isValid, country }){
            // console.log(number, isValid, country);

            this.user.country = country? country.name: '';
            this.user.dial_code = country ? country.dialCode: ''
            this.user.country_code = country ? country.iso2: ''

            var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

            if(this.user.phone != ''){
                if(this.user.phone.length < 10){
                
                document.getElementById("num_val").style.display = "block";
                $('#num_error').html('invalid contact')
                }else{

                    if(re.test(this.user.phone)){
                        document.getElementById("num_val").style.display = "none";
                        $('#num_error').html('')
                        // console.log('numbers')
                    }else{
                        
                        document.getElementById("num_val").style.display = "block";
                        $('#num_error').html('invalid contact')
                    }
                }
            }else{
                document.getElementById("num_val").style.display = "none";
                $('#num_error').html('')
            }

            

            // console.log(this.user.country_code, this.user.dial_code, this.user.country);

        },

        clicked(e) {
           this.user.lat = e.latLng.lat();
           this.user.long = e.latLng.lng();
        },

        uploadProfile(file){
            if(file) {
                this.user.pic = helper.uploadFileUsingComponent(file);
                this.showImage = helper.previewImageComponent(this.user.pic);
                this.showImage1 = null;
                this.size = 'col-11';
            } else {
                this.user.pic = null;
                this.showImage = [];
                this.showImage1 = this.user.pic;
                this.size = 'col-12';
            }
        },

        saveProfile() {
            this.pIsLoading = true;
            this.updateUserProfile(this.user)
            .then((res) => {
                this.pIsLoading = false;
                helper.successAlert("Updated");
            }).catch((error) => {
                this.pIsLoading = false;
                helper.errorMessage(error);
            }).finally(() => {
                $('.ShowProfile').modal('hide');
            });
        },

        submitPassword() {
            if(this.changePassword.confirmPassword !== this.changePassword.password){
               return helper.errorAlert("Confirm password don't match");
            }

            this.mIsLoading = true;
            let user = this.changePassword;

            this.updateUserPassAction(user)
            .then((res) => {
                this.mIsLoading = false;
                helper.successAlert("Updated");
            }).catch((error) => {
                this.mIsLoading = false;
                helper.errorMessage(error);
            }).finally(() => {
                $('.PasswordModal').modal('hide');
            });
        },

    },

    created() {
        this.showImage = [];
        // this.allContriesAction();

        const authUser = this.$store.getters['auth/user'];

        if(authUser) {
           this.user.id = authUser.id;
           this.user.first_name = authUser.first_name;
           this.user.middle_name = authUser.middle_name;
           this.user.last_name = authUser.last_name;
           this.user.email = authUser.email;
           this.user.phone = authUser.phone;
           this.user.country_code = authUser.country_code;
           this.user.dial_code = authUser.dial_code;
           this.user.country = authUser.country;
           this.user.findMeId = authUser.findme_id;
           this.user.lat = authUser.lat;
           this.user.long = authUser.long;

           this.showImage = [];
           this.user.pic = authUser.pic;
           this.showImage1 = authUser.pic;

           this.changePassword.findme_id = authUser.findme_id;
        }
    },
    computed: {
        ...mapGettersForSystem([]),
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
