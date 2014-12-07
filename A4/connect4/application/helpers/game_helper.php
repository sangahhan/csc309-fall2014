<?php


if (!function_exists('is_player_turn()')){
    /*
    * Given a board and a player, return TRUE iff the player has the current
    * turn in the board.
    */
    function is_player_turn($player, $board){
        return $board->player_turn == $player;
    }
}

if (!function_exists('is_player_1()')){
    /*
     * Takes a match object and a user object and returns whether the user
     * is player 1 or player 2 in the match.
     */
    function is_player_1($match, $user){
        return $match->user1_id == $user->id; 
    }
}
