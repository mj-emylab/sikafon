<template>
    <div>
         <modal ref="woModal" modal-class-name="PayCommission" :modalClasses="'modal-md'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>Cashout</b></span>
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

                <form @submit.prevent="saveData" id="commissionForm">

                    <loading
                        :active="saveLoading"
                        :is-full-page="false"
                        loader="bars"
                        :width="20"
                        :height="20"/>

                    <div v-if="show">
                        <div v-for="(field, index) in formData.commissions" :key="index"  class="row mt-3 mb-3">
                            <div class="col-md-12">
                            <custom-input
                                    :label="'Amount'"
                                    v-model="field.amount"
                                    :required="true"
                                    :disabled="true"
                                    type="number"/>
                            </div>
                            <div class="col-md-1 mt-4">
                                <a href="" title="Click to delete input fields" @click.prevent="removeField(index)">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            </div>

                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-md-12 mb-3">
                                <label><b>Account</b></label>
                                <v-select
                                    :options="getPaymentChannels"
                                    :label="'name'"
                                    :reduce="getPaymentChannels => getPaymentChannels.id"
                                    v-model="formData.account_id"
                                    placeholder="Select Account">

                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            :required="!formData.account_id"
                                            v-bind="attributes"
                                            v-on="events" />
                                    </template>
                                </v-select>
                            </div>
                            <div class="col-md-12">
                            <custom-input
                                    :label="'Amount To Cash'"
                                    v-model="formData.amount_to_cash"
                                    :required="true"
                                    :disabled="true"
                                    type="number"/>
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
                <button form="commissionForm" type="submit" title="Click to save data" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span>Cash Now</span>
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
            show: false,


            type: 1, //1 for single and 2 for multiple
            
            formData:{
                account_id: 0,
                amount_to_cash: 0.00,
                commissions:[],
            },
            
        }
    },
    methods: {
        ...mapActions(['payCommissionAction', 'allPaymentChannelAction', 'allCommissionAction']),

        hideModal() {
            helper.hideModal(".PayCommission");
            // $(".PayCommission").modal('hide');
        },

        getTotal(index){
            let field = this.formData.commissions[index];

            this.formData.amount_to_cash += parseFloat(field.amount)
        },

        subTract(index){
            let field = this.formData.commissions[index];

            this.formData.amount_to_cash -= parseFloat(field.amount)
        },

        removeField(index) {
            this.subTract(index);
            this.formData.commissions.splice(index, 1)
        },

        openEditModal(row, type) {
            this.clearData();

            if(type == 1){

                if(row.status == 1){
                    this.formData.commissions = [];
                    this.formData.commissions.push({
                        id: row.id,
                        amount: parseFloat(row.amount).toFixed(2),
                        original_amount: parseFloat(row.amount).toFixed(2),
                    });
                    this.getTotal(0);
                    this.show = true;
                }

            } else {
                this.formData.commissions = [];
                let index = 0
                row.forEach(item => {

                    if(item.status == 1){
                        this.formData.commissions.push({
                            
                            id: item.id,
                            amount: item.amount,
                            original_amount: item.amount,
                        })
                        this.getTotal(index);
                        index++;
                    }

                });
                this.show = true;
            }

            this.addOrUpdate = true;
            helper.openModal(".PayCommission");
        },

        clearData(){
            this.formData.account_id = 0;
            this.formData.amount_to_cash = 0.00;
            this.formData.commissions = [];
            this.show = false;
            // this.formData.commissions = {id: 0, amount: 0, original_amount: 0};
        },

        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            // const data = {formdata: this.formData}
            this.payCommissionAction(data).then((res) => {
                this.saveLoading = false;
                this.allCommissionAction();
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
        this.allPaymentChannelAction()
    },
    computed: {
        ...mapGetters(['getPaymentChannels']),

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

</style>
