<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Payment Channels
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Payment Channel</li>
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

                        <div style="margin-left:10px; margin-bottom:5px;">
                            <span>
                                <loading
                                    :active="isLoading"
                                    :is-full-page="false"
                                    loader="bars"
                                    :width="25"
                                    :height="25"
                                ></loading>
                            </span>
                            <button style="float:right;" @click.prevent="showModal()" type="button" class="btn btn-danger mb-2 mt-2 float-right mr-1">
                                <i class="fa fa-plus"></i>
                                Add
                            </button>
                        </div>
                    
                    </ul>
                    <div class="tab-content">
                    
                        <wo-table
                            :total-records="getPaymentChannels ? getPaymentChannels.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getPaymentChannels">
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" v-if="row.status == 0">
                                    Active
                                </span>
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-danger" v-if="row.status == 1">
                                    Inactive
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
                                        <a  @click.prevent="editModal(row)" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-pencil text-success"></i> Edit
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

    <payment-channel-modal ref="paymentChannel" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import PaymentChannelModal from '../../Modals/PaymentChannelModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, PaymentChannelModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'User Name', field: 'user.first_name'},
                    // { label: 'Category', field: 'category.name'},
                    { label: 'Account Name', field: 'account_name'},
                    { label: 'Account Number', field: 'account_number'},
                    { label: 'Provider', field: 'name'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allPaymentChannelAction', 'deletePaymentChannelAction', 'updatePaymentChannelAction']),

            deleteItem(row) {
                helper.deletingAlert("record will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deletePaymentChannelAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("record deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            showModal() {
                this.$refs.paymentChannel.openAddModal();
            },

            editModal(row) {
                this.$refs.paymentChannel.openEditModal(row);
            },
        },
        created() {
            this.allPaymentChannelAction();
        },
        computed: {
            ...mapGetters(['getPaymentChannels']),
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
