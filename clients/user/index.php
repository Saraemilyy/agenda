<?php
$user = $conn->query("SELECT * FROM clients where id ='" . $_settings->userdata('id') . "'");
foreach ($user->fetch_array() as $k => $v) {
	$meta[$k] = $v;
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
	
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-use">
			<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="row">

					<div class="form-group col-md-6">
					
					
						<label for="name">Nome completo</label>
						
						<input type="text" name="nome" id="nome" class="form-control" value="<?php echo isset($meta['nome']) ? $meta['nome'] : '' ?>" required>
					</div>

					<div class="form-group col-md-6">
						<label for="username">CPF</label>
						<input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo isset($meta['cpf']) ? $meta['cpf'] : '' ?>" required autocomplete="off">
					</div>

					<div class="form-group col-md-6">
						<label for="username">E-mail</label>
						<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required autocomplete="off">
					</div>

					<div class="form-group col-md-6">
						<label for="username">Telefone</label>
						<input type="text" name="telefone" id="telefone" class="form-control" value="<?php echo isset($meta['telefone']) ? $meta['telefone'] : '' ?>" required autocomplete="off">
					</div>

					<div class="form-group col-md-6">
						<label for="username">Usuário</label>
						<input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo isset($meta['usuario']) ? $meta['usuario'] : '' ?>" required autocomplete="off">
					</div>
					<div class="form-group col-md-6">
						<label for="password">Senha</label>
						<input type="password" name="senha" id="senha" class="form-control" value="" autocomplete="off">
						<small><i>Deixe em branco se não quiser alterar a senha.</i></small>
					</div>

					<div class="form-group col-md-12">
					
						<label for="username">Endereço</label>
						<input type="text" name="endereco" id="endereco" class="form-control" value="<?php echo isset($meta['endereco']) ? $meta['endereco'] : '' ?>" required autocomplete="off">
					</div>
				</div>
				
			</form>
		</div>

	</div>
	<div class="card-footer">
		<div class="col-md-12">
		
			<div class="row">
			
				<button class="btn btn-sm btn-primary" form="manage-use">Atualizar</button>
			</div>
					
					
		</div>
	</div>
</div>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage-use').submit(function(e) {
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url: _base_url_ + "classes/clientes.php?f=atualiza_cliente",
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					location.reload()
				} else {
					$('#msg').html('<div class="alert alert-danger">Usuário já existe!</div>')
					end_loader()
				}
			}
		})
	})
</script>