<template>
    <div>
         <modal ref="woModal" modal-class-name="AddGroup" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="groupForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>


                    <div class="col-md-12 flex-fill" v-if="showImage">
                        <img v-for="(show, index) in showImage" :key="index" :src="show" alt="Image"
                                class="img img-thumbnail" style="width: 70px; height: 70px">
                        <img v-if="addOrUpdate" :src="showUpdateImage" alt="Image"
                                class="img img-thumbnail" style="width: 70px; height: 70px">
                        <!-- <span class="ml-3">New</span> -->
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <custom-input
                                    :label="'Name'"
                                    v-model="formData.name"
                                    :required="true"
                                    type="text"
                                    placeholder="Enter name"/>
                            </div>
                            
                            <div class="col-md-4">
                                <label><b>Action</b></label>
                                <v-select
                                    :options="actions"
                                    :label="'name'"
                                    :reduce="actions => actions.id"
                                    v-model="formData.status"
                                    placeholder="Select Action">
                                </v-select>
                            </div>
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
                            <label><b>Upload Picture</b></label>
                            <wo-file-uploader
                            :variant="'danger'"
                            :size="size"
                            @onUpload="uploadFiles"/>

                        </div>

                    </div>

                </form>
            </template>
            <template slot="footer">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="groupForm" type="submit" title="Click to save data" class="btn btn-primary">
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
const { mapActions, mapGetters } = createNamespacedHelpers('single');

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

            actions: [
                {id:0, name: 'private'},
                {id:1, name: 'public'},
            ],

            formData: {
                id: 0,
                name: "",
                image: '',
                description: '',
                status: 0,

            },
            showImage: [],
            showUpdateImage: "",
        }
    },
    methods: {
        ...mapActions(['updateGroupAction', 'saveGroupAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            $(".AddGroup").modal('show');
        },

        openEditModal(row) {
            this.clearData();

            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description;
            this.formData.status= row.status;

            // this.formData.image = row.image;
            if(row.image) {
              this.showUpdateImage = row.image;
            }

            this.addOrUpdate = true;
            helper.openModal(".AddGroup");
        },

        hideModal() {
            helper.hideModal(".AddGroup");
        },

        clearData(){
            this.size = 'col-12';
            this.formData.id = "";
            this.formData.name = "";
            this.formData.description= "";
            this.formData.status= 0;

            this.showImage = [];
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
                this.updateGroupAction(data).then((res) => {
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
                this.saveGroupAction(data).then((res) => {
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

    },
    created() {
    },
    computed: {
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
