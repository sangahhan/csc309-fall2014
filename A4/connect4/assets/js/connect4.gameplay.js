function updateBoard(row) {
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
