<?php
class LeiturasDao{
		//Atributo para banco de dados
		private $PDO;

		/*
		__construct
		Conectando ao banco de dados
		*/
		function __construct(){
			$this->PDO = new \PDO('mysql:host=localhost;dbname=teste', 'root', 'root'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
		}
		/*
		lista
		Listand pessoas
		*/
		public function get($cond, $tipo){
			
			$sth = $this->PDO->prepare("SELECT * FROM tab_leituras WHERE id_cond=:cond_id AND tipo=:tipo");
			$sth->bindValue(':cond_id', $cond);
			$sth->bindValue(':tipo', $tipo);

			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);

			return $result; 
        }
}
        
?>