<template>

    <div class="wrapper">
        <MiniHeader />
        <navbar-nav />

        <div class="content-wrapper" style="min-height: 510px;">
            <router-view></router-view>
        </div>
        <footer-nav />
    </div>

</template>
<script>
import MiniHeader from '../partials/AdminHeader.vue';
import NavbarNav from '../partials/AdminNavbar.vue';
import FooterNav from '../partials/AdminFooter.vue';
export default {
    components: {
        NavbarNav,
        MiniHeader,
        FooterNav,
    },

    mounted() {


        function loadFile(path, type) {
            if (type == "js") {
            var fileref = document.createElement("script")
            fileref.setAttribute("type", "text/javascript")
            fileref.setAttribute("src", path)
            fileref.setAttribute("class", "admin-scripts")
            fileref.async = true;

            document.body.appendChild(fileref)

            } else if (type == "css") {
            var fileref = document.createElement("link")
            fileref.setAttribute("rel", "stylesheet")
            fileref.setAttribute("type", "text/css")
            fileref.setAttribute("href", path)
            fileref.setAttribute("class", "admin-links")
            fileref.async = true;

            document.getElementsByTagName("head")[0].appendChild(fileref)
            }
            
        }
        
        loadFile("admin/bower_components/Ionicons/css/ionicons.min.css", "css")
        loadFile("admin/dist/css/AdminLTE.min.css", "css")
        loadFile("admin/dist/css/skins/_all-skins.min.css", "css")

        loadFile("admin/mine.js", "js")
        loadFile("admin/dist/js/adminlte.min.js", "js")
        loadFile("admin/dist/js/pages/dashboard.js", "js")
        loadFile("admin/dist/js/demo.js", "js")
    },
}
</script>

