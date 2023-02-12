<style>
    table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  text-align: left;
  padding: 8px;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #ddd;
}
</style>
<?php

$dados=[];
if (isset($_POST["submit"])) {
    if (isset($_FILES["file"])) {
        $file = $_FILES["file"]["tmp_name"];
        $nomeArquivo = $_FILES["file"]["name"];
        $nomeArquivo = substr($nomeArquivo, 26, strlen($nomeArquivo) - 26 - 4);
        if ($file) {
            $handle = fopen($file, "r",'UTF-8');
            $cabecalho = false;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$cabecalho) {
                    $cabecalho = $data;
                } else {
                    $dados[] = $data;
                }
            }
            fclose($handle);
        }
    }
}
function removeAcentos($text) {
    $text = mb_convert_encoding($text, "UTF-8", mb_detect_encoding($text, "UTF-8, ISO-8859-1, ISO-8859-15", true));
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
            "/(Nº)/",
            "/(ñ)/",
            "/(Ñ)/"
        ),
        explode(" ", "a A e E i I o O u U n N"),
        $text
    );
  
    return $text;
}
$resultado=[];
if (isset($cabecalho) && isset($dados)) {
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    foreach ($cabecalho as $coluna) {
        echo "<th>" . $coluna . "</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>".$nomeArquivo;
    foreach ($dados as $linha) {
       
        echo "<tr>";
        foreach ($linha as $coluna) {
            
            echo "<td>" . removeAcentos($coluna) . "</td>";
            $resultado[]=removeAcentos($coluna);
        }
        echo "</tr>";
    }
   //               L- C
    // var_dump($dados[0][0]);
    // var_dump($dados[0][1]);
    // var_dump($dados[5][11]);
    // exit;
    $skipFirstLine = true;
    if (!$handle = fopen($file, "r")) {
        echo "Não foi possível abrir o arquivo.";
        exit;
    }
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if ($skipFirstLine) {
            $skipFirstLine = false;
            continue;
        }
        $data = array_map('utf8_encode', $data);
        $dados[] = $data;
       
    }
    
    $json=json_encode($resultado);
   
if ( $json === false) {
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo 'Sem erros';
        break;
        case JSON_ERROR_DEPTH:
            echo 'Profundidade máxima excedida';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo 'Underflow ou modeswitch inadequado';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
        break;
        case JSON_ERROR_SYNTAX:
            echo 'Erro de sintaxe';
        break;
        case JSON_ERROR_UTF8:
            echo 'Caracteres UTF-8 malformados, possivelmente codificados incorretamente';
        break;
        default:
            echo 'Erro desconhecido';
        break;
    }
}

    echo "</tbody>";
    echo "</table>";
    echo "<form action='upload.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='cabecalho' value='" . json_encode($cabecalho) . "'>";
    echo "<input type='hidden' name='dados' value='" . json_encode($resultado) . "'>";
    echo "<input type='hidden' name='nomeArquivo' value='" . $nomeArquivo . "'>";
    echo "<input type='submit' name='submit' value='Upload'>";
    echo "</form>";
   
} else {
    echo "<form action='' method='post' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    echo "<input type='submit' name='submit' value='Upload'>";
    echo "</form>";
}



?>

