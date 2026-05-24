<template>
    <div>
         <modal ref="woModal" modal-class-name="ReplyModal" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="myForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>


                    
                    <div class="mt-3">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <custom-input
                                    :label="'Message'"
                                    v-model="formData.msg"
                                    type="text"
                                    placeholder="Enter Message"
                                />

                            </div>

                            <div>
                                <label><b>Upload File</b></label>
                                <wo-file-uploader
                                :variant="'danger'"
                                :multiple="true"
                                @onUpload="uploadFiles"/>

                            </div>
                        </div>
                    </div>

                </form>
            </template>
            <template slot="footer">
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="myForm" type="submit" title="Click to save data" class="btn btn-primary">
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
import WoFileUploader from '../components/WoFilesUploader.vue';
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


            formData: {
                message_id: 0,
                type: '',
                msg: "",
                attached: [],

            },
        }
    },
    methods: {
        ...mapActions(['saveReplyAction']),

        uploadFiles(file){

            if(file.length > 0) {
                file.forEach(element => {
                    const files = helper.uploadAnyFileUsingComponent(element);
                    const fPreview = helper.previewImageComponent(files);
                    this.files.push(fPreview);
                    this.formData.files.push(files);
                });
            } else {
                this.formData.files = [];
                this.files = [];
            }
        },

        openAddModal(row, type) {
            this.formData.message_id= row.message_id;
            this.formData.type = type,

            // this.addOrUpdate = true;
            helper.openModal(".ReplyModal");
        },

        hideModal() {
            helper.hideModal(".ReplyModal");
        },

        clearData(){
            this.formData.message_id = 0;
            this.formData.msg = "";
            this.formData.type = "";
        },

        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            this.saveReplyAction(data).then((res) => {
                this.saveLoading = false;
                this.hideModal();
                helper.successAlert("Created Successfully");
                this.clearData()
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

    },
    created() {
        
    },
    computed: {
        // ...mapGetters([]),
    },
    mounted() {
    },
}
</script>
<style scoped>

</style>
