 <!-- Header-->
 
<!-- Section-->
<?php 
$sched_arr = array();
$max = 0;
?>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        
    <?php include('about.html') ?>
        
    </div>
</section>
<script>
    $(function(){
        $('#create_appointment').click(function(){
			uni_modal("Formulário de Consultas","admin/appointments/manage_appointment.php",'mid-large')
		})
    })
</script>