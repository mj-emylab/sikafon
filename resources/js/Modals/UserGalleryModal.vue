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
                                    :accept="'image/*'"
                                    :maxSize="'10MB'"
                                    :maxFiles="1"
                                    :helpText="'Choose images files'"
                                    :errorText="{
                                    type: 'Invalid file type. Only images Allowed',
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
const { mapActions, mapGetters } = createNamespacedHelpers('system');

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
                type: 'user',
                

                fileRecords: [],
                uploadUrl: '',
                fileRecordsForUpload: [], // maintain an upload queue
                

            },
        }
    },
    methods: {
        ...mapActions(['updateGalleryAction', 'saveGalleryAction', 'deleteGalleryAction']),

        openAddModal(type) {
            this.clearData();

            this.addOrUpdate = false;
            helper.openModal(".AddUserFile");
        },

        editAddModal(type, row) {
            this.clearData();

            this.addOrUpdate = false;
            helper.openModal(".AddUserFile");
        },

        hideModal() {
            helper.hideModal(".AddUserFile");
        },

        clearData(){
            this.formData.id = "";

            this.formData.fileRecords= [];
            this.formData.uploadUrl= '';
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

        deleteFile(file) {
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
        },



        uploadFiles: function () {
            
            console.log(this.formData.fileRecordsForUpload)
            this.saveData();
            // this.formData.fileRecordsForUpload = [];
        },
        deleteUploadedFile: function (fileRecord) {
            //
            this.deleteFile(fileRecord);
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