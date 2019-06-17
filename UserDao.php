<?php
class UserDao{
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
		public function lista(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM pessoa");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
        }

        public function get($email){
            $sth = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
			$sth->bindValue(':email', $email);
			$sth->execute();
            $result = $sth->fetch();
            return $result;
		}
		public function save($email, $senha){
			$sth = $this->PDO->prepare("INSERT INTO users (senha, email) VALUES ( :senha, :email)");
			$sth->bindValue(':email', $email);
			$sth->bindValue(':senha', $senha);
			$sth->execute();
            //return $result;
		}
}
        
?>