<?php
include_once "../conf.php";
include_once "function.php";
if($_POST['verificar_login'] && $_POST['v_login']){
	if(verificar_login($_POST['v_login'])){echo "TRUE";}else{echo "FALSE";}
	
}elseif($_POST['verificar_email'] && $_POST['v_email']){
	if(verificar_email($_POST['v_email'])){echo "TRUE";}else{echo "FALSE";}
}else{
	echo "x:x Erro x:x";
}

?>