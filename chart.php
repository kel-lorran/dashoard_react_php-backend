<?php
    require_once('./LeiturasDao.php');
    require_once('./Response.php');
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");

    $jsonBody = file_get_contents('php://input');
    $result = new Response();

    if( isset( $_GET['cond'])){
        $cond = $_GET['cond'];
    }else{
        $result->setMesage('erro: condomino ausente');
        die( $result->getResponse());
    }
    
    if( isset( $_GET['tipo'])){
        $tipo = $_GET['tipo'];
    }else{
        $result->setMesage('erro: tipo de leitura ausente');
        die( $result->getResponse());
    }
    if( isset( $_GET['token'])){
        //abordagem temporaria, para não ter que implementar json web token 
        $arrayToken = json_decode(file_get_contents('db.json'), true);
        $time = time();
        
        if(9000 < (time() - $arrayToken[$_GET['token']])){
            unset($arrayToken[$_GET['token']]);
            file_put_contents('db.json', json_encode( $arrayToken));
            $result->setMesage('erro: token expirado');
            die( $result->getResponse());
        }else{
            $arrayToken[$_GET['token']] = time();
            file_put_contents('db.json', json_encode( $arrayToken));
        }
    }else{
        $result->setMesage('erro: token ausente');
        die( $result->getResponse());
    }

    $dao = new LeiturasDao();

    $result_query = $dao->get( $cond, $tipo);
    $result->setContent( $result_query);

    echo $result->getResponse();
?>