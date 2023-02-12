<?php
echo "<form method='get'>
<input	type='text'	name='idade' placehold='Digite a idade'>
<input	type='submit'	value='ver'>


</form >";
function toDesc($p) {
	switch($p) {
		case 'Z': return 'Não nasceu'; break;
		case 'C': return 'criança'; break;
		case 'A': return 'adolescente'; break;
		case 'U': return 'adulto'; break;
		case 'I': return 'idoso'; break;
	}
}

require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\KNearestNeighbors;

$classifier = new KNearestNeighbors();

$samples = [[0],[1], [8], [11], [12], [14], [17], [19], [40], [50], [65], [90], [85]];
$labels = ['Z','C', 'C', 'C', 'A', 'A', 'A', 'U', 'U', 'U', 'I', 'I', 'I'];

$classifier->train($samples, $labels);
$idade=isset($_GET['idade']) ? $_GET['idade'] : 0 ;
$result = $classifier->predict([[$idade]]);
echo "uma pessoa é " . toDesc($result[0][0][0]) . "<br>";
//echo "uma pessoa de 15 ano(s) é " . toDesc($result[1][0][0]) . "\n";
//echo "uma pessoa de 35 ano(s) é " . toDesc($result[2][0][0]) . "\n";
//echo "uma pessoa de 70 ano(s) é " . toDesc($result[3][0][0]) . "\n";
