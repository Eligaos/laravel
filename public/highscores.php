<?php 



header("Content-Type: application/json");
$file = "top10.json";
if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {

    $top10Table = json_decode(file_get_contents($file), true);
    if($top10Table != null){

    	header("Content-Length: ".filesize('top10.json'));
		usort($top10Table, "cmp");
	
     echo(json_encode($top10Table));
	 }
    exit(0);
}
// POST
// Ler pontuacao do ficheiro

$top10Table = json_decode(file_get_contents($file), true);
// NOTA $_POST está vazio se Content-Type do request for application/json
$inputData = json_decode(file_get_contents("php://input"), true);


if(strcmp($inputData["op"],"check") == 0){

		$score = (computeScore($inputData["moves"], $inputData["elapsedTime"], $inputData["boardSize"]));

		echo(checkPOSTResult($score, checkTopTenWorthy($top10Table, $score)));
}elseif((strcmp($inputData["op"],"update") == 0)){

		
		$score = (computeScore($inputData["moves"], $inputData["elapsedTime"], $inputData["boardSize"]));
		if(checkTopTenWorthy($top10Table, $score) == true){

			$pos = getTopTenLowestValuePos($top10Table, $score);
			$top10Table[$pos]['name'] = $inputData["playerName"];
			$top10Table[$pos]['score'] = $score;


			usort($top10Table, "cmp");

				
			file_put_contents($file, json_encode($top10Table));
		    echo(json_encode($top10Table));
		}

}

function computeScore($moves, $elapsedTime, $gameBoardSize) {
 		return round((1/(0.9*$moves+0.1*$elapsedTime))*$gameBoardSize*100000);
} 

function checkPOSTResult($score, $top_ten_worthy){
			$new_score = [
			'score' => $score,
			'top' => $top_ten_worthy
		];
	return json_encode($new_score);
}

function checkTopTenWorthy($top10Table, $score){
	if(count($top10Table) < 10){
		return true;
	}else{
		//$lowestScore = $top10Table[0]['score'];
		for ($i=0; $i < count($top10Table); $i++) { 
				if ($score > $top10Table[$i]['score']) {
						return true;
				}	
		}
		//if($score > $lowestScore){
		//		return true;	
		//}
		return false;
	}	
}


function getTopTenLowestValuePos($top10Table, $score){
		$lowestScore = $top10Table[0]['score'];
		$lowestScorePos = null;
		for ($i=0; $i < count($top10Table); $i++) { 
				if ($top10Table[$i]['score'] < $lowestScore) {
						$lowestScore = $top10Table[$i]['score'];
						$lowestScorePos = $i;
				}	
		}
		if($score > $lowestScore){
				return $lowestScorePos;	
		}
		return null;
}

function cmp($a, $b)
{
	if ($a['score'] == $b['score'] ) {
			  return 0;
	}
   return ($a['score']  > $b['score'] ) ? -1 : 1;
}



// Ordenar e calcular a pontuacao com base nos dados do post
?>


