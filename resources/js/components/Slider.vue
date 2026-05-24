<template>
    <div class="slider">
        <div class="owl-carousel">

            <div class="slider-card" v-for="(item,index) in item" :key="index">
                <div class="swiper-slide h-auto px-2">
                    <div class="w-100 h-100 hover-animate" data-marker-id="59c0c8e33b1527bfe2abaf92">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-img-top overflow-hidden gradient-overlay"> 
                                <img class="img-fluid" :src="item.business_pic? item.business_pic:'assets/img/sikafon.png'" alt="Modern, Well-Appointed Room"/>
                                <router-link :to="{path:'/business_1',query:{id: item.id}}" class="tile-link"></router-link>
                                <div class="card-img-overlay-top text-end"><a class="card-fav-icon position-relative z-index-40" href="javascript: void();"> 
                                    <svg class="svg-icon text-white">
                                        <use xlink:href="#heart-1"> </use>
                                    </svg></a>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-center">
                                <div class="w-100">
                                    <h6 class="card-title">
                                        <router-link :to="{path:'/business_1',query:{id: item.id}}" class="text-decoration-none text-dark">
                                        {{item.name}}
                                        </router-link>
                                    </h6>
                                    <p class="text-sm text-secondary card-subtitle mb-2"><i class="fa fa-map-marker text-secondary opacity-4 me-1"></i>{{item.address}} ({{item.phone}})</p>
                                    <p class="text-sm text-muted text-uppercase">
                                        
                                        <router-link :to="{path:'/business_1',query:{id: item.id}}" style="color: rgb(146, 143, 143); font-size: 12px; text-decoration: none;">
                                            <i class="fas fa-hamburger"></i> {{item.business_code}}
                                        </router-link>
                                    </p>
                                    <p class="card-text d-flex justify-content-between text-gray-800 text-sm">
                                        <router-link :to="{path:'/business_1',query:{id: item.id}}" >
                                            <span class="me-1">
                                                Views   
                                            </span>
                                        </router-link>
                                        <span v-if="item.status != 0" class="me-1">
                                            <img src="assets/img/icons8-approval-24.png" height="20px">
                                            
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>   
    </div> 
</template>
<script>
    export default {
        props: {
            item: {type: Array, default: () => []},
        },
        data() {
            return {
                
            }
        },
        methods: {
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
            this.myCarousel();
        },
        created() {
            this.myCarousel();
        },

    }
</script>
<style scoped>

</style>
