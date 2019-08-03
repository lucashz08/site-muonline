<?php
function Connect(){
	$connect = @mssql_connect(HOST, HOST_USUARIO, HOST_PASS, HOST_DATABASE);
	$connect_db = @mssql_select_db(HOST_DATABASE, $connect);
	
	if($connect && $connect_db){
		return $connect;
	}else{
		echo "Nao foi possivel connectar ao banco de dados MSSQL";
	}
}
?>