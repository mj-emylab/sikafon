<template>
    <div>
        <mini-header />
        <router-view></router-view>
    </div>

</template>
<script>
import MiniHeader from '../partials/Header.vue';
export default {
    components: {
        MiniHeader,
    },
    data () {
        return {}
    },
    methods: {
        
    },

    updated(){
    },

    mounted() {
        
    },
    
}
</script>

