<?php
function verificar_bau(){	
	$bau = mssql_fetch_assoc(query("SELECT CONVERT(TEXT, CONVERT(VARCHAR(1200), Items)) [Items] FROM warehouse WHERE AccountID = '".$_SESSION['LOGIN']."'"));	
	$meu_bau = "0x". strtoupper(bin2hex($bau['Items']));
	$codigo_bau_vazio = "0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
	if($meu_bau == "0x"){return TRUE;} // BAU NUNCA FOI ABERTO
	if($meu_bau == $codigo_bau_vazio){return FALSE;}
	return TRUE;
	
}
//VERIFICAR SE A MISSÃO JA FOI CONCLUIDA

function verificar_missao($missao){	
	$ver = mssql_fetch_assoc(query("SELECT * FROM HZ_MISSAO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	if($ver['missao_'.$missao] == 1){
		return TRUE;
	}else{
		return FALSE;
	}
}
function hz_missao(){
	$ver = mssql_fetch_assoc(query("SELECT memb___id FROM HZ_MISSAO WHERE memb___id = '".$_SESSION['LOGIN']."'"));
	if($ver['memb___id'] == null || $ver['memb___id'] == "" || $ver['memb___id'] == false){
		query("INSERT INTO MuOnline.dbo.HZ_MISSAO (memb___id)VALUES('".$_SESSION['LOGIN']."')");
	}
}
//VERIFICA SE AS MISSOES FORAM COMPLETADAS

function todas_missoes($tipo){
	$tipo = (int)protect($tipo);
	hz_missao();
	switch($tipo){
		// FAÇA 10 RESETS COM QUALQUER CLASSE
		case 0: 
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT Name, ".RESETS." FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char[RESETS] > 10){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(0,0);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não possui um char com mais de 10 resets, volte quando tiver.</p></blockquote>";
			}
		break;
		
		// FAÇA 50 RESETS EM UM DIA
		
		case 1:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT Name, ".RESETS_DAY." FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char[RESETS_DAY] > 50){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(0,0);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 50 resets no Ranking Diario, volte quando tiver.</p></blockquote>";
			}			
		break;
		// FAÇA 350 RESETS EM UMA SEMANA
		case 2:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT Name, ".RESETS_WEEK." FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char[RESETS_WEEK] > 350){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(0,0);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 350 no Ranking Semanal, volte quando tiver.</p></blockquote>";
			}			
		break;
		//FAÇA 1000 RESETS EM UM MES
		case 3:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT Name, ".RESETS_MONTH." FROM Character WHERE AccountID = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char[RESETS_MONTH] > 1000){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(0,0);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 1000 no Ranking Mensal, volte quando tiver.</p></blockquote>";
			}			
		break;
		//FAÇA 20 RESETS COM UM MG
		case 4:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, mg FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['mg'] > 20){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,50);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 20 com uma classe Magic Gladiator, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 20 RESETS COM UM DARK LORD
		case 5:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, dl FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['dl'] > 20){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,52);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 20 com uma classe Dark Lord, volte quando tiver.</p></blockquote>";
			}	
		break;		
		//FAÇA 200 RESETS COM UM DARK LORD
		case 6:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, dl FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['dl'] > 200){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,110);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 200 com uma classe Dark Lord, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 400 RESETS COM UM DARK LORD
		case 7:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, dl FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['dl'] > 400){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,109);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 400 com uma classe Dark Lord, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 600 RESETS COM UM DARK LORD
		case 8:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, dl FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['dl'] > 600){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,111);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 600 com uma classe Dark Lord, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 800 RESETS COM UM DARK LORD
		case 9:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, dl FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['dl'] > 800){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,108);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 800 com uma classe Dark Lord, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 1000 RESETS COM UM DARK LORD
		case 10:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, dl FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['dl'] > 1000){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,107);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 1000 com uma classe Dark Lord, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 200 RESETS COM UM MAGIC GLADIATOR
		case 11:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, mg FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['mg'] > 200){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,119);//FUNÇAO QUE ADICIONA O BONUS boot
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 200 com uma classe Magic Gladiator, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 400 RESETS COM UM MAGIC GLADIATOR
		case 12:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, mg FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['mg'] > 400){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,118);//FUNÇAO QUE ADICIONA O BONUS pants
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 400 com uma classe Magic Gladiator, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 600 RESETS COM UM MAGIC GLADIATOR
		case 13:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, mg FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['mg'] > 600){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,120);//FUNÇAO QUE ADICIONA O BONUS gloves
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 600 com uma classe Magic Gladiator, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 800 RESETS COM UM MAGIC GLADIATOR
		case 14:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, mg FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['mg'] > 800){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,117);//FUNÇAO QUE ADICIONA O BONUS amor
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 800 com uma classe Magic Gladiator, volte quando tiver.</p></blockquote>";
			}	
		break;
		//FAÇA 20 RESETS COM UM SOUL MASTER
		case 15:
			if(logged()){return;}
			if(verificar_missao($tipo)){echo "<blockquote><p>Esta missão já foi concluida.</p></blockquote>"; return;}
			if(!v_logado()){echo "<blockquote><p>Sua conta esta logada.</p></blockquote>"; return;}
			$query = query("SELECT login, sm FROM HZ_RESETS WHERE login = '".$_SESSION['LOGIN']."'");
			while($char = mssql_fetch_assoc($query)){
				if($char['sm'] > 20){
					$premiar = true;
				}
			}
			if($premiar == true){
					if(verificar_bau()){echo "<blockquote><p>Remova todos itens do baú 0, para resgatar o premio!</p></blockquote>"; return;}
					
					if(query("UPDATE HZ_MISSAO SET missao_".$tipo." = 1 WHERE memb___id = '".$_SESSION['LOGIN']."'")){
					
						missao_premio(1,54);//FUNÇAO QUE ADICIONA O BONUS
						
						echo "<blockquote><p>Missão completada, seu premio foi entregue.</p></blockquote>";
					}
				
			}else{
				echo "<blockquote><p>Você ainda não conseguiu os 20 com uma classe Soul Master, volte quando tiver.</p></blockquote>";
			}	
		break;
		
	}
}

/* GERADO DE ITEM NO BAU

function items2($item){
	$item = "0x".$item."FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
	
	return $item;
}
*/
function items($item1,$item2,$item3,$item4,$item5,$item6,$item7,$item8){
	$item = "0x".$item1."FFFFFFFFFFFFFFFFFFFF".$item2."FFFFFFFFFFFFFFFFFFFF".$item3."FFFFFFFFFFFFFFFFFFFF".$item4."FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF".$item5."FFFFFFFFFFFFFFFFFFFF".$item6."FFFFFFFFFFFFFFFFFFFF".$item7."FFFFFFFFFFFFFFFFFFFF".$item8."FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
	return $item;
} 
// ADICIONA O PREMIO NO BAU
function send_premio($premio){
	query("UPDATE warehouse SET Items={$premio} where AccountID = '".$_SESSION['LOGIN']."'");
}
// ESCOLHE O PREMIO A SER ENTREGUE

function missao_premio($tipo, $premio){
			//deixe $f20 para não adicionar itens no espaço
			$f20 = "FFFFFFFFFFFFFFFFFFFF";
			
			$rapier_semi_normal  = items("02EDFF00000000450000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$rapier_semi_ancient = items("02EDFF00000000450005",$f20,$f20,$f20,$f20,$f20,$f20,$f20); 
			$rapier_full_normal  = items("02EFFF000000007F0000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$rapier_full_ancient = items("02EFFF000000007F0005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$Blucker_semi_normal = items("C4EDFF00000000450000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$Blucker_semi_azul   = items("C4EDFF00000000450005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$Blucker_full_normal = items("C4EFFF000000007F0000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$Blucker_full_azul 	 = items("C4EFFF000000007F0005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$dragon_shield_semi  = items("CDEFFF00000000450000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$dragon_shield_full  = items("CDEFFF000000007F0000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			//set lord
			
			$helm_lord_full	 	 = items("E1EFFF000000007F0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$helm_lord_azul	 	 = items("E1EFFF000000007F0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$amor_lord_full  	 = items("01EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$amor_lord_azul 	 = items("01EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$gloves_lord_full	 = items("41EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$gloves_lord_azul	 = items("41EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$pants_lord_full	 = items("21EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$pants_lord_azul	 = items("21EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$boot_lord_full		 = items("61EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$boot_lord_azul		 = items("61EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$kit_lord_full       = items("E1EFFF000000007F0080","01EFFF00000000FF0080","41EFFF00000000FF0080","21EFFF00000000FF0080","61EFFF00000000FF0080",$f20,$f20,$f20);
			$kit_lord_azul       = items("E1EFFF000000007F0085","01EFFF00000000FF0085","41EFFF00000000FF0085","21EFFF00000000FF0085","61EFFF00000000FF0085",$f20,$f20,$f20);
			
			// set gladiator
			
			$amor_glad_full  	 = items("00EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$amor_glad_azul 	 = items("00EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$gloves_glad_full	 = items("40EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$gloves_glad_azul	 = items("40EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$pants_glad_full	 = items("20EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$pants_glad_azul	 = items("20EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$boot_glad_full		 = items("60EFFF00000000FF0080",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$boot_glad_azul		 = items("60EFFF00000000FF0085",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$kit_gladiator_full  = items("00EFFF00000000FF0080","40EFFF00000000FF0080","20EFFF00000000FF0080","60EFFF00000000FF0080",$f20,$f20,$f20,$f20);
			$kit_gladiator_azul  = items("00EFFF00000000FF0085","40EFFF00000000FF0085","20EFFF00000000FF0085","60EFFF00000000FF0085",$f20,$f20,$f20,$f20);
			
			//set thunder Hawk
			
			$amor_t_hawk_semi  	 = items("14CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$amor_t_hawk_sazul 	 = items("14CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$gloves_t_hawk_semi	 = items("54CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$gloves_t_hawk_sazul = items("54CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$pants_t_hawk_semi	 = items("34CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$pants_walker_sazul  = items("34CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$boot_t_hawk_semi	 = items("74CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$boot_t_hawk_sazul 	 = items("74CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$kit_t_hawk_semi  	 = items("14CFFF00000000C50000","54CFFF00000000C50000","34CFFF00000000C50000","74CFFF00000000C50000",$f20,$f20,$f20,$f20);
			$kit_t_hawk_semi_a   = items("14CFFF00000000C50005","54CFFF00000000C50005","34CFFF00000000C50005","74CFFF00000000C50005",$f20,$f20,$f20,$f20);
			
			//set dark soul semi
			$helm_dark_soul	 	 = items("FACFFF00000000450000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$helm_dark_soul_a	 = items("FACFFF00000000450005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$amor_dark_soul		 = items("1ACFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$amor_dark_soul_a	 = items("1ACFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$gloves_dark_soul	 = items("5ACFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$gloves_dark_soul_a	 = items("5ACFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$pants_dark_soul	 = items("3ACFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$pants_dark_soul_a	 = items("3ACFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$boot_dark_soul		 = items("7ACFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$boot_dark_soul_a	 = items("7ACFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$kit_dark_soul_semi	 = items("FACFFF00000000450000","1ACFFF00000000C50000","5ACFFF00000000C50000","3ACFFF00000000C50000","7ACFFF00000000C50000",$f20,$f20,$f20);
			$kit_dark_soul_semi_a= items("FACFFF00000000450005","1ACFFF00000000C50005","5ACFFF00000000C50005","3ACFFF00000000C50005","7ACFFF00000000C50005",$f20,$f20,$f20);
			
			// SET LEGENDARY
			
			$helm_legendary_full 	 = items("E3CFFF00000000450000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$helm_legendary_azul	 = items("E3CFFF00000000450005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$amor_legendary_full  	 = items("03CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$amor_legendary_azul 	 = items("03CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$gloves_legendary_full	 = items("43CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$gloves_legendary_azul	 = items("43CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$pants_legendary_full	 = items("23CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$pants_legendary_azul	 = items("23CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$boot_legendary_full	 = items("63CFFF00000000C50000",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			$boot_legendary_azul	 = items("63CFFF00000000C50005",$f20,$f20,$f20,$f20,$f20,$f20,$f20);
			
			$kit_legendary_semi	 	= items("E3CFFF00000000450000","03CFFF00000000C50000","43CFFF00000000C50000","23CFFF00000000C50000","63CFFF00000000C50000",$f20,$f20,$f20);
			$kit_legendary_semi_a	= items("E3CFFF00000000450005","03CFFF00000000C50005","43CFFF00000000C50005","23CFFF00000000C50005","63CFFF00000000C50005",$f20,$f20,$f20);
			
			
	switch($tipo){	
		//ENTREGUA UM ITEM ALEATORIO TEM QUE SER SORTUDO, PARA GANHAR UM ITEM FULL		
		case 0: //tipo alearorio
			$premiado = rand(0,100);// REGURLA A PORCENTAGEM DE CHANCE		
				// 90% de chance de sair esses items
			if($premiado <= 90){
				$n_premio = rand(0,3); // REGURLA A PORCENTAGEM DE CHANCE
				switch($n_premio){
					case 0:	
						send_premio($rapier_semi_normal);
					break;
					case 1:
						send_premio($Blucker_semi_normal);
					break;
					default:
						send_premio($dragon_shield_semi);
					break;
				}
				// 10% de chance de conseguir esses itens
			}elseif($premiado >= 91 && $premiado <= 99){
				$n_premio = rand(0,10); // REGURLA A PORCENTAGEM DE CHANCE
				switch($n_premio){
					case 0:
						send_premio($dragon_shield_semi);
					break;
					case 1:
						send_premio($rapier_semi_normal);
					break;
					case 2:
					    send_premio($Blucker_semi_azul);
					break;
					case 3:
						send_premio($kit_dark_soul_semi_a);
					break;
					case 4:
						send_premio($kit_t_hawk_semi_a);
					break;
					case 5:
						send_premio($kit_legendary_semi_a);
					break;
					default:	
						send_premio($rapier_semi_ancient);
					break;
				}
				// 1% de chance de conseguir esses items
			}elseif($premiado == 100){
				$n_premio = rand(0,8); // REGURLA A PORCENTAGEM DE CHANCE
				switch($n_premio){
					case 0:
						send_premio($rapier_full_ancient);
					break;
					case 1:
						send_premio($rapier_full_normal);
					break;
					case 2:
						send_premio($dragon_shield_full);
					break;
					case 3:
						send_premio($Blucker_full_azul);
					break;
					case 4:
						send_premio($Blucker_full_normal);
					break;
					case 5:
						send_premio($kit_t_hawk_semi_a);
					break;
					case 6:
						send_premio($kit_lord_azul);
					break;
					case 7:
						send_premio($kit_gladiator_azul);
					break;
					default:
						send_premio($rapier_full_ancient);
					break;
				}
			}
			
		break;
		// AQUI VOCE ESCOLHER O PREMIO A ENTREGUAR PELA MISSAO
		case 1: //escolhe premio
		  switch($premio){
			  
			  case 1:
				send_premio($rapier_full_normal);
			  break;
			  case 2:
				send_premio($rapier_full_ancient);
			  break;
			  case 3:
				send_premio($Blucker_full_normal);
			  break;
			  case 4:
				send_premio($Blucker_full_azul);
			  break;			  
			  case 5:
			    send_premio($dragon_shield_full);
			  break;			  
			  case 6:
			    send_premio($rapier_full_ancient);
			  break;
			  
			  //SET THUNDER HAWK SEMI
			  case 50:
				send_premio($kit_t_hawk_semi);
			  break;
			  case 51:
				send_premio($kit_t_hawk_semi_a);
			  break; 
			  
			  //SET DARK SOUL SEMI
			  case 52:
				send_premio($kit_dark_soul_semi);
			  break;
			  case 53:
				send_premio($kit_dark_soul_semi_a);
			  break;
			  
			  // SET LEGENDARY SEMI
			  case 54:
			   send_premio($kit_legendary_semi);
			  break;			  
			  case 55:
			   send_premio($kit_legendary_semi_a);
			  break;
			  
			  // SET DARK LORD PARTES FULL			  
			  case 107:
			     send_premio($helm_lord_full);
			  break;			  
			  case 108:
			     send_premio($amor_lord_full);
			  break;			  
			  case 109:
			     send_premio($pants_lord_full);
			  break;			  
			  case 110:
			     send_premio($boot_lord_full);
			  break;			  
			  case 111:
			     send_premio($gloves_lord_full);
			  break;
			  
			  //SET DARK LORD PARTES FULL ANCIENT
			  
			  case 112:
			     send_premio($helm_lord_azul);
			  break;			  
			  case 113:
			     send_premio($amor_lord_azul);
			  break;			  
			  case 114:
			     send_premio($pants_lord_azul);
			  break;			  
			  case 115:
			     send_premio($boot_lord_azul);
			  break;			  
			  case 116:
			     send_premio($gloves_lord_azul);
			  break;
			  
			  // set gladiator normal
			  
			  case 117:
			     send_premio($amor_glad_full);
			  break;			  
			  case 118:
			     send_premio($pants_glad_full);
			  break;			  
			  case 119:
			     send_premio($boot_glad_full);
			  break;			  
			  case 120:
			     send_premio($gloves_glad_full);
			  break;
			  
			  //set gladiador azull
			  
			  case 121:
			     send_premio($amor_glad_azul);
			  break;			  
			  case 122:
			     send_premio($pants_glad_azul);
			  break;			  
			  case 123:
			     send_premio($boot_glad_azul);
			  break;			  
			  case 124:
			     send_premio($gloves_glad_azul);
			  break;
			  
			  default:
			   //colocar uma kriss full
			   send_premio($rapier_full_normal);
			  break;
		  }
		  
		break;
	}
	
}
?>