//Below are a list of the variables to be set at the start of the programm, these are edited in methods. 
var balance = 0 
var noOfRounds = 0 
var roundScore = 0 
var dice = []
var noOfDice = 3 
var caseNo = "case"
var avScore = 0

/**
 * Creates a random number repesenting the roll of a dice 
 * @return an integer between 1-6 representing a dice roll
 * 
 */

function roll() {
    a = Math.floor(Math.random()*6)+1
    return a
}

/**
 * Creates an array of length chosen by noOfDice, which include the values of the roll represention for the dice.
 * @param noOfDice the integer value of number of dice chosen between 3-6 
 * @return  an array, "dice" which represents the dice value for that roll 
 */
function diceValues (noOfDice) { 
    for (i=0 ; i < noOfDice ; i++ )
        dice[i] = roll() 
        return dice
}
/**
 * sorts the dice array so they are in numerical order. 
 * this method works as dice are between one and six so you dont have to worry about the unicode issue (i.e. it would sort [1,24,11,3,4] as [1,11,24,3,4]
 * @param  Dice as the array to be sorted 
 * @return  dice, the sorted array  
 */
function sortDice (dice) { 
    dice  = dice.sort()
    return dice 
}

/**
 * checks whether or not the dice fulfil the first win case.
 * @param array the sorted dice are inputed
 * @return true or false as to whether these dice fit this case. 
 */

function case1 (array){

    for (i = 0; i<array.length -1; i++ ){

        if (array[i] == array[i+1]){
            value = true}
        else {
            value = false 
            break} 
        }
    return value 
}


/**
 * checks whether or not the dice fulfil the second win case where the diffrent die has a grater value then the rest.
 * @param array the sorted dice are inputed
 * @return true or false as to whether these dice fit this case. 
 */
function case2a (array){

    for (i = 0; i<array.length -2; i++ ){

        if (array[i] == array[i+1]){
            value = true}
        else {
            value = false 
            break} 
        }
    return value 
    }
/**
 * checks whether or not the dice fulfil the second win case where the diffrent die has a smaller value then the rest.
 * @param array the sorted dice are inputed
 * @return true or false as to whether these dice fit this case. 
 */
function case2b (array){

    for (i = 1; i<array.length -1; i++ ){

        if (array[i] == array[i+1]){
            value = true}
        else {
            value = false 
            break} 
        }
    return value 
    }

/**
 * checks whether or not the dice fulfil the third win case.
 * @param array the sorted dice are inputed
 * @return true or false as to whether these dice fit this case. 
 */
function case3 (array){

    for (i = 0; i<array.length -1; i++ ){

        if (array[i] == array[i+1]-1){
            value = true}
        else {
            value = false 
            break} 
        }
    return value 
    }

/**
 * checks whether or not the dice fulfil the fourth win case.
 * @param array the sorted dice are inputed
 * @return true or false as to whether these dice fit this case. 
 */
function case4 (array){

    for (i = 0; i<array.length -1; i++ ){

        if (array[i] == array[i+1]){
            value = false 
            break}
        else {
            value = true
            } 
        }
    return value 
    }

/**
 * calculates the sum of the given array (used to calculate the sum of the dice).
 * @param array the sorted dice are inputed
 * @return returns the sum of the values in the array
 */
function adds(array) { 
    sum = 0 
    for (i = 0; i<array.length; i++ ){
        sum = sum + array[i]
    }
    return sum 

}

/**
 * uses the above cases to decide which case has been chosen and calculates the score for the round
 * @param array the sorted dice are inputed
 * @return round score, the score for the round 
 * @returns caseNo the case in which the dice fullfilled, returns string stating outcome. 
 */

function run (array){ 

    roundScore = 0 
    if (case1(array) == true) {
        roundScore = 60 + adds(array)
        caseNo = "All the same!"
    }
    else if (case2a(array) == true|| case2b(array) == true){
        roundScore = 40 + adds(array)
        caseNo = "All but one the same!"
    }
    else if (case3(array) == true) {
        roundScore = 20 + adds(array)
        caseNo = "A run!" 
    }
    else if (case4(array) == true) {
        roundScore = adds(array)
        caseNo = "No repeats!"
    }
    else {
        roundScore = 0
        caseNo = "Unlucky, no points!"

    }
    return { 
        roundScore : roundScore,
        caseNo : caseNo

    }
}
/**
 * updates the scores and the number of rounds
 * @return balance, the total points scored so far 
 * @return noOfRounds that have been played so far 
 */
function update () { 
    noOfRounds ++ 
    balance = balance + roundScore 
    return balance , noOfRounds
}

/**
 * calculates the average score of all the rounds, 
 * @return balance, the total points scored so far 
 * @return noOfRounds that have been played so far 
 */
function averageScore () { 
    avScore = balance / noOfRounds
    avScore = avScore.toFixed(1)
    return avScore
}

/**
 * onclick used to open the section "Instruction" with the instructions in 
 */
function openInstruction(){
    document.getElementById("instructions").style.display = "block"
    document.getElementById("instructionButton").style.display = "none"
}
/**
 * onclick used to close the section "Instruction" with the instructions in 
 */
function closeInstruction(){
    document.getElementById("instructions").style.display = "none"
    document.getElementById("instructionButton").style.display = "block"
}

/**
 * used to display the table used in the "main" section, in the phase "play"  
 */
function displayTable() { 
    document.getElementById("tdRound").innerHTML = noOfRounds
    document.getElementById("tdScore").innerHTML = roundScore
    document.getElementById("tdTotalScore").innerHTML = balance
}


/**
 * this is used to represent the dice array in image format. to be used in main section in the phase "play". 
 * Represents 6 sided dice.
 * @input array of the dice to be represented 
 * 
 */

function imgSelect (array){
    for (i=0; i < array.length; i++ ){  
        switch(dice[i]){
            case 1: 
                document.getElementById("dice"+i).innerHTML = "<img src= 'diceOne.png' alt = 'Image of dice value one' >"
                break 
            case 2: 
                document.getElementById("dice"+i).innerHTML = "<img src= 'diceTwo.png' alt = 'Image of dice value two' >"
                break 
            case 3: 
                document.getElementById("dice"+i).innerHTML = "<img src= 'diceThree.png' alt = 'Image of dice value three' >"
                break
            case 4: 
                document.getElementById("dice"+i).innerHTML = "<img src= 'diceFour.png' alt = 'Image of dice value four' >"
                break 
            case 5: 
                document.getElementById("dice"+i).innerHTML = "<img src= 'diceFive.png' alt = 'Image of dice value five' >"
                break 
            case 6: 
                document.getElementById("dice"+i).innerHTML = "<img src= 'diceSix.png' alt = 'Image of dice value six' >"
                break 
        }
    }
}

/**
 * occlick submits the form "startForm"
 * this is used start the game onclick of the the button "startButton"
 * it runs the game using the above function and clears the setup screen. 
 * this is the start of the play phase 
 * it also checks for errors in the input for "noOfDice"
 * 
 */

function start(){
    noOfDice = document.getElementById("noOfDice").value
    if ( /^[3-6]$/.test(noOfDice)) { 
        document.getElementById("startForm").style.display="none"
        document.getElementById("play").style.display ="block"
        dice = diceValues(noOfDice)
        dice = sortDice(dice)
        imgSelect(dice)
        run(dice)
        update(dice)
        displayTable() 
        document.getElementById("outcome").innerHTML = caseNo
    }
    else { 
        document.getElementById("error").innerHTML = "Please input a number between 3 and 6 "
    }
}
/**
 * occlick submits the form "startForm"
 * this is used reroll the game onclick of the the button "rerollButton"
 * it reruns the game, updating the points and round information. 
 * continuation of play phase 
 * 
 */
function rollAgain () { 
    dice = diceValues(noOfDice)
    dice = sortDice(dice)
    imgSelect(dice)
    run(dice)
    update(dice)
    displayTable() 
    document.getElementById("outcome").innerHTML = caseNo

}
/**
 * This ends the game and clears the "play" phase 
 * starts the end phase
 * used onclick of the "quitButton"
 * shows the end phase information including 
 * a button to play again 
 * a table with the information from so far including average points, total points and number of rounds
 * 
 */
function end () { 
    averageScore() 
    document.getElementById("td2Round").innerHTML = noOfRounds
    document.getElementById("td2TotalScore").innerHTML = balance
    document.getElementById("tdAveScore").innerHTML = avScore
    document.getElementById("play").style.display ="none"
    document.getElementById("end").style.display="block"

}
/**
 * used to clear the dice used in the previous game
 */
function diceClear () { 
    for (i = 0; i < 6; i++ ){
        document.getElementById("dice"+i).innerHTML = ""
    }

}
/**
 * This restarts the game and brings you back to the setup stage. 
 * restarts values to how they are at the start of the game
 * onclick of "playAgain" button 
 */
function restart() { 
    balance = 0 
    noOfRounds = 0
    roundScore = 0 
    noOfDice = 0 
    dice = [] 
    diceClear()
    document.getElementById("startForm").style.display="block"
    document.getElementById("end").style.display="none"

}