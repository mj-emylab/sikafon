<template>
  
    <div class="container-fluid px-3">
        <div class="row min-vh-100">
            <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
              <div class="w-100 py-5 px-md-5 px-xxl-6 position-relative">
                  <div class="mb-1">
                    <router-link :to="'/'"><img class="img-fluid mb-4" src="assets/img/logo-square.svg" alt="..." style="max-width: 4rem;"></router-link>
                  <h2>Sign up</h2>
                  <p class="text-muted">Welcome to Egal ghana ...</p>
                  </div>
                  <form @submit.prevent="registerUser" class="form-validate">
                  <!-- <div class="mb-1">
                      <input class="form-control" v-model="user.first_name" name="firstName" id="firstName" type="text" placeholder="first name" autocomplete="off" required data-msg="Please enter your first name">
                  </div>
                  <div class="mb-1">
                      <input class="form-control" v-model="user.middle_name" name="middleName" id="middleName" type="text" placeholder="middle name" autocomplete="off" data-msg="Please enter your middle name">
                  </div>
                  <div class="mb-1">
                      <input class="form-control" v-model="user.last_name" name="lastName" id="lastName" type="text" placeholder="last name" autocomplete="off" required data-msg="Please enter your last name">
                  </div> -->
                  <div class="mb-1">
                      <input class="form-control" v-model="user.email" name="email" id="email" type="email" placeholder="name@address.com" autocomplete="off" data-msg="Please enter your email">
                  </div>

                  
                  <div class="mb-1">
                      <vue-tel-input class="form-control" @validate="checkNumber" v-bind="vueTelProps" v-model="user.phone"></vue-tel-input>
                  </div>
                  <div class="row" id="num_val" style="display:none">
                      <p id="num_error" class="text-warning"></p>
                  </div>

                  <div class="mb-1">
                      <input class="form-control" v-model="user.gh_card_id" @change="checkName(1)" name="gh_card_id" id="gh_card_id" type="text" placeholder="Ghana Card ID" autocomplete="off" required data-msg="Please enter your Ghana Card ID">
                  </div>
                  <div class="row" id="guess" style="display:none">
                      <p id="guess_msg" class="text-warning"></p>
                      <p id="guess_name" class="text-warning"></p>
                  </div>

                  <div class="mb-1">
                      <input class="form-control" @keyup="keyUp" @change="keyUp" v-model="user.password" name="password" id="password" placeholder="Password" type="password" required data-msg="Please enter your password">
                  </div>
                  <div class="row" id="pass_min" style="display:none">
                      <p id="pass_error" class="text-warning"></p>
                  </div>
                  <div class="mb-1">
                      <input v-model="user.password2" class="form-control" name="loginPassword2" id="loginPassword2" placeholder="Password" type="password" required data-msg="Please enter your password">
                  </div>

                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary">Sign up</button>
                  </div>
                  <hr class="my-3 hr-text letter-spacing-2" data-content="OR">
                  <div class="d-grid gap-2">
                      <button class="btn btn btn-outline-primary btn-social"><i class="fa-2x fa-facebook-f fab btn-social-icon"> </i>Connect <span class="d-none d-sm-inline">with Facebook</span></button>
                      <button class="btn btn btn-outline-muted btn-social"><i class="fa-2x fa-google fab btn-social-icon"> </i>Connect <span class="d-none d-sm-inline">with Google</span></button>
                  </div>
                  <hr class="my-4">
                  <p class="text-sm text-muted">By signing up you agree to Directory's <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>.</p>
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
const { mapActions: mapActionsForInventory } = createNamespacedHelpers('inventory');
export default {
  data() {
    return {
      isLoading: false,
      numStatus: 0,
      userStatus: 0,

      passStatus: 0,

      showMapStatus: 0,
      showNamesStatus: 0,

      vuePhoneProps: {
        clearable: true,
        fetchCountry: true,
        required: true,
        defaultCountry: "GH",
        preferredCountries: ["NG", "GH"],
        noExample: false,
        translations: {
          countrySelectorLabel: "Country code",
          countrySelectorError: "Error",
          phoneNumberLabel: "Enter your phone",
          example: "Example:"
        }
      },

      vueTelProps: {
        // mode: "international",
        defaultCountry: "GH",
        placeholder: "Enter a phone number",
        required: true,
        preferredCountries: ["GH", "NG"],
      },
      categories: [],

      userName:{
        name: '',
        country_code: ''
      },
      user: {
        email: "",
        password: "",
        password2: "",
        phone: '',
        country: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        gh_card_id: '',
        remember_me: false,
        country_code: '',
        dial_code: '',

      },
    };
  },

  computed: {
    ...mapGetters(['getUserName']),
  },

  methods: {
    ...mapActions(['registerAction', 'userNameAction']),

    showPassword() {
      helpers.showPassword(document.getElementById("password"));
    },

    validateNumber(num) {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if(num.match(lowerCaseLetters)) {  
        return false;
      }

      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if(num.match(upperCaseLetters)) {  
        return false;
      }

      // Validate Special caracter
      var specialChar = /(_|[^\w\d ])/;
      if(num.match(specialChar)) {  
        return false;
      }
      return true;
    },

    checkNumber({ number, isValid, country }){
      // console.log(number, isValid, country);
      this.numStatus = 0;

      // this.user.country = country.name
      // this.user.dial_code = country.dialCode
      // this.user.country_code = country.iso2

      this.user.country = country? country.name: '';
      this.user.dial_code = country ? country.dialCode: ''
      this.user.country_code = country ? country.iso2: ''

      var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

      if(this.user.phone != ''){
        if(this.user.phone.length < 9){
          
          document.getElementById("num_val").style.display = "block";
          $('#num_error').html('invalid contact')
          this.numStatus = 1;
        }else{
          // if(re.test(this.user.phone)){
          if(this.validateNumber(this.user.phone)){
            document.getElementById("num_val").style.display = "none";
            $('#num_error').html('')
            // console.log('numbers')
            this.numStatus = 0;
          }else{
            
            document.getElementById("num_val").style.display = "block";
            $('#num_error').html('invalid contact')
            this.numStatus = 1;
          }
        }
      }else{
        document.getElementById("guess").style.display = "none";
        $('#guess_msg').html('')
        this.numStatus = 0;
      }

      

      // console.log(this.user.countryCode, this.user.dialCode, this.user.country);

    },

    showNames(){
      if(this.showNamesStatus == 0){
        
        document.getElementById("names").style.display = "block";
        this.showNamesStatus = 1
      }else{
        document.getElementById("names").style.display = "none";
        this.showNamesStatus = 0
      }
    },

    checkName(type){
      
    },

    ///////for pass validations

    // When the user starts to type something inside the password field
    keyUp() {

      // var myInput = document.getElementById("password");
      var myInput = this.user.password;

      var length = document.getElementById("length");

      // Validate length
      if(myInput.length >= 8) {
        document.getElementById("pass_min").style.display = "none";
        $('#pass_error').html('')
        this.passStatus = 0;
      } else if(myInput.length == 0) {
        document.getElementById("pass_min").style.display = "none";
        $('#pass_error').html('')
        this.passStatus = 1;
      } else {
        document.getElementById("pass_min").style.display = "block";
        $('#pass_error').html('password must be up to 8 characters!!!')
        this.passStatus = 1;
      }
    }, //end pass validation

    registerUser() {
      if(this.user.password == this.user.password2) {
        if (this.userStatus == 0) {
          if (this.numStatus == 0) {
            if (this.passStatus == 0) {
              let data = this.user;
              this.registerAction(data).then((res) => {
                helpers.successAlert("Account created");
                this.clear();
                this.isLoading = false;

                this.$router.push({ path: "/index" });
                
              }).catch((error) => {
                this.isLoading = false;
                helpers.errorMessage(error);
              });
            } else {
              helpers.errorAlert("Password not valid");
            }
          } else {
            helpers.errorAlert("Contact not valid");
          }

          
        } else {
          helpers.errorAlert("Card ID not accepted please recheck again");
        }
      } else {
        helpers.errorAlert("Please confirm your password");
      }
      
    },

    clear(){
      this.user.first_name = '';
      this.user.last_name = '';
      this.user.middle_name = '';
      this.user.email= "";
      this.user.password= "";
      this.user.phone= '';
      this.user.country= '';
      this.user.gh_card_id= '';
      this.user.remember_me= false;

      this.userStatus = 0;
      this.numStatus = 0;
      this.passStatus = 0;

    },

  },

  created() {
  },

  mounted() {
  },

};
</script>
<style scoped>
  
</style>
