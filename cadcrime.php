<?php
require __DIR__.'/vendor/autoload.php';
use \App\Entity\Crimes;

$mapasp = new Crimes;
$data=[];

if($_POST) {
      $mapasp->cep  = $_POST['cep'];
      $mapasp->bairro = $_POST['bairro'];
      $mapasp->lat = $_POST['lat'];
      $mapasp->lng = $_POST['lng'];
      $mapasp->rua = $_POST['rua'];
      $mapasp->tipo = $_POST['tipo'];

    if($mapasp->cadastrar()){
      $data=['status'=>true,'mensagem'=>'Salvo com sucesso'];
      return json_encode($data);
      }
    else {
      $data=['status'=>false,'mensagem'=>'Erro ao salvar'];
      return json_encode($data);
    }

}

?>
