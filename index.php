<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php

$sudokuS = 	[[8,3,5,4,1,6,9,2,7],
			 [2,9,6,8,5,7,4,3,1],
			 [4,1,7,2,9,3,6,5,8],
			 [5,6,9,1,3,4,7,8,2],
			 [1,2,3,6,7,8,5,4,9],
			 [7,4,8,5,2,9,1,6,3],
			 [6,5,2,7,8,1,3,9,4],
			 [9,8,1,3,4,5,2,7,6],
			 [3,7,4,9,6,2,8,1,5]];

function no_dupes(array $input_array) {
    return count($input_array) === count(array_flip($input_array));
}

function isSolved($sudoku){
	for ($ele=0; $ele < 9; $ele++){
		$row = [];
		$col = [];

		$row = $sudoku[$ele]; 
		for ($i = 0; $i < 9; $i++){
			array_push($col, $sudoku[$ele][$i]);
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
        		array_push($block, $sudoku[$x][$y]);	
        	}
        }
        if (!no_dupes($block)){
        	return false;
        }
	}
	return true;
}
function createTable($sudoku){
    echo "<table>";
    for($i = 1;$i<=9;$i++){
        echo "<tr>";
            for($j =1; $j<=9;$j++){
            	echo "<td name='".$i."-".$j."'>";
            	if ($sudoku[$i-1][$j-1]!==0){
            		echo $sudoku[$i-1][$j-1];
            	} else {
            		echo "                
	                <select name='s".$i."-".$j."'>
					    <option disabled selected></option>
					    <option value='1'>1</option>
					    <option value='2'>2</option>
					    <option value='3'>3</option>
					    <option value='4'>4</option>
					    <option value='5'>5</option>
					    <option value='6'>6</option>
					    <option value='7'>7</option>
					    <option value='8'>8</option>
					    <option value='9'>9</option>
					</select>";
				}
                echo "</td>";
            }
        echo "</tr>";
    }
    echo "</table>";
}
function createSudoku(){
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
	while ($numSeted < 25){
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
       	// if ($cont==0){
       	// 	echo $sudoku[$randX][$randY];
       	// 	if ($sudoku[$randX][$randY] !== 0){
        // 		echo "amogus";
        // 	} else {
        // 		echo "sugoma";
        // 	}
        // 	return "asd";
       	// }
        
		if ($sudoku[$randX][$randY] == 0 && !in_array($randN, $row) && !in_array($randN, $col) && !in_array($randN, $quadrant)){
			$sudoku[$randX][$randY] = $randN;
			$numSeted++;
		} 
	}
	return $sudoku;
}


createTable(createSudoku());

?>

</body>
</html>