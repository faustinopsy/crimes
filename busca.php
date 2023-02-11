<?php
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.ssp.sp.gov.br/estatistica/pesquisa.aspx");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);

$dom = new DOMDocument();
@$dom->loadHTML($result);
$xpath = new DOMXPath($dom);
$nodes = $xpath->query("//div[@id='conteudo_repAnos_divGrid_1']//table");

$dados = array();
$cabecalho = array();
foreach ($nodes as $node) {
    // Extraia o cabeçalho da tabela
    $linhas = $xpath->query("tr", $node);
    foreach ($linhas as $linha) {
        $colunas = $xpath->query("th", $linha);
        if ($colunas->length > 0) {
            foreach ($colunas as $coluna) {
                $cabecalho[] = $coluna->nodeValue;
            }
        } else {
            $colunas = $xpath->query("td", $linha);
            if ($colunas->length > 0) {
                $linhaDados = array();
                foreach ($colunas as $coluna) {
                    $linhaDados[] = $coluna->nodeValue;
                }
                $dados[] = $linhaDados;
            }
        }
    }
}

echo "<table>";
echo "<thead>";
echo "<tr>";
foreach ($cabecalho as $coluna) {
    echo "<th>" . $coluna . "</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($dados as $linha) {
    echo "<tr>";
    foreach ($linha as $coluna) {
        echo "<td>" . $coluna . "</td>";
    }
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
