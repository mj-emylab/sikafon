<template>
    <div>
        <div class="row">
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
        <!-- start -->
        <section class="gradient-custom">
            <div class="container py-5">

                <div class="row">

                    <div class="col-md-6 col-lg-5 col-xl-5 mb-4 mb-md-0">

                        <h5 class="font-weight-bold mb-3 text-center text-white">Member</h5>

                        <div class="card mask-custom" style="height: 700px; overflow-y: auto;">
                            <div class="card-body">

                                <div class="input-group rounded mb-3">
                                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                                    aria-describedby="search-addon" />
                                    <span class="input-group-text border-0" id="search-addon">
                                    <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">John Doe</p>
                                            <p class="small text-white">Hello, Are you there?</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">Just now</p>
                                            <span class="badge bg-danger float-end">1</span>
                                        </div>
                                        </a>
                                    </li>
                                    <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">Danny Smith</p>
                                            <p class="small text-white">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">5 mins ago</p>
                                        </div>
                                        </a>
                                    </li>
                                    <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">Alex Steward</p>
                                            <p class="small text-white">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">Yesterday</p>
                                        </div>
                                        </a>
                                    </li>
                                    <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">Ashley Olsen</p>
                                            <p class="small text-white">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">Yesterday</p>
                                        </div>
                                        </a>
                                    </li>
                                    <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">Kate Moss</p>
                                            <p class="small text-white">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">Yesterday</p>
                                        </div>
                                        </a>
                                    </li>
                                    <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpgp" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">Lara Croft</p>
                                            <p class="small text-white">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">Yesterday</p>
                                        </div>
                                        </a>
                                    </li>
                                    <li class="p-2">
                                        <a href="#!" class="d-flex justify-content-between link-light">
                                        <div class="d-flex flex-row">
                                            <img src="admin/dist/img/user2-160x160.jpgp" alt="avatar"
                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                            <div class="pt-1">
                                            <p class="fw-bold mb-0">Brad Pitt</p>
                                            <p class="small text-white">Lorem ipsum dolor sit.</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-white mb-1">5 mins ago</p>
                                            <span class="text-white float-end"><i class="fas fa-check" aria-hidden="true"></i></span>
                                        </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-lg-7 col-xl-7">

                        <ul class="list-unstyled text-white" style="height: 500px; overflow-y: auto;">
                            <li class="d-flex justify-content-between mb-4">
                                <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                <div class="card mask-custom">
                                    <div class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                        <p class="fw-bold mb-0">Brad Pitt</p>
                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                        labore et dolore magna aliqua.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between mb-4">
                                <div class="card mask-custom w-100">
                                    <div class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                        <p class="fw-bold mb-0">Lara Croft</p>
                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">
                                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                        laudantium.
                                        </p>
                                    </div>
                                </div>
                                <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                            </li>
                            <li class="d-flex justify-content-between mb-4">
                                <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                <div class="card mask-custom">
                                    <div class="card-header d-flex justify-content-between p-3"
                                        style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                        <p class="fw-bold mb-0">Brad Pitt</p>
                                        <p class="text-light small mb-0"><i class="far fa-clock"></i> 10 mins ago</p>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                        labore et dolore magna aliqua.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            
                        </ul>
                        <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2 mb-3">
                            <img src="admin/dist/img/user2-160x160.jpg" alt="avatar"
                                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="40">
                            <textarea class="form-control" rows="1"></textarea>
                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                            <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- end -->

        <!-- start 2 -->
        <section style="background-color: #CDC4F9;">
            <div class="container py-5">

                <div class="row">
                    <div class="col-md-12">

                        <div class="card" id="chat3" style="border-radius: 15px;">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                                        <div class="p-3">

                                            <div class="input-group rounded mb-3">
                                                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                                                aria-describedby="search-addon" />
                                                <span class="input-group-text border-0" id="search-addon">
                                                <i class="fas fa-search"></i>
                                                </span>
                                            </div>

                                            <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px; overflow-y: auto;">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="p-2 border-bottom">
                                                        <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                            <img
                                                                src="admin/dist/img/user2-160x160.jpg"
                                                                alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                            <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                            <p class="fw-bold mb-0">Marie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Just now</p>
                                                            <span class="badge bg-danger rounded-pill float-end">3</span>
                                                        </div>
                                                        </a>
                                                    </li>
                                                    <li class="p-2 border-bottom">
                                                        <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                            <img
                                                                src="admin/dist/img/user2-160x160.jpg"
                                                                alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                            <span class="badge bg-warning badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                            <p class="fw-bold mb-0">Alexa Chung</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">5 mins ago</p>
                                                            <span class="badge bg-danger rounded-pill float-end">2</span>
                                                        </div>
                                                        </a>
                                                    </li>
                                                    <li class="p-2 border-bottom">
                                                        <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                            <img
                                                                src="admin/dist/img/user2-160x160.jpg"
                                                                alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                            <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                            <p class="fw-bold mb-0">Danny McChain</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                        </a>
                                                    </li>
                                                    <li class="p-2 border-bottom">
                                                        <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                            <img
                                                                src="admin/dist/img/user2-160x160.jpg"
                                                                alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                            <span class="badge bg-danger badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                            <p class="fw-bold mb-0">Ashley Olsen</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                        </a>
                                                    </li>
                                                    <li class="p-2 border-bottom">
                                                        <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                            <img
                                                                src="admin/dist/img/user2-160x160.jpg"
                                                                alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                            <span class="badge bg-warning badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                            <p class="fw-bold mb-0">Kate Moss</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                        </a>
                                                    </li>
                                                    <li class="p-2">
                                                        <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                            <img
                                                                src="admin/dist/img/user2-160x160.jpg"
                                                                alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                            <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                            <p class="fw-bold mb-0">Ben Smith</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 col-lg-7 col-xl-8">

                                        <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px; overflow-y: auto;">

                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Lorem ipsum
                                                    dolor
                                                    sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore
                                                    magna aliqua.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row justify-content-end">
                                                <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Ut enim ad minim veniam,
                                                    quis
                                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                                </div>
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            </div>

                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Duis aute
                                                    irure
                                                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                                </p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row justify-content-end">
                                                <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Excepteur sint occaecat
                                                    cupidatat
                                                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                                </div>
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            </div>

                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Sed ut
                                                    perspiciatis
                                                    unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam
                                                    rem
                                                    aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
                                                    dicta
                                                    sunt explicabo.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row justify-content-end">
                                                <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Nemo enim ipsam
                                                    voluptatem quia
                                                    voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos
                                                    qui
                                                    ratione voluptatem sequi nesciunt.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                                </div>
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            </div>

                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Neque porro
                                                    quisquam
                                                    est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non
                                                    numquam
                                                    eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row justify-content-end">
                                                <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Ut enim ad minima veniam,
                                                    quis
                                                    nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea
                                                    commodi
                                                    consequatur?</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                                </div>
                                                <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            </div>

                                        </div>

                                        <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                            <img src="admin/dist/img/user2-160x160.jpg"
                                                alt="avatar 3" style="width: 40px; height: 100%;">
                                            <input type="text" class="form-control form-control-lg" id="exampleFormControlInput2"
                                                placeholder="Type message">
                                            <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                            <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            </section>
        <!-- end -->
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
            addOrUpdate: false,
            show: false,


            type: 1, //1 for single and 2 for multiple
            
            formData:{
                account_id: 0,
                amount_to_cash: 0.00,
                commissions:[],
            },
            
        }
    },
    methods: {
        ...mapActions(['payCommissionAction', 'allPaymentChannelAction', 'allCommissionAction']),

        hideModal() {
            helper.hideModal(".PayCommission");
            // $(".PayCommission").modal('hide');
        },

        getTotal(index){
            let field = this.formData.commissions[index];

            this.formData.amount_to_cash += parseFloat(field.amount)
        },

        subTract(index){
            let field = this.formData.commissions[index];

            this.formData.amount_to_cash -= parseFloat(field.amount)
        },

        removeField(index) {
            this.subTract(index);
            this.formData.commissions.splice(index, 1)
        },

        openEditModal(row, type) {
            this.clearData();

            if(type == 1){

                if(row.status == 1){
                    this.formData.commissions = [];
                    this.formData.commissions.push({
                        id: row.id,
                        amount: parseFloat(row.amount).toFixed(2),
                        original_amount: parseFloat(row.amount).toFixed(2),
                    });
                    this.getTotal(0);
                    this.show = true;
                }

            } else {
                this.formData.commissions = [];
                let index = 0
                row.forEach(item => {

                    if(item.status == 1){
                        this.formData.commissions.push({
                            
                            id: item.id,
                            amount: item.amount,
                            original_amount: item.amount,
                        })
                        this.getTotal(index);
                        index++;
                    }

                });
                this.show = true;
            }

            this.addOrUpdate = true;
            helper.openModal(".PayCommission");
        },

        clearData(){
            this.formData.account_id = 0;
            this.formData.amount_to_cash = 0.00;
            this.formData.commissions = [];
            this.show = false;
            // this.formData.commissions = {id: 0, amount: 0, original_amount: 0};
        },

        saveData() {
            // this.saveLoading = true;
            const data = this.formData;
            // const data = {formdata: this.formData}
            this.payCommissionAction(data).then((res) => {
                this.saveLoading = false;
                this.allCommissionAction();
                this.hideModal();
                helper.successAlert("Created Successfully");
                this.clearData()
            }).catch((error) => {
                this.saveLoading = false;
                helper.errorMessage(error);
            });

        },

    },
    created() {
        this.allPaymentChannelAction()
    },
    computed: {
        ...mapGetters(['getPaymentChannels']),

        
    },

    mounted() {

    },

    
}
</script>
<style scoped>

    /* chat one */
        .gradient-custom {
            /* fallback for old browsers */
            background: #fccb90;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to bottom right, rgba(252, 203, 144, 1), rgba(213, 126, 235, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to bottom right, rgba(252, 203, 144, 1), rgba(213, 126, 235, 1))
        }

    .mask-custom {
        background: rgba(24, 24, 16, .2);
        border-radius: 2em;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.05);
        background-clip: padding-box;
        box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    }

    /* end */
    /* chat two */
    #chat3 .form-control {
        border-color: transparent;
    }

    #chat3 .form-control:focus {
        border-color: transparent;
        box-shadow: inset 0px 0px 0px 1px transparent;
    }

    .badge-dot {
        border-radius: 50%;
        height: 10px;
        width: 10px;
        margin-left: 2.9rem;
        margin-top: -.75rem;
    }
    /* end */







    /* -webkit- (Chrome, Safari, newer versions of Opera)  */
    /* .element::-webkit-scrollbar { width: 0 !important } */

    /* -moz- (Firefox) */
    /* .element { overflow: -moz-scrollbars-none; } */

    /* -ms- (Internet Explorer +10) */
    /* .element { -ms-overflow-style: none; } */
</style>