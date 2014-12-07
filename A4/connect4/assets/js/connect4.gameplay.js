$.fn.reverse = [].reverse;

var ERR_INVALID_MOVE = "This move is invalid.";
var ERR_OUT_OF_TURN = "It's not your turn.";

var STATE_ACTIVE = 1;
var STATE_U1WIN = 2;
var STATE_U2WIN = 3;
var STATE_TIE = 4;

/*
 * Check if the player with the given id is the winner at a given game state.
 */
function isWinner(state, player_id) {
    return (state == 4) || (state == 3 && player_id == 2) || (state == 2 && player_id == 1);
}


/* 
 * Given an array of jQuery objects that represent a column, update its 
 * class to be pieceClass.
 */
function addPiece(col, pieceClass){    
    var colReversed = col.reverse();
    
    colReversed.each(function(){
        if(!$(this).hasClass('red-piece') && !$(this).hasClass('yellow-piece')){        
            $(this).addClass(pieceClass);               
            return false;                    
        }        
    });

}

/* 
 * Given a div with the properly structured table, display it as a board using
 * the contents of the given board.
 */
function renderBoard(divSelector, board) {

    for (var i = 0; i < board.length; i++) {
        var col = $(divSelector + ' td[data-index$="-'+ i +'"]').reverse(); 
        col.each(function(index, cell){
            console.log(board[i][index]);
            if (board[i][index] == 1) {
                
                $(this).addClass('red-piece');
            } else if (board[i][index] == 2) {
                $(this).addClass('yellow-piece'); 
            }
        });
    } 
}

function getBoard(getBoardURL, arcadeURL, gameboardSelector, currentState) {

    $.getJSON(getBoardURL, 
                function (data,text,jqXHR){
                    if (data) {
                        if (data.status=='success'){
                            // update the board if the one we get is different 
                            // from the one we have
                            if (data.player_turn != currentState.player_turn)
                                renderBoard(gameboardSelector, currentState.board);
                            currentState = data;
                           
                            // if the game is not active
                            if (currentState.win_status != STATE_ACTIVE){
                                if (currentState.win_status == STATE_TIE) {
                                    alert("Tie game!");
                                } else if (isWinner(currentState.win_status, 
                                    currentState.player_id)) {
                                    alert("You won!");
                                } else {
                                    alert("You lost!");
                                }
                                window.location.href = arcadeURL;
                            }

                        } else {
                            alert(data.message);
                        }    
                    }
                }
            );
}