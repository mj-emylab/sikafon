<template>
    <div>
        <modal ref="woModal" modal-class-name="ShowPackage" :modalClasses="'modal-md'">
        <template slot="header">
            <div class="modal-title row">
                <h2 class="col-12">
                    <span><b>Show</b></span>
                </h2>
            </div>
        </template>
        <template slot="close-button">
            <button @click.prevent="hideShowModal" title="Click to close modal" class="btn btn-danger btn-sm">
                <!-- <i class="fa fa-window-close"></i> -->
                <span>&times;</span>
            </button>
        </template>
        <template>

            

            <loading
                :active="saveLoading"
                :is-full-page="false"
                loader="bars"
                :width="20"
                :height="20"/>

            <div v-if="showShow" class="mt-3">
                <div class="row mx-1 my-3" v-for="(row, index) in showData" :key="index">
                    <div class="col-11">
                        <button class="col-12 bg-green" @click.prevent="editPackageModal(row)">
                            Edit/View
                        </button>
                    </div>
                    <div class="col-1 mt-5">
                        <a href="" title="Click to delete input fields" @click.prevent="deleteShowItem(row)">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                </div>
            </div>

        </template>
        <template slot="footer">
            <button @click.prevent="hideShowModal" title="Click to close modal" class="btn btn-danger btn-sm">
                <i class="fa fa-window-close"></i>
                <span>Close</span>
            </button>
        </template>
        </modal>

         <package-modal v-if="showShow" ref="package" />
    </div>
</template>
<script>
import Modal from "../components/CustomModal.vue";
import helper from '../helpers/helpers';
import { createNamespacedHelpers } from 'vuex';
import CustomInput from '../components/CustomInput.vue';
import WoFileUploader from '../components/WoFileUploader.vue';

import PackageModal from './PackageModal.vue';

const { mapActions, mapGetters } = createNamespacedHelpers('administration');

export default {
    components: {
        Modal,
        CustomInput,
        WoFileUploader,
        PackageModal,
    },
    data() {
        return {

            showShow: false,
            showData: [],
            saveLoading:false,
        }
    },
    methods: {
        ...mapActions(['deletePackageAction']),

        editPackageModal(row) {
            this.hideShowModal();
            this.showShow = true;
            this.$refs.package.openEditModal(row);
        },

        openAddPackageModal(row) {
            this.clearDataShow();

            this.showData = row.package;
            this.showShow = true;

            $(".ShowPackage").modal('show');
        },

        hideShowModal() {
            this.showShow = false;
            helper.hideModal(".ShowPackage");
        },

        clearDataShow(){
            this.showData = [];
            this.show = false;
        },

        deleteShowItem(row) {
            helper.deletingAlert("record will be deleted")
            .then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    this.deletePackageAction(row)
                    .then((res) => {

                        // this.hideShowModal();

                        // let i = this.showData.map(item => item.id).indexOf(row.id);
                        // console.log(this.showData[i]);
                        // this.showData.slice(i, 1);

                        this.showData = this.showData.filter((value) =>value.id != row.id);


                        this.isLoading = false;
                        helper.successAlert("record deleted");
                    }).catch((error) => {
                        this.isLoading = false;
                        helper.errorMessage(error);
                    });
                }
            });
        },

    },
    created() {
        // this.allPackageAction()
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
