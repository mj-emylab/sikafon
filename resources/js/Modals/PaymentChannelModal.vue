<template>
    <div>
         <modal ref="woModal" modal-class-name="AddPaymentChannel" :modalClasses="'modal-md'">
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

                <form @submit.prevent="saveData" id="paymentChannelForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>


                    <div class="col-md-12 mb-3">
                        <label><b>Provider</b></label>
                        <v-select
                            :options="providers"
                            :label="'name'"
                            :reduce="providers => providers.id"
                            v-model="formData.provider_id"
                            placeholder="Select Provider">

                            <template #search="{attributes, events}">
                                <input
                                    class="vs__search"
                                    :required="!formData.provider_id"
                                    v-bind="attributes"
                                    v-on="events" />
                            </template>
                        </v-select>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <custom-input
                                :label="'Account Name'"
                                v-model="formData.account_name"
                                :required="true"
                                type="text"
                                placeholder="Enter account name"/>
                        </div>
                        <div class="col-md-12">
                            <custom-input
                                :label="'Account Number'"
                                v-model="formData.account_number"
                                :required="true"
                                type="text"
                                placeholder="Enter Account Number"/>
                        </div>

                    </div>

                </form>
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button form="paymentChannelForm" type="submit" title="Click to save data" class="btn btn-primary">
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

            providers:[
                {id: 1, name: 'MTN'},
                {id: 2, name: 'ARTEL-TIGO'},
                {id: 3, name: 'VODAFONE'},
                {id: 4, name: 'UBA'},
                {id: 5, name: 'CALBANK'},
            ],

            formData: {
                id: 0,
                account_name: "",
                account_number: '',
                provider_id: 0,

            },
        }
    },
    methods: {
        ...mapActions(['updatePaymentChannelAction', 'savePaymentChannelAction', 'allPaymentChannelAction']),

        openAddModal() {
            this.clearData();
            this.addOrUpdate = false;
            // helper.openModal(".AddPaymentChannel");
            $(".AddPaymentChannel").modal('show');
        },

        openEditModal(row) {
            this.clearData();
            this.formData.id= row.id;
            this.formData.account_name= row.account_name;
            this.formData.account_number= row.account_number;
            this.formData.provider_id= row.provider_id;

            this.addOrUpdate = true;
            helper.openModal(".AddPaymentChannel");
            // $(".AddPaymentChannel").modal('show');
        },

        hideModal() {
            helper.hideModal(".AddPaymentChannel");
            // $(".AddPaymentChannel").modal('hide');
        },

        clearData(){
            this.formData.id = "";
            this.formData.account_name = "";
            this.formData.account_number= "";
            this.formData.provider_id= 0;
        },

        saveData() {
            // this.saveLoading = true;
            if(this.addOrUpdate) {
                const data = this.formData;
                this.updatePaymentChannelAction(data).then((res) => {
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
                this.savePaymentChannelAction(data).then((res) => {
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
        ...mapGetters([]),

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
