<?php

class User1
{
    private $dbConnect = null;
    private $parametros = null;

    public function __construct($dbConnect, $parametros)
    {
        if ($parametros)
            $this->parametros = $parametros;

        if ($dbConnect)
            $this->dbConnect = $dbConnect;
    }

    public function logar()
    {
        $dataUser = (array)$this->parametros['data'];
        $login = filter_var($dataUser['login'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var($dataUser['password'], FILTER_SANITIZE_SPECIAL_CHARS);


        $lista = [$login, $password];

        foreach ($lista as $linha) {
            if (empty($linha)) {
                return [
                    'success' => false,
                    'msg' => 'Campos obrigatorios não preenchidos!'
                ];
            }
        }

        $query = "SELECT * FROM finan_pessoal.user WHERE (login = '$login' OR name ='$login') AND password = '$password'
            ";
        try {
            $result = pg_query($this->dbConnect, $query);
            if (pg_affected_rows($result) <= 0) {
                return [
                    'success' => false,
                    'msg' => 'Login ou senha incorretos!!',
                    'dados' => []
                ];
            }

            $row = pg_fetch_assoc($result);

            //==================================================

            session_start();
            $_SESSION['nameUsuario'] = $row['name'];
            $_SESSION['logado'] = 'ativo';
            $_SESSION['login'] = $row['login'];
            $_SESSION['fixed_salary'] = $row['fixed_salary'];
            $_SESSION['id_user'] = $row['id'];

            return [
                'success' => true,
                'msg' => 'Logado com sucesso',
                'dados' => $row,

            ];

        } catch (\Exception $exception) {
            return [
                'success' => false,
                'msg' => $exception->getMessage(),
                'dados' => []
            ];
        }
    }

    public function sendTransacao() {
        $dataUser = (array)$this->parametros['data'];
        $description= filter_var($dataUser['nameTransacao'], FILTER_SANITIZE_SPECIAL_CHARS);
        $value =filter_var($dataUser['value'], FILTER_SANITIZE_SPECIAL_CHARS);
        $idTypeFuture =filter_var($dataUser['idTypeFuture'], FILTER_SANITIZE_SPECIAL_CHARS);

        if ($idTypeFuture == 'Selecione'){
            return [
                'success' => false,
                'msg' => 'Selecione o tipo da fatura!!'
            ];
        }

        session_start();
        $idUser=$_SESSION['id_user'];


        $lista = [$description,$value,$idTypeFuture];

        foreach ($lista as $linha) {
            if (empty($linha)) {
                return [
                    'success' => false,
                    'msg' => 'Campos obrigatorios não preenchidos!'
                ];
            }
        }


        try {

            $queryValue= "INSERT INTO finan_pessoal.checking_account(description,value,date,type,id_user) 
            VALUES ('$description','$value',current_date,'$idTypeFuture','$idUser')";

            $resultValue = pg_query($this->dbConnect, $queryValue);
            if (!$resultValue) {
                return [
                    'success' => false,
                    'msg' => pg_errormessage($this->dbConnect)
                ];

            }

            return [
                'success' => true,
                'msg' => 'Valor da transacao inserido com sucesso!'
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'msg' => $exception->getMessage()
            ];
        }

    }


    public function inserir()
    {
        $name = filter_var($this->parametros['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $login = filter_var($this->parametros['login'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var($this->parametros['password'], FILTER_SANITIZE_SPECIAL_CHARS);
        $salary = filter_var($this->parametros['fixed_salary'], FILTER_SANITIZE_SPECIAL_CHARS);


        $lista = [$name, $login, $password,$salary];

        foreach ($lista as $linha) {
            if (empty($linha)) {
                return [
                    'success' => false,
                    'msg' => 'Campos obrigatorios nao preenchidos!'
                ];
            }
        }

        $queryInserir = "INSERT INTO finan_pessoal.user (name, login, password,fixed_salary)
        VALUES ('$name','$login','$password','$salary')
            ";
        try {
            $executado = pg_query($this->dbConnect, $queryInserir);
            if (!$executado) {
                return [
                    'success' => false,
                    'msg' => pg_errormessage($this->dbConnect)
                ];
            }
            return [
                'success' => true,
                'msg' => 'Inserido com sucesso!'
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'msg' => $exception->getMessage()
            ];
        }
    }


    public function search(){


            $dataUser = (array)$this->parametros['data'];
            $name = filter_var($dataUser['name'], FILTER_SANITIZE_SPECIAL_CHARS);

            $query = "
           SELECT * 
             FROM finan_pessoal.user
             WHERE (name LIKE '%$name%' OR login LIKE '%$name%')";

            try {
                $result = pg_query($this->dbConnect, $query);
                if (pg_affected_rows($result) <= 0) {
                    return [
                        'success' => false,
                        'msg' => 'Nenhum item encontrado!!',
                        'dados' => []
                    ];
                }


                $resultSet = [];
                while ($row = pg_fetch_assoc($result)) {
                    $resultSet[] = $row;
                }

                return [
                    'success' => true,
                    'msg' => 'Listado com sucesso!',
                    'dados' => $resultSet

                ];


            } catch (\Exception $exception) {
                return [
                    'success' => false,
                    'msg' => $exception->getMessage(),
                    'dados' => []
                ];
            }

        }


    public function share() {

        session_start();
     $idUser=$_SESSION['id_user'];

     if ($idUser == '') {
            return [
                'success' => false,
                'msg' => 'ID NAO RECEBIDO!'
            ];
        }





    try {

        $queryS= "SELECT * FROM finan_pessoal.checking_account 
           WHERE  id_user = '$idUser'";

        $resultS = pg_query($this->dbConnect, $queryS);
        if (!$resultS) {
            return [
                'success' => false,
                'msg' => pg_errormessage($this->dbConnect)
            ];

        }

        $resultSet = [];
        while ($row = pg_fetch_assoc($resultS)) {
            $resultSet[] = $row;

        }


        return [
            'success' => true,
            'msg' => 'id inserido!'
        ];
    } catch (\Exception $exception) {
        return [
            'success' => false,
            'msg' => $exception->getMessage()
        ];
    }



    $queryInserir = "INSERT INTO finan_pessoal.share_checking_account(date,id_user,id_checking_account)
        VALUES (current_date,'$idUser','$idChecking')";
    try {
        $executado = pg_query($this->dbConnect, $queryInserir);
        if (!$executado) {
            return [
                'success' => false,
                'msg' => pg_errormessage($this->dbConnect)
            ];
        }
        return [
            'success' => true,
            'msg' => 'Inserido com sucesso!'
        ];
    } catch (\Exception $exception) {
        return [
            'success' => false,
            'msg' => $exception->getMessage()
        ];
    }








}





}












