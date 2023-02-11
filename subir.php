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
$conn = mysqli_connect("localhost", "username", "password", "database_name");
$dados=[];
if (isset($_POST["submit"])) {
    if (isset($_FILES["file"])) {
        $file = $_FILES["file"]["tmp_name"];
        $nomeArquivo = $_FILES["file"]["name"];
        $nomeArquivo = substr($nomeArquivo, 26, strlen($nomeArquivo) - 26 - 4);
        if ($file) {
            $handle = fopen($file, "r");
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
echo "</tbody>";
echo "</table>";
echo "<form action='upload.php' method='post' enctype='multipart/form-data'>";
echo "<input type='hidden' name='cabecalho' value='" . implode(",", $cabecalho) . "'>";
echo "<input type='hidden' name='dados[]' value='" .  $dados[1][11].','.$dados[2][11] . "'>";
echo "<input type='hidden' name='nomeArquivo' value='" . $nomeArquivo . "'>";
echo "<input type='submit' name='submit' value='Upload'>";
echo "</form>";
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
            
            echo "<td>" . utf8_encode($coluna) . "</td>";
        }
        echo "</tr>";
    }
   //               L- C
    // var_dump($dados[0][0]);
    // var_dump($dados[0][1]);
    // var_dump($dados[5][11]);
    // exit;
   
} else {
    echo "<form action='' method='post' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    echo "<input type='submit' name='submit' value='Upload'>";
    echo "</form>";
}



?>

