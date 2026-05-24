<template>
    <div>
        <div class="row gallery ms-n1 me-n1">
            <div v-for="(item, index) in item" :key="index" class="col-lg-4 col-6 px-1 mb-2">
                <a :href="item.url">
                <img class="img-fluid" :src="item.url" alt="...">
                </a>
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
            myGallery(){
                // ------------------------------------------------------- //
                //   Lightbox in galleries
                // ------------------------------------------------------ //

                $(".slider-gallery").each(function() {
                    // the containers for all your galleries
                    $(this).magnificPopup({
                        delegate: "a", // the selector for gallery item
                        type: "image",
                        gallery: {
                            enabled: true,
                            tCounter: "", // markup of counter
                        },
                    });
                });

                $(".gallery").each(function() {
                    // the containers for all your galleries
                    $(this).magnificPopup({
                        delegate: "a", // the selector for gallery item
                        type: "image",
                        gallery: {
                            enabled: true,
                        },
                    });
                });
            }
        },
        mounted() {
            this.myGallery();
        },
        created() {
            this.myGallery();
        },

    }
</script>
<style scoped>

</style>
