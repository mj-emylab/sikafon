<template>
  <div>

    <header class="header">
        <!-- Navbar-->
        <nav class="navbar navbar-expand-lg fixed-top shadow navbar-light bg-white">
            <div class="container-fluid">
            <div class="d-flex align-items-center">
                
                <router-link :to="'/'" class="navbar-brand py-1">
                    <img src="assets/img/findmelogo.png" width="25%" style="margin-right:-254px;" alt="FindMe logo">
                </router-link>
                <div class="form-inline d-none d-sm-flex" action="#" id="search">

                    <div class="input-label-absolute input-label-absolute-left input-expand ms-lg-2 ms-xl-3"> 
                        <label class="label-absolute" for="search_search">
                            <i class="fa fa-search"></i><span class="sr-only">What are you looking for?</span>
                        </label>

                        <input @blur="clearData()" @input="searchAny()" v-model="findData.word" class="form-control form-control-sm border-0 shadow-0 bg-gray-200 show-search" id="search_search" placeholder="Search" aria-label="Search" type="search">

                    </div>
                </div>
            </div>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            
            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="form-inline mt-4 mb-2 d-sm-none" id="searchcollapsed">
                    <div class="input-label-absolute input-label-absolute-left w-100">

                        <label class="label-absolute" for="searchcollapsed_search">
                            <i class="fa fa-search"></i><span class="sr-only">What are you looking for?</span>
                        </label>
                        <input @blur="clearData()" @input="searchAny()" v-model="findData.word" class="form-control form-control-sm border-0 shadow-0 bg-gray-200 show-search" id="searchcollapsed_search" placeholder="Search" aria-label="Search" type="search">
                    </div>
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <router-link :to="'/'" class="nav-link">Home</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <!-- <a class="nav-link dropdown-toggle active" id="homeDropdownMenuLink" href="index.html" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Home</a> -->
                        <router-link :to="'/'" class="nav-link dropdown-toggle active" id="homeDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category</router-link>
                        <div class="dropdown-menu" aria-labelledby="homeDropdownMenuLink">
                            <router-link :to="'/business'" class="dropdown-item">Business</router-link>
                            <router-link :to="'/service'" class="dropdown-item">Services</router-link>
                            <router-link :to="'/professional'" class="dropdown-item">Professionals</router-link>
                            <router-link :to="'/event'" class="dropdown-item">Events <span class="badge badge-info-light ms-1 mt-n1">New</span></router-link>
                            <router-link :to="'/job'" class="dropdown-item">Jobs <span class="badge badge-info-light ms-1 mt-n1">New</span></router-link>

                        </div>
                    </li>
                    <!-- Megamenu-->

                    <!-- /Megamenu end-->
                    <li class="nav-item">
                        <router-link :to="'/contact'" class="nav-link">Contact</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="'/login'" class="nav-link">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="'/register'" class="nav-link">Sign up</router-link>
                    </li>
                    <!-- <li class="nav-item mt-3 mt-lg-0 ms-lg-3 d-lg-none d-xl-inline-block"><a class="btn btn-primary" href="user-add-0.html">Add a listing</a></li> -->

                    <li class="nav-item dropdown position-static">
                        <a class="my-drop-div nav-link"></a>
                        <div class="dropdown-menu megamenu py-lg-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div v-if="searchData" class="row p-3 pe-lg-0 ps-lg-5 pt-lg-5">
                                        
                                        <div class="col-lg-2">

                                            <h6 class="text-uppercase">Businesses</h6>
                                            <ul v-if="searchData.business" class="megamenu-list list-unstyled">
                                                <li v-for="(b, index) in searchData.business" :key="index" class="megamenu-list-item">
                                                    <a @click.prevent="searchNav('business_1', b.id)" class="megamenu-list-link" >{{b.name}}   </a>
                                                </li>
                                                
                                            </ul>
                                        </div>

                                        <div class="col-lg-2">
                                            
                                            <h6 class="text-uppercase">Jobs</h6>
                                            <ul v-if="searchData.job" class="megamenu-list list-unstyled">
                                                <li v-for="(j, index) in searchData.job" :key="index" class="megamenu-list-item">
                                                    <a @click.prevent="searchNav('job_1', j.id)" class="megamenu-list-link" >{{j.job_name}}   </a>
                                                </li>
                                                
                                            </ul>
                                        </div>

                                        <div class="col-lg-2">
                                            
                                            <h6 class="text-uppercase">Professionals</h6>
                                            <ul v-if="searchData.professional" class="megamenu-list list-unstyled">
                                                <li v-for="(p, index) in searchData.professional" :key="index" class="megamenu-list-item">
                                                    <a @click.prevent="searchNav('professional_1', p.id)" class="megamenu-list-link" >{{p.pro_title}}   </a>
                                                </li>
                                                
                                            </ul>
                                        </div>

                                        <div class="col-lg-2">

                                            <h6 class="text-uppercase">Events</h6>
                                            <ul v-if="searchData.event" class="megamenu-list list-unstyled">
                                                
                                                <li v-for="(e, index) in searchData.service" :key="index" class="megamenu-list-item">
                                                    <a @click.prevent="searchNav('vent_1', e.id)" class="megamenu-list-link">{{e.event_name}} 
                                                        <span class="badge badge-info-light ms-1">{{e.event_date}}</span>   
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-lg-2">
                                            
                                            <h6 class="text-uppercase">Services</h6>
                                            <ul v-if="searchData.service" class="megamenu-list list-unstyled">
                                                <li v-for="(s, index) in searchData.service" :key="index" class="megamenu-list-item">
                                                    <a @click.prevent="searchNav('service_1', s.id)" class="megamenu-list-link" >{{s.service_name}}   </a>
                                                </li>
                                                
                                            </ul>
                                        </div>

                                        <div class="col-lg-2">
                                            
                                            <h6 class="text-uppercase">Users</h6>
                                            <ul v-if="searchData.user" class="megamenu-list list-unstyled">
                                                <li v-for="(u, index) in searchData.user" :key="index" class="megamenu-list-item">
                                                    <a v-if="!(['e-admin', 'e-super'].includes(u.findme_id))" @click.prevent="searchNav('people', u.findme_id)" class="megamenu-list-link" >{{u.first_name}}   </a>
                                                </li>
                                                
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
        <!-- /Navbar -->
    </header>


  </div>
</template>
<script>
    import helpers from "./../helpers/helpers";
    import {
        createNamespacedHelpers
    } from 'vuex';

    const {mapActions} = createNamespacedHelpers('auth');
    const { mapActions: mapActionsForInventory } = createNamespacedHelpers('inventory');

    export default {
        data() {
            return {
                findData: {
                    word: '',
                    type: '',
                },

                searchData: [],
            }
        },
        computed: {

            user() {
                return this.$store.getters['auth/user'];
            },

            sideBar() {
                return this.sideBarItems.filter(value => value.role.includes(this.user.role.name));
            }
        },
        created() {
            const authUser = this.$store.getters['auth/user'];
            
        },
        methods: {

            ...mapActions(['logoutAction']),
            ...mapActionsForInventory(['searchAction']),

            searchAny() {
                this.searchAction(this.findData).then((res) => {
                    this.searchData = res;
                    
                }).catch((error) => {
                    helpers.errorMessage(error);
                });
            },

            searchNav(page, id) {
                let currentRouteName = this.$route.path;

                if(page != '/') {
                    if(currentRouteName != '/'+page) {
                        this.$router.push({
                            path: page,
                            query:{id:id}
                        })
                    } else {
                        this.$router.push({
                            query:{id:id}
                        })
                    }
                } else {
                    this.$router.push({
                        path: page,
                        query:{id:id}
                    })
                }
            },

            clearData() {
                this.findData.word = '';
            },

            logout() {
                helpers.deletingAlert("You want to log out? ")
                    .then((result) => {
                        if (result.value) {
                            this.logoutAction()
                                .then((res) => {
                                    this.$store.commit('reset');
                                    location.reload();
                                    this.$router.push({
                                        path: "/"
                                    });
                                }).catch((error) => {
                                    helpers.errorAlert('Failed to log you out. Please try again')
                                });
                        }
                    });
            },

        },
        mounted() {
            function closeAllOpen(){
                var elements = $(".my-drop-div");
                elements.parents(".dropdown").removeClass("show").addClass( "hide" );
                elements.next("div .dropdown-menu").removeClass("show").addClass( "hide" );
            }
            $('.show-search').click(function(e){
                if($(".my-drop-div").parents(".dropdown").hasClass('show')) {

                    $(".my-drop-div").parents(".dropdown").removeClass("show").addClass( "hide" );
                    $(".my-drop-div").next("div .dropdown-menu").removeClass("show").addClass( "hide" );
                    return
                } else {
                    // closeAllOpen();
                    
                    $(".my-drop-div").parents(".dropdown").addClass("show");
                    $(".my-drop-div").next("div .dropdown-menu").addClass("show");
                    return
                    
                }
            });
            $(document).click(function(e){

                if($(e.target).closest(".my-drop-div").length != 0) {
                    return false
                } else if($(e.target).closest(".show-search").length != 0) {
                    
                } else {
                    closeAllOpen();
                }
            });
        }

    }
</script>
<style type="text/css">
    a:hover {
        cursor: pointer;
    }
</style>