<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        File Request/Response
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Request/Response</li>
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
                            :total-records="getShare ? getShare.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getShare">
                            <template #type="{row}">
                                {{ row.message.type }}
                            </template>
                            <template #from="{row}">
                                <span v-if="row.owner == 'fromU'">You</span>
                                <span v-if="row.owner == 'toU'">{{row.user.first_name}}</span>
                            </template>
                            <template #owner="{row}">
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" v-if="row.category == 'job'">
                                    {{ row.message.messageable.job_name }}
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" v-if="row.category == 'findme'">
                                    {{ row.message.messageable.first_name }}
                                </span>
                                
                            </template>
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#FF0000" class="badge badge-success" v-if="row.status == 0">
                                    Pending
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" v-if="row.status == 1">
                                    Accepted
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" v-if="row.status == 2">
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
                                        <!-- <a  @click.prevent="editModal(row)" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-comments text-success"></i> Chat
                                        </a> -->
                                        <a v-if="row.owner == 'fromU'"  @click.prevent="showModal(row, 'from')" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-eye text-success"></i> View
                                        </a>
                                        <a v-if="row.owner == 'toU'"  @click.prevent="showModal(row, 'to')" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-eye text-success"></i> View
                                        </a>
                                        <!-- <a  @click.prevent="showModal(row, 'both')" class="dropdown-item"  title="Edit" href="#">
                                            <i class="fa fa-pencil text-success"></i> View
                                        </a> -->
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

    <find-response ref="share" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import FindResponse from '../../Modals/FindResponseModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('single');

    export default {
            components: { WoTable, FindResponse },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Type', field: 'type'},
                    { label: 'To', field: 'owner'},
                    { label: 'From', field: 'from'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allShareAction', 'deleteShareAction', 'updateShareAction']),

            deleteItem(row) {
                helper.deletingAlert("business will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteBusinessAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("business deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            showModal(row, type) {
                this.$refs.share.openAddModal(row, type);
            },

            editModal(row) {
                this.$refs.share.openEditModal(row);
            }
        },
        created() {
            this.allShareAction();
        },
        computed: {
            ...mapGetters(['getShare']),
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
