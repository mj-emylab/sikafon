<template>
  <div>
    <section class="pt-7 pb-5 d-flex align-items-end dark-overlay bg-cover" style="min-height: 500px; background-image: url('assets/img/photo/photo-1493976040374-85c8e12f0c0e.jpg');">
      
      <div class="container overlay-content">
        <div class="text-white mb-5 mb-5" align="center">
          <h1 class="text-shadow verified">Welcome To Egal Groups</h1>
        </div> 
        <div align="right" class="calltoactions">
          <router-link :to="'/register'" class="btn btn-primary">Not a user sign up</router-link>
          <a @click.prevent="join" class="btn btn-primary" style="background-color:green;" href="">Join now</a>
        </div>
      </div>
    </section>

  </div>
</template>

<script>

  import helpers from '../../helpers/helpers.js';

  import { createNamespacedHelpers } from 'vuex';
  const { mapActions, mapGetters } = createNamespacedHelpers('single');

  export default {
    components: {

    },
    data() {
        return {
          isLoading: false,

          formData: {
            id: this.$route.query.id,
            type: 'join group',
          },
          
        }
    },
    methods: {
      ...mapActions(['joinGroupAction']),

        join() {
          this.joinGroupAction(this.formData).then((res) => {
            helpers.successAlert("success joind");
            this.$router.push({ path: "/chat" });

        }).catch((error) => {

            this.$router.push({ path: "/404" });
            
            helpers.errorMessage(error);
        });
      }
        
    },
    mounted() {
      
    },

    created() {
      // console.log(this.$route.query.id);

    },
    computed: {
    },
  }
</script>
