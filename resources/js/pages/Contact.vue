<template>
  <div>
    <!-- Hero Section-->
    <section class="hero py-6 py-lg-7 text-white dark-overlay"><img class="bg-image" src="assets/img/photo/photo-1522143049013-2519756a52d4.jpg" alt="How can we help you today?">
      <div class="container overlay-content">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb text-white justify-content-center no-border mb-0">
          <li class="breadcrumb-item"><router-link :to="'/'">Home</router-link></li>
          <li class="breadcrumb-item active">Contact</li>
        </ol>
        <h1 class="hero-heading">How can we help you today?</h1>
      </div>
    </section>
    <section class="py-6">
      <div class="container">       
        <div class="row">
          <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
            <div class="icon-rounded mb-4 bg-primary-light">
              <svg class="svg-icon w-2rem h-2rem text-primary">
                <use xlink:href="#map-location-1"> </use>
              </svg>
            </div>
            <h3 class="h5">Address</h3> 
            <p class="text-muted">East Legon <br> Banana Street, Accra<br>, <strong>Ghana</strong></p>
          </div>
          <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
            <div class="icon-rounded mb-4 bg-primary-light">
              <svg class="svg-icon w-2rem h-2rem text-primary">
                <use xlink:href="#landline-1"> </use>
              </svg>
            </div>
            <h3 class="h5">Call center</h3>
            <p class="text-muted">Available 8am - 5pm work days.</p>
            <p class="text-muted"><strong>+233 20 823 6182/+233 55 533 3455</strong></p>
          </div>
          <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
            <div class="icon-rounded mb-4 bg-primary-light">
              <svg class="svg-icon w-2rem h-2rem text-primary">
                <use xlink:href="#mail-1"> </use>
              </svg>
            </div>
            <h3 class="h5">Electronic support</h3>
            <p class="text-muted">Please feel free to write an email to us or to use our electronic ticketing system.</p>
            <ul class="list-unstyled text-muted">
              <li>info@egal.com</li>
              <li>egal.ghana@gmail.com</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="py-6 bg-gray-100">
      <div class="container">
        <h2 class="h4 mb-5">Contact form</h2>
        <div class="row">
          <div class="col-md-7 mb-5 mb-md-0">
            <form class="form" @submit.prevent="contact">
              <div class="controls">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-4">
                      <label class="form-label" for="name">Your name *</label>
                      <input class="form-control" type="text" name="name" id="name"  v-model="contactData.name" placeholder="Enter your name" required="required">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-4">
                      <label class="form-label" for="contact">Your lastname *</label>
                      <input class="form-control" type="text" name="contact" id="contact" v-model="contactData.contact" placeholder="Enter your contact" required="required">
                    </div>
                  </div>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="email">Your email *</label>
                  <input class="form-control" type="email" name="email" v-model="contactData.email" placeholder="Enter your  email" required="required">
                </div>
                <div class="mb-4">
                  <label class="form-label" for="message">Your message for us *</label>
                  <textarea class="form-control" rows="4" name="message" id="message" placeholder="Enter your message" required="required" v-model="contactData.message"></textarea>
                </div>
                <button class="btn btn-outline-primary" type="submit">Send message</button>
              </div>
            </form>
          </div>
          <div class="col-md-5">
            <div class="ps-lg-4 text-sm">
              <p class="text-muted">We are always available at working hours(8am-5pm) work days. </p>
              <p class="text-muted">An enquiry sent outside of working hours might not get immediate response. </p>
              <div class="social">
                <ul class="list-inline">
                  <li class="list-inline-item"><a @click.prevent="" href="" target="_blank"><i class="fab fa-twitter"></i></a></li>
                  <li class="list-inline-item"><a @click.prevent="" href="" target="_blank"><i class="fab fa-facebook"></i></a></li>
                  <li class="list-inline-item"><a @click.prevent="" href="" target="_blank"><i class="fab fa-instagram"></i></a></li>
                  <li class="list-inline-item"><a @click.prevent="" href="" target="_blank"><i class="fab fa-pinterest"></i></a></li>
                  <li class="list-inline-item"><a @click.prevent="" href="" target="_blank"><i class="fab fa-vimeo"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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
        name: "",
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
      this.contactData.name= "";
      this.contactData.newsletter= false;
    },

    call() {
        window.open('tel:+233557522685');
    },

    contact() {
        if(this.contactData.name != ""  && this.contactData.contact != ""  &&  this.contactData.message != "") {

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
