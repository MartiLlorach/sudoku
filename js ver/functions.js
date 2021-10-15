function limiter(input) {
    if (input.value < 1) input.value = '';
    if (input.value > 9) input.value = '';
}

function inArray(array, ele){
    if (array.indexOf(ele)==-1){
        return false;
    } return true;
}

function hasDuplicates(arr) {
    return new Set(arr).size !== arr.length;
}

function countInArray(array, what) {
    var count = 0;
    for (var i = 0; i < array.length; i++) {
        if (array[i] === what) {
            count++;
        }
    }
    return count;
}

function isSolvable(sudoku, rowNum, colNum){
    let row = sudoku[rowNum];
    let col = [];
    for (let index = 0; index < 9; index++) {
        col.push(sudoku[index][colNum]);
    }
    let block = [];
    let bX = Math.floor(colNum / 3);
    let bY = Math.floor(rowNum / 3);
    let startX = bX * 3;
    let startY = bY * 3;
    for (let blockY = startY; blockY < startY+3; blockY++){
        for (let blockX = startX; blockX < startX+3; blockX++){
            block.push(sudoku[blockY][blockX]);
        }
    }

    if (sudoku[rowNum][colNum]!=''){
        let num = sudoku[rowNum][colNum] + '';
        if (countInArray(row, num)==1 && countInArray(row, num)==1 && countInArray(row, num)==1){
            if (rowNum==8 && colNum==8){
                return true;
            } else if (colNum>7){
                if (isSolvable(sudoku, (rowNum+1), 0)) return true;
            } else {
                if (isSolvable(sudoku, rowNum, (colNum+1))) return true;
            }
        }
        return false;
    }

    for (let i = 1; i <= 9; i++) {
        i = i + '';
        if (!inArray(row, i) && !inArray(col, i) && !inArray(block, i)){
            sudoku[rowNum][colNum] = i;
            if (rowNum==8 && colNum==8){
                return true;
            }
            if (colNum>7){
                if (isSolvable(sudoku, (rowNum+1), 0)){
                    return true;
                }
            } else {
                if (isSolvable(sudoku, rowNum, (colNum+1))){
                    return true;
                }
            }
            sudoku[rowNum][colNum] = '';
        }
    }
    return false;    
}

function solveSudoku(sudoku, rowNum, colNum){
    let row = sudoku[rowNum];
    let col = [];
    for (let index = 0; index < 9; index++) {
        col.push(sudoku[index][colNum]);
    }
    let block = [];
    let bX = Math.floor(colNum / 3);
    let bY = Math.floor(rowNum / 3);
    let startX = bX * 3;
    let startY = bY * 3;
    for (let blockY = startY; blockY < startY+3; blockY++){
        for (let blockX = startX; blockX < startX+3; blockX++){
            block.push(sudoku[blockY][blockX]);
        }
    }

    if (sudoku[rowNum][colNum]!=''){
        let num = sudoku[rowNum][colNum] + '';
        if (countInArray(row, num)==1 && countInArray(row, num)==1 && countInArray(row, num)==1){
            if (rowNum==8 && colNum==8){
                printSudoku(sudoku)
                return true;
            } else if (colNum>7){
                if (solveSudoku(sudoku, (rowNum+1), 0)) return true;
            } else {
                if (solveSudoku(sudoku, rowNum, (colNum+1))) return true;
            }
        }
        return false;
    }

    for (let i = 1; i <= 9; i++) {
        i = i + '';
        if (!inArray(row, i) && !inArray(col, i) && !inArray(block, i)){
            sudoku[rowNum][colNum] = i;
            if (rowNum==8 && colNum==8){
                printSudoku(sudoku)
                return true;
            }
            if (colNum>7){
                if (solveSudoku(sudoku, (rowNum+1), 0)){
                    return true;
                }
            } else {
                if (solveSudoku(sudoku, rowNum, (colNum+1))){
                    return true;
                }
            }
            sudoku[rowNum][colNum] = '';
        }
    }
    return false;       
}

function trySolveSudoku(){
    if (!solveSudoku(getSudoku(),0,0)){
        document.getElementsByTagName('p')[0].innerHTML = "NO TE SOLUCIÓ";
    } else{
        document.getElementsByTagName('p')[0].innerHTML = "SOLUCIÓ";
    }
}

function tryIsSolvable(){
    if (isSolvable(getSudoku(),0,0)){
        document.getElementsByTagName('p')[0].innerHTML = "TE SOLUCIÓ";
    } else{
        document.getElementsByTagName('p')[0].innerHTML = "NO TE SOLUCIÓ";
    }
}

function isSolved(sudoku){
    for (let y = 0; y < 9; y++) {
        let row = sudoku[y];
        let col = [];
        
        for ( let x = 0; x < 9; x++){
            if (sudoku[x][y]=='') return false; 
            col.push(sudoku[x][y]);
        }
       
        let block = [];
        let startX = Math.floor(y / 3) * 3;
        let startY = (y % 3) * 3;
        for (let blockY = startY; blockY < startY+3; blockY++){
            for (let blockX = startX; blockX < startX+3; blockX++){
                block.push(sudoku[blockY][blockX]);
            }
        }
        if (hasDuplicates(row) || hasDuplicates(col) || hasDuplicates(block)) return false;
    }
    return true;
}

function createSudoku(){
    sudoku =   [['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', ''], 
				['', '', '', '', '', '', '', '', '']];
    let numSetted = 0;
    let solvable = false;
    while (!solvable){
        while (numSetted < 20) {
            let randX = Math.floor(Math.random() * 9);
            let randY = Math.floor(Math.random() * 9);
            let randNum = Math.floor(Math.random() * 9)+1;
            if (sudoku[randY][randX]==''){
                let row = sudoku[randY];
                let col = [];
                for (let index = 0; index < 9; index++) {
                    col.push(sudoku[index][randX]);
                }

                let block = [];
                let bX = Math.floor(randX / 3);
                let bY = Math.floor(randY / 3);
                let startX = bX * 3;
                let startY = bY * 3;

                for (let y = startY; y < startY+3; y++) {
                    for (let x = startX; x < startX+3; x++){
                        block.push(sudoku[y][x]);
                    }
                }

                if (!inArray(row, randNum) && !inArray(col, randNum) && !inArray(block, randNum)){
                    sudoku[randY][randX] = randNum;
                    numSetted++;
                }
            }
        }
        let tempS = sudoku;
        if (isSolvable(tempS,0,0)){
            solvable = true;
        } else {
            console.log('intento fallido')
            numSetted = 0;
            sudoku=[['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', ''], 
                    ['', '', '', '', '', '', '', '', '']];
        }
    }
    return sudoku;
}

function printSudoku(sudoku){
    document.getElementsByTagName('p')[0].innerHTML = '';
    elements = document.getElementsByTagName("input");
    for (let index = 0; index < elements.length; index++) {
        const element = elements[index];
        element.removeAttribute("readonly");
        element.removeAttribute("class");
        element.value='';
    }

    for (let y = 0; y < sudoku.length; y++) {
        const row = sudoku[y];
        for (let x = 0; x < row.length; x++) {
            const num = row[x];
            let ele = document.getElementById(y + '' + x).firstChild
            if (num!='' && num>0) {
                let ele = document.getElementById(y + '' + x).firstChild
                ele.value = num;
                ele.setAttribute("readonly","");
                ele.setAttribute("class", "appInput");
            } else if(num<0) {
                ele.value =Math.abs(num);
                ele.setAttribute("class", "userInput");
            } else {
                ele.setAttribute("class", "userInput");
            }
        }
        
    }
}

function getSudoku(){
    let sudoku = [[],[],[],[],[],[],[],[],[]];
    for (let y = 0; y < 9; y++) {
        for (let x = 0; x < 9; x++) {
            let num = document.getElementById(y + '' + x).firstChild;
            let val = num.value;
            if (num.classList[0]=='userInput' && val!='') val = 0 - val;
            sudoku[y][x] = val;
        }
    }
    return sudoku;
}

function saveSudoku(){
    localStorage.setItem("sudoku", JSON.stringify(getSudoku()));
}

function loadSudoku(){
    printSudoku(JSON.parse(localStorage.getItem("sudoku")));
}
