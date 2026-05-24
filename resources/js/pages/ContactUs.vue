<template>
  
  <div class="container-fluid px-3">
    <div class="row min-vh-100">
      <div class="col-md-8 col-lg-6 col-xl-5 d-flex align-items-center">
        <div class="w-100 py-5 px-md-5 px-xxl-6 position-relative">
          <div class="mb-5">
            <router-link :to="'/'"><img class="img-fluid mb-3" src="assets/img/logo-square.svg" alt="..." style="max-width: 4rem;"></router-link>
            <h2>Welcome to Findme Africa</h2>
          </div>
          <form @submit.prevent="contact" class="form-contact">
            <div class="mb-4">
              <label class="form-label" for="contact"> Contact</label><span class="text-danger">*</span>
              <input class="form-control" v-model="contactData.contact" name="contact" id="contact" type="text" placeholder="contact" autocomplete="off" required data-msg="Please enter your contact">
            </div>
            <div class="mb-4">
              <label class="form-label" for="email"> Email</label>
              <input class="form-control" v-model="contactData.email" name="email" id="email" type="email" placeholder="email" autocomplete="off">
            </div>
            <div class="mb-4">
              <div class="row">
                <div class="col">
                  <label class="form-label" for="password"> Message</label><span class="text-danger">*</span>
                </div>
              </div>
              <textarea v-model="contactData.message" class="form-control" name="" id="" cols="30" rows="4"></textarea>

            </div>
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" id="loginRemember" type="checkbox">
                <label class="form-check-label text-muted" for="loginRemember"> <span class="text-sm">Subscribe for newsletter</span></label>
              </div>
            </div>
            <div class="d-grid gap-2">
              <button @click="call" class="btn btn btn-outline-primary btn-social">
                <i class="fa-2x fa fa-phone btn-social-icon"> </i>Call @ 
                <span class=""> +233 557522685</span>
              </button>

              <button type="submit" class="btn btn btn-outline-muted btn-social">
                <i class="fa-2x fa fa-paper-plane btn-social-icon"> </i>
                <span class="">Submit Message</span>
              </button>
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
import helpers from "./../helpers/helpers";
import { createNamespacedHelpers } from 'vuex';
const {mapActions} = createNamespacedHelpers('inventory');
export default {
  data() {
    return {
      isLoading: false,
      contactData: {
        contact: "",
        message: "",
        email: "",
        newsletter: false,

      },
    };
  },

  computed: {

  },

  methods: {
    ...mapActions(['contactAction']),

    clear(){
      this.contactData.contact= "";
      this.contactData.message= "";
      this.contactData.email= "";
      this.contactData.newsletter= false;
    },

    call() {
        window.open('tel:+233557522685');
    },

    contact() {
        if(this.contactData.contact != ""  &&  this.contactData.message != "") {

            this.contactAction(this.contactData).then((res) => {
                
                helpers.successAlert("Sent successfully");
                this.isLoading = false;

                this.clear();
                this.$router.push({ path: "/" });

            }).catch((error) => {

                this.isLoading = false;
                helpers.errorMessage(error);
            });
        } else {
            helpers.errorAlert("Contact and Message are important for sending message");
        }
    },

  },

  mounted() {
    
  },

};
</script>
<style scoped>
  
</style>
