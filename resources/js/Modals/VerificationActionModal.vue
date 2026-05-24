<template>
    <div>
         <modal ref="woModal" modal-class-name="UpdateVerification" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>{{ addOrUpdate ? 'Action' : 'Add' }}</b></span>
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

                <form @submit.prevent="saveData" id="updateVerificationForm">

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
                        <div v-if="formData.level_id == 1" class="col-md-12">
                            <custom-input
                                :label="'Ghana Card No'"
                                v-model="submittedData.card_id"
                                :disabled="true"
                                type="text"
                                placeholder="Enter Ghana Card No"/>
                        </div>
                        <div v-if="formData.level_id == 2" class="col-md-12">
                            <custom-input
                                :label="'Guarantor 1 findme ID'"
                                v-model="submittedData.guarantor1"
                                :disabled="true"
                                type="text"
                                placeholder="Enter Guarantor 1 findme ID"/>
                        </div>
                        <div v-if="formData.level_id == 2" class="col-md-12">
                            <custom-input
                                :label="'Guarantor 2 findme ID'"
                                v-model="submittedData.guarantor2"
                                :disabled="true"
                                type="text"
                                placeholder="Enter Guarantor 2 findme ID"/>
                        </div>
                        <div v-if="formData.level_id != 1" class="col-md-12">
                            <custom-input
                                :label="'Location GPS Code'"
                                v-model="submittedData.location"
                                :disabled="true"
                                type="text"
                                placeholder="Enter Location GPS Code"/>
                        </div>
                        
                        <div v-if="formData.level_id != 3">
                            <div class="row mx-1 my-3" v-for="(row, index) in submittedData.files" :key="index">
                                <button class="col-12 bg-red" @click.prevent="download(row)">
                                   Download file
                                </button>
                            </div>

                        </div>
                        <div class="col-md-12 mb-3">
                            <label><b>Action</b></label>
                            <v-select
                                :options="actions"
                                :label="'name'"
                                :reduce="actions => actions.id"
                                v-model="formData.action_id"
                                placeholder="Select Action">
                            </v-select>
                        </div>
                        <div class="col-md-12 mb-3">
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
                <button form="updateVerificationForm" type="submit" title="Click to save data" class="btn btn-primary">
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

const axios = require('axios').default;

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            saveLoading:false,
            addOrUpdate: true,
            show: false,
            token: "",

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
                message: '',
                action_id: 0,
                level_id: 0,

            },

            submittedData: [],
        }
    },
    methods: {
        ...mapActions(['updateVerificationAction', 'allVerificationAction']),

        openAddModal(row) {

            if (row.status != 0) {
                // helper.hideModal(".UpdateVerification");
                helper.errorAlert("Action not allowed");
            } else {
                this.formData.id = row.id;
                this.formData.level_id = row.level;
                this.submittedData = row;

                let levelArr = this.levels.filter((value) =>value.id == this.formData.level_id);
                this.due = levelArr[0].name;

                this.addOrUpdate = true;
                this.show = true;
                $(".UpdateVerification").modal('show');
            }

            
        },

        hideModal() {
            helper.hideModal(".UpdateVerification");
        },

        clearData(){
            this.formData.id= 0;
            this.formData.level_id= 0;
            this.formData.action_id = 0,
            this.formData.message = "";

            this.submittedData = [];
            
        },

        saveData() {

            this.saveLoading = true;
            const data = this.formData;
            this.updateVerificationAction(data).then((res) => {
                this.saveLoading = false;
                this.hideModal();
                helper.successAlert("Action Submited Successfully");
                this.clearData()
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

        download(row) {
            this.isLoading = true;
            if (this.token == null || this.token == undefined || this.token == '' || this.token == "") {
                this.isLoading = false;
                helper.errorAlert("Soryy cannot download this file");
            } else {
                axios({
                    url: 'http://127.0.0.1:8000/api/verification/download/'+row.id,
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
            
        },

    },
    created() {
        this.token = JSON.parse(localStorage.getItem('findMe')).auth.token;
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
