<template>
  <div>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->



        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li>
            <router-link :to="'/index'">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                
              </span>
            </router-link>
            
          </li>

          <li class="treeview">
          <!-- <li class="treeview" v-if="can('human_view')|| can('administrative_all')"> -->

            <a href="#addHumanMenu" data-bs-toggle="collapse" class="nav-link">
              <i class="fa fa-umbrella"></i> <span>Human</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul id="addHumanMenu" class="my-treeview-menu collapse">
              <!-- <li v-if="['admin', 'super_admin'].includes(authRole)"> -->
              <li>
                <router-link :to="'/users'">
                  <i class="fa fa-user-cog"></i>Users
                </router-link>
              </li>
              <li>
                <router-link :to="'/area-boss'">
                  <i class="fa fa-clipboard-list"></i>Area Boss
                </router-link>
              </li>
              <li>
                <router-link :to="'/area-manager'">
                  <i class="fa fa-bullseye"></i>Area Manager
                </router-link>
              </li>
              <li>
                <router-link :to="'/district-manager'">
                  <i class="fa fa-building"></i>District Manager
                </router-link>
              </li>
              <li>
                <router-link :to="'/regional-manager'">
                  <i class="fa fa-bowling-ball"></i>Regional Manager
                </router-link>
              </li>
              <li>
                <router-link :to="'/area-boy'">
                  <i class="fa fa-handshake"></i>Area Boy
                </router-link>
              </li>
            </ul>
          </li>

          <li class="treeview">

            <a href="#addAreaMenu" data-bs-toggle="collapse" class="nav-link">
              <i class="fa fa-globe"></i> <span>Locations</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul id="addAreaMenu" class="my-treeview-menu collapse">
              <li>
                <router-link :to="'/country'">
                  <i class="fa fa-globe"></i>Country
                </router-link>
              </li>
              <li>
                <router-link :to="'/region'">
                  <i class="fa fa-circle"></i>Region
                </router-link>
              </li>
              <li>
                <router-link :to="'/district'">
                  <i class="fa fa-compass"></i>District
                </router-link>
              </li>
              <li>
                <router-link :to="'/area'">
                  <i class="fa fa-spinner"></i>Area
                </router-link>
              </li>
            </ul>
          </li>

          <li class="treeview">

            <a href="#systemMenu" data-bs-toggle="collapse" class="nav-link">
              <i class="fa fa-cogs"></i> <span>System</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul id="systemMenu" class="my-treeview-menu collapse">
              <li>
                <router-link :to="'/verification'">
                  <i class="fa fa-check"></i>Verification
                </router-link>
              </li>
              <li>
                <router-link :to="'/commission'">
                  <i class="fa fa-hourglass"></i>Commission
                </router-link>
              </li>
              <li>
                <router-link :to="'/promotion'">
                  <i class="fa fa-truck"></i>Promotion
                </router-link>
              </li>
              <li>
                <router-link :to="'/payment-channel'">
                  <i class="fa fa-money-bill-alt"></i>Payment Channel
                </router-link>
              </li>
              <li>
                <router-link :to="'/role'">
                  <i class="fa fa-unlock"></i>Role
                </router-link>
              </li>
              <li>
                <router-link :to="'/permission'">
                  <i class="fa fa-toggle-on"></i>Permission
                </router-link>
              </li>
              <li>
                <router-link :to="'/flag'">
                  <i class="fa fa-cog"></i>Flag
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">

            <a href="#sikafonMenu" data-bs-toggle="collapse" class="nav-link">
              <i class="fa fa-money-check-alt"></i> <span>Sikafon</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul id="sikafonMenu" class="my-treeview-menu collapse">
              <li>
                <router-link :to="'/user-request'">
                  <i class="fa fa-credit-card"></i> <span> Activate Sikafon</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-green"></small>
                  </span>
                </router-link>
              </li>

              <li>
                <router-link :to="'/user-request'">
                  <i class="fa fa-money-bill"></i> <span>Wallet</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-green"></small>
                  </span>
                </router-link>
              </li>
            </ul>
          </li>

          <li>
            <a href="#">
              <i class=" fa fa-phone"></i> <span>Emergency Center</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green"></small>
              </span>
            </a>
          </li>

          <li>
            <a href="" @click.prevent="logout">
              <i class="fa fa-sign-out"></i> <span>Logout</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green"></small>
              </span>
            </a>
          </li>
        
        
        
      
          
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

  </div>
</template>
<script>
  import helpers from "./../helpers/helpers";
  import {
      createNamespacedHelpers
  } from 'vuex';

  const { mapActions } = createNamespacedHelpers('auth');

  export default {
    data() {
      return {

      }
    },
    computed: {

        user() {
            return this.$store.getters['auth/user'];
        },

        sideBar() {
            return this.sideBarItems.filter(value => value.role.includes(this.user.role.name));
        }
    },
    created() {
        const authUser = this.$store.getters['auth/user'];
        // if(authUser) {
        //   this.userRole = authUser.role.name;

        //   if(this.userRole == "district_admin"){
        //     //
        //   }else{
        //     if(this.userRole !== "" && this.userRole !== null) {
        //       return this.sideBarItems.filter((value) => value.role === this.userRole);
        //     } else {
        //         return this.sideBarItems;
        //     }
        //   }

        // }

      
    },
    methods: {

        ...mapActions(['logoutAction']),

        // getPage() {
        //   this.$router.push({ path: `${ this.selectedPage.path }` });

        // },

        logout() {
            helpers.deletingAlert("You want to log out? ")
                .then((result) => {
                    if (result.value) {
                        this.logoutAction()
                            .then((res) => {
                                this.$store.commit('reset');
                                localStorage.removeItem('findMe');
                                this.$router.push({
                                    path: "/"
                                });
                            }).catch((error) => {
                                helpers.errorAlert('Failed to log you out. Please try again')
                            });
                    }
                });
        },

    },
    mounted() {

    }

  }
</script>
<style type="text/css">
  a:hover {
    cursor: pointer;
  }

  @media (max-width: 767px) {
    .sidebar{
      padding-top: 30px;
    }
  }


  /* my custom dropdown with b5 .my-treeview-menu */
  .sidebar-mini.sidebar-collapse .sidebar-menu > li > .my-treeview-menu {
      padding-top: 5px;
      padding-bottom: 5px;
      border-bottom-right-radius: 4px;
    }

  .sidebar-mini.sidebar-collapse .sidebar-menu > li > .my-treeview-menu {
      display: none !important;
      -webkit-transform: translateZ(0);
  }

  .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu > li:hover > .my-treeview-menu {
    display: block !important;
    position: absolute;
    width: 180px;
    left: 50px;
  }

  .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu > li:hover > .my-treeview-menu {
    top: 44px;
    margin-left: 0;
  }

  .my-treeview-menu {
    /* display: none; */
    list-style: none;
    padding: 0;
    margin: 0;
    padding-left: 5px;
    background-color: rgb(55, 61, 61);
  }
  .my-treeview-menu .my-treeview-menu {
    padding-left: 20px;
  }
  .my-treeview-menu > li {
    margin: 0;
  }
  .my-treeview-menu > li > a {
    padding: 5px 5px 5px 15px;
    display: block;
    font-size: 14px;
  }
  .my-treeview-menu > li > a > .fa,
  .my-treeview-menu > li > a > .glyphicon,
  .my-treeview-menu > li > a > .ion {
    width: 20px;
  }
  .my-treeview-menu > li > a > .pull-right-container > .fa-angle-left,
  .my-treeview-menu > li > a > .pull-right-container > .fa-angle-down,
  .my-treeview-menu > li > a > .fa-angle-left,
  .my-treeview-menu > li > a > .fa-angle-down {
    width: auto;
  }
</style>