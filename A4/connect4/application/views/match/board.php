
<h1>Game Area</h1>

<div>
    Hello <?= $user->fullName() ?>  <?= anchor(site_url('account/logout'),'(Logout)') ?>  
</div>

<div id='status'> 
    <?php 
    if ($status == "playing")
      echo "Playing " . $otherUser->login;
  else
      echo "Wating on " . $otherUser->login;
  ?>
</div>

<div id="gameboard">
    <table>
        <tr class="detect-hover">
            <td data-index="1"></td>
            <td data-index="2"></td>
            <td data-index="3"></td>
            <td data-index="4"></td>
            <td data-index="5"></td>
            <td data-index="6"></td>
            <td data-index="7"></td>
        </tr>
        <tr id="row-1" data-index="1">
            <td data-index="1-1"></td>
            <td data-index="1-2"></td>
            <td data-index="1-3"></td>
            <td data-index="1-4"></td>
            <td data-index="1-5"></td>
            <td data-index="1-6"></td>
            <td data-index="1-7"></td>
        </tr>
        <tr id="row-2" data-index="2">
            <td data-index="2-1"></td>
            <td data-index="2-2"></td>
            <td data-index="2-3"></td>
            <td data-index="2-4"></td>
            <td data-index="2-5"></td>
            <td data-index="2-6"></td>
            <td data-index="2-7"></td>
        </tr>
        <tr id="row-3" data-index="3">
            <td data-index="3-1"></td>
            <td data-index="3-2"></td>
            <td data-index="3-3"></td>
            <td data-index="3-4"></td>
            <td data-index="3-5"></td>
            <td data-index="3-6"></td>
            <td data-index="3-7"></td>
        </tr>
        <tr id="row-4" data-index="4">
            <td data-index="4-1"></td>
            <td data-index="4-2"></td>
            <td data-index="4-3"></td>
            <td data-index="4-4"></td>
            <td data-index="4-5"></td>
            <td data-index="4-6"></td>
            <td data-index="4-7"></td>
        </tr>
        <tr id="row-5" data-index="5">
            <td data-index="5-1"></td>
            <td data-index="5-2"></td>
            <td data-index="5-3"></td>
            <td data-index="5-4"></td>
            <td data-index="5-5"></td>
            <td data-index="5-6"></td>
            <td data-index="5-7"></td>
        </tr>
        <tr id="row-6" data-index="6">
            <td data-index="6-1"></td>
            <td data-index="6-2"></td>
            <td data-index="6-3"></td>
            <td data-index="6-4"></td>
            <td data-index="6-5"></td>
            <td data-index="6-6"></td>
            <td data-index="6-7"></td>
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

    // board: a 2-dimensional array for the board
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
        ]
    };



    function updateBoard(row) {
        //  TODO: change this to drop the piece in the board based on calls to backend
            var rowIndex = row.attr('data-index');
            // grab cells st col == data index as the recently clicked cell
            var col = $('td[data-index$="-'+rowIndex+'"]');    
            var pieceClass = currentState.player_id == 1 ? 'red-piece' : 'yellow-piece';
            var topPiece = col.first();
            var bottomPiece = col.last();

            if(topPiece.hasClass('yellow-piece') || topPiece.hasClass('red-piece')){
                alert("This column is full!");
            } else { 
                var url = "<?= site_url('board/drop_disc_in_column') ?>";

                $.post(url, {'column_num':rowIndex}, function (data,textStatus,jqXHR){
                    if (!bottomPiece.hasClass('yellow-piece') && !bottomPiece.hasClass('red-piece')){           
                        bottomPiece.addClass(pieceClass);                
                    } else {
                        addPiece(col, pieceClass);        
                    }
                }, function(data) {
                    alert(ERR_INVALID_MOVE);
                });

                
            }

    }

    $(function(){
        // begin timer
        renderBoard('#gameboard', currentBoard);
        $('body').everyTime(2000,function(){
            if (status == 'waiting') {
                $.getJSON('<?= site_url('arcade/checkInvitation') ?>',function(data, text, jqZHR){
                    if (data && data.status=='rejected') {
                        alert("Sorry, your invitation to play was declined!");
                        window.location.href = "<?= site_url('arcade/index');?>";
                    }
                    if (data && data.status=='accepted') {
                        status = 'playing';
                        $('#status').html('Playing ' + otherUser);
                    }

                });
            }

            $.getJSON("<?= site_url('board/getBoard');?>", 
                function (data,text,jqXHR){
                    if (data) {
                        if (data.status=='success'){
                            currentState = data;
                            renderBoard('#gameboard', currentState.board);
                        } else {
                            alert(data.message);
                        }    
                    }
                });
        });

        $('tr.detect-hover td').click(function(){
            if (currentState.player_turn == <?= $user->id ?>) {
               updateBoard($(this), currentState.player_id);
            } else {
                alert(ERR_OUT_OF_TURN);
            }
        });
    });




</script>
