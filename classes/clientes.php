<?php
require_once('../config.php');

Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			if(isset($sql))
			$resp['sql'] = $sql;
			return json_encode($resp);
			exit;
		}
	}

  
	function save_appointment(){
        $connect = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
        $data = [
            "nome" => $_POST["nome"],
            "cpf" => $_POST["cpf"],
            "email" => $_POST["email"],
            "telefone" => $_POST["telefone"],
            "endereco" => $_POST["endereco"],
            "usuario" => $_POST["usuario"],
            "senha" => md5($_POST["senha"]),
        ];

       		      
       $sql=$connect->prepare('INSERT INTO clients set nome=:nome, cpf=:cpf, email=:email, telefone=:telefone, endereco=:endereco, usuario=:usuario,senha=:senha' );
       
        $connect->beginTransaction();
        $sql->execute($data);
        $connect->commit();
      
   
			$this->capture_err();
			if($sql){
				$resp['status'] = 'success';
				/* $resp['nome'] = $name; */
				$this->settings->set_flashdata('success',' Cadastro realizado com sucesso!');
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "Ocorreu um erro ao cadastrar os dados.";
			}
           
		
		return json_encode($resp);
	}




public function atualiza_cliente(){

        extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','senha'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

			if(!empty($senha))
			$data .= ", `senha` = '".md5($senha)."' ";
		
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
				if($move){
					$data .=" , avatar = '{$fname}' ";
					if(isset($_SESSION['userdata']['avatar']) && is_file('../'.$_SESSION['userdata']['avatar']))
						unlink('../'.$_SESSION['userdata']['avatar']);
				}
			}
			$sql = "UPDATE clients set {$data} where id = $id";
			$save = $this->conn->query($sql);

			if($save){
			$this->settings->set_flashdata('success','Detalhes do usuário atualizados com sucesso.');
			foreach($_POST as $k => $v){
				if(!in_array($k,array('id','senha'))){
					if(!empty($data)) $data .=" , ";
					$this->settings->set_userdata($k,$v);
				}
			}
			if(isset($fname) && isset($move))
			$this->settings->set_userdata('avatar',$fname);
			return 1;
			}else{
				$resp['error'] = $sql;
				return json_encode($resp);
			}
        }
    /*$data = [
       "id" =>$_POST['id'],
        "nome" => $_POST["nome"],
       "cpf" => $_POST["cpf"],
        "email" => $_POST["email"],
        "telefone" => $_POST["telefone"],
        "endereco" => $_POST["endereco"], 
        "usuario" => $_POST["usuario"],
        "senha" => md5($_POST["senha"]),
    ];

                 
   $sql=$connect->prepare("UPDATE clients SET nome= :nome,cpf= :cpf,email= :email,telefone= :telefone,endereco= :endereco,usuario= :usuario,senha= :senha WHERE id= :'id'");
   
    $connect->beginTransaction();
    $sql->execute($data);
    $connect->commit();
  

        $this->capture_err();
        if($sql){
            $resp['status'] = 'success';
            /* $resp['nome'] = $name; */
      /*       $this->settings->set_flashdata('success',' Cadastro atualizado com sucesso!');
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = "Ocorreu um erro ao atualizar os dados.";
        }
 */

            }
        
    

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_appointment':
		echo $Master->save_appointment();
	break;
    case 'atualiza_cliente':
		echo $Master->atualiza_cliente();
	break;
	
	default:
		// echo $sysset->index();
		break;
}