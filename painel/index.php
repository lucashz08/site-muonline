<?php session_start();
include_once "modules/conf.php";
include_once "modules/class/connect.php";
include_once "modules/class/function.php";
include_once "modules/class/missoes.php";
?>
<html>
<head>
<title><?php echo TITLE; ?></title>
<meta name="Description" content="<?php echo DESCRIPTION; ?>" />
<meta name="Keywords" content="<?php echo KEYWORDS; ?>" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Lucas Lopes" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" type="text/css" href="style/css.css" />
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-72272011-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-72272011-4'); 
</script>
<script>
function alteraM(campoid){
	var valor = document.getElementById(campoid);
	valor.onkeyup = function(){
		var novoTexto = valor.value.toLowerCase();
		valor.value = novoTexto;
	}
} 
</script>
<style>
 <?php //include_once "style/css.css"; ?>
</style>
<meta charset="UTF-8">
</head>
<body>
<div style="position:relative;margin-left:auto; margin-right:auto; width:560px; margin-top:10px;">
<div id="head"></div>
 <div id="main_painel">
	<div id="main_left">
	<?php if(!isset($_SESSION['LOGIN'])){//painel para logar quando estiver deslogado ?>
		<h1><img src="img/alerta.png" width="16" height="16">Painel de controle</h1>
		<div id="main_login">
		<br />
			<form method="post" action="?logar=TRUE">
				<label>Conta:</label>
				<input type="text" name="login" maxlength="10" id="plogin"onKeyup="alteraM('plogin');">
				<label>Senha:</label>
				<input type="password" name="senha" maxlength="10">
				<br />
				<br />
				<input id="button"type="submit" name="logar" value="Entrar">
			</form>
		</div>
		<div id="main_left_aviso">
		<?php if($_GET['logar'] == "TRUE"){ logar($_POST['login'], $_POST['senha']);}?>
		</div>
	<?php }else{ // painel logado ?>
		<h1><img src="img/logado.jpg" width="16" height="16">Gerenciar Conta</h1>
		<div id="main_menu">
			<ul>
				<li><a href="?"><img src="img/arrow.png"> Principal</a></li>
				<li><a href="?pag=alterar_dados"><img src="img/arrow.png"> Alterar Dados</a></li>
				<li><a href="?pag=trocar_senha"><img src="img/arrow.png"> Trocar Senha</a></li>
				<li><a href="?pag=link_de_referencia"><img src="img/arrow.png"> Link de Referencia</a></li>
				<li><a href="?pag=missoes"><img src="img/arrow.png"> Minhas Missões</a></li>
			 <li><a href="?logar=FALSE"><img src="img/arrow.png"> Deslogar</a></li><?php if($_GET['logar'] == "FALSE"){ Deslogar(); echo "certo"; } // funcao que desloga do painel ?>
			</ul>
		</div>
		<h1><img src="img/logado.jpg" width="16" height="16">Gerenciar Personagem</h1>
		<div id="main_menu">
			<ul>
				<li><a href="?pag=resetar_personagem"><img src="img/arrow.png"> Resetar Personagem</a></li>
				<li><a href="?pag=distribuir_pontos"><img src="img/arrow.png"> Distribuir Pontos</a></li>
				<li><a href="?pag=resetar_pontos"><img src="img/arrow.png"> Resetar Pontos</a></li>
				<li><a href="?pag=desbugar_pontos"><img src="img/arrow.png"> Desbugar Pontos</a></li>
				<li><a href="?pag=desbugar_zen"><img src="img/arrow.png"> Desbugar Zen</a></li>
				<li><a href="?pag=limpar_pk"><img src="img/arrow.png"> Limpar PK</a></li> 
				<li><a href="?pag=trocar_classe"><img src="img/arrow.png"> Trocar de Classe</a></li>
			</ul>
		</div>
	<?php } // fim do painel de login ?>
	</div>
	<div id="main_right">
	<?php if(!isset($_SESSION['LOGIN'])){?>
	 <h2><img src="img/pergunta.png" width="16" height="16"> Informações</h2>
	 <hr>
	 <blockquote>
	 <p>Aqui você pode realizar tarefas como resetar perssonagem, distribuir pontos, desbugar zen entre outras.</p>
	 </blockquote>
	 <?php }else{ // painel logado 
		switch($_GET['pag']){
			case "alterar_dados":
			?>
			<h2><img src="<?php if(v_vip() == 1){echo "img/vip.png ";}elseif(v_vip() == 2){echo "img/svip.png";}else{echo "img/free.png";}?>" width="35" > Alterar Dados</h2>
			<hr>
			<blockquote>
			<p>Para trocar seu Email de cadastro preencha o campo com um novo email, em seguida preencha o campo com sua pergunta secreta e resposta que você usou quando fez o cadastro no site, e apenas uma palavra.</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=alterar_dados&dados=true">
				<br />
				<label>Novo Email :</label>
				<br />
				<input type="email" id="text" name="new_email" maxlength="35">
				<br />
				<label>Pergunta :</label>
				<br />
				<input type="text" id="text" name="sec_per" maxlength="10">
				<br />
				<label>Resposta :</label>
				<br />
				<input type="text" id="text" name="sec_res" maxlength="10">
				<br />
				<br />
				<input id="button"type="submit" name="logar" value="Trocar de Email">
				<p>
					<?php if(isset($_POST['new_email'])){change_email($_POST['new_email'], $_POST['sec_per'], $_POST['sec_res']);}?>
				</p>
			</form>
			</blockquote>
			<?php
			break;
			case "trocar_senha":
			?>
			<h2><img src="<?php if(v_vip() == 1){echo "img/vip.png ";}elseif(v_vip() == 2){echo "img/svip.png";}else{echo "img/free.png";}?>" width="35" > Trocar de Senha</h2>
			<hr>
			<blockquote>
			<p>Para trocar a sua Senha preencha o campo com uma nova senha, em seguida preencha o campo com sua pergunta secreta e resposta que você usou quando fez o cadastro no site, e apenas uma palavra.</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=trocar_senha&nova_senha=true">
				<br />
				<label>Nova Senha :</label>
				<br />
				<input type="password" id="text" name="new_senha" maxlength="10">
				<br />
				<label>Repita Senha :</label>
				<br />
				<input type="password" id="text" name="new_rsenha" maxlength="10">
				<br />
				<label>Pergunta :</label>
				<br />
				<input type="text" id="text" name="sec_per" maxlength="10">
				<br />
				<label>Resposta :</label>
				<br />
				<input type="text" id="text" name="sec_res" maxlength="10">
				<br />
				<br />
				<input id="button"type="submit" name="logar" value="Mudar de Senha">
				<p>
					<?php if(isset($_POST['new_senha'])){change_senha($_POST['new_senha'],$_POST['new_rsenha'], $_POST['sec_per'], $_POST['sec_res']);}?>
				</p>
			</form>
			</blockquote>
			<?php
			break;
			case "link_de_referencia":
			?>
			<h2><img src="<?php if(v_vip() == 1){echo "img/vip.png ";}elseif(v_vip() == 2){echo "img/svip.png";}else{echo "img/free.png";}?>" width="35" > Link de Referencia</h2>
			<hr>
			<blockquote>
			<p>Ajudando na divulgação do servidor você ganha cash sempre que um novo visitante acessa o seu link, a má ultilização deste serviço a fim de burlar o sistema pode resultar em bloqueio da conta.</p>
			</blockquote>
			<blockquote>
				<?php if($_GET['divulgar'] == TRUE){criar_link();} ?>
				<?php ddv(); // FUNÇÃO PARA O LINK DE REFERENCIA ?>
			</blockquote>
			<?php
			break;
			case "missoes":
			?>
			<h2><img src="<?php if(v_vip() == 1){echo "img/vip.png ";}elseif(v_vip() == 2){echo "img/svip.png";}else{echo "img/free.png";}?>" width="35" > Link de Referencia</h2>
			<hr>
			<blockquote>
			<p>Complete suas missoes, você pode ganhar muitos premios!, Aviso: deixe seu /bau 0 vazio!</p>
			</blockquote>
			<?php if(!verificar_missao(0)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_0').style.display = 'block';">Faça 10 resets com qualquer classe.</a></p>
			<?php if($_POST['missao_0']){echo "<hr />";todas_missoes(0); } ?>
			<div id="missao_0" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Aleatório</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_0" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>
			</blockquote>
			<?php } ?>
			<!-- FAÇA 50 RESETS EM UM DIA -->
			<?php if(!verificar_missao(1)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_1').style.display = 'block';">Faça 50 resets em um Dia.</a></p>
			<?php if($_POST['missao_1']){echo "<hr />";todas_missoes(1); } ?>
			<div id="missao_1" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Aleatório</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_1" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 350 RESETS EM UMA SEMANA -->
			<?php if(!verificar_missao(2)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_2').style.display = 'block';">Faça 350 resets em uma Semana.</a></p>
			<?php if($_POST['missao_2']){echo "<hr />";todas_missoes(2); } ?>
			<div id="missao_2" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Aleatório</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_2" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 1000 RESETS EM UM MES -->
			<?php if(!verificar_missao(3)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_3').style.display = 'block';">Faça 1000 resets em um Mês.</a></p>
			<?php if($_POST['missao_3']){echo "<hr />";todas_missoes(3); } ?>
			<div id="missao_3" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Aleatório</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_3" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 20 RESETS COM UM MG -->
			<?php if(!verificar_missao(4)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_4').style.display = 'block';">Faça 20 Resets com um Magic Gladiator.</a></p>
			<?php if($_POST['missao_4']){echo "<hr />";todas_missoes(4); } ?>
			<div id="missao_4" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Set Thunder Hawk</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_4" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 20 RESETS COM UM DL -->
			<?php if(!verificar_missao(5)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_5').style.display = 'block';">Faça 20 Resets com um Dark Lord.</a></p>
			<?php if($_POST['missao_5']){echo "<hr />";todas_missoes(5); } ?>
			<div id="missao_5" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Set Dark Soul</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_5" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 20 RESETS COM UM SM -->
			<?php if(!verificar_missao(15)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_15').style.display = 'block';">Faça 20 Resets com um Soul Master.</a></p>
			<?php if($_POST['missao_15']){echo "<hr />";todas_missoes(15); } ?>
			<div id="missao_15" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Set Legendary</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_15" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 200 RESETS COM UM DL -->
			<?php if(!verificar_missao(6)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_6').style.display = 'block';">Faça 200 Resets com um Dark Lord.</a></p>
			<?php if($_POST['missao_6']){echo "<hr />";todas_missoes(6); } ?>
			<div id="missao_6" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Boot Lord Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_6" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 400 RESETS COM UM DL -->
			<?php if(!verificar_missao(7)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_7').style.display = 'block';">Faça 400 Resets com um Dark Lord.</a></p>
			<?php if($_POST['missao_7']){echo "<hr />";todas_missoes(7); } ?>
			<div id="missao_7" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Pants Lord Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_7" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 600 RESETS COM UM DL -->
			<?php if(!verificar_missao(8)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_8').style.display = 'block';">Faça 600 Resets com um Dark Lord.</a></p>
			<?php if($_POST['missao_8']){echo "<hr />";todas_missoes(8); } ?>
			<div id="missao_8" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Gloves Lord Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_8" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 800 RESETS COM UM DL -->
			<?php if(!verificar_missao(9)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_9').style.display = 'block';">Faça 800 Resets com um Dark Lord.</a></p>
			<?php if($_POST['missao_9']){echo "<hr />";todas_missoes(9); } ?>
			<div id="missao_9" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Armor Lord Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_9" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 1000 RESETS COM UM DL -->
			<?php if(!verificar_missao(10)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_10').style.display = 'block';">Faça 1000 Resets com um Dark Lord.</a></p>
			<?php if($_POST['missao_10']){echo "<hr />";todas_missoes(10); } ?>
			<div id="missao_10" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Helm Lord Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_10" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 200 RESETS COM UM MG -->
			<?php if(!verificar_missao(11)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_11').style.display = 'block';">Faça 200 Resets com um Magic Gladiator.</a></p>
			<?php if($_POST['missao_11']){echo "<hr />";todas_missoes(11); } ?>
			<div id="missao_11" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Boots Gladiator Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_11" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 400 RESETS COM UM MG -->
			<?php if(!verificar_missao(12)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_12').style.display = 'block';">Faça 400 Resets com um Magic Gladiator.</a></p>
			<?php if($_POST['missao_12']){echo "<hr />";todas_missoes(12); } ?>
			<div id="missao_12" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Pants Gladiator Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_12" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 600 RESETS COM UM MG -->
			<?php if(!verificar_missao(13)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_13').style.display = 'block';">Faça 600 Resets com um Magic Gladiator.</a></p>
			<?php if($_POST['missao_13']){echo "<hr />";todas_missoes(13); } ?>
			<div id="missao_13" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Gloves Gladiator Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_13" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			<!-- FAÇA 800 RESETS COM UM MG -->
			<?php if(!verificar_missao(14)){ ?>
			<blockquote>
			<p><a style="cursor:pointer;"onclick="document.getElementById('missao_14').style.display = 'block';">Faça 800 Resets com um Magic Gladiator.</a></p>
			<?php if($_POST['missao_14']){echo "<hr />";todas_missoes(14); } ?>
			<div id="missao_14" style="display:none;">
			<hr />
				<form method="post" action="?pag=missoes">
					<blockquote>
					<p>Tipo de Premio : <b>Armor Gladiator Full</b></p>
					</blockquote>
					<input style="padding:5px; cursor:pointer;" type="submit" name="missao_14" value="Click aqui caso já tenha o que e necessario." >
				</form>
				<br />
			</div>			
			</blockquote>
			<?php } ?>
			
			<?php
			break;
			case "resetar_personagem":
			?> 
		<h2><img src="<?php if(v_vip() == 1){echo "img/vip.png ";}elseif(v_vip() == 2){echo "img/svip.png";}else{echo "img/free.png";}?>" width="35" > Resetar Personagem</h2>
			<hr>
			<blockquote>
			<p>E preciso estar no Level <?php if(v_vip() == 1){echo RESET_VIP;}elseif(v_vip() == 2){echo RESET_VIP2;}else{echo RESET_FREE;}?> para efetuar o Reset, digite o nome do seu personagem abaixo</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=resetar_personagem&reset=true">
				<br />
				<label>Escolha seu personagem :</label>
				<!--<input type="text" id="text" name="character_name" maxlength="10">-->
				<select name="character_name" id="select_style" style="">					
					<?php select_char(); ?>
				</select>
				<br />
				<br />
				<input id="button"type="submit" name="logar" value="Resetar">
				<p>
					<?php if(isset($_POST['character_name'])){go_reset($_POST['character_name']);}?>
				</p>
			</form>
			</blockquote>
			<?php
			break;
			case "distribuir_pontos":
			?> 
			<h2><img src="img/pergunta.png" width="16" height="16"> Distribuir Pontos</h2>
			<hr />
			<blockquote>
			<p>Não passe do valor de <?php echo MAX_PONTOS; ?> em cada Status.</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=distribuir_pontos&adicionar_pontos=true">
				<br />
				<label>Personagem :</label>
				<br />
				<!--<input type="text" id="text" name="nick" maxlength="10">-->
				<select name="nick" id="select_style" style="">					
					<?php select_char(); ?>
				</select>
				<br />	
				<label>Força :</label>
				<br />
				<input type="text" id="text" name="forca" maxlength="5"  placeholder="0">
				<br />				
				<label>Agilidade :</label>
				<br />
				<input type="text" id="text" name="agilidade" maxlength="5"  placeholder="0">				
				<br />
				<label>Vitlidade :</label>
				<br />
				<input type="text" id="text" name="vitalidade" maxlength="5" placeholder="0">				
				<br />
				<label>Energia :</label>
				<br />
				<input type="text" id="text" name="energia" maxlength="5" placeholder="0">		
				<br />
				<br />
				<input id="button"type="submit" name="adicionar_pontos" value="Adicionar Pontos">
				<p>
					<?php if(isset($_POST['adicionar_pontos'])){distribuir($_POST['nick'],$_POST['forca'],$_POST['agilidade'],$_POST['vitalidade'],$_POST['energia']);}?>
				</p>
			</form>
			</blockquote>
				<br />
				<h2>Personagens</h2>
				<br />
			<table>				
				<tr>
					<td><b>Nick</b></td>
					<td><b>Resets</b></td>
					<td><b>Level</b></td>
					<td><b>Pontos</b></td>
				</tr>				
				<?php echo ler_char(); ?>
			</table>			
			<?php
			break;
			case "resetar_pontos":
			?> 
			<h2><img src="img/pergunta.png" width="16" height="16"> Resetar Pontos</h2>
			<hr />
			<blockquote>
			<p>Todos os seus pontos seram adicionados para Redistribuir novamente.</p>
			</blockquote>
			<blockquote>
				<form method="post" action="?pag=resetar_pontos&reset_pontos=true">
					<br />
					<label>Escolha o personagem :</label>
					<br />
					<!--<input type="text" id="text" name="character_name" maxlength="10">-->
					<select name="character_name" id="select_style" style="">					
					<?php select_char(); ?>
					</select>
					<br />
					<br />
					<input id="button"type="submit" name="reset_pontos" value="Reseta Pontos">
					<p>
						<?php if(isset($_POST['reset_pontos'])){echo reset_pontos($_POST['character_name']);}?>
					</p>
				</form>
			</blockquote>
			<?php
			break;
			case "desbugar_pontos":
			?> 
			<h2><img src="img/pergunta.png" width="16" height="16"> Desbugador de Pontos</h2>
			<hr />
			<blockquote>
			<p>Seus pontos serão desbugados com base na quantidade de Resets que seu Char possui .</p>
			</blockquote>
			<blockquote>
				<form method="post" action="?pag=desbugar_pontos&reset_pontos=true">
					<br />
					<label>Escolha o personagem :</label>
					<br />
					<!--<input type="text" id="text" name="character_name" maxlength="10">-->
					<select name="character_name" id="select_style" style="">					
						<?php select_char(); ?>
					</select>
					<br />
					<br />
					<input id="button"type="submit" name="desbugar_pontos" value="Desbugar Pontos">
					<p>
						<?php if(isset($_POST['desbugar_pontos'])){echo desbugar_pontos($_POST['character_name']);}?>
					</p>
				</form>
			</blockquote>			
			<?php
			break;
			case "desbugar_zen":
			?> 
			<h2><img src="img/zen.png" width="16" height="16"> Desbugar Zen</h2>
			<hr />
			<blockquote>
			<p>Digite o nick do personagem que esta com o zen, bugado.</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=desbugar_zen&zen=true">
			<br />
				<label>Escolha o personagem :</label>
				<br />
				<!--<input type="text" id="text" name="desbugar_zen" maxlength="10">-->
				<select name="desbugar_zen" id="select_style" style="">					
					<?php select_char(); ?>
				</select>
				<br />
				<br />
				<input id="button"type="submit" name="logar" value="Desbugar Zen">
				<p>
					<?php if(isset($_POST['desbugar_zen'])){go_zen($_POST['desbugar_zen']);}?>
				</p>
			</form>
			</blockquote>
			<?php
			break;
			case "limpar_pk":
			?>
			<h2><img src="img/zen.png" width="16" height="16"> Limpar PK</h2>
			<hr />
			<blockquote>
			<p>O para limpar PK e preciso ter bastante zen, o valor e cobrado de acordo com a quantidade de players que você matou.</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=limpar_pk&virar_heroi=true">
			<br />
				<label>Escolha o Personagem:</label>
				<br />
				<br />
				<!--<input type="text" id="text" name="virar_pk_heroi" maxlength="10">-->
					<select name="virar_pk_heroi" id="select_style" style="">					
						<?php select_char(); ?>
					</select>
				<br />
				<br />
				<input id="button"type="submit" name="virar_heroi" value="Limpar PK">
				<p>
					<?php if(isset($_POST['virar_heroi'])){virar_heroi($_POST['virar_pk_heroi']);}?>
				</p>
			</form>
			</blockquote>
			<?php
			break;
			case "trocar_classe":
			?>
			<h2><img src="img/zen.png" width="16" height="16"> Trocar de Classe</h2>
			<hr />
			<blockquote>
			<p>Atenção! remova todos os items no seu personagem antes de efetuar a troca de classe, não damos suporte a itens perdidos. É descontado <?php echo CLASS_CASH; ?> Cash por cada troca.</p>
			</blockquote>
			<blockquote>
			<form method="post" action="?pag=trocar_classe&trocar=true">
			<br />
				<label>Escolha o Personagem:</label>
				<br />
				<br />
				<!-- <input type="text" id="text" name="trocar_classe" maxlength="10"> -->
					<select name="trocar_classe" id="select_style" style="">					
						<?php select_char(); ?>
					</select>
				<br />
				<label> Escolha a Classe</label>
				<br />
				<select name="classe_chose" id="select_style">
				  <option value="17">Blade Knight</option>
				  <option value="1">Soul Master</option>
				  <option value="48">Magic Gladiator</option>
				  <option value="33">Muse Elf</option>
				  <option value="64">Dark Lord</option>
				</select>
				<br />
				<br />
				<input id="button"type="submit" name="trocar" value="Trocar de Classe">
				<p>
					<?php if(isset($_POST['trocar'])){trocar_classe($_POST['trocar_classe'], $_POST['classe_chose']);}?>
				</p>
			</form>
			</blockquote>
			<?php
			break;
			default:
			?>
			<h2><img src="img/pergunta.png" width="16" height="16"> Bem Vindo <?php echo info('memb_name');?> .</h2>
			<hr />
			<blockquote>
			<p>Sempre verifique a ultima data que você logou, caso perceba algo estranho troque sua senha.</p>
			</blockquote>
			<table>
				<tr>
					<td>Login</td>
					<td><a id="blue"><?php echo $_SESSION['LOGIN']; ?></a></td>
				</tr>
				<tr>
					<td>Status da Conta</td>
					<td><a id="blue"><?php if(v_vip() == 1){echo NOME_VIP;}elseif(v_vip() == 2){echo NOME_VIP2;}else{echo NOME_FREE;}?></a></td>
				</tr>
				<tr>
					<td>Esta Online</td>
					<td><?php if(v_logado()){echo "<a style=\"color:#ff0000;\">Não</a>";}else{echo "<a style=\"color:green;\">Sim</a>";}?></td>
				</tr>				
				<tr>
					<td>Total de Cash</td>
					<td><a id="blue"><?php echo v_cash();?></a></td>
				</tr>
				<tr>
					<td>Ultima conexão IP</td>
					<td><a id="blue"><?php echo info2("IP");?></a></td>
				</tr>				
				<tr>
					<td>Ultima vêz que Logou</td>
					<td><a id="blue"><?php echo info2("DisConnectTM");?></a></td>
				</tr>
				<tr>
					<td>Tempo Online</td>
					<td><a id="blue"><?php echo tempo_online();?></a></td>
				</tr>
				
			</table>
				<br />
				<h2>Personagens</h2>
				<br />
			<table>				
				<tr>
					<td><b>Nick</b></td>
					<td><b>Resets</b></td>
					<td><b>Level</b></td>
					<td><b>Pontos</b></td>
				</tr>				
				<?php echo ler_char(); ?>
			</table>
			<?php			
		}
	 }?>
	</div>
 </div>
 <div id="rodape">
 <center> <p>Copyright © 2018 MU YES - Todos os Direitos Reservados <br /> Developed by: LucasHz  Version 1.0.0 </p></center>
 </div>
 </div>
</body>
</html>