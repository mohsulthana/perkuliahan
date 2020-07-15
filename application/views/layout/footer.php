</div>
<footer>
  <div class="footer-area">
    <p>© Copyright <?= date('Y'); ?>. All right reserved.</p>
  </div>
</footer>
<!-- footer area end-->
</div>
<!-- page container area end -->
    <!-- jquery latest version -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <!-- bootstrap 4 js -->
    <script src="<?= asset_url();?>js/popper.min.js"></script>
    <script src="<?= asset_url();?>js/bootstrap.min.js"></script>
    <script src="<?= asset_url();?>js/owl.carousel.min.js"></script>
    <script src="<?= asset_url();?>js/metisMenu.min.js"></script>
    <script src="<?= asset_url();?>js/jquery.slimscroll.min.js"></script>
    <script src="<?= asset_url();?>js/jquery.slicknav.min.js"></script>

    <!-- Datatable -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <!-- start chart js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.<?= asset_url();?>js/2.7.2/Chart.min.js"></script> -->
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="<?= asset_url();?>js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="<?= asset_url();?>js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="<?= asset_url();?>js/plugins.js"></script>
    <script src="<?= asset_url();?>js/scripts.js"></script>
    <!-- select2 -->
    <script src="<?= asset_url();?>js/select2.min.js"></script>
    <!-- others -->
    <script>
      $(document).ready(function() {
        $("#dosen1").select2();
        $("#dosen2").select2();
        $("#kelas").select2();
        $('#tableClass').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf'
            ]
        });
        $('#tableClass2').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf'
            ]
        });
      });
    </script>
</body>

</html>
