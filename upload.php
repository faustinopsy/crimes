<?php
//include "conexao.php";

if (isset($_POST["cabecalho"]) && isset($_POST["nomeArquivo"])) {
    var_dump($_POST["dados"]);exit;
    $cabecalho = explode(",", $_POST["cabecalho"]);
    $dados = json_decode($_POST["dados"], true);
    $nomeArquivo = $_POST["nomeArquivo"];

    

    $colunas = "id,nome_arquivo," . implode(",", $cabecalho);
    $query = "INSERT INTO nome_da_tabela ($colunas) VALUES";
    foreach ($dados as $linha) {
        $valores = "NULL,'$nomeArquivo'," . implode(",", array_map(function ($dado) {
            return "'$dado'";
        }, $linha));
        $query .= "($valores),";
    }
    $query = substr($query, 0, -1);
    mysqli_query($conn, $query);
    header("Location: index.php");
}