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
                        
                        <div class="my-3">
                            <template>
                                <VueFileAgent
                                    ref="vueFileAgent"
                                    :capture="'user'"
                                    :editable="false"
                                    :sortable="false"
                                    :resumable="true"
                                    :disabled="false"
                                    :theme="'grid'"
                                    :multiple="false"
                                    :deletable="true"
                                    :meta="true"
                                    :linkable="false"
                                    :accept="'image/*,.zip,audio/*,.pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'"
                                    :maxSize="'10MB'"
                                    :maxFiles="1"
                                    :helpText="'Choose images, doc or zip files'"
                                    :errorText="{
                                    type: 'Invalid file type. Only images, docs or zip Allowed',
                                    size: 'Files should not exceed 10MB in size',
                                    }"
                                    @select="filesSelected($event)"
                                    @beforedelete="onBeforeDelete($event)"
                                    @delete="fileDeleted($event)"

                                    @upload="onUpload($event)"
                                    @upload:error="onUploadError($event)"

                                    v-model="formData.fileRecords"
                                ></VueFileAgent>
                                <button class="col-12 bg-red" :disabled="!formData.fileRecordsForUpload.length" @click="uploadFiles()">
                                    Upload {{ formData.fileRecordsForUpload.length }} files
                                </button>
                            </template>

                        </div>

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
                description: "",

                fileRecords: [

                    // {
                    //     name: "BC.docx",
                    //     size: 561813,
                    //     type: "",
                    //     // "ext": "docx",
                    //     url: "storage/user-profile/16506739797txee.docx",
                    // },
                ],
                uploadUrl: '',
                fileRecordsForUpload: [],

            },
        }
    },
    methods: {
        ...mapActions(['updateUserProfileAction', 'saveUserProfileAction']),

        openAddModal() {
            this.clearData();

            this.addOrUpdate = false;
            helper.openModal(".AddUserFile");
        },

        openEditModal(row) {
            this.clearData();

            this.formData.id= row.id;
            this.formData.name= row.name;
            this.formData.description= row.description;

            this.formData.fileRecords.push(
                {
                    name: row.name+'.'+row.url.split('.').pop(),
                    size: 561813,
                    type: "",
                    // "ext": "docx",
                    url: row.url,
                },
            );

            this.formData.uploadUrl= '';
            this.formData.fileRecordsForUpload= [];

            this.addOrUpdate = true;
            helper.openModal(".AddUserFile");
        },

        hideModal() {
            helper.hideModal(".AddUserFile");
        },

        clearData(){
            this.formData.id = "";
            this.formData.name = "";
            this.formData.description = "";

            this.formData.fileRecords= [];
            this.formData.uploadUrl= '';
            this.formData.fileRecordsForUpload= [];
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updateUserProfileAction(data).then((res) => {
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
                this.saveUserProfileAction(data).then((res) => {
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

        // deleteFile(file) {
        //     this.isLoading = true;
        //     this.deleteUserProfileAction(row)
        //     .then((res) => {
        //         this.isLoading = false;

        //         helper.successAlert("File deleted");
        //     }).catch((error) => {
        //         this.isLoading = false;
        //         helper.errorMessage(error);
        //     });
        // },



        uploadFiles: function () {
            
            // console.log(this.formData.fileRecordsForUpload)
            // this.saveData();
            // this.formData.fileRecordsForUpload = [];
        },
        deleteUploadedFile: function (fileRecord) {
            //
            // this.deleteFile(fileRecord);
        },
        filesSelected: function (fileRecordsNewlySelected) {
            var validFileRecords = fileRecordsNewlySelected.filter((fileRecord) => !fileRecord.error);
            this.formData.fileRecordsForUpload = this.formData.fileRecordsForUpload.concat(validFileRecords);
        },
        onBeforeDelete: function (fileRecord) {
            var i = this.formData.fileRecordsForUpload.indexOf(fileRecord);
            if (i !== -1) {
                // queued file, not yet uploaded. Just remove from the arrays
                this.formData.fileRecordsForUpload.splice(i, 1);
                var k = this.formData.fileRecords.indexOf(fileRecord);
                if (k !== -1) this.formData.fileRecords.splice(k, 1);
                } else {
                    if (confirm('Are you sure you want to delete?')) {
                        this.$refs.vueFileAgent.deleteFileRecord(fileRecord); // will trigger 'delete' event
                }
            }
        },
        fileDeleted: function (fileRecord) {
            var i = this.formData.fileRecordsForUpload.indexOf(fileRecord);
            if (i !== -1) {
                this.formData.fileRecordsForUpload.splice(i, 1);
            } else {
                this.deleteUploadedFile(fileRecord);
            }
        },
        onUpload(e){
            console.log(e)
        },
        onUploadError(e){
            console.log(e)
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
