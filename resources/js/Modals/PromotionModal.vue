<template>
    <div>
         <modal ref="woModal" modal-class-name="ViewPromotion" :modalClasses="'modal-lg'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>View</b></span>
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
                <div style="overflow-x:auto;" v-if="show" id="printDiv">

                    <h4 v-if="row.commission">{{row.promotionCode}} Promotion Code commission on {{row.promotionName}}  <span  class="badge badge-warning light">({{row.commission.length}})</span></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Amount</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Status</th>
                                <th scope="col">Account No.</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in row.commission" :key="index">
                                <td>GHS {{item.amount}}</td>
                                <td>20%</td>
                                <td>
                                    <span style="text-color: white; background-color:#8B0000" v-if="item.status == 0" class="badge badge-warning light">Inprocess</span>
                                    <span style="text-color: white; background-color:#2E8B57" v-if="item.status == 1" class="badge badge-info light">Available</span>
                                    <span style="text-color: white; background-color:#FF0000" v-if="item.status == 2" class="badge badge-success light">Taken</span>
                                    
                                </td>
                                <!-- <td v-if="row.status == 2">
                                    {{item.account_number}}
                                </td>
                                <td v-else>
                                    NA
                                </td> -->
                                <td>{{item.created_at | dateOnly}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </template>
            <template slot="footer">
                
                <button @click.prevent="hideModal" title="Click to close modal" class="btn btn-danger btn-sm">
                    <i class="fa fa-window-close"></i>
                    <span>Close</span>
                </button>
                <button @click.prevent="printDetail" title="Click to print data" class="btn btn-primary">
                    <i class="fa fa-print"></i>
                    <span>Print</span>
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
            show: false,


            row: [],
        }
    },
    methods: {
        ...mapActions([]),

        openAddModal(row) {
            this.row = [];
            this.show = false;

            this.row.promotionName = row.type;
            this.row.promotionCode = row.code;
            this.row.commission = row.commission;

            this.show = true;
            $(".ViewPromotion").modal('show');
        },

        hideModal() {
            helper.hideModal(".ViewPromotion");
        },

        printDetail() {
            printJSData({
                printable: 'printDiv',
                scanStyles: true,
                targetStyles: ['*'],
                type: 'html',
                header: 'Promotion commission',
                headerStyle: 'font-size: 2em; font-weight: bolder; text-align: center; text-decoration: underline; margin-bottom:30px',
                maxWidth: 1200,
                documentTitle: 'Egal GH'
            });
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
