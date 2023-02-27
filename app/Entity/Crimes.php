<?php
namespace App\Entity;
use \App\Db\Database;
use \PDO;

class Crimes{
  public $id;
  public $cep;
  public  $bairro;
  public  $lng;
  public  $lat;
  public  $rua;
  public  $tipo;

  public function cadastrar(){
    $db = new Database('ponto_crime');
    $this->id = $db->insert([
    'cep'        => $this->cep,
    'lat'        => $this->lat,
    'lng'        => $this->lng,
    'bairro'     => $this->bairro,
    'rua'        => $this->rua,
    'tipo'       => $this->tipo
              ]);
    return true;
  }
  public static function getPontosApi(){
    return (new Database('ponto_crime'))->select($where=null, $order=null , $limit=null , $fields ='*')
                                   ->fetchAll(PDO::FETCH_CLASS,self::class);
   }
}