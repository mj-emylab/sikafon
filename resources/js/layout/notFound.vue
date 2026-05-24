<template>
    <div>
        <Header ref="header"/>
        
        <div class="mh-full-screen d-flex align-items-center dark-overlay"><img class="bg-image" src="assets/img/photo/aron-visuals-3jBU9TbKW7o-unsplash.jpg" alt="Not found">
        <div class="container text-white text-lg overlay-content py-6 py-lg-0">
            <h1 class="display-3 fw-bold mb-5">Oops, that page is not here.</h1>
            <p class="fw-light mb-5">Please check your link and make sure you get the correct link. </p>
            <p class="mb-6">
                <router-link class="btn btn-danger" :to="'/'"><i class="fa fa-home me-2"></i>Start from the Homepage</router-link>
            </p>
            <p class="h4 text-shadow">Error 404</p>
        </div>
        </div>
    </div>
    
</template>
<script>
    import Header from '../partials/Header.vue';

    export default {
        components: {
          Header
        },
        data() {
            return {
                isLoading: false,
            }
        },
        methods: {
            
        },
        mounted() {
        
        }
    }
</script>
<style scoped>
    
</style>
