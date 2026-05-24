<template>
  <!-- Content Wrapper. Contains page content -->
  <div>

    <section class="content-header">
      <h1>
        Area Boys
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><router-link :to="'/index'"><i class="fa fa-dashboard"></i> Home</router-link>></li>
        <li class="active">Area Boy</li>
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
                            :total-records="getAreaBoys ? getAreaBoys.length : 0"
                            :remote="false"
                            :columns="columns"
                            :enable-check-box="false"
                            :rows="getAreaBoys">
                            <!-- <template #category="{row}">
                                {{ row.category_name }}
                            </template> -->
                            <template #status="{row}">
                                <span style="text-color: white; background-color:#2E8B57" class="badge badge-success" @click.prevent="editStatus(row)" v-if="row.status == 1">
                                    Active
                                </span>
                                <span style="text-color: white; background-color:#8B0000" class="badge badge-info" @click.prevent="editModal(row)" v-else>
                                    Inactive
                                </span>
                            </template>
                            <template #created_at="{row}">
                                {{ row.created_at | dateOnly }}
                            </template>
                            <template #actions="{row}">
                                <div class="dropdown">
                                    
                                    <div class="row">
                                        <a  @click.prevent="editModal(row)" class=""  title="Edit" href="#">
                                            <i class="fa fa-pencil text-success"></i> Edit
                                        </a>
                                        <a @click.prevent="deleteItem(row)" class="" title="Delete" href="#">
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

    <area-boy-modal ref="areaBoy" />

  </div>
</template>

<script>

    import WoTable from "../../components/WoTable.vue";
    import helper from '../../helpers/helpers.js';
    import AreaBoyModal from '../../Modals/AreaBoyModal.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('administration');

    export default {
            components: { WoTable, AreaBoyModal },

            data() {
                return {
                isLoading: false,
                columns: [
                    { label: 'Name', field: 'user.first_name'},
                    { label: 'Findme ID', field: 'user.findme_id'},
                    // { label: 'Category', field: 'category.name'},
                    { label: 'Area', field: 'area.name'},
                    { label: 'Verified By', field: 'verifiedBy.first_name'},
                    { label: 'Status', field: 'status'},
                    { label: 'Created Date', field: 'created_at'},
                    { label: 'Actions', field: 'actions', sortable: false, thClass: 'text-center', tdClass: 'text-center'}
                ],
            }
        },
        methods: {
        ...mapActions(['allAreaBoyAction', 'deleteAreaBoyAction', 'updateAreaBoyAction']),

            deleteItem(row) {
                helper.deletingAlert("record will be deleted")
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.deleteAreaBoyAction(row)
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
                this.$refs.areaBoy.openAddModal();
            },

            editModal(row) {
                this.$refs.areaBoy.openEditModal(row);
            },
        },
        created() {
            this.allAreaBoyAction();
        },
        computed: {
            ...mapGetters(['getAreaBoys']),
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
