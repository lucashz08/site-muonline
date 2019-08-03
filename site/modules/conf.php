<?php
/**************************************************************************************/
/** WEB MU VERSÃO 1.0.0     BY: LucasHz    				  SKYPE: lucass.lopes0893    **/
/**************************************************************************************/
//////////////////////////////////////////////////////////////////////////
// INFORMAÇÕES DA PAGINA

define("TITLE", "MU YES - Versao 1.1e, Servidor de MU Online 24horas Online!"); 		// TITULO DA PAGINA.
define("DESCRIPTION", "Servidor de MU Versao 1.01e com itens classicos, crie sua conta agora mesmo e comece a jogar agora a melhor versao de MU Online, faça missoes e ganhe muitos premios!"); 		// DESCRIÇAO DA PAGINA.
define("KEYWORDS", "painel, mu, muonline, muyes, mu online, mu, server, 1.1e, season 2, MU, Online, 1.01e, 1.1e season 2"); 		// PALAVRAS CHAVES DA PAGINA SEPARADAS POR VIRGULAS .
define("URL_SITE", "http://muyes.net");				// URL ONDE A WEB ESTA INSTALADA
define("URL_PAINEL", "http://muyes.net/painel");	// URL ONDE O PAINEL DE CONTROLE ESTA INSTALADO
define("URL_SHOP", "http://muyes.net/shop");		// URL ONDE O SHOPPING ESTA INSTALADO

define("BANNER_AVISO",false); // MOSTRAR O BANNER DE AVISO ?

//////////////////////////////////////////////////////////////////////////
// INFORMAÇÕES MSSQL

define("HOST", "localhost");		// IP DA CONECXAO MSSQL PADRAO 127.0.0.1            
define("HOST_USUARIO", "sa");		// USUARIO DO BANCO DE DADOS MSSQL
define("HOST_PASS", "senha");	// SENHA DO BANCO DE DADOS MSSQL
define("HOST_DATABASE", "MuOnline");// NOME DA DATABASE DA CONECXAO

define("PROTECAO_NOB", true);		// DESATIVAR A PROTEÇÃO DA WEB CONTRA INJECT? DEIXE TRUE CASO VOCE SEJA UM IDIOTA

//////////////////////////////////////////////////////////////////////////
// DEFINIÇÕES SMTP DE EMAIL

define("SMTP_ASSUNTO", "MU YES"); 	// SMTP ASSUNTO
define("SMTP_HOST", "mail.mutitans.com.br");    // SMTP
define("SMTP_EMAIL", "email@mutitans.com.br");  // E-MAIL
define("SMTP_EMAIL2", "email@muyes.net");  // E-MAIL QUE IRA APARECE COMO SE TIVE-SE SIDO ENVIADO.
define("SMTP_EMAIL_SENHA", "senha");      // SENHA DO E-MAIL

//////////////////////////////////////////////////////////////////////////
// SISTEMA DE REFERENCIA

define("REFERENCIA_ATIVO", true);	// SISTEMA DE REFERENCIA ESTA ATIVO, TRUE OU FALSE
define("REF_IDIOMA", false);			// LIMITAR PARA APENAS UM IDIOMA
define("REF_PT", "pt");				// ESCOLHA O EXMPLO, en,pt,es
define("REF_CASH", 2);				// TOTAL DE CASH A GANHAR POR REFERENCIA

//////////////////////////////////////////////////////////////////////////
// INFORMAÇÕES DO SERVIDOR

define("VERSAO", "1.01e");				// VERSÃO DO SERVIDOR
define("TIPO_RESET", "Acumulativo");	// TIPO DE RESET
define("DROPS", "30%");					// DROPES DO SERVIDOR
define("EXPERIENCE", "3000x");			// EXPERIENCIA DO SERVER
define("MAXIMO_PONTOS",	"65500");		// MAXIMO DE PONTOS EM STATUS
define("SHOW_ONLINE", false);			// MOSTRAR TOTAL ONLINE ? TRUE OU FALSE

define("COMERCIO_SHOW", false);			// MOSTRAR ESTATUS DO COMERCIO ? TRUE OU FALSE
define("COMERCIO_FULL", "Liberado");	// STATUS DO COMEMERCIO DE ITENS FULL NO SERVER

define("NOME_FREE",	"Free");			// NOME DO PLANO DE VIP 1
define("NOME_VIP",	"Vip Simples");		// NOME DO PLANO DE VIP 1
define("NOME_VIP2",	"Vip Plus");		// NOME DO PLANO DE VIP 2

define("LEVEL_FREE_RESET", 400);		// LEVEL DE RESET FREE
define("LEVEL_VIP_RESET", 350);			// LEVEL DE RESET VIP
define("LEVEL_VIP2_RESET", 320);		// LEVEL DE RESET VIP2

//////////////////////////////////////////////////////////////////////////
// INFORMAÇÕES DE SUPORTE

define("SUPORTE_EMAIL", 	"muyes.email@gmail.com"	);		// EMAIL DE SUPORTE GERAL
define("FINANCEIRO_EMAIL", 	"muyes.email@gmail.com" );		// EMAIL DE SUPORTE FINANCEIRO

//////////////////////////////////////////////////////////////////////////
// TOP RANKING RESULTADOS

define("Q_TOP", 10);		// TOTAL DE RESULTADOS DO TOP RANKING RESETS DA PAGINA INICIAL
define("G_TOP", 20);		// TOTAL DE RESULTADOS DO TOP GUILD DA PAGINA INICIAL

define("Q_TOP_50", 50);		// TOTAL DE RESULTADOS DO TOP RANKING RESETS DE RESETS
define("G_TOP_50", 20);		// TOTAL DE RESULTADOS DO TOP GUILD DA PAGINA MELHORES GUILDS

//////////////////////////////////////////////////////////////////////////
// NOMES DAS TABELAS

define("RESETS", "Resets"); 			//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS
define("RESETS_DAY", "resetsDay"); 		//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS DIARIO
define("RESETS_WEEK", "ResetsWeek"); 	//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS SEMANAL
define("RESETS_MONTH", "ResetsMonth"); 	//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS MENSAL

define("RANKING_VIP", FALSE);			// ATIVAR RANKING PARA CADA TIPO DE VIP, TRUE OU FALSE

define("RESETS_WEEK_FREE", "ResetsWeekFree"); 		//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS WEEK FREE
define("RESETS_WEEK_VIP", "ResetsWeekVip"); 		//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS WEEK VIP 1
define("RESETS_WEEK_VIP2", "ResetsWeekVip2"); 		//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS WEEK VIP 2

define("RESETS_MONTH_FREE", "ResetsMonthFree"); 	//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS MONTH FREE
define("RESETS_MONTH_VIP", "ResetsMonthVip"); 		//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS MONTH VIP 1
define("RESETS_MONTH_VIP2", "ResetsMonthVip2"); 	//NOME DA TABELA QUE GUARDA A QUANTIDADE DE RESETS MONTH VIP 2


//////////////////////////////////////////////////////////////////////////
// CADASTRO

define("VI_CURR_INFO", TRUE);	// SERVIDOR USA A TABELA VI_CURR_INFO? TRUE OU FALSE
define("MIN_LOGIN", TRUE);		// TRANSFORMAR LOGIN EM MINUSCULAS
define("MIN_EMAIL", TRUE);		// TRANSFORMAR EMAIL EM MINUSCULAS

//////////////////////////////////////////////////////////////////////////
// LINK DE DOWNLOAD

define("CLIENTE_FULL", "https://mega.nz/#!BNNixKJC!vAEaKCgOE3wKSbRDUHiP-0u7JS95H3wyljFnQ9ZbKJ0");		// LINK DE DOWNLOAD DO CLIENTE FULL
define("CLIENTE_FULL_SIZE", "70MB");		// TAMANHO DO CLIENTE FULL
define("CLIENTE_DESCRITION", "Instalador do jogo em português.");		// DESCRIÇÃO DO CLIENTE FULL

define("CLIENTE_FULL1", "https://mega.nz/#!wNtFWIhS!pdVaoaW6_KRYY3hVqbUF8ZyPQW_T1SlWnGz5OpZnf2Y");		// LINK DE DOWNLOAD DO CLIENTE FULL
define("CLIENTE_FULL_SIZE1", "70MB");		// TAMANHO DO CLIENTE FULL
define("CLIENTE_DESCRITION1", "Instalador do jogo em Inglês.");		// DESCRIÇÃO DO CLIENTE FULL

define("CLIENTE_PATCH", "https://mega.nz/#!MdUxUAgC!xltpWlqcuOwz1xtMVXNmmy1M7yUnJ8BpAhrY62dyNks");		// LINK DE DOWNLOAD DO PATCH DO CLIENTE
define("CLIENTE_PATCH_SIZE", "1 MB");		// TAMANHO DO PATCH DO CLIENTE
define("CLIENTE_P_DESCRITION", 	"Auto Click f2 ativa f3 desativa.");		// DESCRIÇÃO DO PATCH
?>