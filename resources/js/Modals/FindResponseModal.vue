<template>
    <div>
        <modal ref="woModal" modal-class-name="ShareModal" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>Response</b></span>
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

                <form @submit.prevent="saveData" id="shareModalForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3">
                        
                        <div v-if="type == 1">
                            <div class="row mx-1 my-3">
                                <button class="col-12 bg-red" @click.prevent="download(formData.profile_id)">
                                   {{formData.file_name}} Download
                                </button>
                            </div>

                        </div>

                        <div v-if="type == 2" class="col-md-12">
                            <custom-input
                                :label="'Exp Date'"
                                v-model="formData.exp"
                                :disabled="false"
                                type="date"
                                placeholder="Exp Date"/>
                        </div>
                        <div v-if="type == 2" class="col-md-12">
                            <custom-input
                                :label="'File'"
                                v-model="formData.file_name"
                                :disabled="true"
                                type="text"
                                placeholder=""/>
                        </div>
                        <div v-if="type == 2" class="col-md-12 mb-3">
                            <label><b>Action</b></label>
                            <v-select
                                :options="actions"
                                :label="'name'"
                                :reduce="actions => actions.id"
                                v-model="formData.action_id"
                                placeholder="Select Action">
                            </v-select>
                        </div>

                    </div>

                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="shareModalForm" type="submit" title="Click to save data" class="btn btn-primary">
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
const { mapActions, mapGetters } = createNamespacedHelpers('single');

const axios = require('axios').default;

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: false,
            token: "",
            type: 2,

            actions: [
                {id:1, name: 'accept'},
                {id:2, name: 'decline'},
            ],

            formData: {
                id: 0,
                exp: '',
                action_id: 0,
                file_name: '',
                file_id: 0,
                profile_id: 0,
                status: 0,

            },
        }
    },
    methods: {
        ...mapActions(['updateShareAction', 'saveShareAction', 'allShareAction']),

        openAddModal(row, type) {
            this.addOrUpdate = false;

            if (type == 'from') {
                this.type= 1;
            } else  {
                this.type= 2;
            }
            this.formData.id = row.id;
            this.formData.file_id = row.file_id;
            this.formData.file_name = row.profile.name;
            this.formData.profile_id = row.profile.id;
            this.formData.status = row.status;

            helper.openModal(".ShareModal");
        },

        openEditModal(row) {
            this.formData.id= row.id;
            this.addOrUpdate = true;
            helper.openModal(".ShareModal");
        },

        hideModal() {
            helper.hideModal(".ShareModal");
        },

        clearData(){
            // this.type = 2;

            this.formData.id = 0;
            this.formData.exp = '';
            this.formData.action_id = 0;
            this.formData.file_id = 0;
            this.formData.profile_id = 0;
            this.formData.status = 0;
            this.formData.file_name = '';
        },

        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            this.updateShareAction(data).then((res) => {
                this.saveLoading = false;
                helper.successAlert("Updated Successfully");
                this.clearData()
                this.hideModal();
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

        download(id) {
            if (this.formData.status == 1){
                this.isLoading = true;
                if (this.token == null || this.token == undefined || this.token == '' || this.token == "") {
                    this.isLoading = false;
                    helper.errorAlert("Soryy cannot download this file");
                } else {
                    axios({
                        url: 'http://127.0.0.1:8000/api/files/download/'+id,
                        method: 'GET',
                        responseType: 'blob',
                        headers: {"Authorization" : `Bearer ${this.token}`}
                    }).then((response) => {
                        // console.log(response.data.type)
                        this.isLoading = false;
                        var fileURL = window.URL.createObjectURL(new Blob([response.data], {type: response.data.type}));
                        var fileLink = document.createElement('a');

                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', '');
                        document.body.appendChild(fileLink);

                        fileLink.click();
                    });
                    this.isLoading = false;
                }
            } else {
                helper.successAlert("File not available");
            }
            
        },

    },
    created() {
        this.allShareAction();
        this.token = JSON.parse(localStorage.getItem('findMe')).auth.token;
    },
    computed: {
        ...mapGetters(['getFile']),

    },
    mounted() {
    },
}
</script>
<style scoped>

</style>
