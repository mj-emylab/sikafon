<template>
    <div>

        <section class="hero-home">
            <div class="swiper-container hero-slider">
                <div class="swiper-wrapper dark-overlay">
                <div class="swiper-slide" style="background-image:url(assets/img/sikafon.png)"></div>
                <div class="swiper-slide" style="background-image:url(assets/img/photo/photo-1519974719765-e6559eac2575.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(assets/img/photo/photo-1490578474895-699cd4e2cf59.jpg)"></div>
                <div class="swiper-slide" style="background-image:url(assets/img/photo/photo-1534850336045-c6c6d287f89e.jpg)"></div>
                </div>
            </div>
            <div class="container py-6 py-md-7 text-white z-index-20" style="font-family: 'Montserrat', sans-serif;">
                <div class="row">
                    <div class="col-xl-10">
                        <div class="text-center text-lg-start">
                        <p class="subtitle letter-spacing-4 mb-2 text-secondary text-shadow">Uncover the best places for everything</p>
                        <h1 class="display-3 fw-bold text-shadow">Find With Findme ID</h1>
                        </div>
                        <div class="search-bar mt-5 p-3 p-lg-1 ps-lg-4">
                            <div>
                                <div class="row">
                                    <div class="col-lg-10 d-flex align-items-center">
                                        <input @blur="clearData()" @input="searchAny()" data-bs-toggle="dropdown" v-model="findData.word"  class="form-control border-0 shadow-0" type="text" placeholder="What are you searching for?">

                                        <div style="overflow-x:auto" class="dropdown-menu megamenu py-lg-0 my-2 px-2">
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
                                                                
                                                                <li v-for="(e, index) in searchData.event" :key="index" class="megamenu-list-item">
                                                                    <a @click.prevent="searchNav('vent_1', e.id)" class="megamenu-list-link">{{e.event_name}} 
                                                                        <span class="badge badge-info-light ms-1">{{e.event_date | dateOnly}}</span>   
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

                                    </div>
                                    <!-- <div class="col-lg-3 d-flex align-items-center form-group">
                                        <div class="input-label-absolute input-label-absolute-right w-100">
                                        <label class="label-absolute" for="location"><i class="fa fa-crosshairs"></i><span class="sr-only">City</span></label>
                                        <input class="form-control border-0 shadow-0" type="text" name="location" placeholder="Location" id="location">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-flex align-items-center form-group no-divider">
                                        <select class="">
                                        <option value="small">Restaurants</option>
                                        <option value="medium">Hotels</option>
                                        <option value="large">Cafes</option>
                                        <option value="x-large">Garages</option>
                                        <option value="x-large">Artisans</option>
                                        </select>
                                    </div> -->
                                    <div class="col-lg-2 d-grid">
                                        <button @click.prevent="searchAny" class="btn btn-primary rounded-pill h-100" type="button">Search </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="pt-3 mt-2">
            <div class="container">
                <div class="row mb-lg-6">
                    <div class="col-md-8">
                        <p class="subtitle text-secondary">Find top businesses today</p>
                        <h2 class="mb-md-0">Featured listings around you</h2>
                    </div>
                    <div class="col-md-4 d-md-flex align-items-center justify-content-end">
                    
                        <router-link :to="'/business'" class="text-muted text-sm">
                            See all featured listings<i class="fas fa-angle-double-right ms-2"></i>
                        </router-link>
                   </div>
                </div>
            </div>
            <div v-if="business != null" class="container-fluid">   

                <slider :item="business" />
            </div>
        </section>

        <section class="pt-3 mt-2" style="margin-top: -10%;">
            <div class="container">
                <div class="row mb-lg-6">
                    <div class="col-md-8">
                        <p class="subtitle text-secondary">Find top services today</p>
                        <h2 class="mb-md-0">Featured services around you</h2>
                    </div>
                    <div class="col-md-4 d-md-flex align-items-center justify-content-end">
                        <router-link :to="'/service'" class="text-muted text-sm">
                        See all featured services<i class="fas fa-angle-double-right ms-2"></i>
                        </router-link>
                    </div>
                </div>
                <div class="row">

                    <div v-for="(item,index) in getAllServices" :key="index" class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                        <router-link :to="{path:'/service_1',query:{id: item.id}}" >
                        <div class="px-0 pe-lg-4">

                            <div v-if="index == 0" class="icon-rounded mb-3 bg-primary-light">
                                <svg class="svg-icon w-2rem h-2rem text-primary">
                                <use xlink:href="#destination-map-1"> </use>
                                </svg>
                            </div>
                            <div v-if="index == 1" class="icon-rounded mb-3 bg-secondary-light">
                                <svg class="svg-icon w-2rem h-2rem text-secondary">
                                <use xlink:href="#real-estate-1"> </use>
                                </svg>
                            </div>
                            <div v-if="index == 2" class="icon-rounded mb-3 bg-primary-light">
                                <svg class="svg-icon w-2rem h-2rem text-primary">
                                <use xlink:href="#pay-1"> </use>
                                </svg>
                            </div>

                            <h3 class="h6 text-uppercase">{{item.service_name}}</h3>
                            <p class="text-muted text-sm">{{item.description}}</p>
                        </div>
                        </router-link>

                    </div>
                    
                </div>
            </div>
        </section>

        <section class="pt-3 mt-2 bg-gray-100"> 
            <div v-if="professional != null" class="container">
                <div class="row mb-5">
                    <div class="col-md-8">
                        <p class="subtitle text-secondary">Check out.</p>
                        <h2>Professionals</h2>
                    </div>
                    <div class="col-md-4 d-lg-flex align-items-center justify-content-end">
                        <router-link :to="'/professional'" class="text-muted text-sm">
                            See all deals<i class="fas fa-angle-double-right ms-2"></i>
                        </router-link>
                    </div>
                </div>


                <swiper :item="professional" :page="'home'" :type="'professional'" ref="swiper"/>


            </div>
        </section>

        <section style="padding-left: 5%; padding-right: 5%; margin-top: 4pc;">
            <div class="row mb-lg-6">
                <div class="col-md-8">
                    <p class="subtitle text-secondary">Looking for available jobs?</p>
                    <h2 class="mb-md-0">Top Jobs around you</h2>
                </div>
                <div class="col-md-4 d-md-flex align-items-center justify-content-end">
                    <router-link :to="'/job'" style="float: right;">
                        See all available jobs<i class="fas fa-angle-double-right ms-2"></i>
                    </router-link>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-md-6 col-lg-6 col-xl-5 col-xxl-4" ><img src="assets/img/jobman.jpg" id="job-img"></div>
                    <div class="col-sm-12 col-md-6 col-xl-7 col-xxl-8">
                        <h1 id="job-h1">Looking for available jobs?</h1>
                        <hr>
                        <p>Are you intelligent, success-driven, creative then you have come to the right place</p>
                        <router-link class="btn btn-primary" :to="'/job'" style="border-radius: 5px;padding: 8px 12px;box-shadow: 0px 0px var(--bs-gray-700);">See more</router-link>
                    </div>
                </div>
            </div>
        </section> 

        <section class="py-6 py-lg-7 position-relative dark-overlay" style="margin-top: 10%;"><img class="bg-image" src="assets/img/photo/photo-1507915135761-41a0a222c709.jpg" alt="">
            <div class="container">
                <div class="overlay-content text-white py-lg-5 text-center">
                    <p class="subtitle text-white letter-spacing-4 mb-4">Book your favourite Events</p>
                    <h3 class="display-3 fw-bold text-serif text-shadow mb-5">Travel & Explore</h3>
                    <p class="lead text-shadow mb-5">One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections</p><router-link class="btn btn-primary" :to="'/event'" style="float: right;">See Event</router-link>
                </div>
            </div>
        </section>
    
        <section class="pt-3 mt-2 bg-gray-100"> 
            <div v-if="event != null" class="container">
                <div class="row mb-5">
                    <div class="col-md-8">
                        <p class="subtitle text-secondary">Hurry up, these are expiring soon.        </p>
                        <h2>Upcoming Events</h2>
                    </div>
                    <div class="col-md-4 d-lg-flex align-items-center justify-content-end">
                        <router-link :to="'/event'" class="text-muted text-sm">
                            See all deals<i class="fas fa-angle-double-right ms-2"></i>
                        </router-link>
                    </div>
                </div>



                <swiper :item="event" :page="'home'" :type="'event'" ref="swiper"/>



            </div>
        </section>

        <section class="subscription bg-white promo_section pt-3 pb-2 mt-2 mb-4"  style="padding-left: 5%; padding-right: 5%;">
            <div class="col-md-8">
            <p class="subtitle text-secondary">Looking for people around you?</p>
            <h2 class="mb-md-0">Find anyone here</h2>
            </div>
            <div class="card shadow" style="padding: 43px;border-radius: 30px;width: auto;margin-left: -10px;margin-top: 33px;">
                <div class="card-body"></div>
                <div class="container">
                    <div class="row" style="margin-top: -30px;">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <p style="font-size: 30px;font-family: Montserrat, sans-serif;color: var(--bs-gray-800);text-shadow: 0px 1px 5px var(--bs-gray-500);width: 233px;">Request to find people</p>
                        </div>
                        <div class="col-md-6 col-lg-8 col-xl-5">
                            <form style="height: 38px;margin-top: 23px;width: 399px;"><input class="form-control" type="text" style="width: auto;padding: 15px 12px;border-radius: 30px;border: 2px solid var(--bs-gray-500);" placeholder="FindMe ID" v-model="findUserData.findme_id"></form>
                        </div>
                        <div class="col" style="background:transparent">
                            <button @click.prevent="findUser" class="btn btn-primary" type="button" style="margin-top: 30px;padding: 15px 12px;width: 200.5px;border-radius: 25px;border: none; background: #ED213A; 
                            background: -webkit-linear-gradient(to right, #93291E, #ED213A);  
                            background: linear-gradient(to right, #93291E, #ED213A);">Request</button></div>
                    </div>
                </div>
            </div>
        </section>


        
        <!-- <DownAd ref="header"/> -->

        
        <!-- Instagram-->
        <section>
            <div class="container-fluid px-0">
                <div class="swiper-container instagram-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-1.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-2.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-3.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-4.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-5.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-6.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-7.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-8.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-9.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-10.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-11.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-12.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-13.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-14.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-10.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-11.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-12.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-13.jpg" alt=" "></a></div>
                        <div class="swiper-slide overflow-hidden"><a href="#"><img class="img-fluid hover-scale" src="assets/img/instagram/instagram-14.jpg" alt=" "></a></div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>

    import helper from '../../helpers/helpers.js';
    import DownAd from '../../partials/HomeAd.vue';
    import Slider from '../../components/Slider.vue';
    import Swiper from '../../components/Swiper.vue';

    import { createNamespacedHelpers } from 'vuex';
    const { mapActions, mapGetters } = createNamespacedHelpers('inventory');

  export default {
    components: {
        DownAd, Slider, Swiper,
    },
    data() {
        return {
            show: false,
            business: null,
            event: null,
            professional: null,

            isLoading: false,
            findData: {
                word: '',
                type: '',
            },
            findUserData: {
                findme_id: '',
                type: '',
            },

            searchData: [],
        }
    },
    methods: {
        ...mapActions(['allBusinessAction', 'allServiceAction', 'allJobAction', 'allProfessionalAction', 'allEventAction', 'findAnyAction', 'searchAction']),

        findUser(){

            if( ['e-admin', 'e-super'].includes(this.findUserData.findme_id) ) {
                helper.errorAlert("Findme ID not for people");
            } else {

                this.findAnyAction(this.findUserData).then((res) => {
                    let data = res;
                    this.clearData()
                    if (data.path == 'people') {
                        this.$router.push({
                            path: data.path, 
                            query:{id: data.id}
                        })
                    } else {
                        helper.errorAlert("Findme ID not for people");
                    }
                    
                }).catch((error) => {
                    helper.errorMessage(error);
                });
            }

            
        },

        searchAny() {
            this.searchAction(this.findData).then((res) => {
                this.searchData = res;
                
            }).catch((error) => {
                helper.errorMessage(error);
            });
        },

        searchNav(page, id) {

            if(page != '/') {
                this.$router.push({
                    path: page,
                    query:{id:id}
                })
            }
        },

        clearData() {
            this.findData.word = '';
            this.findUserData.findme_id = '';
        },

        clickHandler(item){

        },

        loadFile(path, type) {

            if (type == "js") {
                var fileref = document.createElement("script")
                fileref.setAttribute("type", "text/javascript")
                fileref.setAttribute("src", path)
                fileref.setAttribute("class", "home-i-scripts")
                fileref.async = true;

                document.body.appendChild(fileref)

            } else if (type == "css") {
                var fileref = document.createElement("link")
                fileref.setAttribute("rel", "stylesheet")
                fileref.setAttribute("type", "text/css")
                fileref.setAttribute("href", path)
                fileref.setAttribute("class", "home-i-links")
                fileref.async = true;

                document.getElementsByTagName("head")[0].appendChild(fileref)
            }
            
        },

        removeTags(className){
            var elements = document.getElementsByClassName(className);
            while(elements.length > 0){
                elements[0].parentNode.removeChild(elements[0]);
            }
        },

        myCarousel(){
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                center: true,
                nav: true,
                navText: [
                    "<i class= 'fa fa-3x fa-angle-left'style='color: var(--bs-danger);'></i>",
                    "<i class= 'fa fa-3x fa-angle-right' style='color: var(--bs-danger);'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,

                    },
                    600: {
                        items: 1,

                    },
                    1000: {
                        items: 4,

                    }
                }
            })
        }

        
    },
    mounted() {
        // this.removeTags("home-i-links");
        // this.removeTags("single-i-scripts");
        // this.removeTags("home-i-scripts");

        // this.loadFile("assets/js/init2.js", "js")
        // this.loadFile("assets/js/theme.js", "js")
        

        // $(document).ready(function() {
            
            
            
            // this.show = true;
        // });
      
    },
    created() {

        Promise.all([
            this.allBusinessAction(),
            this.allProfessionalAction(),
            this.allEventAction()
        ]).then((res) => {
            this.allGetter;

            // this.myCarousel();
        }).catch((error) => {
            // helper.errorMessage(error);
            // this.show= false;
        });

        this.allServiceAction();
        this.allJobAction();
    },
    computed: {
        ...mapGetters(['getAllBusinesses', 'getAllServices', 'getAllJobs', 'getAllEvents', 'getAllProfessionals']),

        allGetter() {
            this.business = this.getAllBusinesses;
            this.event = this.getAllEvents;
            this.professional = this.getAllProfessionals;
        }

        
    },
    

    beforeDestroy() {
        
        // this.removeTags("home-i-links");
        // this.removeTags("home-i-scripts");
    },
    destroyed() {
        // this.removeTags("home-i-links");
        // this.removeTags("home-i-scripts");
    },

  }
</script>
<style scoped>
    a:hover {
        cursor:pointer;
    }
    .slick-slide .slick-active .slick-current {
        z-index: 9999;
    }

</style>
