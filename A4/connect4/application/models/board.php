<?php
class Board {

    // initially it wil be player 1's turn. This will change as the
    // game progresses.
    public $player_turn = 1;


    // The board will be a 2D array. Each sub array will represent a column.
    public $board = array();

    /*
     * Create an empty board with 7 columns
     */
    public function initialize_board() {
        for ($i = 0; $i < 7; $i++) {
            $this->board[] = array();
        }
    }
}
