<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php
$qry = $conn->query("SELECT * FROM `schedule_settings`");
$meta = array_column($qry->fetch_all(MYSQLI_ASSOC),'meta_value','meta_field');
?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<h5 class="card-title">Configurações de agendamento clínico</h5>
		</div>
		<div class="card-body">
			<form action="" id="schedule_settings">
				<div id="msg" class="form-group"></div>
                <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="" class="control-label">Horário semanal</label><br>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary1" name="day_schedule[]" value='Sunday' <?php echo isset($meta['day_schedule']) && in_array("Sunday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary1">
                            Domingo
                        </label>
                    </div>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary2" name="day_schedule[]" value='Monday'  <?php echo isset($meta['day_schedule']) && in_array("Monday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary2">
                            Segundo
                        </label>
                    </div>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary3" name="day_schedule[]" value='Tuesday'  <?php echo isset($meta['day_schedule']) && in_array("Tuesday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary3">
                            Terça
                        </label>
                    </div>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary4" name="day_schedule[]" value='Wednesday'  <?php echo isset($meta['day_schedule']) && in_array("Wednesday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary4">
                            Quarta
                        </label>
                    </div>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary5" name="day_schedule[]" value='Thursday'  <?php echo isset($meta['day_schedule']) && in_array("Thursday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary5">
                            Quinta
                        </label>
                    </div>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary6" name="day_schedule[]" value='Friday'  <?php echo isset($meta['day_schedule']) && in_array("Friday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary6">
                            Sexta
                        </label>
                    </div>
                    <div class="icheck-primary">
                        <input type="checkbox" id="checkboxPrimary7" name="day_schedule[]" value='Saturday'  <?php echo isset($meta['day_schedule']) && in_array("Saturday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                        <label for="checkboxPrimary7">
                            Sábado
                        </label>
                    </div>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="control-label">Horário de atendimento da parte da manhã</label>
                            <div class="row row-cols-3">
                            <input type="time" class="form-control col" name="morning_schedule[]" value="<?php echo isset($meta['morning_schedule']) ? explode(',',$meta['morning_schedule'])[0] : "" ?>" required>
                            <span class="col-auto"> - </span>
                            <input type="time" class="form-control col" name="morning_schedule[]" value="<?php echo isset($meta['morning_schedule']) ? explode(',',$meta['morning_schedule'])[1] : "" ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Horário de atendimento da parte da tarde</label>
                        <div class="row row-cols-3">
                            <input type="time" class="form-control col" name="afternoon_schedule[]" value="<?php echo isset($meta['afternoon_schedule']) ? explode(',',$meta['afternoon_schedule'])[0] : "" ?>" required>
                            <span class="col-auto"> - </span>
                            <input type="time" class="form-control col" name="afternoon_schedule[]" value="<?php echo isset($meta['afternoon_schedule']) ? explode(',',$meta['afternoon_schedule'])[1] : "" ?>" required>
                        </div>
                    </div>
                </div>
                </div>
			</form>
		</div>
		<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="schedule_settings">Atualizar</button>
				</div>
			</div>
		</div>

	</div>
</div>
<script>
	
	$(function(){
        $('#schedule_settings').submit(function(e){
            e.preventDefault()
            start_loader()
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_sched_settings",
                data: $(this).serialize(),
                method:"POST",
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured",'error');
                    end_loader()
                },
                success:function(resp){
                    if(!!resp.status && resp.status == 'success'){
                        location.reload()
                    }else if(!!resp.status && resp.status == 'success' && !!resp.msg){
                        var err_el = $('<div>')
                            err_el.addClass('alert alert-danger')
                            err_el.text(resp.msg)
                            $('#msg').hide().append(err_el).show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                            
                    }else{
                        console.log(resp)
                        alert_toast("Ocorreu um erro",'error');
                    }
                    end_loader();
                }
            })
        })
    })
</script>