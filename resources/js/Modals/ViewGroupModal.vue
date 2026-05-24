<template>
    <div>
         <modal ref="woModal" modal-class-name="ViewGroupModal" :modalClasses="'modal-lg'">
            <template slot="header">
                <div class="modal-title row">
                    <h2 class="col-12">
                        <span><b>View Group</b></span>
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
                    <div>
                        <div class="col-md-12 flex-fill">
                            <img :src="viewData.image" alt="Image" class="img img-thumbnail" style="width: 70px; height: 70px">
                        </div>
                        <p>{{viewData.description}}</p>
                        
                    </div>

                    <div style="overflow-x:auto;">

                        <h4>{{viewData.name}} Users</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Findme ID</th>
                                    <th scope="col">An Admin</th>
                                    <th scope="col">Make Admin</th>
                                    <th scope="col">Delete</th>
                                    <th scope="col">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in viewData.users" :key="index">
                                    <td v-if="item.user">{{item.user.findme_id ? item.user.findme_id : ''}}</td>
                                    <td v-else>NA</td>

                                    <td v-if="item.status == 1">Yes</td>
                                    <td v-else>No</td>

                                    <td v-if="item.status != 1">
                                        <a  @click.prevent="makeAdmin(item)" class="dropdown-item"  title="Remove" href="#">
                                            <i class="fa fa-plus text-red" style="color: red;"></i> Make Admin
                                        </a>
                                    </td>
                                    <td v-else>NA</td>

                                    <td v-if="item.status != 1">
                                        <a  @click.prevent="removeUser(item)" class="dropdown-item"  title="Remove" href="#">
                                            <i class="fa fa-trash text-red" style="color: red;"></i> Delete
                                        </a>
                                    </td>
                                    <td v-else>NA</td>

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
const { mapActions, mapGetters } = createNamespacedHelpers('single');

export default {
    components: {
        Modal,
        CustomInput,
    },
    data() {
        return {
            saveLoading:false,
            show: false,

            viewData: null,
        }
    },
    methods: {
        ...mapActions(['makeGroupAdminAction', 'deleteGroupUserAction']),

        printDetail() {
            printJSData({
                printable: 'printDiv',
                scanStyles: true,
                targetStyles: ['*'],
                type: 'html',
                header: 'Group Detail',
                headerStyle: 'font-size: 2em; font-weight: bolder; text-align: center; text-decoration: underline; margin-bottom:30px',
                maxWidth: 1200,
                documentTitle: 'Egal GH'
            });
        },

        openModal(row) {
            this.clearData();

            this.viewData = row;
            this.show = true;
            console.log(this.viewData)

            helper.openModal(".ViewGroupModal");
        },

        hideModal() {
            helper.hideModal(".ViewGroupModal");
        },

        clearData(){
            this.viewData = null
            this.show = false
        },

        removeUser(row) {
            helper.deletingAlert("user will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deleteGroupUserAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("user deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

        makeAdmin(row) {
            helper.deletingAlert("user will now have admin rights")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.makeGroupAdminAction(row)
                    .then((res) => {
                        this.isLoading = false;
                        helper.successAlert("Done successfully");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
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
