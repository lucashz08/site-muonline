<?php include_once "modules/conf.php";include_once "modules/sis/function.php";
 if($_GET['ref']){verifica_visita($_GET['ref']);}else{setcookie("visita","true",time()+3600*24*365);}
?>
<!DOCTYPE html>
<html style="margin-top:0px;">
<head>
<title><?php echo TITLE; ?></title>
<meta name="Description" content="<?php echo DESCRIPTION; ?>" />
<meta name="Keywords" content="<?php echo KEYWORDS; ?>" />
<meta name="google-site-verification" content="PK30n8GAFa50xyczihQIqw5vlwAEcVbibPb6sZOxOy4" />
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/css.css"/>
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
<script type="text/javascript" src="modules/sis/js.js"></script>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id="conteiner">
<div id="conteiner2">
<div class="header">
	<div id="logar" style="display:none;">
	<?php if(!isset($_SESSION['LOGIN'])){ ?>
		<form method="post" action="?logar=TRUE">
			<input type="text" name="login" class="text" placeholder="Login" id="logarlogin" maxlength="10" onKeyUp="alteraM('logarlogin');">
			<input type="password" name="senha" class="text" placeholder="Senha" maxlength="10">
			<input type="submit" id="button2" value="Entrar">
		</form>
		<br /><p><?php if($_GET['logar'] == "TRUE"){ logar($_POST['login'], $_POST['senha']);}?></p>
			<?php }else{ ?>
				<p><a target="_blank" href="<?php echo URL_PAINEL; ?>">Painel de Controle</a> || <a href="?deslogar=true">Deslogar</a></p><?php if($_GET['deslogar'] == TRUE){Deslogar();}?>
			<?php }?>
	</div>


</div>
<div id="menu_left">

<h2>Principal</h2>
	<br />
	<div id="main_left">
			<ul>
				<li><a href="?page=home"><img src="img/arrow.png"> Inicio</a></li>
				
				<li><a target="_blank"  href="<?php echo URL_PAINEL; ?>"><img src="img/arrow.png"> Painel de Controle</a></li>
				<li><a href="?page=criar_conta" ><img src="img/arrow.png"> Cadastrar Conta</a></li>
				<li><a href="?page=recuperar_conta"><img src="img/arrow.png"> Recuperar Conta</a></li>
				<li><a href="?page=baixa_muonline"><img src="img/arrow.png"> Download do jogo</a></li>
				<li><a target="_blank" href="<?php echo URL_SHOP; ?>"><img src="img/arrow.png"> Shopping de Itens</a></li>
				<li><a href="?page=comprar_cash"><img src="img/arrow.png"> Comprar Cash</a></li>
				<li><a href="?page=informacoes_do_servidor"><img src="img/arrow.png"> Informações</a></li>			
				<li><a href="?page=suporte"><img src="img/arrow.png"> Suporte</a></li>
			</ul>
	</div>
	<h2>Rankings Geral</h2>
		<br />
	<div id="main_left">
			<ul>
				<li><a href="?page=top_reset_mensal"><img src="img/arrow.png"> Resets Mensal</a></li>
				<li><a href="?page=top_reset_semanal"><img src="img/arrow.png"> Resets Semanal</a></li>
				<li><a href="?page=top_reset_diario"><img src="img/arrow.png"> Resets Diario</a></li>
				<li><a href="?page=top_melhores_guilds"><img src="img/arrow.png"> Guild Score</a></li>
				<li><a href="?page=top_tempo"><img src="img/arrow.png"> Tempo Online</a></li>
			</ul>
	</div>
	<h2>Rankings de Classes</h2>
		<br />
	<div id="main_left">
			<ul>
				<li><a href="?page=top_reset_bladeknight"><img src="img/arrow.png"> Blade Knight</a></li>
				<li><a href="?page=top_reset_soulmaster"><img src="img/arrow.png"> Soul Master</a></li>
				<li><a href="?page=top_reset_magicgladiator"><img src="img/arrow.png"> Magic Gladiator</a></li>
				<li><a href="?page=top_reset_muse_elf"><img src="img/arrow.png"> Muse Elf</a></li>
				<li><a href="?page=top_reset_darklord"><img src="img/arrow.png"> Dark Lord</a></li>
			</ul>
	</div>
	<a href="?page=baixa_muonline"><img style="width:180px; margin:10px; border:none;"src="img/Download.jpg"></a>
</div>
<div id="main_right">
<?php 
	switch($_GET['page']){//PAGINA INICIAL 
 default:
?>
<?php
if(BANNER_AVISO == true){
?>
	<div id="slide">
		<img src="img/slide01.jpg">
	</div>
<?php } ?>
	<div id="conteiner_main">
		<div id="main_ranking">
			<div id="title_guild">
				<h2 id="title_ranking"> Melhores da Semana</h2>
			</div>
		<hr>
		<div id="menu_rank">
		<br />
			<ul>
				<li><a onclick="nav_rank('reset_week')">Reset Semanal</a></li>
				<li><a onclick="nav_rank('reset_month')">Reset Mensal</a></li>
				<li><a onclick="nav_rank('reset_day')">Reset Diario</a></li>			
				<li><a onclick="nav_rank('reset_total')">Reset Total</a></li>
			</ul>
		</div>
			<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="40"><p>P</p></td>
				<td width="100"><p>Nome</p></td>
				<td width="30"><center>Resets</center></td>
				
			</tr>
		</table>
			<div id="reset_total" style="display:none;">

				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP." * FROM Character ORDER BY ".RESETS." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"10\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"130\" height=\"18\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"\">".$resets['Name']."</a></td>
									<td width=\"30\" height=\"18\"><center>".$resets[RESETS]."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
			</div>
			<div id="reset_week" style="display:block;">
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP." * FROM Character ORDER BY ".RESETS_WEEK." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"10\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"130\" height=\"18\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"\">".$resets['Name']."</a></td>
									<td width=\"30\" height=\"18\"><center>".$resets[RESETS_WEEK]."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
			</div>
			<div id="reset_month" style="display:none;">
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP." * FROM Character ORDER BY ".RESETS_MONTH." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"10\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"130\" height=\"18\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"\">".$resets['Name']."</a></td>
									<td width=\"30\" height=\"18\"><center>".$resets[RESETS_MONTH]."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
			</div>
			<div id="reset_day" style="display:none;">
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP." * FROM Character ORDER BY ".RESETS_DAY." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"10\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"130\" height=\"18\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"\">".$resets['Name']."</a></td>
									<td width=\"30\" height=\"18\"><center>".$resets[RESETS_DAY]."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
			</div>
		</div>
		<div id="main_info">
			<div id="title_guild">
				<h2> Informações do Servidor</h2>
			</div>
		<hr>
		<br />
		<table>
			<tr>
				<td width="200">Versão</td>
				<td width="200"><a><?php echo VERSAO; ?></a></td>
			</tr>				
			<tr>
				<td width="200">Tipo de Reset</td>
				<td width="200"><a><?php echo TIPO_RESET; ?></a></td>
			</tr>			
			<tr>
				<td width="200">Drop</td>
				<td width="200"><a><?php echo DROPS; ?></a></td>
			</tr>
			<tr>
				<td width="200"> Experiência</td>
				<td width="200"><a><?php echo EXPERIENCE; ?></a></td>
			</tr>
			<tr>
				<td width="200">Maximo de Pontos</td>
				<td width="200"><a><?php echo MAXIMO_PONTOS; ?></a></td>
			</tr>			
			<tr>
				<td width="200">Servidor</td>
				<td width="200"><p style="color:green;">Online</p></td>
			</tr>
			<tr>
				<td width="200">Total de Contas</td>
				<td width="200"><a><?php echo total_contas(); ?></a></a></td>
			</tr>
			<tr>
				<td width="200">Total de Character</td>
				<td width="200"><a><?php echo total_char(); ?></a></td>
			</tr>			
			<tr>
				<td width="200">Total de Guilds</td>
				<td width="200"><a><?php echo total_guild(); ?></a></td>
			</tr>
			<?php if(SHOW_ONLINE == TRUE){?>
			<tr>
				<td width="200">Total Online</td>
				<td width="200"><a><?php echo total_online(); ?></a></td>
			</tr>
			<?php } ?>
			<?php if(COMERCIO_SHOW == TRUE){?>
			<tr>
				<td width="200">Comercio de itens FULL</td>
				<td width="200"><a><?php echo COMERCIO_FULL; ?></a></td>
			</tr>
			<?php } ?>
		</table>
		</div>
				<div id="main_info">
		<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmuyes.net&tabs=timeline&width=340&height=300&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId" width="330" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
		</div>
	<div id="top_guild">
		<div id="title_guild">
			<h2> Melhores Guilds</h2>
		</div>
		<hr>
		<table style="margin-bottom:6px;margin-top:6px; color:#444; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="40"><center>Flag</center></td>
				<td width="80"><center>Guild</center></td>
				<td width="40"><center>Score</center></td>
				
			</tr>
		</table>
		<table>
		<?php 
			$guild = mssql_query("SELECT TOP ".G_TOP." * FROM Guild ORDER BY G_Score DESC");
			while($g_guild = mssql_fetch_assoc($guild)){
				$logo = urlencode(bin2hex($g_guild['G_Mark']));
				echo "
						<tr>
							<td width=\"40\"><img  style=\"background:#FAFAFA;\"src=\"modules/sis/decode.php?decode=$logo\"></td>
							<td width=\"80\"><center><a href=\"\">".$g_guild['G_Name']."</a></center></td>
							<td width=\"40\"><center>".$g_guild['G_Score']."</center></td>
						</tr>
					";
		} ?>
		</table>
	</div>
</div>
<?php 
break;// FIM DA PAGINA INICIAL
case "comprar_cash":
?>
<div id="top_guilds">
	<div id="title_guild">
			<h1> Comprar Cash </h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Essas são nossas promoções, quanto maior for a sua doação mais cashs irar ganha, ao fazer uma doação de no minimo R$ 10,00 você também ganha 30 dias de <?php echo NOME_VIP;?>, 
            e acima de R$ 50,00 você ganha 30 dias de <?php echo NOME_VIP2;?>.</p>
			<br />
			
		</blockquote>
		<br />
			<table width="517" border="0">
				  <tr>
				    <td width="100"height="20" scope="col" ><p style="color:#222; font-weight:bold;">Valor da Doa&ccedil;&atilde;o</p></td>
				    <td width="100"height="20" scope="col" ><p style="color:#222; font-weight:bold;">Porcentagem</p></td>
				    <td width="100"height="20" scope="col" ><p style="color:#222; font-weight:bold;">Exemplos</p></td>
			      </tr>
				  <tr>
				    <td height="20" ></td>
				    <td height="20" ></td>
				    <td height="20" ></td>
			      </tr>
				  <tr>
				    <td height="20" ><a>&nbsp;R$ 10,00</a> ~ <a>R$ 49,00</a> </td>
				    <td height="20" >+&nbsp;<a>0%</a></td>
				    <td height="20" >&nbsp;10 Reais = <a>1.000 Cash</a></td>
			      </tr>
				  <tr>
				    <td height="20" ><a>&nbsp;R$ 50,00</a> ~ <a>R$ 100,00</a></td>
				    <td height="20" >+&nbsp;<a>25%</a></td>
				    <td height="20" >&nbsp;50 Reais = <a>6.250 Cash</a></td>
			      </tr>
				  <tr>
				    <td height="20" ><a>&nbsp;R$ 100,00</a> ~ <a>R$ 199,00</a></td>
				    <td height="20" >+&nbsp;<a>50%</a> </td>
				    <td height="20" >&nbsp;100 Reais = <a>15.000 Cash</a></td>
			      </tr>
				  <tr>
				    <td height="20" ><a>&nbsp;R$ 200,00</a> ~ <a>R$ 499,00</a></td>
				    <td height="20" >+&nbsp;<a>100%</a> </td>
				    <td height="20" >&nbsp;200 Reais = <a>40.000 Cash</a></td>
			      </tr>
				  <tr>
				    <td height="20" ><a>&nbsp;R$ 500,00</a> ~ <a>R$ 999,00</a></td>
				    <td height="20" >+&nbsp;<a>500%</a> </td>
				    <td height="20" >&nbsp;500 Reais = <a>300.000 Cash</a></td>
			      </tr>	
			  	  <tr>
				    <td height="20" ><a>&nbsp;+ R$ 1000,00</a></td>
				    <td height="20" >+&nbsp;<a>1000%</a> </td>
				    <td height="20" >&nbsp;1000 Reais = <a>1.100.000 Cash</a></td>
			      </tr>
				</p>
		     </table>
			 <br />
			 <br />
		<div id="title_guild">
			<h1> Dados para deposito.</h1>
		</div>
		<hr>
		<br />
		        <table width="517" border="0">
                  <tr>
                    <td width="99" rowspan="6" ><center><img style="width:80px; height:80px;" src="img/pagamentos.png"/></center></td>
                    <td width="90" height="20" >&nbsp;Banco: </td>
                    <td width="110" height="20" ><a>&nbsp;Caixa Economica Federal</a></td>
                  </tr>
                  <tr>
                    <td height="20" >&nbsp;&nbsp;Ag&ecirc;ncia: </td>
                    <td height="20" ><a>&nbsp;&nbsp;0342&nbsp;</a></td>
                  </tr>
                  <tr>
                    <td height="20" >&nbsp;&nbsp;Conta: </td>
                    <td height="20" ><a>&nbsp;&nbsp;00011267-6</a></td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;&nbsp;Opera&ccedil;&atilde;o:</td>
                    <td height="20"><a>&nbsp;&nbsp;013&nbsp;</a></td>
                  </tr>
                  <tr>
                    <td height="20" >&nbsp;&nbsp;Tipo de conta:&nbsp;</td>
                    <td height="20" ><a>&nbsp; Poupan&ccedil;a</a></td>
                  </tr>
                  <tr>
                    <td height="20" >&nbsp;&nbsp;Favorecido: </a></td>
                    <td height="20" ><a>&nbsp;&nbsp;Lucas .S. Lopes</a></td>
                  </tr>
                </table>
</div>
<?php
break;
case "suporte":
?>
<div id="top_guilds">
		<div id="title_guild">
			<h1> Suporte ao jogador </h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Nossa equipe esta pronta para atender sempre que possível, você pode entrar em contato através das opções abaixo.</p>
			<br />
		</blockquote>
		<table>
			<tr>
				<td width="200">Suporte Geral :</td>
				<td width="310"><a> <?php echo SUPORTE_EMAIL;?></a></td>
			</tr>
			<tr>
				<td width="200">Suporte Financeiro :</td>
				<td width="310"><a> <?php echo FINANCEIRO_EMAIL;?></</a></td>
			</tr>
		</table>
</div>	
<?php
break;
case "recuperar_conta":
?>
<div id="top_guilds">
		<div id="title_guild">
			<h1>Recuperar Conta.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
				<p>Digite o E-mail que você usou no cadastro, todas as informações da conta será enviado a este email.</p>
			<br />
		</blockquote>
		<table>
		<form action="?page=recuperar_conta" method="post">
			<tr>
				<td width="180">Digite o Email da conta :</td>
				<td width="200"><a><input style="padding:2px 5px 2px 5px;" type="text"name="email_recupera" placeholder="exemplo@email.com"></a></td>
				<td width="150"><a><input style="padding:2px 5px 2px 5px; cursor:pointer;"type="submit" name="recuperar_conta" value="Recuperar Conta"></a></td>
			</tr>
		</form>
		</table>
		<div id="cadastro_result">
		 <?php if(isset($_POST['recuperar_conta'])){recuperar_conta($_POST['email_recupera']); } ?>
		</div>

</div>	
<?php
break;
case "informacoes_do_servidor":
?>
<div id="top_guilds">
		<div id="title_guild">
			<h1> Informações do Servidor </h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Algumas informações sobre o nosso Servidor de Mu Online.</p>
			<br />
		</blockquote>
				<table>
			<tr>
				<td width="200">Versão</td>
				<td width="310"><a><?php echo VERSAO; ?></a></td>
			</tr>				
			<tr>
				<td width="200">Tipo de Reset</td>
				<td width="200"><a><?php echo TIPO_RESET; ?></a></td>
			</tr>			
			<tr>
				<td width="200">Drop</td>
				<td width="200"><a><?php echo DROPS; ?></a></td>
			</tr>			
			<tr>
				<td width="200">Experiência</td>
				<td width="200"><a><?php echo EXPERIENCE; ?></a></td>
			</tr>
			<tr>
				<td width="200">Maximo de Pontos</td>
				<td width="200"><a><?php echo MAXIMO_PONTOS; ?></a></td>
			</tr>			
			<tr>
				<td width="200">Servidor</td>
				<td width="200"><p style="color:green;">Online</p></td>
			</tr>
			<tr>
				<td width="200">Online Desde</td>
				<td width="200"><p style="color:green;">01/01/2018</p></td>
			</tr>
			<tr>
				<td width="200">Total de Contas</td>
				<td width="200"><a><?php echo total_contas(); ?></a></a></td>
			</tr>
			<tr>
				<td width="200">Total de Character</td>
				<td width="200"><a><?php echo total_char(); ?></a></td>
			</tr>			
			<tr>
				<td width="200">Total de Guilds</td>
				<td width="200"><a><?php echo total_guild(); ?></a></td>
			</tr>
			<?php if(SHOW_ONLINE == TRUE){?>
			<tr>
				<td width="200">Total Online</td>
				<td width="200"><a><?php echo total_online(); ?></a></td>
			</tr>
			<?php } ?>
			<?php if(COMERCIO_SHOW == TRUE){?>
			<tr>
				<td width="200">Comercio de itens FULL</td>
				<td width="200"><a><?php echo COMERCIO_FULL; ?></a></td>
			</tr>
			<?php } ?>
			<tr>
				<td width="200">Level de Reset <?php echo NOME_FREE; ?></td>
				<td width="200"><a><?php echo LEVEL_FREE_RESET; ?></a></td>
			</tr>
			<tr>
				<td width="200">Level de Reset <?php echo NOME_VIP; ?></td>
				<td width="200"><a><?php echo LEVEL_VIP_RESET; ?></a></td>
			</tr>
			<tr>
				<td width="200">Level de Reset <?php echo NOME_VIP2; ?></td>
				<td width="200"><a><?php echo LEVEL_VIP2_RESET; ?></a></td>
			</tr>
		</table>
		<br />
		<div id="title_guild">
			<h1> Comandos do jogo </h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Alguns comandos disponivel dentro do jogo para facilitar a sua vida.</p>
			<br />
		</blockquote>
				<table>
			<tr>
				<td width="200">/post (msg)</td>
				<td width="310"><a>Envia mensagem para todos os Onlines na sala.</a></td>
			</tr>				
			<tr>
				<td width="200">/trade</td>
				<td width="200"><a>Utilizado para troca de itens.</a></td>
			</tr>			
			<tr>
				<td width="200">/duelo</td>
				<td width="200"><a>Envia solicitação para duelar.</a></td>
			</tr>
			<tr>
				<td width="200">/duelend</td>
				<td width="200"><a>Cancela um duelo em andamento.</a></a></td>
			</tr>
			<tr>
				<td width="200">/war (nomedaguild)</td>
				<td width="200"><a>Declara uma guerra entre guilds.</a></td>
			</tr>			
			<tr>
				<td width="200">/party</td>
				<td width="200"><a>Envia solicitação para party.</a></td>
			</tr>
			<tr>
				<td width="200">/bau</td>
				<td width="200"><a>Altera o bau, temos um total de 10 baus extras.</a></td>
			</tr>
			<tr>
				<td width="200">@ (msg)</td>
				<td width="200"><a>Envia mensagem para todos os membros da guild.</a></td>
			</tr>			
			<tr>
				<td width="200">@> (msg)</td>
				<td width="200"><a>Adiciona uma mensagem a guild.</a></td>
			</tr>
			<tr>
				<td width="200">~ (msg)</td>
				<td width="200"><a>Envia mensagem para todos os membros da party</a></td>
			</tr>
			<tr>
				<td width="200">/f 100</td>
				<td width="200"><a>Adiciona 100 pontos em Força.</a></td>
			</tr>
			<tr>
				<td width="200">/a 100</td>
				<td width="200"><a>adiciona 100 pontos em Agilidade.</a></td>
			</tr>
			<tr>
				<td width="200">/v 100</td>
				<td width="200"><a>Adiciona 100 pontos em Vitalidade.</a></td>
			</tr>
			<tr>
				<td width="200">/e 100</td>
				<td width="200"><a>Adiciona 100 pontos em Energia.</a></td>
			</tr>
		</table>
	</div>
<?php
break;
case "criar_conta":
?>
<div id="top_guilds">
		<div id="title_guild">
			<h1> Criar nova Conta </h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Não use Simbolos como @, %,& ou espaço, apenas letras e numeros para preencher o registro abaixo.</p>
			<br />
		</blockquote>
		<div id="nova_conta">
		<table>
		
		<form method="POST" action="?page=criar_conta&nova_conta=true">
			<tr>
				<td width="110"><p>Login :</p></td>
				<td width="160"><input id="loginlogin" onKeyUp="alteraM('loginlogin');" onblur="login_key();" name="login" type="text" maxlength="10"></td>
				<td><p>De 4 a 10 Caracteres , So letras ou Numeros</p></td>
			<tr>
			<tr>
				<td width="80"><p>Nome :</p></td>
				<td width="130"><input name="nome"type="text" maxlength="10"></td>
				<td><p>De 4 a 10 Caracteres</p></td>
			<tr>
			<tr>
				<td width="80"><p>Senha :</p></td>
				<td width="130"><input name="senha" id="senhasenha" onKeyUp="senha_key()" type="password" maxlength="10"></td>
				<td><p>De 4 a 10 Caracteres</p></td>
			<tr>
			<tr>
				<td width="80"><p>Repita Senha :</p></td>
				<td width="130"><input name="rsenha" id="rsenhasenha" onKeyUp="rsenha_key()" type="password" maxlength="10"></td>
				<td><p>Repita a senha usada no campo de cima</p></td>
			<tr>
			<tr>
				<td width="80"><p>E-mail :</p></td>
				<td width="130"><input id="emailemail" onKeyUp="alteraM('emailemail');" onblur="email_key();" name="email" type="email" maxlength="35"></td>
				<td><p>Use um email valido, muito importante!</p></td>
			<tr>
			<tr>
				<td width="80"><p>Pergunta Secreta :</p></td>
				<td width="130"><input name="pergunta" type="text" maxlength="10"></td>
				<td><p>Uma palavra, Muito importante</p></td>
			<tr>
			<tr>
				<td width="80"><p>Resposta Secreta :</p></td>
				<td width="130"><input name="resposta" type="text" maxlength="10"></td>
				<td><p>Uma palavra, Muito importante</p></td>
			<tr>
			<tr>
				<td width="80"><p></p></td>
				<td width="130"><input name="novo_registro" id="button"type="submit" value="Criar sua Conta"></td>
				<td><p></p></td>
			<tr>
		</form>
		
		</table>
		</div>
		<div id="cadastro_result">
		 <?php if(isset($_GET['nova_conta']) && isset($_POST['novo_registro'])){
			 cadastrar_conta($_POST['login'],$_POST['nome'],$_POST['senha'],$_POST['rsenha'],$_POST['email'],$_POST['pergunta'],$_POST['resposta']);
			 } ?>
		</div>
</div>
<?php
break;
case "baixa_muonline": //inicio dwonload
?>
<div id="top_guilds">
		<div id="title_guild">
			<h1> Baixar MU </h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Opções de download do cliente do Mu Yes, ao baixar click no executavel para fazer a instalação, depois basta criar uma conta/registro em nosso site para logar no servidor, o servidor e gratis, você não paga para jogar!</p>
			<br />
		</blockquote>
		        
                  <h1>Downloads</h1>
                    <div class='quadros'>
                        <table border='0' width='100%'>
                          <tr>
                           <td colspan='3' align='center'><strong><font color='#FE2626'>Arquivos do Jogo</font></strong></td>
                          </tr>
                          <tr>
                           <td width="150" align='center' bgcolor='#FAFAFA'><strong>Nome</strong></td>
                           <td align='center' bgcolor='#FAFAFA'><strong>Tamanho</strong></td>
                           <td align='center' bgcolor='#FAFAFA'><strong>Descrição</strong></td>
                          </tr>
                          <tr>
                           <td align='center'><a target="_blank" href='<?php echo CLIENTE_FULL; ?>'><strong>Click para Baixar</strong></a></td>
                           <td align='center'><?php echo CLIENTE_FULL_SIZE; ?></td>
                           <td align='center'><?php echo CLIENTE_DESCRITION;?></td>
                          </tr>
						   <tr>
                           <td align='center'><a target="_blank" href='<?php echo CLIENTE_FULL1; ?>'><strong>Click para Baixar</strong></a></td>
                           <td align='center'><?php echo CLIENTE_FULL_SIZE1; ?></td>
                           <td align='center'><?php echo CLIENTE_DESCRITION1;?></td>
                          </tr>
                          <tr>
                           <td align='center' ><a target="_blank" href='<?php echo CLIENTE_PATCH; ?>'><strong>Click para Baixar</strong></a></td>
                           <td align='center' ><?php echo CLIENTE_PATCH_SIZE; ?></td>
                           <td align='center' ><?php echo CLIENTE_P_DESCRITION; ?></td>
                          </tr>
                        </table>
                     </div>
                     <div class='quadros'>
					 <BR />
                        <table border='0' width='100%'>
                          <tr>
                           <td align='center'><strong><font color='#FE2626'>Configurações Requeridas</font></strong></td>
                          </tr>
                          <tr>
                           <td align='center'>
                             <table width='100%'>
                              <tr>
                               <td align='center' bgcolor='#FAFAFA'><strong>Tipo</strong></td>
                               <td align='center' bgcolor='#FAFAFA'><strong>Minimo Requirido</strong></td>
                               <td align='center' bgcolor='#FAFAFA'><strong>Recomendado</strong></td>
                              </tr>
                              <tr>
                               <td align='center'>Processador</td>
                               <td align='center'>Pentium II - 300 mhz</td>
                               <td align='center'>Pentium III - 1000 mhz ou superior</td>
                              </tr>
                              <tr>
                               <td align='center'>Memória</td>
                               <td align='center'>128 MB</td>
                               <td align='center'>512 MB ou superior</td>
                              </tr>
                              <tr>
                               <td align='center'>Placa de Video</td>
                               <td align='center'>16 MB</td>
                               <td align='center'>64 MB ou superior</td>
                              </tr>
                             </table> 
<br />	<br />						 
                           </td>
                          </tr>
                        </table>
                     </div>
                     <div class='quadros'>
				
                        <table border='0' width='100%'>
                          <tr>
                           <td align='center'><strong><font color='#FE2626'>Utilitários</font></strong></td>
                          </tr>
                          <tr>
                           <td align='center'>
                             <table width='100%'>
                              <tr>
                               <td width="100"align='center' bgcolor='#FAFAFA'><strong>Programa</strong></td>
                               <td align='center' bgcolor='#FAFAFA'><strong>Descrição</strong></td>
                              </tr>
                              <tr>
                               <td align='center' ><a href='http://baixaki.ig.com.br/download/DirectX.htm' target='_blank'>DirectX 9.0c</a></td>
                               <td align='center' >Os Drivers do DirectX são pré-requisitos obrigatórios para quem tem ou pretende ter games no PC.</td>
                              </tr>
                              <tr>
                               <td align='center' ><a href='http://baixaki.ig.com.br/download/Spybot-Search-Destroy.htm' target='_blank'>Spybot</a></td>
                               <td align='center' >Remova programas espiões que você nem imagina existirem no seu computador.</td>
                              </tr>
                              <tr>
                               <td align='center' ><a href='http://baixaki.ig.com.br/download/AVG-Anti-Virus-Free.htm' target='_blank'>AVG</a></td>
                               <td align='center' >Excelente antivírus grátis, com atualizações via web e tudo mais!</td>
                              </tr>
							  
                             </table> 
<br /><br />							 
                           </td>
                          </tr>
                        </table>
                     </div>
                     <div class='quadros'>
				
                        <table border='0' width='100%'>
                          <tr>
                           <td align='center'><strong><font color='#FE2626'>Drivers de Vídeo</font></strong></td>
                          </tr>
                          <tr>
                           <td align='center'>
                             <a href='http://www.voodoofiles.com/type.asp?cat_id=0' target='_blank'><img src='img/drivers/download_3dfx.gif' border='0' style='border:0px; width:71px !important; height:52px !important;' /></a>
                             <a href='http://mirror.ati.com/support/driver.html' target='_blank'><img src='img/drivers/download_ati.gif' border='0' style='border:0px; width:71px !important; height:52px !important;' /></a>
                             <a href='http://downloadcenter.intel.com/?lang=por' target='_blank'><img src='img/drivers/download_intel.gif' border='0' style='border:0px;width:71px !important; height:52px !important;' /></a>
                             <a href='http://www.matrox.com/mga/support/drivers/' target='_blank'><img src='img/drivers/download_matrox.gif' border='0' style='border:0px;width:71px !important; height:52px !important;' /></a>
                             <a href='http://www.nvidia.com.br/page/drivers.html' target='_blank'><img src='img/drivers/download_nvidia.gif' border='0' style='border:0px;width:71px !important; height:52px !important;' /></a>
                           </td>
                          </tr>
                        </table>
						<br />
                     </div>
                
			</div>
<?php
break; // fim download
case "top_tempo":
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?> Onlines.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Ranking de quem passa mais tempo online no server.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Horas/Minutos</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php
					
					$tempo = query("SELECT TOP ".Q_TOP_50." TempoOnline, memb___id FROM MuOnline.dbo.MEMB_INFO ORDER BY TempoOnline DESC");
					$c = 1;
					while($tempo2 = mssql_fetch_assoc($tempo)){
						$i = mssql_fetch_array(query("SELECT TOP 1 * FROM Character WHERE AccountID = '$tempo2[memb___id]' ORDER BY Resets DESC"));
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$i['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($i['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".tempo_online($tempo2[TempoOnline])."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($i['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;
case "top_melhores_guilds": //INICIO RANKING DE GUILD
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo G_TOP_50; ?> melhores Guilds</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Apenas as melhores Guilds aparecem aqui, Estas são as guilds que mais conseguem Score em suas Batalhas.</p>
			<br />
		</blockquote>
		<table style="margin-bottom:6px;margin-top:6px; color:#444; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="100"><center>Bandeira</center></td>
				<td width="100"><center>Guild Nome</center></td>
				<td width="100"><center>Guild Master</center></td>
				<td width="150"><center>Score</center></td>
				
			</tr>
		</table>
		<table>
		<?php 
			$guild = query("SELECT TOP ".G_TOP_50." * FROM Guild ORDER BY G_Score DESC");
			$c = 0;
			while($g_guild = mssql_fetch_assoc($guild)){
				$c++;
				$logo = urlencode(bin2hex($g_guild['G_Mark']));
				echo "
						<tr>
							<td width=\"50\"><center>".img_top($c)."</center></td>
							<td width=\"100\"><center><img src=\"modules/sis/decode.php?decode=$logo\"></center></td>
							<td width=\"100\"><center><a href=\"\">".$g_guild['G_Name']."</a></center></td>
							<td width=\"100\"><center><a href=\"\">".$g_guild['G_Master']."</a></center></td>
							<td width=\"150\"><center>".$g_guild['G_Score']."</center></td>
						</tr>
					";
		} ?>
		</table>
	</div>
<?php
break; //FIM RANKING DE GUILD
case "top_reset_diario":
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?> mais rapidos do dia.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Aqui estão os mais rapidos em reset durante todo o dia, o ranking e zerado todos os dias as 00:00</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character ORDER BY ".RESETS_DAY." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS_DAY]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break; // FIM DO RESETS DIAIO
case "top_reset_semanal":
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?> mais rapidos da semana.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Aqui estão os mais rapidos em resets durante a semana, o ranking e zerado todo os domigos as 00:00</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character ORDER BY ".RESETS_WEEK." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS_WEEK]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;// FIM TOP RESET SEMANAL
case "top_reset_mensal": // INICIO TOP RESET MENSAL
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?> mais rapidos do Mês.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Aqui estão os mais rapidos durante o mês, o ranking e zerado todo dia primeiro de cada mês.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character ORDER BY ".RESETS_MONTH." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS_MONTH]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;// FIM TOP RESET MENSAL
case "top_reset_bladeknight"://INICIO TOP BK
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?>, Blade Knight.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Top Blade Knight com mais resets no servidor.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character WHERE Class = 16 OR Class = 17 ORDER BY ".RESETS." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;//FIM DO TOP SM
case "top_reset_soulmaster":
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?>, Soul Master.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Top Soul Master com mais resets no servidor.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character WHERE Class = 0 OR Class = 1 ORDER BY ".RESETS." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;//FIM DO TOP SM
case "top_reset_magicgladiator":
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?>, Magic Gladiator.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Top Magic Gladiator com mais resets no servidor.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character WHERE Class = 48 ORDER BY ".RESETS." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;//FIM DO TOP MG
case "top_reset_muse_elf":
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?>, Muse Elf.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Top Muse Elf com mais resets no servidor.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character WHERE Class = 32 OR Class = 33 ORDER BY ".RESETS." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break;//FIM DO TOP Elf
case "top_reset_darklord": // INICO TOP DL
?>
	<div id="top_guilds">
		<div id="title_guild">
			<h1> Top <?php echo Q_TOP_50; ?>, Dark Lord.</h1>
		</div>
		<hr>
		<blockquote>
			<br />
			<p>Top Dark Lord com mais resets no servidor.</p>
			<br />
		</blockquote>
					<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
			<tr style="margin-bottom:10px; ">
				<td width="50"><center>Posição</center></td>
				<td width="150"><center>Nome</center></td>
				<td width="150"><center>Classe</center></td>
				<td width="150"><center>Resets</center></td>
				<td width="100"><center>Online</center></td>
				
			</tr>
		</table>
				<table style="margin-bottom:6px;margin-top:6px; color:#222; font-weight:bold;">
				<?php 
					$resets2 = query("SELECT TOP ".Q_TOP_50." * FROM Character WHERE Class = 64 ORDER BY ".RESETS." DESC");
					$c = 1;
					while($resets = mssql_fetch_assoc($resets2)){
						
						echo "
								<tr id=\"rr_\">
									<td width=\"50\" height=\"18\"><p><center>".img_top($c)."</center></p></td>
									<td width=\"150\" height=\"18\"><center><a href=\"\">".$resets['Name']."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".v_class($resets['Name'])."</center></a></td>
									<td width=\"150\" height=\"18\"><center>".$resets[RESETS]."</center></td>
									<td width=\"100\" height=\"18\"><center>".v_char_logado($resets['AccountID'])."</center></td>
								</tr>
							";
							$c++;
				} ?>
				</table>
	</div>
<?php
break; // FIM TOP DL
	} //fim do switch
?>
</div>
<div id="rodape">
<center> <p>Copyright © 2018 MU YES - Todos os Direitos Reservados <br /> Developed by: LucasHz <br /> Version 1.0.0 </p></center>

<script type="text/javascript">
 //<!--
 $(document).ready(function() {$(".box-curtir-flutuante").hover(function() {$(this).stop().animate({right: "0"}, "medium");}, function() {$(this).stop().animate({right: "-250"}, "medium");}, 500);});
 //-->
 </script><br />
 <style type="text/css">
 .box-curtir-flutuante{background: url("https://lh6.googleusercontent.com/-ifgDqZQMUCs/TzrA46yEwyI/AAAAAAAACh0/krzLEdM-rXA/s150/Face.jpg") no-repeat scroll left center transparent !important;display: block;float: right;height: 270px;padding: 0 5px 0 46px;width: 245px;z-index: 99999;position:fixed;right:-250px;top:20%;}
 .box-curtir-flutuante div{border:none;position:relative;display:block;}
 .box-curtir-flutuante span{bottom: 12px;font: 8px "lucida grande",tahoma,verdana,arial,sans-serif;position: absolute;right: 6px;text-align: right;z-index: 99999;}
 .box-curtir-flutuante span a{color: #808080;text-decoration:none;}
 .box-curtir-flutuante span a:hover{text-decoration:underline;}
 </style><div class="box-curtir-flutuante" style=""><div> <iframe src="http://www.facebook.com/plugins/likebox.php?href=www.facebook.com/muyes.net/&width=245&colorscheme=light&show_faces=true&connections=9&stream=false&header=false&height=270" scrolling="no" frameborder="0" scrolling="no" style="border: medium none; overflow: hidden; height: 270px; width: 245px;background:#fff;"></iframe></div></div>

</div>
</div>
</div>
</body>
</html>