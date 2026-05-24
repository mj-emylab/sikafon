<template>
    <div>
         <modal ref="woModal" modal-class-name="AddService" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="serviceForm">

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
                                v-model="formData.service_cat_id"
                                placeholder="Select Category">

                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        :required="!formData.service_cat_id"
                                        v-bind="attributes"
                                        v-on="events" />
                                </template>
                            </v-select>
                        </div>
                        <div class="col-md-12">
                            <custom-input
                                :label="'Name'"
                                v-model="formData.service_name"
                                :required="true"
                                type="text"
                                placeholder="Enter name"/>
                        </div>
                        <div class="col-md-12">
                            <custom-input
                                :label="'Price'"
                                v-model="formData.price"
                                :required="true"
                                type="number"
                                placeholder="Enter price"/>
                        </div>
                        <div class="col-md-12">
                            <custom-input
                                :label="'Address'"
                                v-model="formData.service_location"
                                :required="true"
                                type="text"
                                placeholder="Enter address"/>
                        </div>
                        <div v-if="!addOrUpdate" class="col-md-12">
                            <custom-input
                                :label="'FindMe ID'"
                                v-model="formData.service_code"
                                :required="true"
                                type="text"
                                @input="checkName"
                                placeholder="Enter findme ID"/>
                        </div>
                        <div v-if="!addOrUpdate" class="col-md-12 mb-3" id="guess" style="display:none">
                            <p id="guess_msg" class="text-warning"></p>
                            <p id="guess_name" class="text-warning"></p>
                        </div>

                        <div class="col-md-12">
                            <custom-input
                                :label="'latitude'"
                                v-model="formData.lat"
                                :required="true"
                                type="text"
                                :disabled="true"
                                placeholder="Enter latitude"/>
                        </div>
                        <div class="col-md-12">
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
                                v-model="formData.service_description"
                                required
                            ></textarea>
                        </div>
                        
                        <div class="col-md-12">
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
                <button form="serviceForm" type="submit" title="Click to save data" class="btn btn-primary">
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
                service_name: "",
                price: 0,
                lat: 7.777799446548184,
                long: -1.756994012507438,
                service_location: '',
                image: '',
                service_description: '',
                service_cat_id: '',
                service_code: '',
                genId: '',

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
        ...mapActions(['updateServiceAction', 'saveServiceAction', 'allServiceAction', 'userNameAction']),
        ...mapActionsAdmin(['allCategoryAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            // helper.openModal(".AddService");
            $(".AddService").modal('show');
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

        checkName(){
            var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

            if(this.formData.service_code == ''){
                document.getElementById("guess").style.display = "block";
                $('#guess_msg').html('Please enter code')
                this.userStatus = 1;
            }else{
                if(this.formData.service_code.length < 3){
                    document.getElementById("guess").style.display = "block";
                    $('#guess_msg').html('Code should be more than three letters')
                    this.userStatus = 1;
                }else{

                    var space = this.formData.service_code.split(' ');
                    var hyphen = this.formData.service_code.split('-');

                    if (space.length < 2 && hyphen.length < 2) {
                        if(re.test(this.formData.service_code)){
                            document.getElementById("guess").style.display = "block";
                            $('#guess_msg').html('Code should have letters')
                            this.userStatus = 1;
                        }else{

                            $('#guess_msg').html('')
                            this.userStatus = 0
                            document.getElementById("guess").style.display = "none";

                            //send req
                            // var uname = this.user.service_code.toUpperCase()
                            var uname = this.formData.service_code.toLowerCase()
                            var genId  = 'e-'+uname;

                            // this.userName.name = genId;
                            this.userName.name = this.formData.service_code;

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

        openEditModal(row) {
            this.clearData();
            this.formData.service_code= row.service_code;
            this.formData.genId= row.service_code;

            this.formData.id= row.id;
            this.formData.service_name= row.service_name;
            this.formData.service_location= row.service_location,
            this.formData.lat= row.lat;
            this.formData.long= row.long;
            this.formData.price= row.price;

            // this.formData.image = row.image;
            if(row.image) {
              this.showUpdateImage = row.image;
            }

            this.formData.service_description= row.service_description,

            this.formData.service_cat_id= row.service_cat_id,

            this.formData.social = [];
            row.social.forEach(item => this.formData.social.push({
                id: item.id,
                media_id: item.name,
                link: item.link
            }));



            this.addOrUpdate = true;
            helper.openModal(".AddService");
            // $(".AddService").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddService");
            // $(".AddService").modal('hide');
        },

        clearData(){
            this.size = 'col-12';
            this.formData.id = "";
            this.formData.service_name = "";
            this.formData.service_location = "";
            // this.formData.lat= "";
            // this.formData.long= "";
            this.geolocation();
            this.formData.service_description= "";
            this.formData.image= "";
            this.formData.service_cat_id= "";
            this.formData.price= "";
            this.formData.service_code= "";
            this.userName.name = "";
            this.userStatus = 0;
            this.genId= '';

            this.showImage = [];

            this.formData.social= [
                {id: 0, media_id: 0, link: ''}
            ];
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
                this.updateServiceAction(data).then((res) => {
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
                    const data = this.formData;
                    this.saveServiceAction(data).then((res) => {
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
        this.allServiceAction()
        this.allCategoryAction()
    },
    computed: {
        ...mapGetters(['getServices', 'getUserName']),
        ...mapGettersAdmin(['getCategories']),
        categories(){
            let cat = this.getCategories.filter((value) =>value.type == 'service');
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
}
</script>
<style scoped>

</style>
