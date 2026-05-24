
<script src="{{ mix('js/app.js') }}" type="text/javascript" defer></script>

    <script>
        function injectSvgSprite(path) {
        
            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }

        injectSvgSprite('https://demo.bootstrapious.com/directory/1-4/icons/orion-svg-sprite.svg'); 
    
  </script>
  <!-- jQuery-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <!-- Bootstrap JS bundle - Bootstrap + PopperJS-->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/new/3.2.1-jquery.min.js"></script>
  <script src="assets/new/3.6.0-jquery.min.js"></script>
  <script src="assets/new/owl.carousel.min.js"></script>


  <!-- Magnific Popup - Lightbox for the gallery-->
  <script src="assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
  <!-- Smooth scroll-->
  <script src="assets/vendor/smooth-scroll/smooth-scroll.polyfills.min.js"></script>
  <!-- Bootstrap Select-->
  <script src="assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
  <!-- Object Fit Images - Fallback for browsers that don't support object-fit-->
  <script src="assets/vendor/object-fit-images/ofi.min.js"></script>

  <!-- Swiper Carousel -->
  <script src="assets/new/swiper.min.js"></script>
