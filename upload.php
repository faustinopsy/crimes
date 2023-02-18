<?php
header('Content-Type: text/html; charset=UTF-8');
require __DIR__.'/vendor/autoload.php';
define('TITLE','Cadastrar');
use \App\Entity\mapasp;

$mapasp = new MapaSP;
$tipocrime=[];
$tipocrime[]=[
    15=>'Homicidio doloso',
    30=>'Vitimas de Homicidio doloso',
    45=>'Homicidio culposo por acidente de transito',
    60=>'Vitimas de homicidio por acidente de transito',
    30=>'Homicidio culposo por acidente de transito',
    75=>'Homicidio culposo outros',
    90=>'Tentativa de homicidio',
    105=>'Lesao corporal seguida de morte',
    120=>'Lesao corporal dolosa',
    135=>'Lesao corporal por acidente de transito',
    150=>'Lesao corporal culposa',
    165=>'Lesao corporal outras',
    180=>'Latrocinio',
    195=>'Vitimas de latrocinio',
    210=>'Total de estupro',
    225=>'Estupro',
    240=>'Estupro de funeravel',
    255=>'Total de roubos outros',
    270=>'Roubo outros',
    285=>'Roubo de veiculo',
    300=>'Roubo a bancoo',
    315=>'Roubo de carga',
    330=>'Furto outros',
    345=>'Furto de veiculo'
];

if (isset($_POST["cabecalho"]) && isset($_POST["nomeArquivo"])) {
    $cabecalho = json_decode($_POST["cabecalho"], true);
    $dados = json_decode($_POST["dados"], true);
    $nomeArquivo = $_POST["nomeArquivo"];
    $dados = json_decode($_POST["dados"], true);

    if ($dados === NULL) {
        $error = json_last_error();
        switch ($error) {
            case JSON_ERROR_NONE:
                echo 'Sem erros';
                break;
            case JSON_ERROR_DEPTH:
                echo 'Profundidade máxima excedida';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                echo 'Desigualdade de modos ou underflow';
                break;
            case JSON_ERROR_CTRL_CHAR:
                echo 'Erro de caractere de controle, possivelmente codificação errada';
                break;
            case JSON_ERROR_SYNTAX:
                echo 'Erro de sintaxe';
                break;
            case JSON_ERROR_UTF8:
                echo 'Caractere UTF-8 malformado, possivelmente codificação errada';
                break;
            default:
                echo 'Erro desconhecido';
                break;
        }
    }
    function removeAcentos($text) {
        $text = preg_replace(
            array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö)/",
                "/(Ó|Ò|Õ|Ô|Ö)/",
                "/(ú|ù|û|ü)/",
                "/(Ú|Ù|Û|Ü)/",
                "/(ñ)/",
                "/(Ñ)/"
            ),
            explode(" ", "a A e E i I o O u U n N"),
            $text
        );
        return $text;
    }
    
    for ($i = 15; $i < count($dados); $i ++) {
        $mapasp = new MapaSP();
        $mapasp->ano = intval(filter_var($cabecalho[0], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->bairro = trim($nomeArquivo);
        $mapasp->tipo_crime = $tipocrime[0][$i];
        $mapasp->mes1 = intval(filter_var($dados[$i + 1], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes2 = intval(filter_var($dados[$i + 2], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes3 = intval(filter_var($dados[$i + 3], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes4 = intval(filter_var($dados[$i + 4], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes5 = intval(filter_var($dados[$i + 5], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes6 = intval(filter_var($dados[$i + 6], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes7 = intval(filter_var($dados[$i + 7], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes8 = intval(filter_var($dados[$i + 8], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes9 = intval(filter_var($dados[$i + 9], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes10 = intval(filter_var($dados[$i + 10], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes11 = intval(filter_var($dados[$i + 11], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->mes12 = intval(filter_var($dados[$i + 12], FILTER_SANITIZE_NUMBER_INT));
        $mapasp->total = intval(filter_var($dados[$i + 13], FILTER_SANITIZE_NUMBER_INT));
        $i+=14;
        $mapasp->cadastrar();
    }
    header("Location: subir.php");
}