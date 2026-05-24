<template>
    <div>
         <modal ref="woModal" modal-class-name="AddVerification" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="verificationForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <custom-input
                                :label="'Level'"
                                v-model="due"
                                :disabled="true"
                                type="text"
                                placeholder=""/>
                        </div>
                        <div v-if="show" class="col-md-12 mb-3">
                            <label><b>Levels</b></label>
                            <v-select
                                :options="levels"
                                :label="'name'"
                                :reduce="levels => levels.id"
                                v-model="formData.level_id"
                                placeholder="Select Level">

                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        :required="!formData.level_id"
                                        v-bind="attributes"
                                        v-on="events" />
                                </template>
                            </v-select>
                        </div>
                        <div v-if="formData.level_id == 1" class="col-md-12">
                            <custom-input
                                :label="'Ghana Card No'"
                                v-model="formData.cardId"
                                :required="true"
                                type="text"
                                placeholder="Enter Ghana Card No"/>
                        </div>
                        <div v-if="formData.level_id == 2" class="col-md-12">
                            <custom-input
                                :label="'Guarantor 1 findme ID'"
                                v-model="formData.guarantor1"
                                :required="true"
                                type="text"
                                placeholder="Enter Guarantor 1 findme ID"/>
                        </div>
                        <div v-if="formData.level_id == 2" class="col-md-12">
                            <custom-input
                                :label="'Guarantor 2 findme ID'"
                                v-model="formData.guarantor2"
                                :required="true"
                                type="text"
                                placeholder="Enter Guarantor 2 findme ID"/>
                        </div>
                        <div v-if="formData.level_id != 1" class="col-md-12">
                            <custom-input
                                :label="'Location GPS Code'"
                                v-model="formData.location"
                                :required="true"
                                type="text"
                                placeholder="Enter Location GPS Code"/>
                        </div>
                        
                        <div v-if="formData.level_id != 3" class="my-3">
                            <template>
                                <VueFileAgent
                                    ref="vueFileAgent"
                                    :capture="'user'"
                                    :editable="false"
                                    :sortable="false"
                                    :resumable="true"
                                    :disabled="false"
                                    :theme="'grid'"
                                    :multiple="true"
                                    :deletable="deleteable"
                                    :meta="true"
                                    :linkable="true"
                                    :accept="'image/*,.zip,audio/*,.pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'"
                                    :maxSize="'10MB'"
                                    :maxFiles="5"
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
                                <button v-if="!addOrUpdate" class="col-12 bg-red" :disabled="!formData.fileRecordsForUpload.length" @click="uploadFiles()">
                                    Upload {{ formData.fileRecordsForUpload.length }} files
                                </button>
                            </template>

                        </div>
                        <div v-if="addOrUpdate" class="col-md-12 mb-3">
                            <label><b>Action</b></label>
                            <v-select
                                :options="actions"
                                :label="'name'"
                                :reduce="actions => actions.id"
                                v-model="formData.action_id"
                                placeholder="Select Action">
                            </v-select>
                        </div>
                        <div v-if="addOrUpdate" class="col-md-12 mb-3">
                            <label><b>Message</b></label>
                            <textarea
                                placeholder="Enter Message"
                                cols="30"
                                class="form-control"
                                rows="3"
                                style="resize:none"
                                v-model="formData.message"
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
                <button form="verificationForm" type="submit" title="Click to save data" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span>Submit</span>
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
            deleteable: true,
            show: false,

            levels: [
                {id:1, name: 'level 1'},
                {id:2, name: 'level 2'},
                {id:3, name: 'level 3'}
            ],
            due: '',

            actions: [
                {id:1, name: 'accept'},
                {id:2, name: 'decline'},
            ],


            formData: {
                id: 0,
                cardId: '',
                guarantor1: '',
                level_id: 1,
                guarantor2: '',
                location: '',
                message: '',
                action_id: 0,

                type: '',
                type_id: 0,

                fileRecords: [],
                uploadUrl: '',
                fileRecordsForUpload: [], // maintain an upload queue

            },
        }
    },
    methods: {
        ...mapActions(['updateVerificationAction', 'saveVerificationAction', 'allVerificationAction']),

        openAddModal(row, type) {

            if (row.status == 4) {
                helper.errorAlert("You have a pending request");
                // this.hideModal();
            } else if (row.status == 0) {
                this.formData.level_id = 1;

                this.formData.type = type;
                this.formData.type_id = row.id;

                let levelArr = this.levels.filter((value) =>value.id == this.formData.level_id);
                this.due = levelArr[0].name;

                this.addOrUpdate = false;
                $(".AddVerification").modal('show');
            } else if (row.status == 1) {
                this.formData.level_id = 2;

                this.formData.type = type;
                this.formData.type_id = row.id;

                let levelArr = this.levels.filter((value) =>value.id == this.formData.level_id);
                this.due = levelArr[0].name;

                this.addOrUpdate = false;
                $(".AddVerification").modal('show');
            } else if (row.status == 2) {
                this.formData.level_id = 3;

                this.formData.type = type;
                this.formData.type_id = row.id;

                let levelArr = this.levels.filter((value) =>value.id == this.formData.level_id);
                this.due = levelArr[0].name;

                this.addOrUpdate = false;
                $(".AddVerification").modal('show');
            } else if (row.status == 3) {
                helper.errorAlert("Verification completed");
                // this.hideModal();
            } else {
                this.formData.level_id = 1;

                this.formData.type = type;
                this.formData.type_id = row.id;

                let levelArr = this.levels.filter((value) =>value.id == this.formData.level_id);
                this.due = levelArr[0].name;

                this.addOrUpdate = false;
                $(".AddVerification").modal('show');
            }
        },

        openEditModal(row) {
            this.clearData();

            this.formData.id= row.id;
            this.formData.guarantor1= row.guarantor1;
            this.formData.guarantor2= row.guarantor2;
            this.formData.cardId= row.cardId;
            this.formData.location= row.location;
            this.formData.level_id= row.level;

            this.formData.action_id = row.action_id,
            this.formData.message = row.message,

            this.deleteable = false;

            // this.formData.image = row.image;

            this.fileRecords= [];
            this.uploadUrl= '';
            this.fileRecordsForUpload= []; // maintain an upload queue

            let levelArr = this.levels.filter((value) =>value.id == this.formData.level_id);
            this.due = levelArr[0].name;

            this.addOrUpdate = true;
            helper.openModal(".AddVerification");
        },

        hideModal() {
            helper.hideModal(".AddVerification");
        },

        clearData(){
            this.formData.id= "";
            this.formData.guarantor1= "";
            this.formData.guarantor2= "";
            this.formData.cardId= "";
            this.formData.location= "";
            this.formData.level_id= 1;
            this.formData.action_id = 0,
            this.formData.message = '',

            this.deleteable = true;

            this.formData.type = "";
            this.formData.type_id = 0;

            this.fileRecords= [];
            this.uploadUrl= '';
            this.fileRecordsForUpload= [];
        },

        saveData() {

            if(this.addOrUpdate) {
                // this.saveLoading = true;
                // const data = this.formData;
                // this.updateVerificationAction(data).then((res) => {
                //     this.saveLoading = false;
                //     this.hideModal();
                //     helper.successAlert("Action Submited Successfully");
                //     this.clearData()
                // }).catch((error) => {
                //     this.saveLoading = false;
                //     helper.errorMessage(error);
                // });
            } else {
                this.saveLoading = true;
                const data = this.formData;
                this.saveVerificationAction(data).then((res) => {
                    this.saveLoading = false;
                    // this.hideModal();
                    helper.successAlert("Submited Successfully");
                    // this.clearData()
                }).catch((error) => {
                    this.saveLoading = false;
                    helper.errorMessage(error);
                });
            }

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
        this.allVerificationAction()
    },
    computed: {
        // ...mapGetters(['']),
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
