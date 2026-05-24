<template>
  <div class="container-fluid px-3">
    <div class="row min-vh-100">
      <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
        <div class="w-100 py-5 px-md-5 px-xxl-6 position-relative">
          <div class="mb-5"><img class="img-fluid mb-3" src="assets/img/logo-square.svg" alt="..." style="max-width: 4rem;">
            <h2>Hi </h2>
          </div>
          <form @submit.prevent="submitCode" class="form-validate">
            <div class="mb-4">
              <label class="form-label" for="code">Please Enter Your Reset Password Validation code</label>
              <input class="form-control" v-model="user.code" name="code" id="code" type="text" placeholder="Code" autocomplete="off" required data-msg="Please enter your findme ID">
            </div>
            <!-- Submit-->
            <div class="d-grid">
              <button class="btn btn-lg btn-primary">Submit</button>
            </div>
          </form>
          <router-link :to="'/'" class="close-absolute me-md-5 me-xl-6 pt-5">
            <svg class="svg-icon w-3rem h-3rem">
              <use xlink:href="#close-1"> </use>
            </svg>
          </router-link>
        </div>
      </div>
      <div class="col-md-4 col-lg-6 col-xl-7 d-none d-md-block">
        <!-- Image-->
        <div class="bg-cover h-100 me-n3" style="background-image: url(assets/img/photo/photo-1497436072909-60f360e1d4b1.jpg);"></div>
      </div>
    </div>
  </div>
</template>
<script>
  import Helper from "../helpers/helpers";
  import { createNamespacedHelpers } from 'vuex';
  const {mapActions} = createNamespacedHelpers('auth');
  export default {
    data() {
      return {
        isLoading: false,
        user:{
          code: ''
        },
      };
    },

    methods: {
      ...mapActions(['validateResetPasswordToken']),

      submitCode() {

        this.isLoading = true;
        let user = this.user;

        this.validateResetPasswordToken(user)
        .then((res) => {
          // console.log(res)
          this.isLoading = false;
          Helper.successAlert("Validation successful...");

          this.$router.push({ path: "/reset_password" });

        }).catch((error) => {
          this.isLoading = false;
          Helper.errorMessage(error);
        });
      },

      reset() {
      }
    },

    created() {
    },
  };
</script>
