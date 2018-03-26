<?php

class Usuario{
    private $id;
    private $login;
    private $senha;
    private $dtcadastro;

    public function __construct($login="", $pass=""){
        $this->setLogin($login);
        $this->setSenha($pass);
    }

    public function getid()
    {
        return $this->id;
    }

    public function setid($id)
    {
        $this->id = $id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getDtcadastro()
    {
        return $this->dtcadastro;
    }

    public function setDtcadastro($dtcadastro)
    {
        $this->dtcadastro = $dtcadastro;
    }

    public function isSeted($data){
        if(count($data)>0){// count($result)>0
            $this->getData($data);
            return true;
        }
        else{
            return false;
        }
    }
    public function loadById($id){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE id = :id",array(":id"=> $id));
        $this->isSeted($result[0]);

    }
    public function loadByLogin($login){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE login = :login",array(":login"=> $login));
        $this->isSeted($result[0]);
    }

    public static function getList(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY id");
    }

    public static function search($login){
        $sql = new Sql();
        $result =  $sql->select("SELECT * FROM  tb_usuarios WHERE login LIKE :login ORDER BY id", array(
           ":login"=>"%$login%"
        ));
    }

    public function login($login, $pass){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE login = :login AND senha = :password", array(
            ":login"=>$login,
            ":password"=>$pass
        ));
        if($this->isSeted($result[0])){
        }
        else {
            throw new Exception("Login e/ou senha inválidos.");
        }
    }

    public function getData($data){
        $this->setid($data['id']);
        $this->setLogin($data['login']);
        $this->setSenha($data['senha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));
    }

    public function insert($table, $login, $pass){

        $sql = new Sql();
        $result = $this::search("$login");
        if(count($result)>0){
            echo "Login já cadastrado !";
        }
        else{

            $sql->query("INSERT INTO $table(login, senha) VALUES (:login, :senha)",array(
                ":login"=> $login,
                ":senha"=>$pass
            ));
            echo "Usuário cadastrado com sucesso !";
// PEGA O ULTIMO USUARIO ADICIONADO
//            $id = $sql -> select("SELECT LAST_INSERT_ID()");
//            $id = $id[0]['LAST_INSERT_ID()'];
//            $data = $sql->select("SELECT * FROM $table WHERE id = :id", array(":id"=>$id));
//            $this->getData($data[0]);
        }
    }

    public function update($login, $pass, $param){
        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET login=:login, senha=:pass WHERE login = :param",array(
            ":login"=> $login,
            ":pass" => $pass,
            ":param"=>$param
        ));
    }

    public function __toString()
    {
        return json_encode(array(
            "id" => $this->getid(),
            "login" => $this->getLogin(),
            "senha" => $this->getSenha(),
            "dtcadastro" => $this->getDtcadastro()->format("d-m-Y H:i:s")
        ));
    }
}

?>