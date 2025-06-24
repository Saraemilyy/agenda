<?php 
require_once('../../config.php');
/* session_start(); */
?>

<div class="container-fluid">
    <form id="appointment_form">
        <div class="row" id="">
            <div class="col-6">
               
           
                <div class="form-group">
                    <label for="name" class="control-label">Nome Completo</label>
                    <input type="text" class="form-control" name="nome" id="nome">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf">
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">E-mail</label>
                    <input type="text" class="form-control" name="email" id="email">
                </div>

                <div class="form-group">
                    <label for="dob" class="control-label">Telefone</label>
                    <input type="text" class="form-control" name="telefone" id="telefone">
                </div>
            </div>
            <div class="col-6">

            <div class="form-group">
                    <label for="dob" class="control-label">Endereço</label>
                    <input type="text" class="form-control" name="endereco" id="endereco">
                </div>
             
                <div class="form-group">
                    <label for="dob" class="control-label">Usuário</label>
                    <input type="text" class="form-control" name="usuario" id="usuario">
                </div>
               
                <div class="form-group">
                    <label for="dob" class="control-label">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha" required>
                </div>

      <!--           <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn" id="submit" name="submit">Cadastrar</button>
            <button class="btn-danger btn ml-2" >Cancelar</button>
        </div> -->
    </form>
</div>
</div>
<script>
$(function(){
    $('#appointment_form').submit(function(e){
        e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/clientes.php?f=save_appointment",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("Ocorreu um erro",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
                       location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: $('#uni_modal').offset().top }, "fast");
                    }else{
						alert_toast("Ocorreu um erro",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
    })
    $('#uni_modal').on('hidden.bs.modal', function (e) {
        if($('#appointment_form').length <= 0)
            location.reload()
    })
})
</script>


