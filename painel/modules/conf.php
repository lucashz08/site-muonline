<?php
/**************************************************************************************/
/** Painel de controle versão 1.0.0     by: LucasHz      SKYPE: lucass.lopes0893     **/
/**************************************************************************************/


//////////////////////////////////////////////////////////////////////////
// INFORMAÇÕES DA PAGINA

define("TITLE", "MU YES - Painel de controle."); 		// Title da pagina.
define("DESCRIPTION", "Painel de controle Mu Yes Server"); 		// Descrição da pagina.
define("KEYWORDS", "painel, mu, muonline, muyes"); 		// Palavras chaves da pagina separadas por virgulas
define("URL_PAINEL", "http://muyes.net/painel");		// URL da onde o painel esta instalado
define("URL_WEB", "http://muyes.net");		// URL da onde o painel esta instalado

//////////////////////////////////////////////////////////////////////////
// INFORMAÇÕES MSSQL

define("HOST", "localhost"); 		// IP da connecxao MSSQL padrão 127.0.0.1            
define("HOST_USUARIO", "sa");		// usuario do banco de dados MSSQL
define("HOST_PASS", "senha");		// Senha do banco de dados MSSQL
define("HOST_DATABASE", "MuOnline");	// Nome da Database da connecxao

define("PROTECAO_NOB", FALSE);		// DESATIVAR A PROTEÇÃO DA WEB CONTRA INJECT? DEIXE TRUE CASO VOCE SEJA UM IDIOTA

//////////////////////////////////////////////////////////////////////////
//CONFIGURAÇÕES DE RESET

define("RESET_FREE", 400);      // LEVEL DE RESET FREE
define("RESET_VIP", 350);		// LEVEL DE RESET VIP 1
define("RESET_VIP2", 320);		// LEVEL DE RESET VIP 2

//////////////////////////////////////////////////////////////////////////
// ZEN REQUERIDO

define("RESET_ZEN", 300000);      // DESCONTAR ZEN RESET FREE
define("RESET_ZEN_VIP", 200000);		// DESCONTAR ZEN RESET VIP 1
define("RESET_ZEN_VIP2", 100000);		// DESCONTAR ZEN RESET VIP 2



//////////////////////////////////////////////////////////////////////////
// NOMES DAS TABELAS

define("RESETS", "Resets"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS
define("RESETS_DAY", "ResetsDay"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS DIARIO
define("RESETS_WEEK", "ResetsWeek"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS SEMANAL
define("RESETS_MONTH", "ResetsMonth"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS MENSAL

define("RANKING_VIP", FALSE);		// ATIVAR RANKING DE RESET PARA CADA TIPO DE VIP, TRUE OU FALSE

define("RESETS_WEEK_FREE", "ResetsWeekFree"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS WEEK FREE
define("RESETS_WEEK_VIP", "ResetsWeekVip"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS WEEK VIP 1
define("RESETS_WEEK_VIP2", "ResetsWeekVip2"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS WEEK VIP 2

define("RESETS_MONTH_FREE", "ResetsMonthFree"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS MONTH FREE
define("RESETS_MONTH_VIP", "ResetsMonthVip"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS MONTH VIP 1
define("RESETS_MONTH_VIP2", "ResetsMonthVip2"); 		//NOME DA TABELA QUE GUARDA A CONTIDADE DE RESETS MONTH VIP 2

define("TABELA_CASH", "Cash");		// TABELA ONDE FICA OS CASH NA MEMB_INFO

//////////////////////////////////////////////////////////////////////////
// NOMES DOS STATUS

define("NOME_FREE",	"Free");			// NOME DO PLANO DE VIP 1
define("NOME_VIP", "Vip Simples");		// NOME DO PLANO DE VIP 1
define("NOME_VIP2",	"Vip Plus");		// NOME DO PLANO DE VIP 2

//////////////////////////////////////////////////////////////////////////
// MAXIMO DE PONTOS 32700 OU 65500

define("MAX_PONTOS", 65535);      	// MAXIMO DE PONTOS

define("LEVEL_MAX",	400);		  	// LEVEL MAXIMO DO SERVIDOR
define("PONTOS_LEVEL", 10);		 	// QUANTOS PONTOS GANHA POR LEVEL, PARA O CALCULO DO DESBUGADO


//////////////////////////////////////////////////////////////////////////
// LIMPAR PK/HERO

define("MIN_PRECO", 100000);	// PRECO MINIMO PARA USAR A OPÇÃO
define("PRECO_PK", 100); 		// MULTIPLICA A QUANTIDADE DA TABELA PKTIME E SOMA COM O PRECO MINIMO


//////////////////////////////////////////////////////////////////////////
// ATIVAR MISSOES DE RESETS

define("MISSAO_RESET", TRUE); // ADICIONA RESETS DE CADA CLASSE NA TABELA HZ_RESETS

//////////////////////////////////////////////////////////////////////////
// ATIVAR MISSOES DE RESETS

define("CLASS_CASH", 50); // CASH COBRADO PARA TROCAR DE CLASSE































?>