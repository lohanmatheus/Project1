<?php
include('User1.php');
$parametros = (array)json_decode(file_get_contents('php://input'),true);
$link = pg_connect("host=localhost port=5432 dbname=financa user=postgres password=1998");

if ($parametros['classe'] == 'usuario') {
    $usuario = new User1($link, $parametros);

    switch ($parametros['acao']) {
            case "logar":
            $arrayResposta =$usuario->logar();
            break;

            case "transacao":
            $arrayResposta =$usuario->sendTransacao();
            break;

            case "inserindo":
            $arrayResposta =$usuario->inserir();
            break;

            case "search":
            $arrayResposta =$usuario->search();
            break;

            case "share":
            $arrayResposta =$usuario->share();
            break;
    }
    echo json_encode($arrayResposta);
    exit;
}

echo json_encode([
    'success' => false,
    'msg' => 'Informe uma acao e ferramenta para utilizar a api!',
    'dados' => []
]);



