<template>
  <div class="col-md-6">
    <div class="authincation-content">
      <div class="row no-gutters">
        <div class="col-xl-12">
          <div class="auth-form">
            <h2 class="text-center mb-4">Please Enter Your Account Findme ID</h2>
            <form @submit.prevent="reset" >
              <div class="form-group">
                <label class="mb-1" for="findmeId"><strong>Findme ID</strong></label>
                <input
                  v-model="user.findmeId"
                  type="text"
                  class="form-control"
                  id="findmeId"
                  required
                />
              </div>
              <div class="form-group">
                <label class="mb-1" for="pass"><strong>New Password</strong></label>
                <input
                  v-model="user.password"
                  id="pass"
                  type="password"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-row d-flex justify-content-between mt-4 mb-2">
                <div class="form-group">
                  <div class="custom-control custom-checkbox ml-1">
                    <input
                      type="checkbox"
                      @change.prevent="showPassword"
                      class="custom-control-input"
                      id="show_pass"
                    />
                    <label class="custom-control-label" for="show_pass"
                      >Show Password</label
                    >
                  </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block">
                        Submit
                        </button>
                    </div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Con from "../helpers/helpers";
import { createNamespacedHelpers } from 'vuex';
const {mapActions} = createNamespacedHelpers('auth');
export default {
  data() {
    return {
      user: {
        email: "",
        password: ""
      },
    };
  },

  methods: {

    showPassword() {
       Con.showPassword(document.getElementById("pass"));
    },

    reset() {
    }
  }
};
</script>
