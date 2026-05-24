<template>
<div class="nav-header bg-white">
    <router-link :to="'/index'" class="brand-logo">
        <img class="logo-abbr" :src="'/images/logo.png'" alt="">
        <span class="brand-title" style="color: #7fb401">
            <span style="font-size: 24px; font-weight: bolder; margin-right: -4px">C</span>
            <span style="font-weight: bolder; font-size: 34px;">4</span>
            <span style="font-size: 24px; font-weight: bolder; margin-left: -4px">S</span>
        </span>
    </router-link>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
</template>
<style scope>
    .nav-header {
       border-radius: 0 0 5px 5px;
       border: 2px solid #7fb401;
    }
</style>
