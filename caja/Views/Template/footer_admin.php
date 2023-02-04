<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>SistemaCaja</span></strong>. Todos los derechos reservados
  </div>
  <div class="credits">
    Desarrollado por <a href="#">Samuel Vela</a>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php printHTMLRequired() ?>
<?php printReloadPage() ?>

<script type="text/javascript">
  var base_url = '<?= base_url() ?>';
</script>

<!-- Vendor JS Files -->
<script src="<?= media() ?>/js/general/sweetalert2@11.js?version=<?= getVerion() ?>"></script>
<script src="<?= media() ?>/js/general/all.js?version=<?= getVerion() ?>"></script>
<script src="<?= media() ?>/js/general/jquery-3.6.0.min.js?version=<?= getVerion() ?>"></script>
<script src="<?= media() ?>/js/general/jquery.dataTables.min.js?version=<?= getVerion() ?>"></script>
<script src="<?= media() ?>/js/general/dataTables.bootstrap5.min.js?version=<?= getVerion() ?>"></script>
<script src="<?= media() ?>/js/general/feather.min.js?version=<?= getVerion() ?>"></script>
<script src="<?= media() ?>/js/general/apexcharts.min.js"></script>
<script src="<?= media() ?>/js/general/bootstrap.bundle.min.js"></script>
<script src="<?= media() ?>/js/general/chart.umd.js"></script>
<script src="<?= media() ?>/js/general/echarts.min.js"></script>
<script src="<?= media() ?>/js/general/quill.min.js"></script>
<script src="<?= media() ?>/js/general/simple-datatables.js"></script>
<script src="<?= media() ?>/js/general/tinymce.min.js"></script>
<script src="<?= media() ?>/js/general/validate.js"></script>
<script src="<?= media() ?>/js/general/axios.min.js?version=<?= getVerion() ?>"></script>

<!-- Template Main JS File -->
<script src="<?= media() ?>/js/general/main.js"></script>
<script src="<?= media() ?>/js/general/filerequired.js?version=<?= getVerion() ?>"></script>

<?php if (isset($data['page_function_js']) && !empty($data['page_function_js'])) { ?>
  <script src="<?= media() ?>/js/<?= $data['page_function_js'] ?>.js?version=<?= getVerion() ?>"></script>
<?php } ?>

</body>

</html>