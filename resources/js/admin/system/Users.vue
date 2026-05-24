<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        User
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">User</li>
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
                            :total-records="getUsers ? getUsers.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getUsers">
                            <template #name="{row}">
                                {{row.first_name}} {{row.last_name}}
                            </template>
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#FF0000" class="badge" @click.prevent="changeModal(row)" v-if="row.status == 0">
                                    User
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge" @click.prevent="changeModal(row)" v-else-if="row.status == 1">
                                    Super Admin
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge" @click.prevent="changeModal(row)" v-else-if="row.status == 2">
                                    Admin
                                </span>
                                <span style="text-color: white; background-color:#2E8B57" class="badge" @click.prevent="changeModal(row)" v-else-if="row.status == 3">
                                    Agent
                                </span>
                                <span style="text-color: white; background-color:#FF0000" class="badge" @click.prevent="changeModal(row)" v-else>
                                    Others
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
                                        <a  @click.prevent="editModal(row)" class="dropdown-item"  title="View" href="#">
                                            <i class="fa fa-eye text-success"></i> View
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
    <user-modal ref="user" />
    <change-modal ref="change" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import UserModal from '../../modals/UserModal';
    import ChangeModal from '../../modals/ChangeModal';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, UserModal, ChangeModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'name'},
                    { label: 'Findme ID', field: 'findme_id'},
                    // { label: 'Role', field: 'type'},
                    { label: 'Type', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allUserAction', 'deleteUserAction', 'updateUserAction']),

            deleteItem(row) {
                helper.deletingAlert("record will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteUserAction(row)
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
                // this.$refs.user.openAddModal();
            },

            changeModal(row) {
                this.$refs.change.openAddModal(row);
            },

            editModal(row) {
                this.$refs.user.editModal(row);
            },
        },
        created() {
            this.allUserAction();
        },
        computed: {
            ...mapGetters(['getUsers']),
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
