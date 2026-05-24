<template>
  <div>
  <!-- <div class="fixed-top"> -->

    <header class="main-header">
      <!-- Logo -->
      <router-link :to="'/index'" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>User Dashboard</b></span>
      </router-link>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- <ul>
          

          <li><a href="default.asp">Home</a></li>

          <li><a href="news.asp">News</a></li>
          <li><a href="contact.asp">Contact</a></li>
          <li><a href="about.asp">About</a></li>
        </ul> -->

        <ul id="horiznav">
          <li><router-link class="mywhite" :to="'/'">Home</router-link></li>
          
          <li class="dropdown">
            <a href="" data-toggle="dropdown" data-bs-toggle="dropdown">
              <img :src="user.pic ? user.pic : 'assets/img/d.jpg'" class="user-image user" alt="User Image">
              <span class="hidden-xs text-white">{{ user.findme_id ? user.findme_id : 'Offline' }}</span>
            </a>
              
              <!-- Menu Footer-->
              <div class="dropdown-menu" >
                <a @click.prevent="openProfileModal()" href="#" class="dropdown-item">Profile</a>
                <a @click.prevent="openPasswordModal()" href="#" class="dropdown-item">Change Password</a>
                <a @click.prevent="logout" href="#" class="dropdown-item">Log Out</a>
              </div>
          </li>

          <li>
            <a class="mywhite" href="" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>

        </ul>


      </nav>
    </header>

    <profile-model ref="profile" />

  </div>
</template>
<script>
  import helpers from "./../helpers/helpers";
  import { createNamespacedHelpers } from 'vuex';
  import ProfileModel from '../Modals/ProfileModal.vue';

  const { mapActions } = createNamespacedHelpers('auth');

  export default {
    components: { ProfileModel },
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

        openProfileModal(){
            this.$refs.profile.myProfile();
        },

        openPasswordModal(){
            this.$refs.profile.myPassword();
        },

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

      // document.addEventListener("DOMContentLoad", function(){
      //   window.addEventListener('scroll', function(){
      //     if(this.window.scrollY > 50) {
      //       this.document.getElementById('nav_top').classList.add('fixed-top');
      //       nav_height = this.document.querySelector('.navbar').offsetHeight;
      //       this.document.body.style.paddingTop = nav_height + 'px';
      //     } else {
      //       this.document.getElementById('nav_top').classList.remove('fixed-top');
      //       this.document.body.style.paddingTop = '0';
      //     }
      //   })
      // })

    }

  }
</script>
<style type="text/css" scoped>
  a:hover {
    cursor: pointer;
  }

  /* ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
  }

  li {
    display: inline;
  } */

  .user {
    /* display: inline-block; */
    width: 30px;
    height: 30px;
    border-radius: 50%;

    object-fit: cover;
  }

  ul#horiznav, #horiznav ul{/*remove the bullets from the dropdown ul as well*/
    margin:0;
    padding:0;
    list-style-type:none;
    /* height:32px */
  }

  #horiznav li{
    float:left;
    margin-left: 10px;
    margin-right: 10px;
    position:relative/*set position:relative as the start point for absolutely positioning the dropdown*/
  }

  #horiznav li a{
    display:block;
    /* text-align:center; */
    /* color:white; */
    text-decoration:none;
  }

  #horiznav li .mywhite{
    color:white;
    text-decoration:none;
  }
</style>