function id(id){
	return document.getElementById(id);
}

function alteraM(campoid){
	var valor = document.getElementById(campoid);
	valor.onkeyup = function(){
		var novoTexto = valor.value.toLowerCase();
		valor.value = novoTexto;
	}
}
	
function nav_rank(nav){
	if(nav == "reset_total"){
		id(nav).style.display = "block";
		id("title_ranking").innerHTML = "Melhores em Resets";
		id("reset_week").style.display = "none";
		id("reset_month").style.display = "none";
		id("reset_day").style.display = "none";
	}else if(nav == "reset_week"){
		id(nav).style.display = "block";
		id("title_ranking").innerHTML = "Melhores da Semana";
		id("reset_total").style.display = "none";
		id("reset_month").style.display = "none";
		id("reset_day").style.display = "none";
	}else if(nav == "reset_month"){
		id(nav).style.display = "block";
		id("title_ranking").innerHTML = "Melhores do Mês";
		id("reset_week").style.display = "none";
		id("reset_total").style.display = "none";
		id("reset_day").style.display = "none";
	}else if(nav == "reset_day"){
		id(nav).style.display = "block";
		id("title_ranking").innerHTML = "Melhores do Dia";
		id("reset_week").style.display = "none";
		id("reset_month").style.display = "none";
		id("reset_total").style.display = "none";
		
	}
}

// VERIFICAÇÃO DE EMAIL E LOGIN QUANDO ESTIVER PREENCHENDO

function v_login(login){
	var hr 	= new XMLHttpRequest();
	var url = "modules/sis/registro.php";
	var vars = "verificar_login=true&v_login="+login;
	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {	
		if(hr.readyState == 4 && hr.status == 200){
			var resultado = hr.responseText;
			if(resultado == "TRUE"){
			document.getElementById('loginlogin').style.borderColor = '#ff0000';
			}else{
			document.getElementById('loginlogin').style.borderColor = '#3c8a3c';	
			}
			//console.log(resultado);	
		}
	}
	hr.send(vars);
}

//CHAMAR A FUNÇÃO DE VERIFICAÇÃO
function login_key(){
	var login = id("loginlogin");
	
	//login.onkeyup = function(){
		if(login.value == null || login.value == ""|| login.value == " "){
		document.getElementById('loginlogin').style.borderColor = '#ff0000';
		}else{
			v_login(login.value);
		}
	//}
}

// VERIFICAÇÃO DE EMAIL QUANDO ESTIVER PREENCHENDO

function v_email(email){
	var hr 	= new XMLHttpRequest();
	var url = "modules/sis/registro.php";
	var vars = "verificar_email=true&v_email="+email;
	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {	
		if(hr.readyState == 4 && hr.status == 200){
			var resultado = hr.responseText;
			if(resultado == "TRUE"){
			document.getElementById('emailemail').style.borderColor = '#ff0000';
			}else{
			document.getElementById('emailemail').style.borderColor = '#3c8a3c';	
			}
			//console.log(resultado);	
		}
	}
	hr.send(vars);
}

//CHAMAR A FUNÇÃO DE VERIFICAÇÃO
function email_key(){
	var email = id("emailemail");
	
	//email.onkeyup = function(){
		if(email.value == null || email.value == ""|| email.value == " "){
		document.getElementById('emailemail').style.borderColor = '#ff0000';	
		}else{
			v_email(email.value);
		}
	//}
}

//verificar senha esta igual
function senha_key(){
	var senha = id("senhasenha");
	senha.onkeyup = function(){
		if(senha.value == null || senha.value == ""|| senha.value == " "){	
			document.getElementById('senhasenha').style.borderColor = '#ff0000';		
		}else{
			document.getElementById('senhasenha').style.borderColor = '#3c8a3c';
		}
	}

}
function rsenha_key(){
	var senha = id("senhasenha");
	var rsenha = id("rsenhasenha");
	
	rsenha.onkeyup = function(){
		
		if(rsenha.value == null || rsenha.value == ""|| rsenha.value == " "){	
			document.getElementById('rsenhasenha').style.borderColor = '#ff0000';		
		}else if(senha.value === rsenha.value){
			document.getElementById('rsenhasenha').style.borderColor = '#3c8a3c';
		}else{
			document.getElementById('rsenhasenha').style.borderColor = '#ff0000';	
		}
	}
}

























