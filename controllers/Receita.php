<?php
namespace controllers{
	class Receita{
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
		/*
		lista
		Listand imoveis
		*/
		public function lista(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM heroku_a240fb0bf187ac6.receitas order by NomeReceita;");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
		/*
		get
		Pega receita pelo id
		*/
		public function get($id){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM heroku_a240fb0bf187ac6.receitas WHERE idReceita = :id");
			$sth ->bindValue(':id',$id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
        /*
        get
        Pega receita pelo ids dos ingredientes
        */
        public function getReceitaIngrediente($ids){
            global $app;
            $valida = true;
            $ids_l = "" ;
            foreach ($ids as $value) {
                if($valida){
                    $valida = false;
                    $ids_l = $value;
                }else{
                    $ids_l = $ids_l . "," . $value;
                }
            }
            $sth = $this->PDO->prepare("Select distinct  r.idReceita,r.NomeReceita,r.Imagem,r.Imagem from heroku_a240fb0bf187ac6.receitas r Inner Join heroku_a240fb0bf187ac6.receitaingrediente ri on r.idReceita = ri.idReceita where ri.idIngrediente IN ($ids_l)");


            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $app->render('default.php',["data"=>$result],200);
        }


	}
}