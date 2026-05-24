<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Roles
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Role</li>
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
                            :total-records="getRoles ? getRoles.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getRoles">
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

    <role-modal ref="role" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import RoleModal from '../../Modals/RoleModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, RoleModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'name'},
                    // { label: 'Category', field: 'category.name'},
                    { label: 'Description', field: 'description'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allRoleAction', 'deleteRoleAction', 'updateRoleAction']),

            deleteItem(row) {
                helper.deletingAlert("event will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteRoleAction(row)
                        .then((res) => {
                            this.isLoading = false;
                            helper.successAlert("event deleted");
                        }).catch((error) => {
                            this.isLoading = false;
                            helper.errorMessage(error);
                        });
                    }
                });
            },

            showModal() {
                this.$refs.role.openAddModal();
            },

            editModal(row) {
                this.$refs.role.openEditModal(row);
            },
        },
        created() {
            this.allRoleAction();
        },
        computed: {
            ...mapGetters(['getRoles']),
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
