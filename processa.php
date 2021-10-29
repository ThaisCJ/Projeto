<?php

	require_once 'classes/usuarios.php';
	$u = new Usuario;


	//verificar se clicou no botão
	if(isset($_POST['nome']))
	{
		$nome = addslashes($_POST['nome']);
		$telefone = addslashes($_POST['telefone']);
		$celular = addslashes($_POST['celular']);
		$dataNascimento = addslashes($_POST['dataNascimento']);
		$sexo = addslashes($_POST['sexo']);
		$CEP = addslashes($_POST['CEP']); 
		$estado = addslashes($_POST['estado']);
		$cidade = addslashes($_POST['cidade']);
		$bairro = addslashes($_POST['bairro']);
		$rua = addslashes($_POST['rua']);
		$numero = addslashes($_POST['numero']);
		$email = addslashes($_POST['email']);
		$senha = addslashes($_POST['senha']);
		$confirmarSenha = addslashes($_POST['confSenha']);
		
		//verificar se esta preechido
		if(!empty($nome) && !empty($telefone) && !empty($celular) && !empty($dataNascimento) && !empty($sexo) && !empty($CEP) && !empty($estado) && !empty($cidade) && !empty($bairro) && !empty($rua) && !empty($numero) && !empty($email) && !empty($senha)  && !empty($confirmarSenha))
		{
			$u->conectar("bancorealize","localhost","root","");
			if($u->msgErro == "")//se esta tudo ok
			{
				if($senha == $confirmarSenha)
				{
					if($u->cadastrar($nome, $telefone, $celular, $dataNascimento, $sexo, $CEP, $estado, $cidade, $bairro, $rua, $numero, $email, $senha))
					{
						echo "cadastrado com sucesso, faça o login!";
					}
					else
					{
						echo "email já cadastrado!"; 
					}
				}
				else
				{
					echo "As senhas não correspondem!";
				}
			}
			else
			{
				echo "Erro: ".$u->msgErro; 
			}
		}
		else
		{
			echo "Preencha todos os campos!";
		}
	}
?>