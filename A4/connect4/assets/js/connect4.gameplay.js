$.fn.reverse = [].reverse;

    function addPiece(col, pieceClass){    
        var colReversed = col.reverse();
        
        colReversed.each(function(){
            if(!$(this).hasClass('red-piece') && !$(this).hasClass('yellow-piece')){        
                    $(this).addClass(pieceClass);               
                    return false;                    
            }        
        });

    }



function renderBoard(div_selector, board) {

    for (var i = 0; i < board.length; i++) {
        var col = $(div_selector + ' td[data-index$="-'+ (i + 1) +'"]').reverse(); 
        col.each(function(index, cell){
            if (currentBoard[i][index] == 1) {
                $(this).addClass('red-piece');
            } else if (currentBoard[i][index] == 2)
            $(this).addClass('yellow-piece'); 
        });
    } 
}