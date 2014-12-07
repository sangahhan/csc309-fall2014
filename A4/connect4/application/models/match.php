<?php
class Match  {
	const ACTIVE = 1;
	const U1WON = 2;
	const U2WON = 3;
	const TIE = 4;

	public $id;

	public $user1_id;
	public $user2_id;

	public $match_status_id = self::ACTIVE;

	public $board_state;

	public function new_game(){

		$board = new GameBoard();
		$board->initialize_board();

		$this->board_state = serialize($board);
	}

	/*
	* Given a current player, switch the player_turn field of the board to
	* the other player.
	*/
	private function toggle_user_in_board($player, $board){

		if ($board->player_turn == 1){
			$board->player_turn = 2;
		} else {
			$board->player_turn = 1;
		}

	}

	/*
	 * Given a player id and a column number, add a piece belonging to the given player
	 * in the column.
	 * If it is not current player's turn in the board, return -1.
	 * If the column is full or out of bounds, return -2.
	 * If the piece was successfully placed, return 0.
	 */
	public function drop_disc_in_column($player, $column_num){

		if ($this->match_status_id == self::ACTIVE){
			$board = unserialize($this->board_state);

			if (!is_player_turn($player, $board)){ return -1; }

			if (($column_num < 7) && (count($board->board[$column_num]) < 6)){
				$board->board[$column_num][] = $player;
			} else {
				return -2;
			}

			$this->toggle_user_in_board($player, $board);
			$this->board_state = serialize($board);
		}

		return 0;
	}

	public function count_all_pieces(){
		$board_obj = unserialize($this->board_state);
		$board = $board_obj->board;

		$total_count = 0;
		for ($col = 0; $col < 7; $col ++){
			$total_count = $total_count + count($board[$col]);
		}

		return $total_count;

	}

	/*
	 * Given the last move made, return 1 if it created no win or tie.
	 * Return 4 if it created a tie or a 2 if created a win.
	 */
	public function get_match_status($last_move){
		$board_obj = unserialize($this->board_state);
		$board = $board_obj->board;

		$row = count($board[$last_move]) - 1;

		if (($this->count_all_pieces() + 1) >= 42){
			return 4;
		}

		// The way we have it set up, we go in opposite directions the shown
		// direction.
		$directions = array( array('row' => 0, 'col' => 1), // Horizontal
				array('row' => 1, 'col' => 0),	// Vertical
				array('row' => 1, 'col' => 1),	// Right diagonal
				array('row' => 1, 'col' => -1));// Left diagonal

		for ($i = 0; $i < 4; $i ++){
			$count = 0;

			$count = $this->count_discs_in_direction($directions[$i], $row, $last_move, $board);

			$directions[$i]['row'] = $directions[$i]['row'] * -1;
			$directions[$i]['col'] = $directions[$i]['col'] * -1;

			$count = $count
				+ $this->count_discs_in_direction($directions[$i], $row, $last_move, $board)
				+ 1;

			if ($count >= 4){
				return 2;
			}
		}

		return 1;
	}

	/*
	 * Given a direction, a row an a column position of a disc as well as
	 * a board, return how many consecutive discs of type $board[$column][$num]
	 * are placed in the given direction.
	 *
	 */
	public function count_discs_in_direction($direction, $row, $column, $board){

		$player = $board[$column][$row];

		$steps = 0;
		$count = 0;
		for ($steps = 0; $steps < 3; $steps ++){
			$next_row = $row + $direction['row'];
			$next_column = $column + $direction['col'];

			if (($next_column < 7 && $next_column >= 0) &&
				($next_row < count($board[$next_column]) && $next_row >= 0)){

				if($board[$next_column][$next_row] == $player){
					$count = $count + 1;
				} else {
					break;
				}
			} else {
				break;
			}

			$row = $next_row;
			$column = $next_column;
		}

		return $count;
	}
}