<?php

class Usuario{
    private $idusuario;
    private $login;
    private $senha;
    private $dtcadastro;


    public function getIdusuario()
    {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
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

    public function loadById($id){
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :id",array(":id"=> $id));
        if(isset($result[0])){// count($result)>0
            $row = $result[0];
            $this->setIdusuario($row['idusuario']);
            $this->setLogin($row['login']);
            $this->setSenha($row['senha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));
        }
    }

    public static function getList(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario");
    }

    public static function search($login){
        $sql = new Sql();
        return $sql->select("SELECT * FROM  tb_usuarios WHERE login LIKE :login ORDER BY idusuario", array(
           ":login"=>"%$login%"
        ));
    }














    public function login($login, $pass){
        $sql = new Sql();
        //$results = $sql->select("SELECT * FROM tb_usuarios WHERE login = :LOGIN AND senha = :PASSWORD", array(
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE login = :login AND senha = :password", array(
            ":login"=>$login,
            ":password"=>$pass
        ));
//
//        $result = $sql->select("SELECT * FROM tb_usuarios WHERE login = :login AND senha = :pass",array(
//":login"=> $login,
// ":senha"=> $pass
//));
        if (count($results) > 0) {
            $row = $results[0];
            $this->setIdusuario($row['idusuario']);
            $this->setLogin($row['login']);
            $this->setSenha($row['senha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));
        }
        else {

            throw new Exception("Login e/ou senha inválidos.");
        }
    }

    public function __toString()
    {
        return json_encode(array(
            "idusuario" => $this->getIdusuario(),
            "login" => $this->getLogin(),
            "senha" => $this->getSenha(),
            "dtcadastro" => $this->getDtcadastro()->format("d-m-Y H:i:s")
        ));
    }
}

?>