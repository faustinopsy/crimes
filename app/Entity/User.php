<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class User{

  /**
   * Identificador único do jogo
   * @var integer
  */
  public $id;
  public $sub;
  
  public $member_name;
  public $member_email;
  public $member_password;
 


  public function cadastrar(){
    //DEFINIR A DATA
	$senha=User::calculate_password_hash($this->member_email, $this->member_password);
    $this->data = date('Y-m-d H:i:s');

   
    $db = new Database('member_accounts');
    $this->id = $db->insert([
	  'member_name'=> $this->member_name,
	  'member_email'=> $this->member_email,
	  'member_password'=> $senha
                          
        ]);

    //RETORNAR SUCESSO
    return true;
  }

function calculate_password_hash($login, $password)
{
    $hash = '*0';
    if (CRYPT_BLOWFISH == 1) {
        if (defined('PHP_VERSION_ID') && (PHP_VERSION_ID > 50306)) {
            $hash = crypt($password, '$2y$08$' . User::generate_bf_salt($login));
        } else {
            $hash = crypt($password, '$2a$08$' . User::generate_bf_salt($login));
        }
    }

    if ((CRYPT_MD5 == 1) && !strcmp($hash, '*0')) {
        $hash = crypt($password, '$1$' . $login);
    }

    return strcmp($hash, '*0') ? $hash : md5($password);
}
function generate_bf_salt($string)
{
    $result = '';
    $bin = unpack('C*', md5($string, true));
    for ($i = 0; $i < count($bin); $i++) {
        $shift = 2 + ($i % 3) * 2;
        $first = ($bin[$i + 1] >> $shift);
        $second = ($bin[$i + 1] & bindec(str_repeat('1', $shift)));
        switch ($shift) {
            case 2:
                $result .= User::bf_salt_character($first);
                $tmp = $second;
                break;
            case 4:
                $result .= User::bf_salt_character(($tmp << 4) | $first);
                $tmp = $second;
                break;
            case 6:
                $result .= User::bf_salt_character(($tmp << 2) | $first);
                $result .= User::bf_salt_character($second);
                break;
        }
    }
    if ($shift == 2) {
        $result .= User::bf_salt_character($second);
    }

    return $result;
}
function bf_salt_character($num)
{
    if ($num > 63) {
        return chr(46);
    } elseif ($num < 12) {
        return chr(46 + $num);
    } elseif ($num < 38) {
        return chr(53 + $num);
    } else {
        return chr(59 + $num);
    }
}

  public function atualizar(){
    return (new Database('member_accounts'))->update('id = '.$this->id,[
		'member_name'=> $this->member_name,
	    'member_email'=> $this->member_email,
	    'member_password'=> $this->member_password
      ]);
  }
  public function notificar(){
      
    $db = new Database('incritos');
    $this->id = $db->insert([
	  'id'=> $this->id,
	  'sub'=> $this->sub
                          
        ]);

    //RETORNAR SUCESSO
    return true;
  }
 public static function getNotificar(){
   return (new Database('incritos'))->select($where = null, $order=null , $limit=null , $fields ='sub')
                                     ->fetchAll(PDO::FETCH_CLASS,self::class);
								  
	
  }
  public function excluir(){
    return (new Database('member_accounts'))->delete('id = '.$this->id);
  }

 
  public static function getMember($id){
   return (new Database('member_accounts'))->select('id = '.$id, $order=null , $limit=null , $fields ='member_name,member_email')
                                     ->fetchAll(PDO::FETCH_CLASS,self::class);
								  
	
  }

  public static function getLogin($email,$pass){
	  $senha=User::calculate_password_hash($email, $pass);
    $match= (new Database('member_accounts'))->select('member_email = "'.$email .'" AND member_password="'.$senha.'"', $order=null , $limit=null , $fields = 'id,member_email')
                                 ->fetchAll(PDO::FETCH_CLASS,self::class);
								  
   $total= json_decode(json_encode($match)); 
	return $total;
  }
 

}