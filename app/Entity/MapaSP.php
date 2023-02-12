<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class MapaSP{

  public $id;
  public $ano;
  public  $bairro;
  public  $tipo_crime;
  public  $mes1;
  public  $mes2;
  public  $mes3;
  public  $mes4;
  public  $mes5;
  public  $mes6;
  public  $mes7;
  public  $mes8;
  public  $mes9;
  public  $mes10;
  public  $mes11;
  public  $mes12;
  public  $total;


  public function cadastrar(){
   
    $db = new Database('mapacrimesp');
    $this->id = $db->insert([
    'ano'        => $this->ano,
    'bairro'     => $this->bairro,
    'tipo_crime' => $this->tipo_crime,
    'mes1'       => $this->mes1,
    'mes2'       => $this->mes2,
    'mes3'       => $this->mes3,
    'mes4'       => $this->mes4,
    'mes5'       => $this->mes5,
    'mes6'       => $this->mes6,
    'mes7'       => $this->mes7,
    'mes8'       => $this->mes8,
    'mes9'       => $this->mes9,
    'mes10'      => $this->mes10,
    'mes11'      => $this->mes11,
    'mes12'      => $this->mes12,
    'total'      => $this->total
              ]);

    //RETORNAR SUCESSO
    return true;
  }
  public static function getMapaApi($ano){
    
    return (new Database('mapacrimesp'))->select('ano ='. $ano, $order=null , $limit=null , $fields ='*')
                                   ->fetchAll(PDO::FETCH_CLASS,self::class);
   }
  
  

}