<template>
  <div>
    <section class="py-5">
      <div class="container">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb ps-0  justify-content-start">
          <li class="breadcrumb-item"><router-link :to="'/'">Home</router-link></li>
          <li class="breadcrumb-item active">About Us   </li>
        </ol>
        <h1 class="hero-heading mb-0">Egal Ghana info</h1>
        <p class="text-muted mb-5">The digital home in ghana.</p>
        <div class="row">
          <div class="col-lg-7 mb-5 mb-lg-0">
            <div class="text-block"> 
              <div class="row mb-3">
                <div class="col-sm-9">
                  <h5>Contact Details</h5>
                </div>
              </div>
              <p class="text-sm text-muted"><i class="fa fa-id-card fa-fw me-2"></i>Egal Ghana<br><i class="fa fa-birthday-cake fa-fw me-2"></i>Since 2018<br><i class="fa fa-envelope-open fa-fw me-2"></i>egal.ghana@gmail.com  <span class="mx-2"> | </span>  <i class="fa fa-phone fa-fw me-2"></i>+233 20 823 6182/+233 55 533 3455</p>
              
            </div>
            <div class="text-block"> 
              <div class="row mb-3">
                <div class="col-sm-9">
                  <h5>Address</h5>
                </div>
              </div>
              <div class="d-flex text-sm text-muted"> <i class="fa fa-address-book fa-fw flex-shrink-0 me-2"></i>
                <div class="mt-n1">East Legon <br> Banana Street, Accra, Ghana.</div>
              </div>
            </div>
          </div>
          <div class="col-md-8 col-lg-4 ms-lg-auto">
            <div class="card border-0 shadow">
              <div class="card-header bg-primary-light py-4 border-0">
                <div class="d-flex align-items-center">
                  <div>
                    <h4 class="h6 subtitle text-sm text-primary">What info is shared with others?</h4>
                  </div>
                  <svg class="svg-icon svg-icon svg-icon-light w-3rem h-3rem ms-3 text-primary flex-shrink-0">
                    <use xlink:href="#identity-1"> </use>
                  </svg>
                </div>
              </div>
              <div class="card-body p-4">
                <p class="text-muted text-sm card-text">Egal is an I.T company in Ghana with the vision <strong>digitizing the whole of Africa</strong>.</p>
                <p class="text-muted text-sm card-text">Findme is the core Egal platform which connected. <strong>All other Egal platforms</strong> such as Fundme.</p>
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
    };
  },

  computed: {

  },

  methods: {

  },

  mounted() {
    
  },

};
</script>
<style scoped>
  
</style>
