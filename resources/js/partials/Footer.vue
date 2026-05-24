<template>
  <div>
    <footer id="footer" style="margin-top: 10%;">
        <div class="footer-newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 style="color: #fff;">Our Newsletter</h3>
                        <p style="color: #fff;">Register to our Newsletter</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="post"> <input type="email" name="email"><input type="submit" value="Subscribe"> </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i><a @click.prevent="joinAffiliate" href="#">Join Affiliate</a></li>
                            <li><i class="bx bx-chevron-right"></i> <router-link :to="'/about-us'">About us</router-link></li>
                            <li><i class="bx bx-chevron-right"></i> <router-link :to="'/contact-us'">Contact us</router-link></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p style="color: #fff;"> East Legon <br> Banana Street, Accra<br> Ghana <br><br> <strong>Phone:</strong> +233 20 823 6182<br>
                          +233 55 533 3455<br> <strong>Email:</strong> egal.ghana@gmail.com<br> </p>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-info">
                        <h3><img src="assets/img/findme_logo (2).png" height="50%" width="50%"></h3>
                        <p>Anything, Anywhere, Anyone</p>
                        <div class="social-links mt-3"> 
                          <a href="#" class="twitter">
                            <i class="fa-brands fa-facebook-f"></i>
                          </a> 
                          <a href="#" class="facebook">
                            <i class="fa-brands fa-twitter"></i>
                          </a> 
                          <a href="#" class="instagram">
                            <i class="fa-brands fa-instagram"></i>
                          </a> 
                          <a href="#" class="linkedin">
                            <i class="fa-brands fa-linkedin-in"></i>
                          </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="py-4 fw-light text-gray-300" style="background-color: #a70808;">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
              <p class="text-sm mb-md-0">&copy; {{new Date().getFullYear()}}, FindMe. All rights reserved.</p>
            </div>
            <div class="col-md-6">
              <ul class="list-inline mb-0 mt-2 mt-md-0 text-center text-md-end">
                <li class="list-inline-item"><img class="w-2rem" src="assets/img/visa.svg" alt="..."></li>
                <li class="list-inline-item"><img class="w-2rem" src="assets/img/mastercard.svg" alt="..."></li>
                <li class="list-inline-item"><img class="w-2rem" src="assets/img/paypal.svg" alt="..."></li>
                <li class="list-inline-item"><img class="w-2rem" src="assets/img/western-union.svg" alt="..."></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
<script>
import helper from '../helpers/helpers';
import { createNamespacedHelpers } from 'vuex';
const { mapActions, mapGetters } = createNamespacedHelpers('single');

export default {
    components: {
    },
    data() {
        return {
          saveLoading:false,
        }
    },
    methods: {
      ...mapActions(['allAffiliateAction']),

      joinAffiliate() {
        this.allAffiliateAction().then((res) => {
          this.saveLoading = false;
          helper.successAlert("Created Successfully");
        }).catch((error) => {
          this.saveLoading = false;
          helper.errorMessage(error);
        });

      },

    },
    created() {
        
    },
    computed: {
    },
    mounted() {
    },
}
</script>
