<?php
namespace controllers{
	class Categoria{
		//Atributo para banco de dados
		private $PDO;

		/*
		__construct
		Conectando ao banco de dados
		*/
		function __construct(){
			$this->PDO = new \PDO('mysql:host=us-cdbr-iron-east-04.cleardb.net;dbname=heroku_a240fb0bf187ac6; charset=UTF8', 'b6bd418f4f2cf7', 'f7c43c31'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
		}
		public function lista(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM heroku_a240fb0bf187ac6.categoria;");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
		public function get($id){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM heroku_a240fb0bf187ac6.ingredientes WHERE idCategoria = :id");
			$sth ->bindValue(':id',$id);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $app->render('default.php',["data"=>$result],200);
        }


	}
}