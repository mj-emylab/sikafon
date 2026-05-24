<template>
    <div>
        <mini-header />
        <router-view></router-view>
        <footer-nav />
    </div>

</template>
<script>
import MiniHeader from '../partials/Header.vue';
import FooterNav from '../partials/Footer.vue';
export default {
    components: {
        MiniHeader,
        FooterNav,
    },
}
</script>

