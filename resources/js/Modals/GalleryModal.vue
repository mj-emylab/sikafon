<template>
    <div>
        <modal ref="woModal" modal-class-name="AddGallery" :modalClasses="'modal-lg'">
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

                <form @submit.prevent="nothing" id="galleryForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3">
                        
                        
                        <div class="row">
                            <div class="col-md-12 flex-fill" v-if="fileRecordShow">
                                <img v-for="(show, index) in fileRecordShow" :key="index" :src="show[0]" alt="Image" class="img img-thumbnail mr-2" style="width: 70px; height: 70px">
                            </div>
                            <div class="col-md-12 flex-fill" v-if="fileRecords">
                                <img v-for="(show, index) in fileRecords" :key="index" :src="show.image" alt="Image" class="img img-thumbnail mr-2" style="width: 70px; height: 70px">
                            </div>
                            
                        </div>
                        <div class="row">
                            <label><b>Add Images</b></label>
                            <wo-file-uploader @onUpload="uploadImages" :variant="'secondary'" :multiple="true" :size="size"/>
                        </div>
                        <div class="row" style="margin-left:2px; margin-right:2px; padding-right:2px; padding-left:2px;">
                            <VueSlickCarousel
                                v-bind="slickOptions"
                                v-if="fileRecords.length"
                                ref="carousel"
                                class="carousel"
                                @beforeChange="updateIndexOnDrag"
                                >
                                <div
                                    class="work" style="margin-left:2px; margin-right:2px;"
                                    v-for="(img, i) in fileRecords"
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
                            </VueSlickCarousel>
                        </div>

                    </div>
                    
                </form>
            </template>
            <template slot="footer">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button @click.prevent="saveData" title="Click to save data" class="btn btn-primary">
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
const { mapActions, mapGetters } = createNamespacedHelpers('system');

import WoFileUploader from '../components/WoFileUploader.vue';
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    components: {
        Modal,
        CustomInput,
        WoFileUploader,
        VueSlickCarousel,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,
            size: 'col-12',

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
                autoplay:true,
                // autoplaySpeed: 200,
                // speed: 200,
                // pauseOnHover: false,
                // pauseOnFocus: false
            },
            currentSlide: 0,


            formData: {
                id: 0,
                type: '',
                fileRecordsForUpload: [],
            },
            fileRecords: [],
            fileRecordShow: [],
        }
    },
    methods: {
        ...mapActions(['updateGalleryAction', 'saveGalleryAction', 'deleteGalleryAction']),

        nothing(){},

        openAddModal(type, row) {
            this.clearData();
            this.formData.type = type;

            if (type == 'user') {
                row.forEach(item => this.fileRecords.push({
                    id: item.id,
                    image: item.url
                    
                }));
            } else {
                this.formData.id = row.id;
                row.images.forEach(item => this.fileRecords.push({
                    id: item.id,
                    image: item.url
                    
                }));
            }

            this.addOrUpdate = false;
            helper.openModal(".AddGallery");
        },

        editAddModal(type, row) {
            this.clearData();

            this.addOrUpdate = false;
            helper.openModal(".AddGallery");
        },

        hideModal() {
            helper.hideModal(".AddGallery");
        },

        clearData(){
            this.formData.id = 0;
            this.formData.type = "";
            this.size = 'col-12';

            this.fileRecords= [];
            this.fileRecordShow = [];
            this.formData.fileRecordsForUpload= [];
        },

        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            this.saveGalleryAction(data).then((res) => {
                this.saveLoading = false;
                this.hideModal();
                helper.successAlert("Created Successfully");
                this.clearData()
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

        deleteImage(row, index) {
            // this.isLoading = true;
            helper.deletingAlert("File will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteGalleryAction(row)
                    .then((res) => {
                        this.isLoading = false;

                        this.fileRecords.splice(index, 1)//

                        helper.successAlert("File deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        uploadImages(file){
            if(file.length > 0) {
                file.forEach(element => {
                    const images = helper.uploadFileUsingComponent(element);
                    const preview = helper.previewImageComponent(images);
                    this.fileRecordShow.push(preview);
                    this.formData.fileRecordsForUpload.push(images);
                    this.size= 'col-11';
                });
                // console.log(this.formData.images)
            } else {
                this.size= 'col-12';
                this.formData.fileRecordsForUpload = [];
                this.fileRecordShow = [];
            }
        },

        updateIndexOnClick(slideIndex) {
            this.currentSlide = slideIndex;
        },
        updateIndexOnDrag(oldSlideIndex, newSlideIndex) {
            this.currentSlide = newSlideIndex;
        },

    },
    watch: {
        currentSlide(newValue, oldValue) {
            this.$refs.carousel.goTo(newValue);
        },
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