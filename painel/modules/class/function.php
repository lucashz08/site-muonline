<?php
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
		die ( 'Erro de caracteres!' ); 
	} 
}
 
//INFORMAÇÕES DA CONTA
function info($in){
	if(logged()){return;}
	$info = mssql_fetch_assoc(query("SELECT * FROM MEMB_INFO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	
	return $info[$in];
}
//INFORMAÇÕES DA CONTA
function info2($in){
	if(logged()){return;}
	$info = mssql_fetch_assoc(query("SELECT * FROM MEMB_STAT WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	
	return $info[$in];
}	
//MSSQL_QUERY
function query($query){
	Connect();
	return mssql_query($query);
}
//logar no painel
function logar($login, $senha){
	if($login == "" || $login == NULL || $senha == "" || $senha == NULL){
		echo "Preencha todos os campos";
	}else{
		$login = protect(nova_v(ClearString(espaco(d10($login)))));
		$senha = protect(nova_v(ClearString(espaco(d10($senha)))));
		
		$testa = mssql_num_rows(query("SELECT * FROM ".HOST_DATABASE.".dbo.MEMB_INFO WHERE memb___id = '".$login."' AND memb__pwd = '".$senha."'"));
		if($testa > 0){
			$_SESSION['LOGIN'] = $login;
			header("Location: ".URL_PAINEL);
		}else{
			echo "Login ou Senha incorreto!";
		}
	}
}
//deslogar do painel
function Deslogar(){
	session_destroy();
	header("Location: ".URL_PAINEL);
}
//verificar character
function v_char($char){
	if(logged()){return;}
	$char = protect(nova_v(ClearString(espaco(d10($char)))));
	$testa = mssql_num_rows(query("SELECT Name FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."' AND Name = '{$char}'"));
	if($testa > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}
// verificar Vip 
function v_vip(){
	if(logged()){return;}
	$vip = mssql_fetch_assoc(query("SELECT vip FROM MEMB_INFO WHERE memb___id = '".$_SESSION['LOGIN']."'"));	
	return $vip['vip'];
}

// verificar Level

function v_level($character){
	$level = mssql_fetch_assoc(query("SELECT cLevel, Name, AccountID FROM Character WHERE Name = '{$character}'"));	
	return $level['cLevel'];
}
//verificar zen

function v_zen($char, $zenn){
	
	$zen = mssql_fetch_assoc(query("SELECT Money FROM Character WHERE Name = '{$char}'"));
	if($zenn < $zen['Money']){
		return TRUE;
	}else{
		return FALSE;
	}	
}
//verificar cash
function verificar_cash($cash){
	
	$cashh = mssql_fetch_assoc(query("SELECT Cash FROM MEMB_INFO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	if($cash < $cashh['Cash']){
		return TRUE;
	}else{
		return FALSE;
	}	
}

// verificar se a conta esta logada
function v_logado(){
	if(logged()){return;}
	$logado = mssql_fetch_assoc(query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	if($logado['ConnectStat'] == 0){
		return TRUE;
	}else{
		return FALSE;
	}
}
//VERIFICAR QUANTIDADE DE CASH
function v_cash(){
	if(logged()){return;}
	$cash = mssql_fetch_assoc(query("SELECT ".TABELA_CASH." FROM MEMB_INFO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	return $cash[TABELA_CASH];
}
//verificar se esta logado no site
function logged (){
	if(isset($_SESSION['LOGIN'])){
		return FALSE;
	}else{
		return TRUE;
	}
}
//LER PERSONAGENS DA CONTA
function ler_char(){
	if(logged()){return;}	
	$query = query("SELECT Name, LevelUpPoint, cLevel, ".RESETS." FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."'");
	while($infos = mssql_fetch_assoc($query)){
		echo "
				<tr>
					<td><a id=\"blue\">".$infos['Name']."</a></td>
					<td>".$infos[RESETS]."</td>
					<td>".$infos['cLevel']."</td>
					<td>".$infos['LevelUpPoint']."</td>
				</tr>
		";
	}

}
//desbugar zen

function go_zen($char){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if(!v_logado()) {echo "<blockquote><p>Sua conta esta logada</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
	$desbugar = mssql_fetch_assoc(query("SELECT Money FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."' AND Name = '{$char}'"));
	
	if( $desbugar['Money'] < 0 || $desbugar['Money'] > 2000000000){
		if(query("UPDATE Character SET Money = 1000000000 WHERE Name = '{$char}'")){
			echo "<blockquote><p>O zen do Char <b>$char</b> foi desbugado.</p></blockquote>";
		}
	}else{
		echo "<blockquote><p>O zen do char <b>$char</b> não esta Bugado!</p></blockquote>";
	}
}

function v_class($char){
	if(empty($char)){return;}
	$char = protect(nova_v(ClearString(espaco(d10($char)))));	
	$class = mssql_fetch_assoc(query("SELECT Class FROM Character WHERE Name = '{$char}'"));
	return $class['Class'];
}
//HZ_RESET_MISSAO

function hz_missao_reset(){
	$ver = mssql_fetch_assoc(query("SELECT login FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'"));
	if($ver['login'] == null || $ver['login'] == "" || $ver['login'] == false){
		query("INSERT INTO MuOnline.dbo.HZ_RESETS (login,bk,mg,elf,sm,dl)VALUES('".$_SESSION['LOGIN']."', '0', '0', '0', '0', '0')");
	}
}

// reseta personagem 

function go_reset($char){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
			switch(v_vip()){
				case 0:
					if(!v_zen($char, RESET_ZEN)){echo "<blockquote><p>Você precisa de mais zen!!!</p></blockquote>"; return;}
					if(v_level($char) >= RESET_FREE ){ 
					if(!v_logado()){ echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
						
	
						if(query("UPDATE Character SET Experience = 0, Money = Money - '".RESET_ZEN."', cLevel = 1,".RESETS." = ".RESETS." + 1,
						".RESETS_DAY." = ".RESETS_DAY." + 1, ".RESETS_WEEK." = ".RESETS_WEEK." + 1,".RESETS_MONTH." = ".RESETS_MONTH." + 1 WHERE Name = '{$char}'")){
							
							//RANKING SEPARADO POR VIP
							if(RANKING_VIP == TRUE){
								if(query("UPDATE Character SET ".RESETS_WEEK_FREE." = ".RESETS_WEEK_FREE." + 1, ".RESETS_MONTH_FREE." = ".RESETS_MONTH_FREE." + 1 WHERE Name = '{$char}'")){
									return;
								}
							}
							//RESET NORMAL DAQUI PARA BAIXO
							echo "<blockquote><p><b>$char</b> foi resetado com sucesso!</p></blockquote>";
							
								//CONTA RESET DE CADA CLASSE PARA MISSOES
									if(MISSAO_RESET == TRUE){
										hz_missao_reset();
										switch(v_class($char)){
											case 0:	
											case 1:
											    query("UPDATE HZ_RESETS SET sm = sm + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 16:	
											case 17:
												query("UPDATE HZ_RESETS SET bk = bk + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 32:	
											case 33:
												query("UPDATE HZ_RESETS SET elf = elf + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 48:
												query("UPDATE HZ_RESETS SET mg = mg + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;		
											case 64:
												query("UPDATE HZ_RESETS SET dl = dl + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
										}
									}
						}
					}else{
						echo "<blockquote><p>Você não tem Level o bastante.</p></blockquote>"; return;
					}
				break;
				case 1:
					if(!v_zen($char, RESET_ZEN_VIP)){echo "<blockquote><p>Você precisa de mais zen!!!</p></blockquote>"; return;}
					if(v_level($char) >= RESET_VIP ){ 
					if(!v_logado()){ echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
						
						if(query("UPDATE Character SET Experience = 0, Money = Money - '".RESET_ZEN_VIP."', cLevel = 1,".RESETS." = ".RESETS." + 1, 
						".RESETS_DAY." = ".RESETS_DAY." + 1, ".RESETS_WEEK." = ".RESETS_WEEK." + 1, ".RESETS_MONTH." = ".RESETS_MONTH." + 1 WHERE Name = '{$char}'")){
							
						//RANKING SEPARADO POR VIP
							
							if(RANKING_VIP == TRUE){
								if(query("UPDATE Character SET ".RESETS_WEEK_VIP." = ".RESETS_WEEK_VIP." + 1, ".RESETS_MONTH_VIP." = ".RESETS_MONTH_VIP." + 1 WHERE Name = '{$char}'")){
									echo "<blockquote><p><b>$char</b> foi resetado com sucesso!</p></blockquote>";
									return;
								}
							}	
						//FIM DO RANKING POR VIP
							echo "<blockquote><p><b>$char</b> foi resetado com sucesso!</p></blockquote>";
							
								//CONTA RESET DE CADA CLASSE PARA MISSOES
									if(MISSAO_RESET == TRUE){
										hz_missao_reset();
										switch(v_class($char)){
											case 0:	
											case 1:
											    query("UPDATE HZ_RESETS SET sm = sm + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 16:	
											case 17:
												query("UPDATE HZ_RESETS SET bk = bk + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 32:	
											case 33:
												query("UPDATE HZ_RESETS SET elf = elf + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 48:
												query("UPDATE HZ_RESETS SET mg = mg + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;		
											case 64:
												query("UPDATE HZ_RESETS SET dl = dl + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
										}
									}
						}
					}else{
						echo "<blockquote><p>Você não tem Level o bastante.</p></blockquote>"; return;
					}
				break;
				case 2:
					if(!v_zen($char, RESET_ZEN_VIP2)){echo "<blockquote><p>Você precisa de mais zen!!!</p></blockquote>"; return;}
					if(v_level($char) >= RESET_VIP2 ){ 
					if(!v_logado()){ echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
						
						if(query("UPDATE Character SET Experience = 0, Money = Money - '".RESET_ZEN_VIP2."', cLevel = 1,".RESETS." = ".RESETS." + 1, 
						".RESETS_DAY." = ".RESETS_DAY." + 1, ".RESETS_WEEK." = ".RESETS_WEEK." + 1,".RESETS_MONTH." = ".RESETS_MONTH." + 1 WHERE Name = '{$char}'")){
							
							//RANKING SEPARADO POR VIP
							
							if(RANKING_VIP == TRUE){
								if(query("UPDATE Character SET ".RESETS_WEEK_VIP2." = ".RESETS_WEEK_VIP2." + 1, ".RESETS_MONTH_VIP2." = ".RESETS_MONTH_VIP2." + 1 WHERE Name = '{$char}'")){
									echo "<blockquote><p><b>$char</b> foi resetado com sucesso!</p></blockquote>";
									return;
								}
							}	
							//FIM DO RANKING DE VIP
							
							echo "<blockquote><p><b>$char</b> foi resetado com sucesso!</p></blockquote>";
								//CONTA RESET DE CADA CLASSE PARA MISSOES
									if(MISSAO_RESET == TRUE){
										hz_missao_reset();
										switch(v_class($char)){
											case 0:	
											case 1:
											    query("UPDATE HZ_RESETS SET sm = sm + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 16:	
											case 17:
												query("UPDATE HZ_RESETS SET bk = bk + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 32:	
											case 33:
												query("UPDATE HZ_RESETS SET elf = elf + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
											case 48:
												query("UPDATE HZ_RESETS SET mg = mg + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;		
											case 64:
												query("UPDATE HZ_RESETS SET dl = dl + 1 WHERE login = '".$_SESSION['LOGIN']."'");
											break;
										}
									}
						}
					}else{
						echo "<blockquote><p>Você não tem Level o bastante.</p></blockquote>"; return;
					}
				break;
				
				default:
				
				echo "<blockquote><p>Erro no Vip!</p></blockquote>";
				break;
				
			}
}

// DESTREBUIDOR DE PONTOS

function distribuir($char,$for,$agi,$vit,$ene){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
	$for = (int)abs($for);
	$agi = (int)abs($agi);
	$vit = (int)abs($vit);
	$ene = (int)abs($ene);
	if($for > MAX_PONTOS || $agi > MAX_PONTOS || $vit > MAX_PONTOS || $ene > MAX_PONTOS){ echo "<blockquote><p>Não passe do valor ".MAX_PONTOS." em cada status.</p></blockquote>"; return; }
	
	$total = $vit + $agi + $for + $ene;
	
	$pontos = mssql_fetch_assoc(query("SELECT LevelUpPoint,Strength, Dexterity, Vitality, Energy FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."' AND Name = '{$char}'"));
	
	if($for + $pontos["Strength"] > MAX_PONTOS || $agi + $pontos["Dexterity"] > MAX_PONTOS || $vit + $pontos["Vitality"] > MAX_PONTOS || $ene + $pontos["Energy"] > MAX_PONTOS){ echo "<blockquote><p>Não passe do valor ".MAX_PONTOS." em cada status.</p></blockquote>"; return; }

	
	if($total <= $pontos['LevelUpPoint']){
		if(query("UPDATE Character SET Strength = Strength + {$for}, Dexterity = Dexterity + {$agi}, Vitality = Vitality + {$vit}, Energy = Energy + {$ene}, LevelUpPoint = LevelUpPoint - {$total} WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'")){
			$for = $for + $pontos["Strength"];
			$agi = $agi + $pontos["Dexterity"];
			$vit = $vit + $pontos["Vitality"];
			$ene = $ene + $pontos["Energy"];
			
			echo "<blockquote><p>Pontos adicionados com sucesso  no <b>$char</b> !
 <br/>
 <hr />
  <br/>

 <table>		
				<tr>
					<td><b>Status</b></td>
					<td><b>Pontos</b></td>
				</tr>
				<tr>
					<td><b>Força</b></td>
					<td><b>".$for."</b></td>
				</tr>				
				<tr>
					<td><b>Agilidade</b></td>
					<td><b>".$agi."</b></td>
				</tr>				
				<tr>
					<td><b>Vitalidade</b></td>
					<td><b>".$vit."</b></td>
				</tr>				
				<tr>
					<td><b>Energia</b></td>
					<td><b>".$ene."</b></td>
				</tr>		
			</table>
			</p></blockquote>
			";		
		}
	}else{
	 echo "<blockquote><p>Você não tem $total esses pontos!</p></blockquote>";	
	}	
}

// RESETAR PONTOS

function reset_pontos($char){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
	$reset_p = mssql_fetch_assoc(query("SELECT Strength, Dexterity, Vitality, Energy FROM Character WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'"));
	
	$for  = 	(int)abs($reset_p['Strength']); 
	$agi  =		(int)abs($reset_p['Dexterity']); 
	$vit  =		(int)abs($reset_p['Vitality']); 
	$ene  =		(int)abs($reset_p['Energy']);
	
	$total = $for + $agi + $vit + $ene - 130;
	
	if(query("UPDATE Character SET Strength = 30, Dexterity = 30, Vitality = 30, Energy = 30, LevelUpPoint = LevelUpPoint + {$total} WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'")){
		echo "<blockquote><p>Pontos de <b>{$char}</b> resetados com sucesso!</p></blockquote>";
	}
}

// DESBUGAR PONTOS COM BASE EM RESETS

function desbugar_pontos($char){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
	$ponto = mssql_fetch_assoc(query("SELECT ".RESETS." FROM Character WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'"));

	$n_ponto = $ponto[RESETS] * (LEVEL_MAX * PONTOS_LEVEL);
	if(query("UPDATE Character SET Strength = 30, Dexterity = 30, Vitality = 30, Energy = 30, LevelUpPoint = {$n_ponto} WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'")){
		echo "<blockquote><p>Pontos de <b>{$char}</b> desbugados, total $n_ponto !</p></blockquote>";
	}
	
}

//LIMPAR PK FUNÇÃO

function virar_heroi($char){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if($char == null || $char == ""){return;}
	if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
	$pk = mssql_fetch_assoc(query("SELECT PkCount, PkLevel, PkTime FROM Character WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'"));
	
	$preco = MIN_PRECO + ($pk['PkTime'] * PRECO_PK);
	if($preco > 2000000000){echo "<blockquote><p>Não a zen que pague pelos seus pecados</p></blockquote>"; return;}
	if(!v_zen($char, $preco)){echo "<blockquote><p>Você precisa de $preco zen !!!</p></blockquote>"; return;}
	
	if(query("UPDATE Character SET PkCount = -1, PkLevel = 1, PkTime = 784, Money = Money - {$preco} WHERE Name = '{$char}' AND AccountID = '".$_SESSION['LOGIN']."'")){
		echo "<blockquote><p>O <b>{$char}</b> agora esta como heroi, custo $preco zen!</p></blockquote>";
	}	
}	
//trocar de clase
function v_classe($class){
	if($class == 1){return TRUE;}
	if($class == 17){return TRUE;}
	if($class == 33){return TRUE;}
	if($class == 48){return TRUE;}
	if($class == 64){return TRUE;}
	return FALSE;
}
function trocar_classe($char, $class){
	if(logged()){return;}
	if($char == null || $char == ""){return;}
	$char = protect(ClearString(espaco(d10($char))));
	if($char == null || $char == ""){return;}
	if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
	if(!v_char($char)){echo "<blockquote><p>Este perssonagem não pertence a esta conta!</p></blockquote>"; return;}
	
	if(!verificar_cash(CLASS_CASH)){echo "<blockquote><p>Você não tem ".CLASS_CASH." Cash para trocar de Classe!</p></blockquote>"; return;}
		
	$class = (int)protect($class);
	
	if(!v_classe($class)){echo "<blockquote><p>A classe que você escolheu não é uma classe valida!</p></blockquote>"; return;}
	
	if(query("UPDATE Character SET Class = {$class} WHERE Name = '{$char}'")){
	   query("UPDATE MEMB_INFO SET Cash = Cash - ".CLASS_CASH." WHERE memb___id = '".$_SESSION['LOGIN']."'");
	  
	  echo "<blockquote><p>A classe do char {$char} foi alterada com sucesso!</p></blockquote>";
	}
	
	
	
}
//verificar Se email ja existe

function verificar_email($email){
  $email = protect(ClearString(espaco(d35($email))));
  $email2 = mssql_num_rows(query("SELECT mail_addr FROM MEMB_INFO WHERE mail_addr = '{$email}'"));
  if($email2 > 0){
	return TRUE;  
  }else{
	  return FALSE;
  }
}

// verificar pergunta e resposta

function v_ask_answ($pergunta,$resposta){
	if(logged()){return;}
	if($pergunta == null || $pergunta == "" || $resposta == null || $resposta == ""){return;}
	$pergunta = protect($pergunta);
	$resposta = protect($pergunta);
	
	$p_a = mssql_fetch_assoc(query("SELECT fpas_ques, fpas_answ FROM MEMB_INFO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	
	if($pergunta == $p_a['fpas_ques'] && $resposta == $p_a['fpas_answ']){
		return TRUE;
	}else{
		return FALSE;
	}
}

//ALTERAR EMAIL

function change_email($email,$pergunta,$resposta){
	if(logged()){return;}
	if($email == null || $email == ""){return;}
	if($pergunta == null || $pergunta == "" || $resposta == null || $resposta == ""){return;}
	$email = protect(ClearString(espaco(d35($email))));
	if($email == null || $email == ""){return;}
	if(verificar_email($email)){echo "<blockquote><p>Este email já esta em uso, favor escolher outro.</p></blockquote>"; return;}
	if(!v_ask_answ($pergunta,$resposta)){echo "<blockquote><p>Pergunta e resposta invalida</p></blockquote>"; return;}
	
	if(query("UPDATE MEMB_INFO SET mail_addr = '{$email}' WHERE memb___id = '".$_SESSION['LOGIN']."'")){
		echo "<blockquote><p>Email alterado com sucesso!</p></blockquote>";
	}

}

//ALTERAR SENHA

function change_senha($senha,$rsenha,$pergunta,$resposta){
	if(logged()){return;}
	if($senha == null || $senha == ""){echo "A senha não pode ficar em branco";return;}
	$senha = protect(ClearString(espaco(d10($senha))));
	if($pergunta == null || $pergunta == "" || $resposta == null || $resposta == ""){return;}
	if($senha != $rsenha){echo "<blockquote><p>As senha digitada não confere ou não e uma senha valida!</p></blockquote>"; return;}
	if(!v_ask_answ($pergunta,$resposta)){echo "<blockquote><p>Pergunta e resposta invalida</p></blockquote>"; return;}
	
	if(query("UPDATE MEMB_INFO SET memb__pwd = '{$senha}' WHERE memb___id = '".$_SESSION['LOGIN']."'")){
			echo "<blockquote><p>Senha alterado com sucesso!</p></blockquote>";

	}
}

// SISTEMA DE REFERENCIA

function criar_link(){
	if(query("INSERT INTO MuOnline.dbo.HZ_VISITAS_REFERENCIA (login)VALUES('".$_SESSION['LOGIN']."')")){
		header('Location: ?pag=link_de_referencia');
	}	
}
					
function ddv(){						
	$query_dv = @mssql_query("SELECT * FROM MuOnline.dbo.HZ_VISITAS_REFERENCIA WHERE login = '".$_SESSION['LOGIN']."'");
	$divulgacao = @mssql_num_rows($query_dv);
	$id_dv = @mssql_fetch_assoc($query_dv);
	if($divulgacao > 0){
		echo "<p>Seu link de Divulgação é : <input type=\"text\" value=\"".URL_WEB."/?ref=".$id_dv['id']."\"> </p>";
		echo "
			<table border='1' width='50%'>
			<tr>
				<td><strong><em>Total de Visitas</em></strong></td>
				<td><strong><em>Total de cash já ganho</em></strong></td>
			</tr>
			<tr>
				 <td> ".$id_dv['visitas']."</td>
				<td> ".$id_dv['cash']."</td>
			</tr>
			</table>
			<br />
			";
			}else{
				echo "<p><strong><a href=\"?pag=link_de_referencia&divulgar=TRUE\">Click Aqui para receber um link de Divulgação!</a></strong></p>";			
			} 
}

function select_char(){
	$char = query("SELECT * FROM MuOnline.dbo.Character WHERE AccountID = '".$_SESSION['LOGIN']."'");
	
	while($per = mssql_fetch_array($char)){
		echo "<option value=\"{$per[Name]}\">{$per[Name]}</option>";
	}
}					
							 
function tempo_online(){
	$tempo = mssql_fetch_array(query("SELECT TempoOnline FROM MEMB_INFO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	
	$hora = floor($tempo[TempoOnline] / 60);
	$minutos = $tempo[TempoOnline] % 60;
	
	$total = $hora.":".$minutos;
	
	return $total;
}

































?>