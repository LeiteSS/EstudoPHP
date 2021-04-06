<?php
class Database
{
	#variavel para o nome do banco
	private static $dbName = 'tutorial';
	#variavel para host onde o banco se encontra
	private static $dbHost = 'localhost';
	#variavel para o nome do usuario do banco
	private static $dbUsername = 'root';
	#variavel para a senha do usuario
	private static $dbUserPassword = 'root';
	
	#será construido o objeto PDO (PHP Data Objects) para esse cara
	#a classe PDO é um singleton (solteirão) *rever o que é singleton*
	private static $cont = null;
	
	#Construtor da classe Database
	public function __construct() {
		die('Init function is not allowed');
	}
	
	#A principal função da classe 
	#detalhe: é usado o padrão singleton para garantir que um PDO exista em toda aplicação 
	public static function connect()
	{
		#Uma conexão para toda a aplicação
		if ( null == self::$cont )
		{
				try
				{
					self::$cont = new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
				}
				catch(PDOException $e)
				{
					die($e->getMessage());
				}
		}
		return self::$cont;
	}
	
	#Fecha a conexão com o banco
	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>