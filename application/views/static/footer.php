<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Servidor: </b> <?=date('d-m-Y | H:i:A')?>
  </div>
  <strong>Credit 24-7</strong> | Copyright &copy; <script>document.write(new Date().getFullYear())</script> 
</footer>

</div><!-- ./wrapper -->


<!-- Bootstrap 3.3.5 -->
<script src="<?=_R_?>js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=_R_?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=_R_?>/js/app.min.js"></script>
<!-- Sparkline -->
<script src="<?=_R_?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=_R_?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=_R_?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?=_R_?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?=_R_?>plugins/chartjs/Chart.min.js"></script>
<!-- DataTables -->
<script src="<?=_R_?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=_R_?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?=_R_?>plugins/autoNumeric.js"></script>



<!-- Custom Scripts -->
<script src="<?=_R_?>/js/main.js"></script>
<script>
 jQuery(function($) {
  $('.masked').autoNumeric('init');    
});
</script>
<script>
  $(function () {
    $('#dataTable1').DataTable({
      "ordering": false
    });
    $('#dataTable2').DataTable({
      "ordering": true,
      "searching": true
    });
    $('.dataTable3').DataTable({
      "paging": true
    });
  });
</script>
</body>
</html>
