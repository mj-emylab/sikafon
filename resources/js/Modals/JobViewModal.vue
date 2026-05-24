<template>
    <div>
         <modal ref="woModal" modal-class-name="ViewJob" :modalClasses="'modal-md'">
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

                <div>

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div class="row mt-3 mb-3" v-if="show">
                        <div class="col-md-12 mb-3">
                            <label><b>Message</b></label>
                            <textarea
                                placeholder="Enter Message"
                                cols="30"
                                class="form-control"
                                rows="3"
                                style="resize:none"
                                v-model="msg"
                                disabled
                            ></textarea>
                        </div>
                        
                        <div>
                            <div class="row mx-1 my-3" v-for="(row, index) in submittedData" :key="index">
                                <button class="col-12 bg-red" @click.prevent="download(row.file_id)">
                                   Download file
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
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
            msg: "",

            submittedData: [],
        }
    },
    methods: {

        openAddModal(row) {
            this.clearData()

            this.submittedData = row.messageable.applicants;
            this.msg = row.msg;

            this.show = true;
            $(".ViewJob").modal('show');

            
        },

        hideModal() {
            helper.hideModal(".ViewJob");
        },

        clearData(){
            this.show = false;
            this.submittedData = [];
            this.msg = "";
            
        },

        download(id) {
            this.isLoading = true;
            if (this.token == null || this.token == undefined || this.token == '' || this.token == "") {
                this.isLoading = false;
                helper.errorAlert("Soryy cannot download this file");
            } else {
                axios({
                    url: 'http://127.0.0.1:8000/api/user_profiles/download/'+id,
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
