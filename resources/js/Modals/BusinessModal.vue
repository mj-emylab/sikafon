<template>
    <div>
        <modal ref="woModal" modal-class-name="AddBusiness" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="bussinessForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>


                    <div class="row">
                        <div class="col-3" v-if="showImage.length > 0">
                            <img v-for="(show, index) in showImage" :key="index" :src="show" alt="Image"
                                class="img img-thumbnail" style="width: 70px; height: 70px">
                            <span class="ml-3">New</span>
                        </div>
                        <div class="col-3" v-if="addOrUpdate">
                            <img :src="showUpdateImage" alt="Image"
                                class="img img-thumbnail" style="width: 70px; height: 70px">
                            <span class="ml-3">Old</span>
                        </div>
                    </div>

                    <gmap-map ref="map" @click="clicked"
                        :center="{ lat: mapData.lat, lng: mapData.lng }"
                        :zoom="12"
                        map-type-id="roadmap"
                        style="width: 100%; height: 400px">
                        <GmapMarker v-if="mapData" :position="mapData" label="S"/>
                    </gmap-map>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-12 mb-3">
                            <label><b>Category</b></label>
                            <v-select
                                :options="categories"
                                :label="'name'"
                                :reduce="categories => categories.id"
                                v-model="formData.category_id"
                                placeholder="Select Category">

                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        :required="!formData.category_id"
                                        v-bind="attributes"
                                        v-on="events" />
                                </template>
                            </v-select>
                        </div>
                        <div>
                            <custom-input
                                :label="'Name'"
                                v-model="formData.name"
                                :required="true"
                                type="text"
                                placeholder="Enter name"/>
                        </div>
                        <div v-if="!addOrUpdate">
                            <custom-input
                                :label="'Store URL'"
                                v-model="formData.store"
                                :required="true"
                                type="text"
                                placeholder="Enter store link"/>
                        </div>
                        <div>
                            <custom-input
                                :label="'Email'"
                                v-model="formData.email"
                                :required="true"
                                type="email"
                                placeholder="Enter email"/>
                        </div>
                        <div>
                            <custom-input
                                :label="'Address'"
                                v-model="formData.address"
                                :required="true"
                                type="text"
                                placeholder="Enter address"/>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label><b>Phone number</b></label>
                            <vue-tel-input @validate="checkNumber" v-bind="vueTelProps" v-model="formData.phone"></vue-tel-input>
                            
                        </div>
                        <div class="col-md-12 mb-3" id="num_val" style="display:none">
                            <span id="num_error" class="text-danger "></span>
                        </div>

                        <div v-if="!addOrUpdate" class="col-md-12">
                            <custom-input
                                :label="'FindMe ID'"
                                v-model="formData.business_code"
                                :required="true"
                                type="text"
                                @input="checkName"
                                placeholder="Enter findme ID"/>
                        </div>
                        <div v-if="!addOrUpdate" class="col-md-12">
                            <custom-input
                                :label="'Agent FindMe ID without (e-)'"
                                v-model="formData.agent"
                                :required="true"
                                type="text"
                                @input="checkName"
                                placeholder="Enter agent findme ID"/>
                        </div>
                        <div v-if="!addOrUpdate" class="col-md-12 mb-3" id="guess" style="display:none">
                            <p id="guess_msg" class="text-warning"></p>
                            <p id="guess_name" class="text-warning"></p>
                        </div>

                        <div>
                            <custom-input
                                :label="'latitude'"
                                v-model="formData.lat"
                                :required="true"
                                type="text"
                                :disabled="true"
                                placeholder="Enter latitude"/>
                        </div>
                        <div>
                            <custom-input
                                :label="'Longitude'"
                                v-model="formData.long"
                                type="text"
                                :required="true"
                                :disabled="true"
                                placeholder="Enter Longitude"/>
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
                        
                        <div>
                            <label><b>Upload Picture</b></label>
                            <wo-file-uploader
                            :variant="'danger'"
                            :size="size"
                            @onUpload="uploadFiles"/>

                        </div>

                    </div>


                    <hr>
                    <div class="mt-3">
                        <div class="row" v-for="(field, index) in formData.social" :key="index">
                            <div class="col-md-5">
                                <label><b>Select Media</b></label>
                                <v-select
                                    :options="socials"
                                    :label="'name'"
                                    :reduce="socials => socials.id"
                                    v-model="field.media_id"
                                    placeholder="Select Media"/>
                            </div>
                            <div class="col-md-6">
                                <custom-input
                                    :label="'Url'"
                                    v-model="field.link"
                                    type="text"
                                    placeholder="Enter Link"
                                />

                            </div>
                            <div class="col-md-1 mt-4">
                                <a href="" title="Click to delete input fields" @click.prevent="removeField(index)">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </form>
            </template>
            <template slot="footer">
                <button class="btn btn-success btn-sm float-left mr-1" title="Show add social media input fields" @click.prevent="addMore()">
                    <i class="fa fa-plus"></i> more
                </button>
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="bussinessForm" type="submit" title="Click to save data" class="btn btn-primary">
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
import WoFileUploader from '../components/WoFileUploader.vue';
const { mapActions, mapGetters } = createNamespacedHelpers('system');
const { mapActions: mapActionsAdmin, mapGetters: mapGettersAdmin } = createNamespacedHelpers('administration');

export default {
    components: {
        Modal,
        CustomInput,
        WoFileUploader,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,
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

            // categories: [
            //     {id:1, name: 'artisans'},
            //     {id:2, name: 'mobiles'},
            //     {id:3, name: 'transport'}
            // ],

            socials: [
                {id:1, name: 'facebook'},
                {id:2, name: 'instagram'},
                {id:3, name: 'tweeter'}
            ],


            formData: {
                id: 0,
                name: "",
                country: '',
                lat: 7.777799446548184,
                long: -1.756994012507438,
                country_code: '',
                dial_code: '',
                phone: '',
                phone2: '',
                email: '',
                address: '',
                image: '',
                description: '',
                category_id: '',
                business_code: '',
                genId: '',
                store: '',
                agent: '',

                social: [
                    {id: 0, media_id: 0, link: ''}
                ],

            },
            showImage: [],
            showUpdateImage: "",

            userStatus: 0,
            userName:{
                name: ''
            },
        }
    },
    methods: {
        ...mapActions(['updateBusinessAction', 'saveBusinessAction', 'allBusinessAction', 'userNameAction']),
        ...mapActionsAdmin(['allCategoryAction']),

        openAddModal() {
            this.clearData();

            this.addOrUpdate = false;
            helper.openModal(".AddBusiness");
            // $(".AddBusiness").modal('show');
        },

        addMore() {
            this.formData.social.push({
                id: 0,
                media_id: 0,
                link: ""
            });
        },

        removeField(index) {
            this.formData.social.splice(index, 1)
        },

        openEditModal(row) {
            this.clearData();

            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.country= row.country,
            this.formData.lat= row.lat? row.lat : 7.777799446548184;
            this.formData.long= row.long? row.long : -1.756994012507438;
            this.formData.country_code= row.country_code;
            this.formData.dial_code= row.dial_code;
            this.formData.address= row.address;
            this.formData.business_code= row.business_code;
            this.formData.genId= row.business_code;
            this.formData.store= row.store;
            this.formData.agent= row.agent? row.agent.findme_id : '';

            // this.formData.image = row.image;
            if(row.business_pic) {
              this.showUpdateImage = row.business_pic;
            }

            this.formData.description= row.about,
            this.formData.phone= row.phone,
            this.formData.email= row.email,

            this.formData.category_id= row.category_id,

            this.formData.social = [];
            row.social.forEach(item => this.formData.social.push({
                id: item.id,
                media_id: item.name,
                link: item.link
            }));



            this.addOrUpdate = true;
            helper.openModal(".AddBusiness");
            // $(".AddBusiness").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddBusiness");
            // $(".AddBusiness").modal('hide');
        },

        clearData(){
            this.size = 'col-12';
            this.formData.id = "";
            this.formData.name = "";
            this.formData.country = "";
            // this.formData.lat= "";
            // this.formData.long= "";
            this.geolocation();

            this.formData.agent= "";
            this.formData.business_code= "";
            this.userName.name = "";
            this.userStatus = 0;
            this.genId= '';
            this.formData.store= '';

            // this.formData.country_code= row.country_code;
            // this.formData.dial_code= row.dial_code;
            this.formData.address= "";
            this.formData.image= "";
            this.formData.description= "";
            this.formData.phone= "";
            this.formData.email= "";
            this.formData.category_id= "";

            this.showImage = [];

            this.formData.social= [
                {id: 0, media_id: 0, link: ''}
            ];
        },

        checkNumber({ number, isValid, country }){
            // console.log(number, isValid, country);

            // this.formData.country = country.name
            // this.formData.dial_code = country.dialCode
            // this.formData.country_code = country.iso2

            this.formData.country = country? country.name: '';
            this.formData.dial_code = country ? country.dialCode: ''
            this.formData.country_code = country ? country.iso2: ''

            var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

            if(this.formData.phone != ''){
                if(this.formData.phone.length < 10){
                
                    document.getElementById("num_val").style.display = "block";
                    $('#num_error').html('invalid contact')
                }else{

                    if(re.test(this.formData.phone)){
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

            

            // console.log(this.formData.country_code, this.formData.dial_code, this.formData.country);

        },

        checkName(){
            var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

            if(this.formData.business_code == ''){
                document.getElementById("guess").style.display = "block";
                $('#guess_msg').html('Please enter code')
                this.userStatus = 1;
            }else{
                if(this.formData.business_code.length < 3){
                    document.getElementById("guess").style.display = "block";
                    $('#guess_msg').html('Code should be more than three letters')
                    this.userStatus = 1;
                }else{

                    var space = this.formData.business_code.split(' ');
                    var hyphen = this.formData.business_code.split('-');
                    // console.log(space.length+ '   ---  '+ hyphen.length)
                    // console.log(space)
                    // console.log(hyphen)

                    if (space.length < 2 && hyphen.length < 2) {
                        if(re.test(this.formData.business_code)){
                            document.getElementById("guess").style.display = "block";
                            $('#guess_msg').html('Code should have letters')
                            this.userStatus = 1;
                        }else{

                            $('#guess_msg').html('')
                            this.userStatus = 0
                            document.getElementById("guess").style.display = "none";

                            //send req
                            // var uname = this.user.business_code.toUpperCase()
                            var uname = this.formData.business_code.toLowerCase()
                            var genId  = 'e-'+uname;

                            // this.userName.name = genId;
                            this.userName.name = this.formData.business_code;

                            this.userNameAction(this.userName).then((res) => {
                                // helpers.successAlert("Name granted");
                                // console.log(this.getUserName)

                                if(this.getUserName.status == 0){
                                    document.getElementById("guess").style.display = "none";
                                    $('#guess_msg').html('')
                                    this.userStatus = 0;

                                    this.formData.genId = genId
                                    // helper.successAlert("Name granted");
                                }else{
                                document.getElementById("guess").style.display = "block";
                                    $('#guess_msg').html(this.getUserName.msg)
                                    $('#guess_name').html('Please try: '+this.getUserName.guess)
                                    // helper.successAlert("Name not available");
                                    this.userStatus = 1;
                                }

                            }).catch((error) => {
                                
                                // helper.errorMessage(error);
                                this.userStatus = 1;
                            });
                        }
                    } else {
                        document.getElementById("guess").style.display = "block";
                        $('#guess_msg').html("Code shouldn't have white space or hyphen!!!")
                        this.userStatus = 1;
                    }

                }
            }
        },

        uploadFiles(file){
            if(file){
                this.formData.image = helper.uploadFileUsingComponent(file);
                this.showImage = helper.previewImageComponent(this.formData.image);
                this.formData.image = file;
                this.size = 'col-11';
            }else{
                this.size = 'col-12';
                this.formData.image = null;
                this.showImage = [];
            }
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateBusinessAction(data).then((res) => {
                    this.saveLoading = false;
                    helper.successAlert("Updated Successfully");
                    this.clearData()
                    this.hideModal();
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            } else {

                if (this.userStatus == 0) {
                    if(this.formData.agent != '') {
                        this.formData.agent = 'e-'+this.formData.agent;
                    }
                    
                    const data = this.formData;
                    this.saveBusinessAction(data).then((res) => {
                        this.saveLoading = false;
                        this.hideModal();
                        helper.successAlert("Created Successfully");
                        this.clearData()
                    }).catch((error) => {
                        this.saveLoading = false;
                        helper.errorMessage(error);
                    });
                } else {
                    helper.errorAlert("Code not accepted regenerate another one");
                }
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
        this.allCategoryAction()
    },
    computed: {
        ...mapGetters(['getBusinesses', 'getUserName']),
        ...mapGettersAdmin(['getCategories']),
        categories(){
            let cat = this.getCategories.filter((value) =>value.type == 'business');
            return cat;
        },

        mapData() {
            return {
                lat: parseFloat(this.formData.lat),
                lng: parseFloat(this.formData.long),
            };
        }
    },
    mounted() {

    },

    beforeDestroy() {
        
    },
    destroyed() {
        
    },
}
</script>
<style scoped>

</style>
