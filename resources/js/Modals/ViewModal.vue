<template>
    <div>
         <modal ref="woModal" modal-class-name="ViewModal" :modalClasses="'modal-lg'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>View {{type}}</b></span>
                    </h2>
                </div>
            </template>
            <template slot="close-button">
                <button @click.prevent="printDetail" class="btn btn-secondary btn-sm">
                    <i class="fa fa-print"></i>
                    <span>Print</span>
                </button>
            </template>
            <template>

                <div id="printDiv" v-if="show">
                    <div v-if="type == 'session'">
                        <h4>Sessions</h4>

                        <div style="overflow-x:auto;" v-for="(item, index) in sessionData" :key="index">
                            <h4>{{dayOfWeekAsString(item.day)+ ' '+item.start_at+ ' - '+item.end_at}}</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">SR</th>
                                        <th scope="col">Findme ID</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item2, index2) in item.users" :key="index2">
                                        <td>{{getIndex(index2)}}</td>
                                        <td>{{item2.user.findme_id}}</td>
                                        <td>{{item.updated_at | dateOnly}}</td>
                                    </tr>
                                </tbody>
                            </table>

                            
                        </div>
                        
                    </div>

                    <div style="overflow-x:auto;" v-if="type == 'ticket'">
                        <h4>{{eventData.event_name+ ' '+eventData.event_code+ ' '+eventData.slots}}</h4>

                        <h4>Events Tickets</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">SR</th>
                                    <th scope="col">Findme ID</th>
                                    <th scope="col">Agent Findme ID</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Cost</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in eventData.tickets" :key="index">
                                    <td>{{getIndex(index)}}</td>
                                    <td v-if="item.user">{{item.user.findme_id ? item.user.findme_id : ''}}</td>
                                    <td v-else>NA</td>
                                    <td v-if="item.agent">{{item.agent.findme_id ? item.agent.findme_id : ''}}</td>
                                    <td v-else>NA</td>
                                    <td v-if="item">{{item.description? item.description : '' }}</td>
                                    <td v-else>NA</td>
                                    <td v-if="item">{{item.code ? item.code : ''}}</td>
                                    <td v-if="item">{{item.cost ? item.cost : ''}}</td>
                                    <td v-if="item">{{item.created_at | dateOnly}}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    
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
            show: false,
            type: 'session',


            sessionData: [],

            eventData: [],
        }
    },
    methods: {
        ...mapActions([]),

        getIndex(index){
            return index + 1;
        },

        dayOfWeekAsString(dayIndex) {
            return ["None", "Sunday", "Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][dayIndex] || '';
        },

        printDetail() {
            printJSData({
                printable: 'printDiv',
                scanStyles: true,
                targetStyles: ['*'],
                type: 'html',
                header: 'Detail Table',
                headerStyle: 'font-size: 2em; font-weight: bolder; text-align: center; text-decoration: underline; margin-bottom:30px',
                maxWidth: 1200,
                documentTitle: 'Egal GH'
            });
        },

        openModal(row, type) {
            this.clearData();

            if (type == 'ticket') {
                this.type = 'ticket';
                this.eventData = row;
                this.addOrUpdate = false;
                this.show = true;
                // console.log(this.eventData)
                helper.openModal(".ViewModal");
            } else if (type == 'session') {
                this.type = 'session';
                this.sessionData = row;
                this.addOrUpdate = false;
                this.show = true;
                helper.openModal(".ViewModal");
            }
        },

        hideModal() {
            helper.hideModal(".ViewModal");
        },

        clearData(){
            this.eventData = [];
            this.sessionData = [];
            this.show = false;
            
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
