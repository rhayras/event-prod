<!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>The Events Production</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/restaurantly-restaurant-template/ -->
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/main.js"></script>

  <script src="assets/vendor/calendar/js/pignose.calendar.full.min.js"></script>
  

</body>

</html>

<script>
    $(document).ready(function(){
        $(document).on("submit","#loginForm",function(e){
            e.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url     : 'ajax.php?action=loginAdmin',
                method  :   'POST',
                dataType:   'JSON',
                data    :   formdata,
                success: function (data) {
                    if(data.success){
                        window.location.href = "admin/dashboard.php";
                    }else{
                        alert(data.msg);
                    }
                },
                error: function(res){
                    console.log(res.responseText);
                }
            });
        });
    });
</script>