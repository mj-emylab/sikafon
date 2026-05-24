import { wrap } from "lodash";
import Resources from "./resources";
import moment from 'moment';
const Login = new Resources("login");
const logout = new Resources("logout");

export default {

    // Login method
    loginUser(formData) {
        return Login.store(formData);
    },

    //Logout
    logout() {
        return logout.list(null);
    },

};