<template>
  
  <div class="container-fluid px-3">
      <div class="row min-vh-100">
          <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
            <div class="w-100 py-5 px-md-5 px-xxl-6 position-relative">
                <div class="mb-4">
                  <router-link :to="'/'"><img class="img-fluid mb-4" src="assets/img/logo-square.svg" alt="..." style="max-width: 4rem;"></router-link>
                <h2>Welcome to Findme Membership</h2>
                <p class="text-muted">Please fill the following form to claim your discounts</p>
                </div>
                <form @submit.prevent="registerUser" class="form-validate">
                <div class="mb-4">
                    <label class="form-label" for="firstName"> Card No.</label><span class="text-danger">*</span>
                    <input class="form-control" v-model="user.first_name" name="firstName" id="firstName" type="text" placeholder="card number" autocomplete="off" required data-msg="Please enter your first name">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="firstName"> First Name</label><span class="text-danger">*</span>
                    <input class="form-control" v-model="user.first_name" name="firstName" id="firstName" type="text" placeholder="first name" autocomplete="off" required data-msg="Please enter your first name">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="middleName"> Middle Name</label>
                    <input class="form-control" v-model="user.middle_name" name="middleName" id="middleName" type="text" placeholder="middle name" autocomplete="off" data-msg="Please enter your middle name">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="lastName"> Last Name</label><span class="text-danger">*</span>
                    <input class="form-control" v-model="user.last_name" name="lastName" id="lastName" type="text" placeholder="last name" autocomplete="off" required data-msg="Please enter your last name">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="email"> Email Address</label>
                    <input class="form-control" v-model="user.email" name="email" id="email" type="email" placeholder="name@address.com" autocomplete="off" data-msg="Please enter your email">
                </div>

                <!-- <div class="mb-4">
                    <label class="form-label" for="showMap">Click To Show Map</label>
                    <input class="form-control" @click="showMap" name="showMap" id="showMap" type="radio" placeholder="show map" autocomplete="off" data-msg="show map">
                </div> -->
                <div class="mb-4" id="map" style="display:none">
                    <!-- <gmap-map ref="map" @click="clicked"
                        :center="{ lat: 7.777799446548184, lng: -1.756994012507438 }"
                        :zoom="12"
                        map-type-id="roadmap"
                        style="width: 400px; height: 400px">
                        <GmapMarker v-if="mapData" :position="mapData" label="S"/>
                    </gmap-map> -->

                    <!-- <gmap-map ref="map" @click="clicked"
                      :center="{ lat: coordinates.lat, lng: coordinates.lng }"
                      :zoom="12"
                      map-type-id="roadmap"
                      class="form-group"
                      style="width: 100%; height: 400px">
                      <GmapMarker v-if="coordinates" :position="coordinates" label="C"/>
                    </gmap-map> -->
                </div>
                <div class="mb-4">
                    <label class="form-label" for="long"> Longitude</label>
                    <input class="form-control" v-model="user.long" name="long" id="long" type="text" disabled>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="lat"> Latitude</label>
                    <input class="form-control" v-model="user.lat" name="lat" id="lat" type="text" disabled>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="area"> Area</label><span class="text-danger">*</span>
                    <input class="form-control" v-model="user.area" name="area" id="area" type="text" placeholder="area" autocomplete="off" required data-msg="Please enter your area name">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="phone"> Contact</label><span class="text-danger">*</span>
                    <vue-tel-input class="form-control" @validate="checkNumber" v-bind="vueTelProps" v-model="user.phone"></vue-tel-input>
                </div>
                <div class="row" id="num_val" style="display:none">
                    <p id="num_error" class="text-warning"></p>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="findMeId"> FindMe ID / Username</label><span class="text-danger">*</span>
                    <input class="form-control" v-model="user.findMeId" @change="checkName(1)" name="findMeId" id="findMeId" type="text" placeholder="findme ID" autocomplete="off" required data-msg="Please enter your findme ID">
                </div>
                <div class="row" id="guess" style="display:none">
                    <p id="guess_msg" class="text-warning"></p>
                    <p id="guess_name" class="text-warning"></p>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password"> Enter your password</label><span class="text-danger">*</span>
                    <input class="form-control" @keyup="keyUp" @change="keyUp" v-model="user.password" name="password" id="password" placeholder="Password" type="password" required data-msg="Please enter your password">
                </div>
                <div class="row" id="pass_min" style="display:none">
                    <p id="pass_error" class="text-warning"></p>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="loginPassword2"> Confirm your password</label><span class="text-danger">*</span>
                    <input v-model="user.password2" class="form-control" name="loginPassword2" id="loginPassword2" placeholder="Password" type="password" required data-msg="Please enter your password">
                </div>

                <div class="d-grid gap-2">
                  <button class="btn btn-lg btn-primary" style="background-color:green" type="submit">Claim</button>
                </div>


                <hr class="my-4">
                <p class="text-sm text-muted">And hope you've read and agree to our Directory's <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>.</p>
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
import helpers from "../helpers/helpers";
import { createNamespacedHelpers } from 'vuex';
const {mapActions, mapGetters} = createNamespacedHelpers('auth');
const { mapActions: mapActionsForInventory } = createNamespacedHelpers('inventory');
export default {
data() {
  return {
    isLoading: false,
    numStatus: 0,
    userStatus: 0,

    userStatus2: 0,
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
      // disabledFetchingCountry: false,
      // disabled: false,
      // disabledFormatting: false,
      placeholder: "Enter a phone number",
      required: true,
      // enabledCountryCode: false,
      // enabledFlags: true,
      preferredCountries: ["GH", "NG"],
      // invalidMsg: "Wrong number",
      // onlyCountries: [],
      // ignoredCountries: [],
      // autocomplete: "off",
      // name: "telephone",
      // maxLen: 25,
      // wrapperClasses: "",
      // inputClasses: "",
      // dropdownOptions: {
      //   disabledDialCode: false
      // },
      // inputOptions: {
      //   showDialCode: false
      // }
    },
    categories: [],

    userName:{
      name: '',
      country_code: ''
    },
    userName2:{
      name: '',
      country_code: ''
    },
    user: {
      email: "",
      password: "",
      password2: "",
      phone: '',
      area: '',
      country: '',
      first_name: '',
      middle_name: '',
      last_name: '',
      findMeId: '',
      remember_me: false,
      country_code: '',
      dial_code: '',
      lat: null,
      long: null,
      genId: '',



      has_business: 0,
      b_description: '',
      b_category_id: '',
      b_name: '',
      b_store: '',
      b_code: '',
      b_address: '',
      findMeId2: '',

    },
  };
},

computed: {
  ...mapGetters(['getUserName']),

  coordinates() {
    return {
      lat: parseFloat(this.user.lat),
      lng: parseFloat(this.user.long),
    };
  },

},

methods: {
  ...mapActions(['registerAction', 'userNameAction']),
  ...mapActionsForInventory(['getCategoryAction']),

  showBusiness() {
    if(this.user.has_business == 1) {
      this.user.has_business = 0
    } else {
      this.user.has_business = 1
    }
  },

  getCategories() {
    this.getCategoryAction().then((res) => {
      this.categories = res.filter((value) =>value.type == 'business');
    }).catch((error) => {
      helpers.errorMessage(error);
    });
  },

  showPassword() {
    helpers.showPassword(document.getElementById("password"));
  },

  checkContact({ countryCode,isValid,phoneNumber,countryCallingCode}){
    // console.log(countryCode)

  },

  clicked(e) {
    this.user.lat = e.latLng.lat();
    this.user.long = e.latLng.lng();
  },

  success(position) {
    this.user.lat =  position.coords.latitude
    this.user.long = position.coords.longitude
  },

  geolocation (){
    // navigator.geolocation.getCurrentPosition((position) => {
    //   this.user.lat =  position.coords.latitude
    //   this.user.long = position.coords.longitude
    // });

    if (navigator.geolocation) {
        navigator.permissions
        .query({ name: "geolocation" })
        .then((result) => {
            if (result.state === "granted") {
              navigator.geolocation.getCurrentPosition(this.success)

              // navigator.geolocation.getCurrentPosition((position) => {
              //   // this.user.lat =  position.coords.latitude
              //   // this.user.long = position.coords.longitude
              // });
            } else {
              // console.log('result', result)
              return helpers.errorAlert("Please make sure you allow Findme to access your location!");
            }
        });
    }
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

  //
  showMap(){
    if(this.showMapStatus == 0){
      
      document.getElementById("map").style.display = "block";
      this.showMapStatus = 1
    }else{
      document.getElementById("map").style.display = "none";
      this.showMapStatus = 0
    }
    
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
    var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

    if(this.user.country_code == '' || this.user.phone == ''){
      if(type ==2){
        document.getElementById("guess2").style.display = "block";
        $('#guess_msg2').html('Please fill your phone number first')
      } else {
        document.getElementById("guess").style.display = "block";
        $('#guess_msg').html('Please fill your phone number first')
      }
      
    }else{
      if(type ==2){
        $('#guess_msg2').html('')
        document.getElementById("guess2").style.display = "none";
      } else {
        $('#guess_msg').html('')
        document.getElementById("guess").style.display = "none";
      }
      

      if(this.user.findMeId == '' && type ==2){
        document.getElementById("guess2").style.display = "block";
        $('#guess_msg2').html('Please enter code')
        this.userStatus2 = 1;

      } else if(this.user.findMeId == '' && type ==1){
        document.getElementById("guess").style.display = "block";
        $('#guess_msg').html('Please enter username')
        this.userStatus = 1;
        
      }else{
        if(this.user.findMeId.length < 3 && type ==1){
          document.getElementById("guess").style.display = "block";
          $('#guess_msg').html('Name should be more than three letters')
          this.userStatus = 1;

        } else if(this.user.findMeId2.length < 3 && type ==2){
          document.getElementById("guess2").style.display = "block";
          $('#guess_msg2').html('Name should be more than three letters')
          this.userStatus2 = 1;

        }else{
          if(type ==2){
            var space = this.user.findMeId2.split(' ');
            var hyphen = this.user.findMeId2.split('-');

            if (space.length < 2 && hyphen.length < 2) {
              if(re.test(this.user.findMeId2)){
                document.getElementById("guess2").style.display = "block";
                $('#guess_msg2').html('Name should have letters')
                this.userStatus2 = 1;
              }else{

                $('#guess_msg2').html('')
                this.userStatus2 = 0
                document.getElementById("guess2").style.display = "none";

                var uname = this.user.findMeId2.toLowerCase()
                var genId  = 'e-'+uname;

                // this.userName.name = genId;
                this.userName2.name = this.user.findMeId2;
                this.userName2.country_code = this.user.country_code;

                this.userNameAction(this.userName2).then((res) => {

                  if(this.getUserName.status == 0){
                    document.getElementById("guess2").style.display = "none";
                    $('#guess_msg2').html('')

                    this.user.b_code = genId
                    this.userStatus2 = 0;
                  }else{
                    document.getElementById("guess2").style.display = "block";
                    $('#guess_msg2').html(this.getUserName.msg)
                    $('#guess_name2').html('Please try: '+this.getUserName.guess)
                    // helpers.successAlert("Name not available");
                    this.userStatus2 = 1;
                  }

                }).catch((error) => {
                  this.userStatus2 = 1;
                  // helpers.errorMessage(error);
                });
              }
            } else {
              document.getElementById("guess2").style.display = "block";
              $('#guess_msg2').html("Code shouldn't have white space or hyphen!!!")
              this.userStatus2 = 1;
            }



          } else {
            var space = this.user.findMeId.split(' ');
            var hyphen = this.user.findMeId.split('-');

            if (space.length < 2 && hyphen.length < 2) {
              if(re.test(this.user.findMeId)){
                document.getElementById("guess").style.display = "block";
                $('#guess_msg').html('Name should have letters')
                this.userStatus = 1;
              }else{

                $('#guess_msg').html('')
                this.userStatus = 0
                document.getElementById("guess").style.display = "none";

                //send req
                // var uname = this.user.findMeId.toUpperCase()
                var uname = this.user.findMeId.toLowerCase()
                // var genId  = this.user.country_code+'-'+uname+'@FM';
                var genId  = 'e-'+uname;

                // this.userName.name = genId;
                this.userName.name = this.user.findMeId;
                this.userName.country_code = this.user.country_code;

                this.userNameAction(this.userName).then((res) => {
                  // helpers.successAlert("Name granted");
                  // console.log(this.getUserName)

                  if(this.getUserName.status == 0){
                    document.getElementById("guess").style.display = "none";
                    $('#guess_msg').html('')

                    this.user.genId = genId
                    // helpers.successAlert("Name granted");
                    this.userStatus = 0;
                  }else{
                    document.getElementById("guess").style.display = "block";
                    $('#guess_msg').html(this.getUserName.msg)
                    $('#guess_name').html('Please try: '+this.getUserName.guess)
                    // helpers.successAlert("Name not available");
                    this.userStatus = 1;
                  }

                }).catch((error) => {
                  this.userStatus = 1;
                  // helpers.errorMessage(error);
                });
              }
            } else {
              document.getElementById("guess").style.display = "block";
              $('#guess_msg').html("Name shouldn't have white space or hyphen!!!")
              this.userStatus = 1;
            }
          }

        }
      }
    }
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
            if (this.user.has_business == 1 && this.userStatus2 != 0) {
              helpers.errorAlert("Business findme ID not accepted please regenerate");
            } else {

              if (this.user.lat == null || this.long == null) {
                this.geolocation ();
                // helpers.errorAlert("Please make sure you allow Findme to access your location");
              } else {
                let data = this.user;
                this.registerAction(data).then((res) => {
                  helpers.successAlert("Account created");
                  this.clear();
                  this.isLoading = false;

                  if(this.user.has_business == 1) {
                    this.$router.push({ path: "/user-business" });
                  } else {
                    this.$router.push({ path: "/index" });
                  }
                  
                }).catch((error) => {
                  this.isLoading = false;
                  helpers.errorMessage(error);
                });
              }

            }
          } else {
            helpers.errorAlert("Password not valid");
          }
        } else {
          helpers.errorAlert("Contact not valid");
        }

        
      } else {
        helpers.errorAlert("Findme ID not accepted please regenerate");
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
    this.user.area= '';
    this.user.country= '';
    this.user.findMeId= '';
    this.user.remember_me= false;

    this.userStatus = 0;
    this.numStatus = 0;
    this.passStatus = 0;

    this.user.b_description = '';
    this.user.b_category_id = 0;
    this.user.b_name = '';
    this.user.b_store = '';
    this.user.b_address = '';
    // this.user.has_business = 0;
    this.user.b_code = '';
    this.user.findMeId2 = '';

  },

},

created() {
  this.geolocation()
  this.getCategories();
},

mounted() {
  this.getCategories();
  this.geolocation()
},

};
</script>
<style scoped>

</style>
