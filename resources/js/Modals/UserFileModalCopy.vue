<template>
    <div>
         <modal ref="woModal" modal-class-name="AddUserFile" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>{{ addOrUpdate ? 'Edit' : 'Add' }}</b></span>
                    </h2>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <span>&times;</span>
                </button>
            </template>
            <template>

                <form @submit.prevent="saveData" id="fileForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="col-md-12 flex-fill" v-if="images.length > 0">
                        <img v-for="(show, index) in images" :key="index" :src="show[0]" alt="Image" class="img img-thumbnail mr-2" style="width: 70px; height: 70px">
                    </div>
                    <!-- <div class="col-md-12 flex-fill" v-if="formData.images.length > 0">
                        <img v-for="(show, index) in formData.images" :key="index" :src="show.image" alt="Image" class="img img-thumbnail mr-2" style="width: 70px; height: 70px">
                    </div> -->

                    <div class="row mt-3 mb-3">
                        
                        <div>
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

                        <div class="col-md-12">
                            <label><b>Upload Gallery</b></label>
                            <image-uploader
                            :variant="'danger'"
                            @onUpload="uploadImages" :multiple="true"/>

                        </div>
                        
                        <div>
                            <label><b>Upload File</b></label>
                            <wo-file-uploader
                            :variant="'danger'"
                            :multiple="true"
                            @onUpload="uploadFiles"/>

                        </div>

                    </div>
                    <div class="row">
                        <vue-slick-carousel
                            v-bind="slickOptions"
                            v-if="filteredImages.length"
                            ref="carousel"
                            class="carousel"
                            @beforeChange="updateIndexOnDrag"
                            >
                            <div
                                class="work"
                                v-for="(img, i) in filteredImages"
                                :key="img.image"
                                @click="updateIndexOnClick(i)"
                            >
                                <div class="col-md-1 mt-4">
                                    <a href="" title="Click to delete image" @click.prevent="deleteImage(img, i)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </div>
                                <img :src="img.image" />
                            </div>
                        </vue-slick-carousel>
                    </div>
                    <div class="row">
                        <vue-slick-carousel
                            v-bind="slickOptions"
                            v-if="filteredFiles.length"
                            ref="carousel"
                            class="carousel"
                            @beforeChange="updateIndexOnDrag"
                            >
                            <div
                                class="work"
                                v-for="(img, i) in filteredFiles"
                                :key="img.image"
                                @click="updateIndexOnClick(i)"
                            >
                                <div class="col-md-1 mt-4">
                                    <a href="" title="Click to delete image" @click.prevent="deleteImage(img, i)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </div>
                                <img :src="img.image" />
                            </div>
                        </vue-slick-carousel>
                    </div>

                </form>
            </template>
            <template slot="footer">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="fileForm" type="submit" title="Click to save data" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span>Save</span>
                </button>
            </template>
         </modal>
    </div>
</template>
<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

import Modal from "../components/CustomModal.vue";
import helper from '../helpers/helpers';
import { createNamespacedHelpers } from 'vuex';
import CustomInput from '../components/CustomInput.vue';
import WoFileUploader from '../components/WoFilesUploader.vue';
import ImageUploader from '../components/WoFileUploader.vue';
const { mapActions, mapGetters } = createNamespacedHelpers('admistration');

export default {
    components: {
        Modal,
        CustomInput,
        VueSlickCarousel,
        WoFileUploader,
        ImageUploader,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,


            slickOptions: {
                slidesToShow: 1,
                accessibility: true,
                adaptiveHeight: false,
                dots: true,
                edgeFriction: 0.30,
                swipe: true,
                arrows: true,
                infinite: true,
                variableWidth: true,
                draggable: true,

                // fade: false,
                // autoplay:false,
                // autoplaySpeed: 200,
                // speed: 200,
                // pauseOnHover: false,
                // pauseOnFocus: false
            },


            formData: {
                id: 0,
                name: "",
                description: "",
                files: [],
                type: 'user',
                images: [],
                

            },
            images: [],
            filteredImages: [],
            filteredFiles: [],
            files: [],
        }
    },
    methods: {
        ...mapActions(['updateFileAction', 'saveFileAction']),

        openAddModal() {
            this.addOrUpdate = false;
            helper.openModal(".AddUserFile");
            // $(".AddUserFile").modal('show');
        },

        openEditModal(row) {
            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description,
            this.formData.file= '';
            this.formData.images = [];

            this.filteredImages = [];
            row.filteredImages.forEach(item => this.filteredImages.push({
                id: item.id,
                image: item.url
                
            }));

            this.files = [];
            row.files.forEach(item => this.files.push({
                id: item.id,
                image: item.url
                
            }));

            this.addOrUpdate = true;
            helper.openModal(".AddUserFile");
        },

        hideModal() {
            helper.hideModal(".AddUserFile");
            // $(".AddUserFile").modal('hide');
        },

        uploadImages(file){
            if(file.length > 0) {
                file.forEach(element => {
                    const images = helper.uploadFileUsingComponent(element);
                    const preview = helper.previewImageComponent(images);
                    this.images.push(preview);
                    this.formData.images.push(images);
                });
                // console.log(this.formData.images)
            } else {
                this.formData.images = [];
                this.images = [];
            }
        },

        deleteImage(row, index) {
            helper.deletingAlert("Product image " + row.name + " will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteProductImageAction(row)
                    .then((res) => {
                        this.isLoading = false;

                        this.filteredImages.splice(index, 1)//

                        helper.successAlert("Product image " + row.name + " deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        deleteFile(row, index) {
            helper.deletingAlert("Product image " + row.name + " will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteProductImageAction(row)
                    .then((res) => {
                        this.isLoading = false;

                        this.filteredImages.splice(index, 1)//

                        helper.successAlert("Product image " + row.name + " deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        clearData(){
            this.formData.id = "";
            this.formData.name = "";
            this.formData.description = "";
            this.formData.files = [];
            this.formData.images = [];
            this.filteredImages = [];
        },

        uploadFiles(file){
            // if(file){
            //     this.formData.file = helper.uploadAnyFileUsingComponent(file);
            //     this.formData.file = file;
            // }else{
            //     this.formData.file = null;
            // }

            if(file.length > 0) {
                file.forEach(element => {
                    const files = helper.uploadAnyFileUsingComponent(element);
                    const fPreview = helper.previewImageComponent(files);
                    this.files.push(fPreview);
                    this.formData.files.push(files);
                });
                // console.log(this.formData.files)
            } else {
                this.formData.files = [];
                this.files = [];
            }
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateFileAction(data).then((res) => {
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
                this.saveFileAction(data).then((res) => {
                    this.saveLoading = false;
                    this.hideModal();
                    helper.successAlert("Created Successfully");
                    this.clearData()
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            }

        },

        updateIndexOnDrag(){},

    },
    created() {
        
    },
    computed: {
        ...mapGetters([]),
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
