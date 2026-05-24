<template>
  <div class="container-fluid px-3">
    <div class="row min-vh-100">
      <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
        <div class="w-100 py-5 px-md-5 px-xxl-6 position-relative">
          <div class="mb-5"><img class="img-fluid mb-3" src="assets/img/logo-square.svg" alt="..." style="max-width: 4rem;">
            <h2>Hi </h2>
          </div>
          <form @submit.prevent="submitPassword" class="form-validate">
            <div class="mb-4">
              <label class="form-label" for="findMeId">Please Enter Your FindMe ID</label>
              <input class="form-control" v-model="changePassword.findmeId" name="findMeId" id="findMeId" type="text" placeholder="findme ID" autocomplete="off" required data-msg="Please enter your findme ID without (e-)">
            </div>
            <div class="mb-4">
              <label class="form-label" for="password">Please Enter Your New Password</label>
              <input class="form-control" @keyup="keyUp" @change="keyUp" @blur="blur" @focus="focus" v-model="changePassword.password" name="password" id="password" placeholder="Password" type="password" required data-msg="Please enter your password">

            </div>
            <div class="row" id="message">
              <h3>Password must contain the following:</h3>
              <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
              <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
              <p id="number" class="invalid">A <b>number</b></p>
              <p id="length" class="invalid">Minimum <b>8 characters</b></p>
              <p id="special" class="invalid">A <b> special character</b></p>
            </div>
            <div class="mb-4">
              <label class="form-label" for="confPass">Confirm Your New Password</label>
              <input class="form-control" v-model="changePassword.confirmPassword" name="confPass" id="confPass" placeholder="Confirm Password" type="password" required data-msg="Please confirm your password">

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
      passStatus1: 0,
      passStatus2: 0,
      passStatus3: 0,
      passStatus4: 0,
      passStatus5: 0,

      changePassword:{
        confirmPassword: '',
        password: '',
        findmeId: '',
      },
    };
  },

  methods: {
    ...mapActions(['savePasswordResetDetails']),

    showPassword() {
       Helper.showPassword(document.getElementById("pass"));
    },

    submitPassword() {
      this.changePassword.findmeId = 'e-'+this.changePassword.findmeId;

      if(this.passStatus1 != 1 && this.passStatus2 != 1 && this.passStatus3 != 1 && this.passStatus4 != 1 && this.passStatus5 != 1) {
        
        if(this.changePassword.confirmPassword == this.changePassword.password){
          this.isLoading = true;
          let user = this.changePassword;

          this.savePasswordResetDetails(user)
          .then((res) => {

            this.isLoading = false;
            Helper.successAlert("Updated");

            this.$router.push({ path: "/index" });
              
          }).catch((error) => {
              this.isLoading = false;
              Helper.errorMessage(error);
          });
        } else {
          return Helper.errorAlert("Confirm password don't match");
        }
      } else {
        return Helper.errorAlert("Invalid password");
      }
    },

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
      var myInput = this.changePassword.password;

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
        this.passStatus1 = 0;
      } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
        this.passStatus1 = 1;
      }
      
      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if(myInput.match(upperCaseLetters)) {  
        capital.classList.remove("invalid");
        capital.classList.add("valid");
        this.passStatus2 = 0;
      } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
        this.passStatus2 = 1;
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if(myInput.match(numbers)) {  
        number.classList.remove("invalid");
        number.classList.add("valid");
        this.passStatus3 = 0;
      } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
        this.passStatus3 = 1;
      }
      
      // Validate length
      if(myInput.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
        this.passStatus4 = 0;
      } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
        this.passStatus4 = 1;
      }

      // Validate Special caracter
      var specialChar = /(_|[^\w\d ])/;
      if(myInput.match(specialChar)) {  
        special.classList.remove("invalid");
        special.classList.add("valid");
        this.passStatus5 = 0;
      } else {
        special.classList.remove("valid");
        special.classList.add("invalid");
        this.passStatus5 = 1;
      }
    }, //end pass validation

    clear(){
      this.changePassword.password= "";
      this.changePassword.findmeId= '';

      this.passStatus1= 0;
      this.passStatus2= 0;
      this.passStatus3= 0;
      this.passStatus4= 0;
      this.passStatus5= 0;
    },

    reset() {
    }
  },

  created() {
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