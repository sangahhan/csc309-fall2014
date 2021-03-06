
<h1>Game Area</h1>

<div>
    Hello <?= $user->fullName() ?>. 
</div>

<div id='status'> 

</div>

<div id="gameboard">
    <table>
        <tr class="detect-hover">
            <td data-index="0"></td>
            <td data-index="1"></td>
            <td data-index="2"></td>
            <td data-index="3"></td>
            <td data-index="4"></td>
            <td data-index="5"></td>
            <td data-index="6"></td>
        </tr>
        <tr id="row-0" data-index="0">

            <td data-index="0-0"></td>
            <td data-index="0-1"></td>
            <td data-index="0-2"></td>
            <td data-index="0-3"></td>
            <td data-index="0-4"></td>
            <td data-index="0-5"></td>
            <td data-index="0-6"></td>

        </tr>
        <tr id="row-1" data-index="1">
            <td data-index="1-0"></td>
            <td data-index="1-1"></td>
            <td data-index="1-2"></td>
            <td data-index="1-3"></td>
            <td data-index="1-4"></td>
            <td data-index="1-5"></td>
            <td data-index="1-6"></td>

        </tr>
        <tr id="row-2" data-index="2">
            <td data-index="2-0"></td>
            <td data-index="2-1"></td>
            <td data-index="2-2"></td>
            <td data-index="2-3"></td>
            <td data-index="2-4"></td>
            <td data-index="2-5"></td>
            <td data-index="2-6"></td>
        </tr>
        <tr id="row-3" data-index="3">
            <td data-index="3-0"></td>
            <td data-index="3-1"></td>
            <td data-index="3-2"></td>
            <td data-index="3-3"></td>
            <td data-index="3-4"></td>
            <td data-index="3-5"></td>
            <td data-index="3-6"></td>
        </tr>
        <tr id="row-4" data-index="4">
            <td data-index="4-0"></td>
            <td data-index="4-1"></td>
            <td data-index="4-2"></td>
            <td data-index="4-3"></td>
            <td data-index="4-4"></td>
            <td data-index="4-5"></td>
            <td data-index="4-6"></td>
        </tr>
        <tr id="row-5" data-index="5">
            <td data-index="5-0"></td>
            <td data-index="5-1"></td>
            <td data-index="5-2"></td>
            <td data-index="5-3"></td>
            <td data-index="5-4"></td>
            <td data-index="5-5"></td>
            <td data-index="5-6"></td>
        </tr>

    </table>
</div>



<?php 
/*
echo form_textarea('conversation');
echo form_open();
echo form_input('msg');
echo form_submit('Send','Send');
echo form_close();
*/
?>
<script src="<?= js_url('connect4.gameplay.js') ?>"></script>
<script>
    var otherUser = "<?= $otherUser->login ?>";
    var user = "<?= $user->login ?>";
    var status = "<?= $status ?>";
    var playerId;

    // currentState.board: a 2-dimensional array for the current board
    //  each element represents a row
    //  where the leftmost item is at the bottom
    var currentState = {
        board: [
        [0,0,0,0,0,0],
        [0,0,0,0,0,0],
        [0,0,0,0,0,0],
        [0,0,0,0,0,0],
        [0,0,0,0,0,0],
        [0,0,0,0,0,0],
        [0,0,0,0,0,0]
        ],
        player_turn: null
    };



    function updateBoard(rowNum) {

        var rowIndex = rowNum;
            // grab cells st col == data index as the recently clicked cell
            var col = $('td[data-index$="-'+rowIndex+'"]');    
            var pieceClass = 
                currentState.player_id == 1 ? 'red-piece' : 'yellow-piece';
            var topPiece = col.first();
            var bottomPiece = col.last();

            if(topPiece.hasClass('yellow-piece') || 
                topPiece.hasClass('red-piece')){
                alert("This column is full!");
            } else { 
                var url = "<?= site_url('board/drop_disc_in_column') ?>";
                console.log(rowIndex);
                $.post(url, {'column_num':rowIndex }, 
                    function (data,textStatus,jqXHR){
                        if (!bottomPiece.hasClass('yellow-piece') && 
                            !bottomPiece.hasClass('red-piece')){           
                            bottomPiece.addClass(pieceClass);                
                        } else {
                            renderBoard("#gameboard", currentState.board); 
                        }
                    }, 
                    function(data) {
                        alert(ERR_INVALID_MOVE);
                    }
                );

                
            }

        }

        $(function(){
        // begin timer
        $('body').everyTime(200,function(){
            if (status == 'waiting') {
                $.getJSON('<?= site_url('arcade/checkInvitation') ?>',
                    function(data, text, jqZHR){
                        if (data && data.status=='rejected') {
                            alert("Sorry, your invitation was declined!");
                            window.location.href =
                                 "<?= site_url('arcade/index');?>";
                        }
                        if (data && data.status=='accepted') {
                            status = 'playing';
                        }

                    }
                );

            }

            $.getJSON("<?= site_url('board/getBoard');?>", 
                function (data,text,jqXHR){
                    if (data) {
                        if (data.status=='success'){


                            
                            // update the board if the one we get is different 
                            // from the one we have
                       
                            //if (data.player_turn != currentState.player_turn){

                                renderBoard('#gameboard', currentState.board);
                            //}
                                  currentState = data;
                                  var currentPlayerString = "your";
                                  if (currentState.player_turn != currentState.player_id ) {
                                    currentPlayerString = otherUser + "'s";
                                  }
                                  $('#status').html(
                                'You are Player ' + currentState.player_id + 
                                '. You are playing ' + otherUser + 
                                '. <br/>It is '+ currentPlayerString + ' turn.');
                            // if the game is active
                            if (currentState.win_status != STATE_ACTIVE){
                                if (currentState.win_status == STATE_TIE) {
                                    alert("Tie game!");
                                } else if (isWinner(currentState.win_status, 
                                    currentState.player_id)) {
                                    alert("You won!");
                                } else {
                                    alert("You lost!");
                                }
                                var url = "<?= site_url('board/end_game') ?>";
                                 $.post(url);
                                window.location.href = 
                                    "<?= site_url('arcade/index');?>";
                            }

                        } else {
                           $.getJSON('<?= site_url('arcade/checkInvitation') ?>',
                                function(data, text, jqZHR){
                                    if (data && data.status=='rejected') {
                                        alert("Sorry, your invitation was declined!");
                                        window.location.href =
                                             "<?= site_url('arcade/index');?>";
                                    }
                                    else if (data && data.status=='accepted') {
                                        status = 'playing';
                                    
                                    } else {
                                        alert(data.message);
                                    }

                                }
                            );
                        }    
                    }
                }
            );
        });

        $('tr.detect-hover td').click(function(){
            if (currentState.player_turn == currentState.player_id ) {
                updateBoard($(this).attr('data-index'), currentState.player_id);
                renderBoard('#gameboard', currentState.board);
            } else {
                alert(ERR_OUT_OF_TURN);
            }
        });
    });




</script>
