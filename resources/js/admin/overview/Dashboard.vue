<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div v-if="dashboardData != null" class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{dashboardData.business}}</h3>

              <p>Business</p>
            </div>
            <div class="icon">
              <i class="ion-briefcase"></i>
            </div>
            <router-link :to="'/user-business'" class="small-box-footer">Add Business <i class="fa fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h3>{{dashboardData.service}}<sup style="font-size: 20px"></sup></h3>

              <p>Services</p>
            </div>
            <div class="icon">
              <i class="ion-bag"></i>
            </div>
            <router-link :to="'/user-service'" class="small-box-footer">Add Services <i class="fa fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{dashboardData.professional}}</h3>

              <p>Professionals</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <router-link :to="'/user-professional'" class="small-box-footer">Add Professionals <i class="fa fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{dashboardData.event}}</h3>

              <p>Events</p>
            </div>
            <div class="icon">
              <i class="ion ion-wineglass"></i>
            </div>
            <router-link :to="'/user-event'" class="small-box-footer">Add Events <i class="fa fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{dashboardData.job}}</h3>

              <p>jobs</p>
            </div>
            <div class="icon">
              <i class="ion ion-hammer"></i>
            </div>
            <router-link :to="'/user-job'" class="small-box-footer">Add Jobs <i class="fa fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>140</h3>

              <p>Shops</p>
            </div>
            <div class="icon">
              <i class="ion ion-pricetags"></i>
            </div>
            <a href="add-shops.html" class="small-box-footer">Add Shops <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>1200</h3>

              <p>Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>65 Pt</h3>

              <p>Sika point</p>
            </div>
            <div class="icon">
              <i class="ion-checkmark-circled"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <hr>
      <!-- /.row -->
      <!-- Main row -->
      

    </section>
     
    <!-- /.content -->
  </div>
</template>

<script>
  // import helper from '../../helpers/helpers.js';

  import { createNamespacedHelpers } from 'vuex';
  const { mapActions, mapGetters } = createNamespacedHelpers('single');

  export default {
    components: {},

    data() {
      return {
        isLoading: false,
        dashboardData: null,
      }
    },
    methods: {
      ...mapActions(['setDashboardAction']),

      getAllData() {

        this.setDashboardAction().then((res) => {
          this.getData;
        }).catch((error) => {
          // helper.errorMessage(error);
          this.dashboardData= null;
        });
      },
    },
    created() {
      this.getAllData();
    },
    computed: {
      ...mapGetters(['getDashboardData']),
      getData() {
        this.dashboardData = this.getDashboardData;
      },
    },

    mounted() {
        
      this.getAllData();
    },
  }
</script>
<style scoped>
    @media (max-width: 767px) {
        .content-header{
            padding-top: 10%;
        }
    }
</style>
