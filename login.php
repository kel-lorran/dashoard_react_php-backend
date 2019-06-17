<?php
    require_once('./UserDao.php');
    require_once('./Response.php');
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    
    $jsonBody = file_get_contents('php://input');
    $body = json_decode( $jsonBody, true);
    $result = new Response();

    if( isset( $_GET['action'])){
        $action = $_GET['action'];
    }else{
        $result->setMesage('erro: action ausente');
        die( $result->getResponse());
    }
    if(! $jsonBody){
        $result->setMesage('erro: body ausente');
        die( $result->getResponse());
    }
    if(! isset($body['email'])){
        $result->setMesage('erro: email invalido');
        die( $result->getResponse());
    }else{
        if( $body['email'] == ''){
            $result->setMesage('erro: email invalido');
            die( $result->getResponse());
        }
    }
    if(! isset($body['senha'])){
        $result->setMesage('erro: senha invalida');
        die( $result->getResponse());
    }else{
        if( $body['senha'] == ''){
            $result->setMesage('erro: email invalido');
            die( $result->getResponse());
        }
    }

    $dao = new UserDao();

    if( $action === 'LOGAR'){

        $result_query = $dao->get( $body['email']);
        
        if(! ($result_query['email'] === $body['email'])){
            $result->setMesage('usuario não encontrado');
            die( $result->getResponse());
        }elseif( ! ($result_query['senha'] === $body['senha'])){
            $result->setMesage('senha incorreta');
            die( $result->getResponse());
        }else{
            //abordagem temporaria, para não ter que implementar json web token 
            $arrayToken = json_decode(file_get_contents('db.json'), true);
            $time = time();
            $arrayToken[md5( $time)] = $time;
            file_put_contents('db.json', json_encode( $arrayToken));
            $result->setContent( md5( $time));
        }
    }
    if( $action === 'REGISTRAR'){
    
        $result_query = $dao->save( $body['email'], $body['senha']);

        //abordagem temporaria, para não ter que implementar json web token 
        $arrayToken = json_decode(file_get_contents('db.json'), true);
        $time = time();
        $arrayToken[md5( $time)] = $time;
        file_put_contents('db.json', json_encode( $arrayToken));
        $result->setContent( md5( $time));
    
    }
    
    echo $result->getResponse();
?>