<?php
function Connect(){
	$connect = @mssql_connect(HOST, HOST_USUARIO, HOST_PASS);
	$connect_db = @mssql_select_db(HOST_DATABASE, $connect);
	
	if($connect && $connect_db){
		return $connect;
	}else{
		echo "Nao foi possivel connectar ao banco de dados MSSQL";
	}
}
//logar no site
function logar($login, $senha){
	if($login == "" || $login == NULL || $senha == "" || $senha == NULL){
		echo "Preencha todos os campos";
	}else{
		$login = ClearString(espaco(d10($login)));
		$senha = ClearString(espaco(d10($senha)));
		
		$testa = mssql_num_rows(query("SELECT * FROM ".HOST_DATABASE.".dbo.MEMB_INFO WHERE memb___id = '".$login."' AND memb__pwd = '".$senha."'"));
		if($testa > 0){
			$_SESSION['LOGIN'] = $login;
			header("Location: ".URL_SITE);
		}else{
			echo "Login ou Senha incorreto!";
		}
	}
}
//DESLOGAR DO PAINEL
function Deslogar(){
	session_destroy();
	header("Location: ".URL_SITE);
}

//LIMPAR STRING
function ClearString($texto){
 return strip_tags(trim(addslashes($texto)));
}
//REMOVER ESPAÇOS

function espaco($h){
	return str_replace(" ", "", $h);
	}
// RECORTAR AS 10 PRIMEIRO DIGITOS

function d10($h){
	return substr($h, 0, 10);	
}
// RECORTAR AS 35 PRIMEIRO DIGITOS

function d35($h){
	return substr($h, 0, 35);	
}
//lIMPA A VAREAVEL
function nova_v($var){ 
	$newvar = preg_replace('/[^a-zA-Z0-9\_\-]/', '', $var); 
	return $newvar; 
}
//LIMPAR CONTRA INJECT
function protect($protected){ 

	$banlist = array (";","!","#","$","%","^","&","(",")","[","]","{","}","=","+","|",":",";","<",">","?","~","'","*","/"," \ ", "insert", "select", "update", "delete", "distinct", "having", "truncate", "replace", "handler", "like", "procedure", "limit", "order by", "group by", "shutdown", "delete"); 
	if ( eregi ( "[a-zA-Z0-9@]+", $protected ) ) { 
		$protected = trim(str_replace($banlist, '', $protected)); 
		return $protected;
	} else {
		echo $protected;
		die ( 'Erro de caracteres' ); 
	} 
} 
//MSSQL_QUERY
function query($query){
	Connect();
	return @mssql_query($query);
}

//gera as imagens para o top ranking

function img_top($c){
	if($c == 1){
		$c = "<img id=\"medal\" src=\"img/ouro.gif\">";
		return $c;
	}elseif($c == 2){
		$c = "<img id=\"medal\" src=\"img/prata.gif\">";
		return $c;
	}elseif($c == 3){
		$c = "<img id=\"medal\" src=\"img/bronze.gif\">";
		return $c;
	}else{
		return $c;
	}
}
// total de contas
function total_contas(){
	$conta = mssql_result(query("SELECT count(*) FROM MEMB_INFO"),0,0);
	return $conta;
}
//total de character 
function total_char(){
	$char = mssql_result(query("SELECT count(*) FROM Character"),0,0);
	return $char;
}
// total de guilds

function total_guild(){
	$guild = mssql_result(query("SELECT count(*) FROM Guild"),0,0);
	return $guild;
}
//total online
function total_online(){
	$online = mssql_result(query("SELECT count(*) FROM MEMB_STAT WHERE ConnectStat = 1"),0,0);
	return $online;
}
// verificar classe

function v_class($char){
	if(empty($char)){return;}
	$char = protect(nova_v(ClearString(espaco(d10($char)))));	
	$class = mssql_fetch_assoc(query("SELECT Class FROM Character WHERE Name = '{$char}'"));
	switch($class['Class']){
		case 0:
			$char = "Dark Wizard";
			return $char;
		break;		
		case 1:
			$char = "Soul Master";
			return $char;
		break;
		case 16:
			$char = "Dark Knight";
			return $char;
		break;		
		case 17:
			$char = "Blade Knight";
			return $char;
		break;
		case 32:
			$char = "Fary Elf";
			return $char;
		break;		
		case 33:
			$char = "Muse Elf";
			return $char;
		break;
		case 48:
			$char = "Magic Gladiator";
			return $char;
		break;		
		case 64:
			$char = "Dark Lord";
			return $char;
		break;
	}
}
// VERIFICAR CHAR ESTA LOGADO 

function v_char_logado($char){
	if(empty($char)){return;}
	$char = protect(nova_v(ClearString(espaco(d10($char)))));
	$char = mssql_fetch_assoc(query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = '{$char}'"));
	if($char['ConnectStat'] == 1){
	 return "<p style='color:#2fb42f;'>Sim</p>";	
	}else{
	 return "<p style='color:#b4352f;'>Não</p>";	
	}
}

// verificar se email ja existe

function verificar_email($email){
  $email = protect(ClearString(espaco(d35($email))));
  $email2 = mssql_num_rows(query("SELECT mail_addr FROM MEMB_INFO WHERE mail_addr = '{$email}'"));
  if($email2 > 0){
	return TRUE;  
  }else{
	  return FALSE;
  }
}

// verificar se login ja existe

function verificar_login($login){
  $email = protect(nova_v(ClearString(espaco(d10($login)))));
  $login2 = mssql_num_rows(query("SELECT memb___id FROM MEMB_INFO WHERE memb___id = '{$login}'"));
  if($login2 > 0){
	return TRUE;  
  }else{
	  return FALSE;
  }
}
//verificar se esta logado no site
function logged (){
	if(isset($_SESSION['LOGIN'])){
		return FALSE;
	}else{
		return TRUE;
	}
}

// CADASTRAR NOVA CONTA

function cadastrar_conta($login,$nome,$senha,$rsenha,$email,$pergunta,$resposta){
	// VERIFICAR SE ESTA LOGADO
	if(!logged()){echo "<blockquote ><br /><p style=\"color:#ff0000;\">E preciso deslogar do painel para criar uma nova conta!</p><br /></blockquote>"; return;}
	
	// VERIFICAR SENHA 
	if($senha != $rsenha){echo "<blockquote ><br /><p style=\"color:#ff0000;\">As senhas digitadas não são iguais!</p><br /></blockquote>"; return;}
	
	if(empty($login) || $login == "" || $login == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de login.</p><br /></blockquote>"; return;}
	if(empty($nome)  || $nome == ""  || $nome == null) {echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de nome.</p><br /></blockquote>"; return;}
	if(empty($senha) || $senha == "" || $senha == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de senha.</p><br /></blockquote>"; return;}
	if(empty($rsenha)|| $rsenha == "" || $rsenha == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha de confimação de senha.</p><br /></blockquote>"; return;}
	if(empty($email) || $email == "" || $email == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de email.</p><br /></blockquote>"; return;}
	if(empty($pergunta) || $pergunta == "" || $pergunta == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de pergunta.</p><br /></blockquote>"; return;}
	if(empty($resposta) || $resposta == "" || $resposta == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de resposta.</p><br /></blockquote>"; return;}
	
	$login 		= protect(ClearString(espaco(d10($login))));
	$nome  		= protect(nova_v(ClearString(espaco(d10($nome)))));
	$senha 		= protect(nova_v(ClearString(espaco(d10($senha)))));
	$rsenha 	= d10($rsenha);
	$email 		= protect(ClearString(espaco(d35($email))));
	$pergunta 	= protect(nova_v(ClearString(espaco(d10($pergunta)))));
	$resposta 	= protect(nova_v(ClearString(espaco(d10($resposta)))));

	if(empty($login) || $login == "" || $login == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Login digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	if(empty($nome)  || $nome == ""  || $nome == null) {echo "<blockquote ><br /><p style=\"color:#ff0000;\">Nome digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	if(empty($senha) || $senha == "" || $senha == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Senha digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	if(empty($rsenha)|| $rsenha == "" || $rsenha == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Repetição de Senha digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	if(empty($email) || $email == "" || $email == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Email digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	if(empty($pergunta) || $pergunta == "" || $pergunta == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Pergunta digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	if(empty($resposta) || $resposta == "" || $resposta == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Resposta digitado não é valido escolha outro.</p><br /></blockquote>"; return;}
	
	//VERIFICAR DE AS SENHAS DIGITADAS SÃO IGUAIS
	
	if($senha != $rsenha){echo "<blockquote ><br /><p style=\"color:#ff0000;\">A senha digitada não é validas, escolha outra senha.</p><br /></blockquote>"; return;}

	//TRANSFORMAR TUDO EM LETRA MINUSCULAS
	
	if(MIN_LOGIN == TRUE){
		$login = strtolower($login);
	}
	// TRANSFORMAR EMAIL EM LETRAS MINUSCULAS
	if(MIN_EMAIL == TRUE){
	    $email = strtolower($email);
	}
	// VERIFICAR SE EMAIL E LOGIN JA EXISTE
	
	if(verificar_login($login)){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Este login já esta em uso, escolha outro!</p><br /></blockquote>"; return;}	
	if(verificar_email($email)){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Email já esta em uso, caso tenha esquecido os dados da sua conta entre em contato com suporte</p><br /></blockquote>"; return;}
		
	if(query("INSERT INTO MEMB_INFO 
		(memb___id,   memb__pwd,	 memb_name, 	mail_addr, 	fpas_ques, 		fpas_answ, sno__numb, bloc_code, ctl1_code, post_code, addr_info, tel__numb, phon_numb, addr_deta, mail_chek) VALUES 
		('{$login}', '{$senha}',     '{$nome}',     '{$email}','{$pergunta}',  '{$resposta}', '1', 		'0', 		'1', 	 '1234',	'1111',    '12343', '0000-0000', 	'',		 '1')")){
		
		//SE O SERVIDOR REGISTRAR NA TABELA VI_CURR_INFO
		
		if(VI_CURR_INFO == TRUE){
			query("INSERT INTO VI_CURR_INFO
			(ends_days, chek_code, used_time, memb___id, memb_name, memb_guid, sno__numb, Bill_Section, Bill_Value, Bill_Hour, Surplus_Point,    Surplus_Minute, 			Increase_Days) VALUES
			  ('2005',		'1',	'1234',   '{$login}', '{$nome}',  '1',		 '7',		  '6',			'3',		'6',		'6',	  '2003-11-23 10:36:00',			'0') 	");					
		}
		
		// MENSAGEM DE CADASTRO REALIZADO COM SUCESSO
		
		echo "
		<blockquote ><br /><p style=\"color:green;\">Cadastro efetuado com sucesso anote todos os seus dados abaixo para não esquecer! um email foi enviado com seus dados, salve ele em seus favoritos!</p><br /></blockquote>
		<table>
			<tr>
				<td width=\"150\">Login de acesso :</td>
				<td width=\"360\"><a>{$login}</a></td>
			</tr>			
			<tr>
				<td>Senha de acesso :</td>
				<td><a>{$senha}</a></td>
			</tr>			
			<tr>
				<td>E-mail :</td>
				<td><a>{$email}</a></td>
			</tr>
			<tr>
				<td>Pergunta Secreta :</td>
				<td><a>{$pergunta}</a></td>
			</tr>
			<tr>
				<td>Resposta Secreta :</td>
				<td><a>{$resposta}</a></td>
			</tr>				
		</table>
		
		
		";
		$mmsg = "
		<table>
			<tr>
				<td width=\"150\">Login de acesso :</td>
				<td width=\"360\"><a>{$login}</a></td>
			</tr>			
			<tr>
				<td>Senha de acesso :</td>
				<td><a>{$senha}</a></td>
			</tr>			
			<tr>
				<td>E-mail :</td>
				<td><a>{$email}</a></td>
			</tr>
			<tr>
				<td>Pergunta Secreta :</td>
				<td><a>{$pergunta}</a></td>
			</tr>
			<tr>
				<td>Resposta Secreta :</td>
				<td><a>{$resposta}</a></td>
			</tr>				
		</table>
		";
		
		envia_email($mmsg, $email, "Conta criada, agora você já pode logar em nosso server!");
	}
	
}
// SISTEMA DE REFERENCIA

function verifica_visita($id){
	if(REFERENCIA_ATIVO == FALSE){return;}
	
	$id = (int)protect(d10($id));
	
	// VERIFICA O IDIOMA DO NAVEGADOR, LIMITAÇÃO DE IDIOMA
	if(REF_IDIOMA == TRUE){
	$idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);	
	if($idioma != REF_PT ){return;}	
	}
	if($id < 0 && $id > 32767){return;}
	if($_COOKIE["visita"] == "true" || $_COOKIE["_v__"] == "true" || isset($_COOKIE["visita"]) || isset($_COOKIE["_v__"])){return;}
	
	$check = mssql_num_rows(query("SELECT * FROM MuOnline.dbo.HZ_VISITAS WHERE Ip = '".$_SERVER['REMOTE_ADDR']."'"));
	if($check > 0){return;}
	
	$check2 = mssql_num_rows(query("SELECT * FROM MuOnline.dbo.HZ_VISITAS_REFERENCIA WHERE id = '{$id}'"));
	if($check2 > 0){
		$IP = $_SERVER['REMOTE_ADDR'];
		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
						
		query("INSERT INTO  MuOnline.dbo.HZ_VISITAS (id, Ip,PcNome) VALUES ({$id}, '{$IP}','{$hostname}')");
		setcookie("_v__","true",time()+3600*24*365);	//coloca um cokie
		setcookie("visita","true",time()+3600*24*365);	//coloca um cokie

		$login = mssql_fetch_assoc(query("SELECT login FROM MuOnline.dbo.HZ_VISITAS_REFERENCIA WHERE Id = '{$id}'"));			
		query("UPDATE MuOnline.dbo.MEMB_INFO SET Cash = Cash + ".REF_CASH." WHERE memb___id = '{$login['login']}'");
		query("UPDATE MuOnline.dbo.HZ_VISITAS_REFERENCIA SET Cash = Cash + ".REF_CASH.", Visitas = Visitas + 1 WHERE Id = {$id}");						
	}
				
}


function envia_email($spamtext, $email, $titulo){
		include_once('modules/sis/PHPMailer/class.phpmailer.php');
        
		$mail = new PHPMailer();

        $mail->IsSMTP(); // mandar via SMTP
        $mail->Host = "".SMTP_HOST.""; // Seu servidor smtp
        $mail->SMTPAuth = true; // smtp autenticado
        $mail->Username = "".SMTP_EMAIL.""; // usuário deste servidor smtp
        $mail->Password = "".SMTP_EMAIL_SENHA.""; // senha

        $mail->From = "".SMTP_EMAIL2."";
        $mail->FromName = "".SMTP_ASSUNTO."";
        $mail->AddAddress($email);
        $mail->IsHTML(true); 	// send as HTML

        $mail->Subject = "".$titulo."";
        $mail->Body = $spamtext;

		if($mail->Send()){}
		
		$mail->SmtpClose();
}

function recuperar_conta($email){
	$email 		= protect(ClearString(espaco(d35($email))));
	if(empty($email) || $email == "" || $email == null){echo "<blockquote ><br /><p style=\"color:#ff0000;\">Preencha o campo de email.</p><br /></blockquote>"; return;}
	$dados = mssql_fetch_array(query("SELECT * FROM MuOnline.dbo.MEMB_INFO WHERE mail_addr = '{$email}'"));
	
	$infos = "
			<table>
			<tr>
				<td width=\"150\">Login de acesso :</td>
				<td width=\"360\"><a>".$dados[memb___id]."</a></td>
			</tr>			
			<tr>
				<td>Senha de acesso :</td>
				<td><a>".$dados[memb__pwd]."</a></td>
			</tr>			
			<tr>
				<td>E-mail :</td>
				<td><a>".$dados[mail_addr]."</a></td>
			</tr>
			<tr>
				<td>Pergunta Secreta :</td>
				<td><a>".$dados[fpas_ques]."</a></td>
			</tr>
			<tr>
				<td>Resposta Secreta :</td>
				<td><a>".$dados[fpas_answ]."</a></td>
			</tr>				
		</table>
	";
	envia_email($infos, $email, "Recuperação de conta!");
	echo "<blockquote ><br /><p style=\"color:green;\">Um email com todos os seus dados de cadastro foi enviado, verifique a sua caixa de entrada ou lixo eletronico!</p><br /></blockquote>";
}

function tempo_online($tempo){
	
	$hora = floor($tempo / 60);
	$minutos = $tempo % 60;
	
	$total = $hora.":".$minutos;
	
	return $total;
}
















?>