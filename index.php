<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
ini_set('memory_limit','32M');
session_start();

function no_dupes(array $input_array) {
    return count($input_array) === count(array_flip($input_array));
}

function isSolved($sudoku){
	for ($ele=0; $ele < 9; $ele++){
		$row = [];
		$col = [];

		$row = $sudoku[$ele]; 
		for ($i = 0; $i < 9; $i++){
			array_push($col, $sudoku[$i][$ele]);
		}
		if (!no_dupes($row) || !no_dupes($col)){
			return false;
		}
	}

	for($b = 0 ; $b < 9 ; $b++){
         
        $block = [];
        $xS = floor($b / 3) * 3;
        $yS = ($b % 3) * 3;
        for ($x = $xS; $x < $xS + 3; $x++){
        	for ($y = $yS; $y < $yS + 3; $y++){
        		array_push($block, $sudoku[$y][$x]);	
        	}
        }
        if (!no_dupes($block)){
        	return false;
        }
	}
	return true;
}

function backTrackSolve($sudoku, $rowNum, $colNum){
	// print_r($sudoku);
	// echo "<br><br><br><br><br><br><br><br><br><br>";

	if (is_int($sudoku[$rowNum][$colNum]) && $sudoku[$rowNum][$colNum]!=0){
		if ($rowNum == 8 && $colNum == 8){
			echo "te solució";
			return true;
		} else {
			if ($colNum>7){
				if (backTrackSolve($sudoku, $rowNum + 1, 0 )){
					return true;
				}
			} else {
				if (backTrackSolve($sudoku, $rowNum, $colNum + 1)){
					return true;
				}
			}	
		}
	}
	echo $colNum." ";
	$row = $sudoku[$rowNum];
		$col = [
			$sudoku[0][$colNum],
			$sudoku[1][$colNum],
			$sudoku[2][$colNum],
			$sudoku[3][$colNum],
			$sudoku[4][$colNum],
			$sudoku[5][$colNum],
			$sudoku[6][$colNum],
			$sudoku[7][$colNum],
			$sudoku[8][$colNum]];
		$block = [];
		$xS = floor($colNum / 3) * 3;
        $yS = ($rowNum % 3) * 3;
        for ($x = $xS; $x < $xS + 3; $x++){
        	for ($y = $yS; $y < $yS + 3; $y++){
        		array_push($block, $sudoku[$y][$x]);	
        	}
        }

	for ($i = 1; $i <= 9; $i++){
        if (!in_array($i, $row) && !in_array($i, $col) && !in_array($i, $block)){
			// echo "row: ". $rowNum . ", col: ". $colNum . "<br>";
        	if ($rowNum == 8 && $colNum == 8){
				$sudoku[$rowNum][$colNum] = $i;
				echo "te solució";
				return true;
			} else {
				if ($colNum>7){
					$sudoku[$rowNum][$colNum] = $i;
					if (backTrackSolve($sudoku, $rowNum + 1, 0 )){
						return true;
					} else{
						$sudoku[$rowNum][$colNum] = 0;
					}
				} else 
					$sudoku[$rowNum][$colNum] = $i;
					if (backTrackSolve($sudoku, $rowNum, $colNum + 1)){
						return true;
					} else{
						$sudoku[$rowNum][$colNum] = 0;
					}
				}
				
			}
    }
    return false;		
}


function createSudoku(){
	// $sudokuS = 	[[8,3,5,4,1,6,9,2,7],
	// 			[2,9,6,8,5,7,4,3,1],
	// 			[4,1,7,2,9,3,6,5,8],
	// 			[5,6,9,1,3,4,7,8,2],
	// 			[1,2,3,6,7,8,5,4,9],
	// 			[7,4,8,5,2,9,1,6,3],
	// 			[6,5,2,7,8,1,3,9,4],
	// 			[9,8,1,3,4,5,2,7,6],
	// 			[3,7,4,9,6,2,8,1,5]];
	// return $sudokuS;

	$sudoku =  [[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0], 
				[0, 0, 0, 0, 0, 0, 0, 0, 0]];

	$numSeted = 0;
	$cont=0;
	while ($numSeted < 20){	//AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
		$randN = rand(1,9);
		$randX = rand(0,8);
		$randY = rand(0,8);

		$row = $sudoku[$randX];

		$col = [];
		for ($i = 0;$i < 9; $i++){
			array_push($col, $sudoku[$i][$randY]);
		}

		$quadrant = [];
		$qX = floor($randX / 3);
		$qY = floor($randY / 3);
		$startX = $qX * 3;
		$startY = $qY * 3;
		for ($x = $startX; $x < $startX + 3; $x++){
        	for ($y = $startY; $y < $startY + 3; $y++){
        		array_push($quadrant, $sudoku[$x][$y]);	
        	}
        }

		if ($sudoku[$randX][$randY] == 0 && !in_array($randN, $row) && !in_array($randN, $col) && !in_array($randN, $quadrant)){
			$sudoku[$randX][$randY] = $randN;
			$numSeted++;
		} 
	}
	echo '<p>' . $numSeted . '</p>';
	return $sudoku;
}

function createTable($sudoku){
    echo "<form method=POST><table>";
    for($j = 1;$j<=9;$j++){
        echo "<tr>";
            for($i =1; $i<=9;$i++){
            	echo "<td>";
            	if ($sudoku[$i-1][$j-1]!==0){
            		echo "<input type='text' name='".$i."-".$j."' value=" . $sudoku[$i-1][$j-1] . " readonly>";
            	} else { //EL POST NO PUEDE PILLAR LO QU ESTA DENTRO DEL SELECT
            		echo "<input type='number'  name='" . $i . "-" . $j . "' min=1 max=9 value=' '>";
				}
                echo "</td>";
            }
        echo "</tr>";
    }
    echo "</table>";
}

function innitGame(){
	if (isset($_SESSION['tablero'])){
		$sudoku = $_SESSION['tablero'];
	} else {
		$sudoku = createSudoku();		
		$_SESSION['tablero'] = $sudoku;
	}
	createTable($sudoku);
}

if (!isset($_GET['game'])){
	echo "<br><form mothod='GET'>
			<input style='display: none' name='game' value='true'>
			<input class='btn btn-primary' type='submit' value='EMPIEZA EL JUEGO'>
		</form>";
}

if (isset($_GET['game'])){
	innitGame();
	echo "
				<input name='save' class='btn btn-primary' type='submit' value='GUARDA PARTIDA'> <br><br>
				<input name='check' class='btn btn-primary' type='submit' value='COMPROVA'>
			</form>";

}

if (isset($_POST['save'])){
	$sudokuT = [[],[],[],[],[],[],[],[],[]];
	for ($x = 1; $x <= 9; $x++){
		for ($y = 1; $y <= 9; $y++){
			array_push($sudokuT[($x-1)], $_POST[$y . "-" . $x]);
		}
	}	
	$_SESSION['tabla'] = $sudokuT;
}

if (isset($_POST['check'])){
	$sudokuT = [[],[],[],[],[],[],[],[],[]];
	for ($x = 1; $x <= 9; $x++){
		for ($y = 1; $y <= 9; $y++){
			array_push($sudokuT[($x-1)], $_POST[$y . '-' . $x]);
		}
	}
	$_SESSION['tabla'] = $sudokuT;

	$sudokuS = 	[[0,3,5,4,1,6,9,2,7],
				[2,9,6,8,5,7,4,3,1],
				[4,1,7,2,9,3,6,5,8],
				[5,6,9,1,0,4,7,8,2],
				[1,2,3,6,7,8,5,4,9],
				[7,4,8,5,2,9,1,6,3],
				[6,5,0,7,8,1,3,9,4],
				[9,8,1,3,4,5,2,7,6],
				[3,7,4,9,6,2,8,0,5]];


	if (backTrackSolve($sudokuT,0,0)){
		echo "<h1>solucionable<h1>";
	}
	// if (isSolved($sudokuT)){
	// 	echo "<h1>CORRECTO!!<h1>";
	// }
}


?>


</body>
</html>