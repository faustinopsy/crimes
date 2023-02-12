<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Megasena{

  /**
   * Identificador único do jogo
   * @var integer
   
  public $id;
  public $n1;
  public $n2;
  public $n3;
  public $n4;
  public $n5;
  public $n6;
  public $n7;
  public $n8;
  public $n9;
  public $n10;
  public $n11;
  public $n12;
  public $n13;
  public $n14;
  public $n15;
  public $data;

  public $user;
*/

  
  
  public function cadastrarSorteio(){
    //DEFINIR A DATA
    //$this->data = date('Y-m-d');

    //INSERIR A VAGA NO BANCO
    $db = new Database('megasena');
    $this->id = $db->insert([
                          'B1'     => $this->n1,
                          'B2'     => $this->n2,
                          'B3'     => $this->n3,
                          'B4'     => $this->n4,
                          'B5'     => $this->n5,
                          'B6'     => $this->n6,
                          
                           'Concurso'    => $this->Concurso,
                          'Data'    => $this->Data
                                    ]);

    //RETORNAR SUCESSO
    return true;
  }
  /**
   * Método responsável por atualizar a vaga no banco
   * @return boolean
   */
    public function cadastrarSorteionovo(){
   
    $db = new Database('megasena');
    $this->id = $db->insert([
                          'B1'     => $this->n1,
                          'B2'     => $this->n2,
                          'B3'     => $this->n3,
                          'B4'     => $this->n4,
                          'B5'     => $this->n5,
                          'B6'     => $this->n6,
                          
                          'concurso'=> $this->concurso,
                          'data'    => $this->data
                                    ]);

    //RETORNAR SUCESSO
    return true;
  }
   public function cadastrarCidade(){
   
    $db = new Database('sorteiosmunicipio_megasena');
    $this->id = $db->insert([
                          'municipio'       => $this->municipio,
                          'uf'              => $this->uf,
                          'data'            => $this->data,
                          'concurso'        => $this->concurso
                         ]);

    //RETORNAR SUCESSO
    return true;
  }
     public function cadastrarpremiacao(){
   
    $db = new Database('sorteiospremio_megasena');
    $this->id = $db->insert([
                          'descricaoFaixa'       => $this->descricaoFaixa,
                          'numeroDeGanhadores'   => $this->numeroDeGanhadores,
                          'valorPremio'          => $this->valorPremio,
                          'concurso'             => $this->concurso
                                    ]);

    //RETORNAR SUCESSO
    return true;
  }

  /**
   * Método responsável por obter as vagas do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
   
   public static function getSorteios(){
    return (new Database('sorteioslotofacil'))->select($where = null, $order = 'Concurso desc', $limit = null, $fields ='*')
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }
    public static function getSorteiosfav($limite){
    return (new Database('sorteioslotofacil'))->select($where = null, $order = null, $limit = $limite, $fields ='*')
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }
   public static function getUltimosSorteios($limite){
    return (new Database('sorteioslotofacil'))->select($where = null, $order = 'Concurso desc', $limit = $limite, $fields ='Concurso')
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }
  public static function getSorteio($data){
   return (new Database('sorteioslotofacil'))->select('Data = "'.$data.'"', $order=null , $limit=null , $fields ='B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,B11,B12,B13,B14,B15')
                                  ->fetchObject(self::class);
  }
    public static function getSorteioUltimoData($data){
   return (new Database('sorteioslotofacil'))->select('Data = "'.$data.'"', $order=null , $limit=null , $fields ='Concurso,B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,B11,B12,B13,B14,B15')
                                  ->fetchObject(self::class);
  }
    public static function getRepetidos($id){
   return (new Database('sorteioslotofacil'))->select('Concurso = '.$id, $order=null , $limit=null , $fields ='B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,B11,B12,B13,B14,B15')
                                  ->fetchObject(self::class);
  }
  public static function getSorteioApi($id){
   return (new Database('sorteioslotofacil'))->select('Concurso = '.$id, $order=null , $limit=null , $fields ='Data, B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,B11,B12,B13,B14,B15')
                                  ->fetchObject(self::class);
  }
    public static function getSorteioFavorito($idx){
    return (new Database('sorteioslotofacil'))->select2('Concurso = '.$idx, $fields ='B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,B11,B12,B13,B14,B15')
                                   ->fetchObject(self::class);
   }
  public static function getSorteioData($data){
   return (new Database('sorteioslotofacil'))->select('Data = "'.$data.'"', $order=null , $limit=null , $fields ='Concurso')
                                ->fetchObject(self::class);
  }
 public static function getSorteioDatamapa(){
   return (new Database('sorteioslotofacil'))->selectmapa()->fetchAll(PDO::FETCH_CLASS,self::class);
  } 
  

}