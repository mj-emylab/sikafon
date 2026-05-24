<template>
    <div>
        <div v-if="type == 'event'">



            <!-- Slider main container-->
            <div class="swiper-container swiper-container-mx-negative swiper-init pt-3" data-swiper="{&quot;slidesPerView&quot;:4,&quot;spaceBetween&quot;:20,&quot;loop&quot;:true,&quot;roundLengths&quot;:true,&quot;breakpoints&quot;:{&quot;1200&quot;:{&quot;slidesPerView&quot;:3},&quot;991&quot;:{&quot;slidesPerView&quot;:2},&quot;565&quot;:{&quot;slidesPerView&quot;:1}},&quot;pagination&quot;:{&quot;el&quot;:&quot;.swiper-pagination&quot;,&quot;clickable&quot;:true,&quot;dynamicBullets&quot;:true}}">
            <!-- Additional required wrapper-->
                <div class="swiper-wrapper pb-5">

                    <!-- Slides-->
                    <div v-for="(item,index) in item" :key="index" class="swiper-slide h-auto px-2">
                        <!-- place item-->
                        <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                            <div class="card h-100 border-0 shadow">

                                <div class="card-img-top overflow-hidden gradient-overlay"> 
                                    <img class="img-fluid w-100" :src="item.image? item.image:'assets/img/sikafon.png'" alt="Modern, Well-Appointed Room"/>
                                    <!-- <router-link class="tile-link" :to="{path:'/event_1',query:{id: item.id}}" ></router-link> -->
                                    <div class="card-img-overlay-bottom z-index-20">
                                        <div class="d-flex text-white text-sm align-items-center">
                                            <img class="avatar avatar-border-white flex-shrink-0 me-2" :src="item.image? item.image:'assets/img/sikafon.png'" :alt="item.event_name"/>
                                            <div>{{item.event_name}}</div>
                                        </div>
                                    </div>
                                    <div class="card-img-overlay-top text-end">
                                        <router-link class="card-fav-icon position-relative z-index-40" :to="{path:'/event_1',query:{id: item.id}}" >

                                            <rate :status="item.status" />
                                        </router-link>
                                    </div>
                                </div>

                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                    <h6 class="card-title">
                                        <router-link class="text-decoration-none text-dark" :to="{path:'/event_1',query:{id: item.id}}" >{{item.event_description}}</router-link>
                                    </h6>
                                    <div class="d-flex card-subtitle mb-3">
                                        <p class="flex-grow-1 mb-0 text-muted text-sm">{{item.location}}</p>
                                        <star
                                            icon="fa fa-star"
                                            :item="item.comments"
                                            colorDown="text-gray-300"
                                            colorUp="text-warning"
                                            ref="star"
                                        />
                                    </div>
                                    <p class="card-text text-muted"><span class="h4 text-primary">{{item.slots}}</span> Slots</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <!-- If we need pagination-->
                <div class="swiper-pagination"></div>
            </div>
            
        </div>

        <div v-if="type == 'professional'">
            <!-- Slider main container-->
            <div class="swiper-container swiper-container-mx-negative swiper-init pt-3" data-swiper="{&quot;slidesPerView&quot;:4,&quot;spaceBetween&quot;:20,&quot;loop&quot;:true,&quot;roundLengths&quot;:true,&quot;breakpoints&quot;:{&quot;1200&quot;:{&quot;slidesPerView&quot;:3},&quot;991&quot;:{&quot;slidesPerView&quot;:2},&quot;565&quot;:{&quot;slidesPerView&quot;:1}},&quot;pagination&quot;:{&quot;el&quot;:&quot;.swiper-pagination&quot;,&quot;clickable&quot;:true,&quot;dynamicBullets&quot;:true}}">
                <!-- Additional required wrapper-->
                <div class="swiper-wrapper pb-5">

                    <!-- Slides-->
                    <div v-for="(item,index) in item" :key="index" class="swiper-slide h-auto px-2">
                        <!-- place item-->
                        <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                            <div class="card h-100 border-0 shadow">

                                <div class="card-img-top overflow-hidden gradient-overlay"> 
                                    <img class="img-fluid w-100" :src="item.image? item.image:'assets/img/sikafon.png'" alt="Modern, Well-Appointed Room"/>
                                    <router-link class="tile-link" :to="{path:'/professional_1',query:{id: item.id}}" ></router-link>
                                    <div class="card-img-overlay-bottom z-index-20">
                                        <div class="d-flex text-white text-sm align-items-center">
                                            <img class="avatar avatar-border-white flex-shrink-0 me-2" :src="item.image? item.image:'assets/img/sikafon.png'" :alt="item.pro_title"/>
                                            <div>{{item.pro_title}}</div>
                                        </div>
                                    </div>
                                    <div class="card-img-overlay-top text-end">
                                        <router-link class="card-fav-icon position-relative z-index-40" :to="{path:'/professional_1',query:{id: item.id}}" >
                                            <rate :status="item.status" />
                                        </router-link>
                                    </div>
                                </div>

                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                    <h6 class="card-title">
                                        <router-link class="text-decoration-none text-dark" :to="{path:'/professional_1',query:{id: item.id}}" >{{item.pro_description}}</router-link>
                                    </h6>
                                    <div class="d-flex card-subtitle mb-3">
                                        <p class="flex-grow-1 mb-0 text-muted text-sm">{{item.pro_location}}</p>
                                        <star
                                            icon="fa fa-star"
                                            :item="item.comments"
                                            colorDown="text-gray-300"
                                            colorUp="text-warning"
                                            ref="star"
                                        />
                                    </div>
                                    <p class="card-text text-muted"><span class="h4 text-primary">{{item.pro_title}}</span> Professional</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
                <!-- If we need pagination-->
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div v-if="type == 'business'">
            <!-- Slider main container-->
            <div class="swiper-container swiper-container-mx-negative swiper-init pt-3" data-swiper="{&quot;slidesPerView&quot;:4,&quot;spaceBetween&quot;:20,&quot;loop&quot;:true,&quot;roundLengths&quot;:true,&quot;breakpoints&quot;:{&quot;1200&quot;:{&quot;slidesPerView&quot;:3},&quot;991&quot;:{&quot;slidesPerView&quot;:2},&quot;565&quot;:{&quot;slidesPerView&quot;:1}},&quot;pagination&quot;:{&quot;el&quot;:&quot;.swiper-pagination&quot;,&quot;clickable&quot;:true,&quot;dynamicBullets&quot;:true}}">
                <!-- Additional required wrapper-->
                <div class="swiper-wrapper pb-5">

                    <!-- Slides-->
                    <div v-for="(item,index) in item" :key="index" class="swiper-slide h-auto px-2">
                        <!-- place item-->
                        <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                            <div class="card h-100 border-0 shadow">

                                <div class="card-img-top overflow-hidden gradient-overlay"> 
                                    <img class="img-fluid w-100" :src="item.business_pic" alt="Modern, Well-Appointed Room"/>
                                    <router-link class="tile-link" :to="{path:'/business_1',query:{id: item.id}}" ></router-link>
                                    <div class="card-img-overlay-bottom z-index-20">
                                        <div class="d-flex text-white text-sm align-items-center">
                                            <img class="avatar avatar-border-white flex-shrink-0 me-2" :src="item.business_pic" :alt="item.name"/>
                                            <div>{{item.name}}</div>
                                        </div>
                                    </div>
                                    <div class="card-img-overlay-top text-end">
                                        <router-link class="card-fav-icon position-relative z-index-40" :to="{path:'/business_1',query:{id: item.id}}" >
                                            <rate :status="item.status" />
                                        </router-link>
                                    </div>
                                </div>

                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                    <h6 class="card-title">
                                        <router-link class="text-decoration-none text-dark" :to="{path:'/business_1',query:{id: item.id}}" >{{item.about}}</router-link>
                                    </h6>
                                    <div class="d-flex card-subtitle mb-3">
                                        <p class="flex-grow-1 mb-0 text-muted text-sm">{{item.address}} ({{item.phone}})</p>
                                        <star
                                            icon="fa fa-star"
                                            :item="item.comments"
                                            colorDown="text-gray-300"
                                            colorUp="text-warning"
                                            ref="star"
                                        />
                                    </div>
                                    <p class="card-text text-muted"><span class="h4 text-primary">{{item.business_code}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
                <!-- If we need pagination-->
                <div class="swiper-pagination"></div>
            </div>
        </div> 

        <div v-if="type == 'job'">
            <!-- Slider main container-->
            <div class="swiper-container swiper-container-mx-negative swiper-init pt-3" data-swiper="{&quot;slidesPerView&quot;:4,&quot;spaceBetween&quot;:20,&quot;loop&quot;:true,&quot;roundLengths&quot;:true,&quot;breakpoints&quot;:{&quot;1200&quot;:{&quot;slidesPerView&quot;:3},&quot;991&quot;:{&quot;slidesPerView&quot;:2},&quot;565&quot;:{&quot;slidesPerView&quot;:1}},&quot;pagination&quot;:{&quot;el&quot;:&quot;.swiper-pagination&quot;,&quot;clickable&quot;:true,&quot;dynamicBullets&quot;:true}}">
                <!-- Additional required wrapper-->
                <div class="swiper-wrapper pb-5">

                    <!-- Slides-->
                    <div v-for="(item,index) in item" :key="index" class="swiper-slide h-auto px-2">
                        <!-- place item-->
                        <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                            <div class="card h-100 border-0 shadow">

                                <div class="card-img-top overflow-hidden gradient-overlay"> 
                                    <img class="img-fluid w-100" :src="item.image? item.image:'assets/img/sikafon.png'" alt="Modern, Well-Appointed Room"/>
                                    <router-link class="tile-link" :to="{path:'/business_1',query:{id: item.id}}" ></router-link>
                                    <div class="card-img-overlay-bottom z-index-20">
                                        <div class="d-flex text-white text-sm align-items-center">
                                            <img class="avatar avatar-border-white flex-shrink-0 me-2" :src="item.image? item.image:'assets/img/sikafon.png'" :alt="item.job_name"/>
                                            <div>{{item.job_name}}</div>
                                        </div>
                                    </div>
                                    <div class="card-img-overlay-top text-end">
                                        <router-link class="card-fav-icon position-relative z-index-40" :to="{path:'/business_1',query:{id: item.id}}" >
                                            <rate :status="item.status" />
                                        </router-link>
                                    </div>
                                </div>

                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                    <h6 class="card-title">
                                        <router-link class="text-decoration-none text-dark" :to="{path:'/business_1',query:{id: item.id}}" >{{item.job_name}}</router-link>
                                    </h6>
                                    <div class="d-flex card-subtitle mb-3">
                                        <p class="flex-grow-1 mb-0 text-muted text-sm">{{item.job_description}}...</p>
                                        <p class="text-sm text-muted text-uppercase mb-1">GHS {{item.amount}} <a href="#" class="text-dark">At {{item.job_location}}</a></p>
                                        
                                        
                                        <star
                                            icon="fa fa-star"
                                            :item="item.comments"
                                            colorDown="text-gray-300"
                                            colorUp="text-warning"
                                            ref="star"
                                        />
                                    </div>
                                    <p class="text-sm mb-0"><a class="me-1" href="#">Applicants: {{item.applicants.length}},</a><a class="me-1" href="#">Closed: {{item.deadline | dateOnly}}</a>
                                        </p>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
                <!-- If we need pagination-->
                <div class="swiper-pagination"></div>
            </div>
        </div> 

        <div v-if="type == 'service'">
            <!-- Slider main container-->
            <div class="swiper-container swiper-container-mx-negative swiper-init pt-3" data-swiper="{&quot;slidesPerView&quot;:4,&quot;spaceBetween&quot;:20,&quot;loop&quot;:true,&quot;roundLengths&quot;:true,&quot;breakpoints&quot;:{&quot;1200&quot;:{&quot;slidesPerView&quot;:3},&quot;991&quot;:{&quot;slidesPerView&quot;:2},&quot;565&quot;:{&quot;slidesPerView&quot;:1}},&quot;pagination&quot;:{&quot;el&quot;:&quot;.swiper-pagination&quot;,&quot;clickable&quot;:true,&quot;dynamicBullets&quot;:true}}">
                <!-- Additional required wrapper-->
                <div class="swiper-wrapper pb-5">

                    <!-- Slides-->
                    <div v-for="(item,index) in item" :key="index" class="swiper-slide h-auto px-2">
                        <!-- place item-->
                        <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                            <div class="card h-100 border-0 shadow">

                                <div class="card-img-top overflow-hidden gradient-overlay"> 
                                    <img class="img-fluid w-100" :src="item.image? item.image:'assets/img/sikafon.png'" alt="Modern, Well-Appointed Room"/>
                                    <router-link class="tile-link" :to="{path:'/service_1',query:{id: item.id}}" ></router-link>
                                    <div class="card-img-overlay-bottom z-index-20">
                                        <div class="d-flex text-white text-sm align-items-center">
                                            <img class="avatar avatar-border-white flex-shrink-0 me-2" :src="item.image? item.image:'assets/img/sikafon.png'" :alt="item.service_name"/>
                                            <div>{{item.service_name}}</div>
                                        </div>
                                    </div>
                                    <div class="card-img-overlay-top text-end">
                                        <router-link class="card-fav-icon position-relative z-index-40" :to="{path:'/service_1',query:{id: item.id}}" >
                                            <rate :status="item.status" />
                                        </router-link>
                                    </div>
                                </div>

                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                    <h6 class="card-title">
                                        <router-link class="text-decoration-none text-dark" :to="{path:'/service_1',query:{id: item.id}}" >{{item.service_name}}</router-link>
                                    </h6>
                                    <div class="d-flex card-subtitle mb-3">
                                        <p class="flex-grow-1 mb-0 text-muted text-sm">{{item.description}}</p>
                                        <star
                                            icon="fa fa-star"
                                            :item="item.comments"
                                            colorDown="text-gray-300"
                                            colorUp="text-warning"
                                            ref="star"
                                        />
                                    </div>
                                    <p class="card-text text-muted"><span class="h4 text-primary">At {{item.service_location}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
                <!-- If we need pagination-->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div> 
</template>
<script>
    import Star from "./Star";
    import Rate from "./Rate";

    export default {
        components: {
            Star,
            Rate
        },
        props: {
            item: {type: Array, default: () => []},
            type: {
                type: String,
                default: "none"
            },
            page: {
                type: String,
                default: "none"
            },
        },
        data() {
            return {
                
            }
        },
        methods: {
            mySwiper() {
                // =====================================================
                //      Detail slider
                // =====================================================

                var detailSlider = new Swiper(".detail-slider", {
                    slidesPerView: 3,
                    spaceBetween: 0,
                    centeredSlides: true,
                    loop: true,
                    breakpoints: {
                        991: {
                            slidesPerView: 4,
                        },
                        565: {
                            slidesPerView: 3,
                        },
                    },

                    // If we need pagination
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },

                    // Navigation arrows
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });

                var bookingDetailSlider = new Swiper(".booking-detail-slider", {
                    slidesPerView: 2,
                    spaceBetween: 0,
                    centeredSlides: true,
                    loop: true,
                    // If we need pagination
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },

                    // Navigation arrows
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });

                // =====================================================
                //      Init swipers automatically
                // =====================================================

                $(".swiper-init").each(function() {
                    var slider = $(this),
                        configuration = JSON.parse($(this).attr("data-swiper"));

                    new Swiper(slider, configuration);
                });

                var homeSlider = new Swiper(".home-slider", {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    centeredSlides: true,
                    loop: true,
                    speed: 1500,
                    parallax: true,
                    /*
                    autoplay: {
                        delay: 5000,
                    },
                    */
                    // If we need pagination
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                    // Navigation arrows
                    navigation: {
                        nextEl: "#homeNext",
                        prevEl: "#homePrev",
                    },
                });

                // =====================================================
                //      Items slider
                // =====================================================

                var itemsSlider = new Swiper(".items-slider", {
                    slidesPerView: 4,
                    spaceBetween: 20,
                    loop: true,
                    roundLengths: true,
                    breakpoints: {
                        1200: {
                            slidesPerView: 3,
                        },
                        991: {
                            slidesPerView: 2,
                        },
                        565: {
                            slidesPerView: 1,
                        },
                    },

                    // If we need pagination
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                });

                var itemsSliderFull = new Swiper(".items-slider-full", {
                    slidesPerView: 6,
                    spaceBetween: 20,
                    loop: true,
                    roundLengths: true,
                    breakpoints: {
                        1600: {
                            slidesPerView: 5,
                        },
                        1400: {
                            slidesPerView: 4,
                        },
                        1200: {
                            slidesPerView: 3,
                        },
                        991: {
                            slidesPerView: 2,
                        },
                        565: {
                            slidesPerView: 1,
                        },
                    },

                    // If we need pagination
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                });

                var guidesSlider = new Swiper(".guides-slider", {
                    slidesPerView: 5,
                    spaceBetween: 15,
                    loop: true,
                    roundLengths: true,
                    breakpoints: {
                        1200: {
                            slidesPerView: 4,
                        },
                        991: {
                            slidesPerView: 3,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        400: {
                            slidesPerView: 1,
                        },
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                });

                var brandsSlider = new Swiper(".brands-slider", {
                    slidesPerView: 6,
                    spaceBetween: 15,
                    loop: true,
                    roundLengths: true,
                    breakpoints: {
                        1200: {
                            slidesPerView: 4,
                        },
                        991: {
                            slidesPerView: 3,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                });

                var swiper = new Swiper(".hero-slider", {
                    effect: "fade",
                    speed: 2000,
                    allowTouchMove: false,
                    autoplay: {
                        delay: 10000,
                    },
                });

                var instagramSlider = new Swiper(".instagram-slider", {
                    slidesPerView: 16,
                    breakpoints: {
                        1900: {
                            slidesPerView: 12,
                        },
                        1500: {
                            slidesPerView: 10,
                        },
                        1200: {
                            slidesPerView: 8,
                        },
                        991: {
                            slidesPerView: 6,
                        },
                        768: {
                            slidesPerView: 5,
                        },
                        576: {
                            slidesPerView: 4,
                        },
                    },
                });

                var testimonialsSlider = new Swiper(".testimonials-slider", {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    loop: true,
                    roundLengths: true,
                    breakpoints: {
                        1200: {
                            slidesPerView: 3,
                            spaceBetween: 0,
                        },
                        991: {
                            slidesPerView: 2,
                            spaceBetween: 0,
                        },
                        565: {
                            slidesPerView: 1,
                        },
                    },

                    // If we need pagination
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                });
            },
        },
        mounted() {
            this.mySwiper();
        },
        created() {
            this.mySwiper();
        },

    }
</script>
<style scoped>

</style>
