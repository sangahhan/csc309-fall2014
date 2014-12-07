function updateBoard(row) {
    //  TODO: change this to drop the piece in the board based on calls to backend
        var rowIndex = row.attr('data-index');
        // grab cells st col == data index as the recently clicked cell
        var col = $('td[data-index$="-'+rowIndex+'"]');    
        var topPiece = col.first();
        var bottomPiece = col.last();

        if(topPiece.hasClass('yellow-piece') || topPiece.hasClass('red-piece')){
            alert("This column is full!");
        } else if (!bottomPiece.hasClass('yellow-piece') && !bottomPiece.hasClass('red-piece')){           
                bottomPiece.addClass('red-piece');    
                newItem=bottomPiece;                
        } else {
            addPiece(col);        
        }

}


$.fn.reverse = [].reverse;

function addPiece(col){    
    var colReversed = col.reverse();
    
    colReversed.each(function(){
        if(!$(this).hasClass('red-piece') && !$(this).hasClass('yellow-piece')){        
                $(this).addClass('red-piece');
                newItem=$(this);                
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