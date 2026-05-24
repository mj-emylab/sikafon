<template>
  
  <div class="container-fluid px-3">
    <div class="row min-vh-100">
      <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
        <div class="w-100 py-5 px-md-5 px-xxl-6 position-relative">
          <div class="mb-5">
            <router-link :to="'/'"><img class="img-fluid mb-3" src="assets/img/logo-square.svg" alt="..." style="max-width: 4rem;"></router-link>
            <h2>Welcome back</h2>
          </div>
          <form @submit.prevent="loginUser" class="form-validate">
            <div class="mb-4">
              <label class="form-label" for="email"> Email</label>
              <input class="form-control" v-model="user.email" name="email" id="email" type="email" placeholder="Email" required data-msg="Please enter your email">
            </div>
            <div class="mb-4">
              <div class="row">
                <div class="col">
                  <label class="form-label" for="password"> Password</label>
                </div>
                <div class="col-auto">
                  <router-link class="form-text small text-primary" :to="'/forget_password'">Forgot password?</router-link>
                </div>
              </div>

              <input class="form-control" v-model="user.password" name="password" id="password" placeholder="Password" type="password" required data-msg="Please enter your password">

            </div>
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" id="loginRemember" type="checkbox">
                <label class="form-check-label text-muted" for="loginRemember"> <span class="text-sm">Remember me for 30 days</span></label>
              </div>
            </div>
            <!-- Submit-->
            <div class="d-grid">
              <button class="btn btn-lg btn-primary">Sign in</button>
            </div>
            <hr class="my-3 hr-text letter-spacing-2" data-content="OR">
            <div class="d-grid gap-2">
              <button class="btn btn btn-outline-primary btn-social"><i class="fa-2x fa-facebook-f fab btn-social-icon"> </i>Connect <span class="d-none d-sm-inline">with Facebook</span></button>
              <button class="btn btn btn-outline-muted btn-social"><i class="fa-2x fa-google fab btn-social-icon"> </i>Connect <span class="d-none d-sm-inline">with Google</span></button>
            </div>
            <hr class="my-4">
            <p class="text-center"><small class="text-muted text-center">Don't have an account yet? <router-link :to="'/register'">Sign Up</router-link></small></p>
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
import helpers from "./../helpers/helpers";
import { createNamespacedHelpers } from 'vuex';
const {mapActions, mapGetters} = createNamespacedHelpers('auth');
export default {
  data() {
    return {
      isLoading: false,
      user: {
        password: "",
        email: '',
        remember_me: false,

      },
    };
  },

  computed: {

  },

  methods: {
    ...mapActions(['loginAction']),

    showPassword() {
      helpers.showPassword(document.getElementById("password"));
    },

    ///////for pass validations

    // When the user clicks on the password field, show the message box
    focus() {
      document.getElementById("message").style.display = "block";
    },

    // When the user clicks outside of the password field, hide the message box
    blur() {
      document.getElementById("message").style.display = "none";
    },

    // When the user starts to type something inside the password field
    keyUp() {

      // var myInput = document.getElementById("password");
      var myInput = this.user.password;

      var letter = document.getElementById("letter");
      var capital = document.getElementById("capital");
      var number = document.getElementById("number");
      var length = document.getElementById("length");
      var special = document.getElementById("special");

      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if(myInput.match(lowerCaseLetters)) {  
        letter.classList.remove("invalid");
        letter.classList.add("valid");
      } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
      }
      
      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if(myInput.match(upperCaseLetters)) {  
        capital.classList.remove("invalid");
        capital.classList.add("valid");
      } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if(myInput.match(numbers)) {  
        number.classList.remove("invalid");
        number.classList.add("valid");
      } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
      }
      
      // Validate length
      if(myInput.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
      } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
      }

      // Validate Special caracter
      var specialChar = /(_|[^\w\d ])/;
      if(myInput.match(specialChar)) {  
        special.classList.remove("invalid");
        special.classList.add("valid");
      } else {
        special.classList.remove("valid");
        special.classList.add("invalid");
      }
    }, //end pass validation

    clear(){
      this.user.password= "";
      this.user.email= '';
      this.user.remember_me= false;
    },

    loginUser() {

      let formData = new FormData();
      this.isLoading = true;
      if(this.user.remember_me == true) {
          this.user.remember_me = 1;
      } else {
          this.user.remember_me = 0;
      }

      formData.append("email", this.user.email);
      formData.append("password", this.user.password);
      formData.append("remember_me", this.user.remember_me);

        this.loginAction(formData).then((res) => {
          helpers.successAlert("Account Verified");
          this.isLoading = false;

          this.clear();
          this.$router.push({ path: "/index" });

          // this.removeTag("login-links");
          // this.removeTag("login-scripts");

        }).catch((error) => {

          this.isLoading = false;
          helpers.errorMessage(error);
        });
    },

  },

  mounted() {
    
  },

};
</script>
<style scoped>
  #message {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
  }

  #message p {
    padding: 10px 35px;
    font-size: 18px;
  }

  /* Add a green text color and a checkmark when the requirements are right */
  .valid {
    color: green;
  }

  .valid:before {
    position: relative;
    left: -35px;
    content: "✔";
  }

  /* Add a red text color and an "x" when the requirements are wrong */
  .invalid {
    color: red;
  }

  .invalid:before {
    position: relative;
    left: -35px;
    content: "✖";
  }
</style>
