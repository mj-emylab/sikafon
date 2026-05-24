<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Verification
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Verification</li>
      </ol>
    </section>
    
    <section class="content">

        <div class="row">
            <!-- <div class="col-md-3">

            <img class="" src="images/event.png" style="width: 100%; height: 100%; margin-left: auto;margin-right: auto;" />
            </div> -->
        
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs bg-red">

                        <div style="margin-left:10px; margin-bottom:5px; height: 50px;">
                            <span>
                                <loading
                                    :active="isLoading"
                                    :is-full-page="false"
                                    loader="bars"
                                    :width="25"
                                    :height="25"
                                ></loading>
                            </span>
                        </div>
                    
                    </ul>
                    <div class="tab-content">
                    
                        <wo-table
                            :total-records="getVerifications ? getVerifications.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getVerifications">
                            <!-- <template #category="{row}">
                                {{ row.category_name }}
                            </template> -->
                            <template #actionBy="{row}">
                                <span v-if="row.officer">
                                    {{row.officer.first_name}}
                                </span>
                                <span v-else>
                                    NA
                                </span>
                            </template>
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" @click.prevent="editModal(row)" v-if="row.status == 0">
                                    Pending
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" @click.prevent="editModal(row)" v-if="row.status == 1">
                                    Accepted
                                </span>
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-danger" @click.prevent="editModal(row)" v-if="row.status == 2">
                                    Declined
                                </span>
                            </template>
                            <template #created_at="{row}">
                                {{ row.created_at | dateOnly }}
                            </template>
                            <template #actions="{row}">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown" data-bs-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a @click.prevent="actionModal(row)" class="dropdown-item"  title="Action" href="#">
                                            <i class="fa fa-pencil text-success"></i> Action
                                        </a>
                                        <a @click.prevent="deleteItem(row)" class="dropdown-item" title="Delete" href="#">
                                            <i class="fa fa-trash text-danger"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </template>
                        </wo-table>
                    </div>
                        
                        
                </div>
            </div>
        </div>

    </section>

    <verification-modal ref="verification" />
    <verification-action-modal ref="verificationAction" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import VerificationModal from '../../Modals/VerificationModal.vue';
    import VerificationActionModal from '../../Modals/VerificationActionModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, VerificationModal, VerificationActionModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'user.first_name'},
                    { label: 'Category', field: 'category'},
                    { label: 'Officer', field: 'actionBy'},
                    { label: 'Level', field: 'level'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allVerificationAction', 'deleteVerificationAction', 'updateVerificationAction']),

            deleteItem(row) {
                // helper.deletingAlert("event will be deleted")
                // .then((result) => {
                //     if (result.value) {
                //         this.isLoading = true;
                //         this.deleteVerificationAction(row)
                //         .then((res) => {
                //             this.isLoading = false;
                //             helper.successAlert("event deleted");
                //         }).catch((error) => {
                //             this.isLoading = false;
                //             helper.errorMessage(error);
                //         });
                //     }
                // });
            },

            showModal() {
                // this.$refs.verification.openAddModal();
            },

            editModal(row) {
                this.$refs.verification.openEditModal(row);
            },
            actionModal(row) {
                this.$refs.verificationAction.openAddModal(row);
            },
        },
        created() {
            this.allVerificationAction();
        },
        computed: {
            ...mapGetters(['getVerifications']),
        },

        mounted() { 
        },
    }
</script>
<style scoped>
    @media (max-width: 767px) {
        .content-header{
            padding-top: 10%;
        }
    }
</style>
