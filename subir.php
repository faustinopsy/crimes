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
//verifica se o metodo POST existe o submit
if (isset($_POST["submit"])) {
    //verifica se existe o arquivo no metodo POST
    if (isset($_FILES["file"])) {
        //transfere o arquivo digital para a variável file
        $file = $_FILES["file"]["tmp_name"];
        //coloca o nome do arquivo na variável nomearquivo
        $nomeArquivo = $_FILES["file"]["name"];
         //todos os arquivos iniciam o nome do bairro aparti da posição 26, 
         //e também retira a extensão do nome restando apenas o nome do bairro
        $nomeArquivo = substr($nomeArquivo, 26, strlen($nomeArquivo) - 26 - 4);
        if ($file) {
             //abre o arquivo "r" e ler, passando o conteúdo para variável handle
            $handle = fopen($file, "r",'UTF-8');
            $cabecalho = false;
            //executa um loop por linha pulando a primeira, 
            //e informa que os dados estão separados por ";" sendo um csv
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
$resultado=[];  //Abaixo o script para exibir em tela os dados do arquivo
if (isset($cabecalho) && isset($dados)) {
    echo "<table><thead><tr>";
    foreach ($cabecalho as $coluna) {
        echo "<th>" . $coluna . "</th>";
    }
    echo "</tr></thead><tbody>".$nomeArquivo;
    foreach ($dados as $linha) {
        echo "<tr>";
        foreach ($linha as $coluna) {
            echo "<td>" . removeAcentos($coluna) . "</td>";
            $resultado[]=removeAcentos($coluna);
        }
        echo "</tr>";
    }
    $json=json_encode($resultado);
//Formulário para exibição dos dados do arquivo, e preparar para subir para o banco de dados
    echo "</tbody></table>"; 
    echo "<form action='upload.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='cabecalho' value='" . json_encode($cabecalho) . "'>";
    echo "<input type='hidden' name='dados' value='" . json_encode($resultado) . "'>";
    echo "<input type='hidden' name='nomeArquivo' value='" . $nomeArquivo . "'>";
    echo "<input type='submit' name='submit' value='Upload'>";
    echo "</form>";
} else {   //Formulário para upload do arquivo
    echo "<form action='' method='post' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    echo "<input type='submit' name='submit' value='Upload'>";
    echo "</form>";
}



?>

