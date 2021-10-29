<?php

Class Usuario
{
	private $pdo;
	public $msgErro = "";
	
	public function conectar($nome, $host, $usuario, $senha)
	{
			global $pdo;
			global $msgErro;
			
			try
			{
				$pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
			}
			catch(PDOException $e)
			{
				$msgErro = $e->getMessage();
			}
	}
	
	public function cadastrar($nome, $telefone, $celular, $dataNascimento, $sexo, $CEP, $estado, $cidade, $bairro, $rua, $numero, $email, $senha)
	{
		global $pdo;
		// verificar se usuario já existe
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
		$sql ->bindValue(":e",$email);
		$sql->execute();
		
		if($sql->rowCount() > 0)
		{
			return false; //ja esta cadastrada
		}
		else
		{	
			//caso não, Cadastrar
			$sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, celular, dataNascimento, sexo, CEP, estado cidade, bairro, rua, numero, email, senha) VALUES (:n, :t, :c, :d, :se, :cep, :es, :ci, :b, :r, :nu, :e, :s)");
			
			$sql->bindValue(":n",$nome);
			$sql->bindValue(":t",$telefone);
			$sql->bindValue(":c",$celular);
			$sql->bindValue(":d",$dataNascimento);
			$sql->bindValue(":se",$sexo);
			$sql->bindValue(":cep",$CEP);
			$sql->bindValue(":es",$estado);
			$sql->bindValue(":ci",$cidade);
			$sql->bindValue(":b",$bairro);
			$sql->bindValue(":r",$rua);
			$sql->bindValue(":nu",$numero);
			$sql->bindValue(":e",$email);
			$sql->bindValue(":s",md5($senha));
			$sql->execute();
			return true;
		}
	}		
	
	public function logar($email, $senha)
	{
		global $pdo;
		//verificar se o email e senha estão cadastrados, se sim
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
		$sql->bindValue(":e",$email);
		$sql->bindValue(":s",md5($senha));
		$sql->execute();	
		if($sql->rowCount() > 0)
		{
			//entrar no sistema (sessão)
			$dado = $sql->fatch();
			session_start();
			$_SESSION['id_usuario'] = $dado['id_usuario'];
			return true; // logado com sucesso
		}
		else
		{
			return false; // não foi possivel logar
		}
	}
}
?>