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

function isSolvable(sudoku, rowNum, colNum){

    

}
function solveSudoku(){


    
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
        let bX = Math.floor(randX / 3);
        let bY = Math.floor(randY / 3);
        let startX = bX * 3;
        let startY = bY * 3;

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

    while (numSetted < 20) {
        let randX = Math.floor(Math.random() * 8)+1;
        let randY = Math.floor(Math.random() * 8)+1;
        let randNum = Math.floor(Math.random() * 8)+1;

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
    return sudoku;
}

function printSudoku(sudoku){
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
