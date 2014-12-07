<?php


if (!function_exists('is_player_1()')){
    /*
    * Given a board and a player, return TRUE iff the player has the current
    * turn in the board.
    */
    function is_player_turn($player, $board){
        if ($board->player_turn != $player){
            return FALSE;
        }
        return TRUE;
    }
}

if (!function_exists('is_player_1()')){
    /*
     * Takes a match object and a user object and returns whether the user
     * is player 1 or player 2 in the match.
     */
    function is_player_1($match, $user){
        if ($match->user1_id == $user->id) {
                return TRUE;
        } else {
                return FALSE;
        }
    }
}
