<template>
  <div>
    <h1>My name</h1>
    <a href="sample">sample</a>
    <router-link :to="'sample'">
        <h3 class="u-gallery-heading">Vue link</h3>
    </router-link>
  </div>
  
</template>

<script>

  export default {
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
    h1{
        color: blue;
    }
</style>

