<?php
class Match  {
	const ACTIVE = 1;
	const U1WON = 2;
	const U2WON = 3;

	public $id;

	public $user1_id;
	public $user2_id;

	public $match_status_id = self::ACTIVE;

	public $board_state;

	public function new_game(){
		$board = new Board();
		$board->initialize_board();

		$this->board_state = serialize($board);
	}

	/*
	 * Given a board and a player, return TRUE iff the player has the current
	 * turn in the board.
	 */
	private function is_player_turn($player, $board){
		if ($board->player_turn != $player){
			return FALSE;
		}

		return TRUE;
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
	 * Given a player id and a
	 *
	 */
	public function drop_disc_in_column($player, $column_num){

		if ($this->match_status_id == self::ACTIVE){
			$board = unserialize($this->board_state);

			if (!is_player_turn($player, $board)){ return; }

			if ($column_num < 7){
				if(count($board->board[$column_num]) < 6){
					$board->board[$column_num][] = $player;
				}
			} else {
				return;
			}

			$this->board_state = serialize($board);

		}

		return;
	}

	/*
	 * Return TRUE if the given move resulted in a consecutive count of four
	 * or more discs.
	 */
	public function get_game_status($last_move){
		$board_obj = unserialize($this->board_state);
		$board = $board_obj->board;

		$row = count($board[$last_move]);

		// The way we have it set up, we go in opposite directions the shown
		// direction.
		$directions = array( array('row' => 0, 'col' => 1), // Horizontal
							array('row' => 1, 'col' => 0),	// Vertical
							array('row' => 1, 'col' => 1),	// Right diagonal
							array('row' => 1, 'col' => -1));// Left diagonal


		for ($i = 0; $i < 4; $i++){
			$count = 0;

			$count = count_in_direction($direction[$i], $row, $column, $board);

			$direction[$i]['row'] = $direction[$i]['row'] * -1;
			$direction[$i]['col'] = $direction[$i]['col'] * -1;

			$count = $count
					+ count_in_direction($direction[$i], $row, $column, $board)
					+ 1;

			if ($count >= 4){
				return TRUE;
			}
		}

		return FALSE;
	}

	/*
	 * Given a direction, a row an a column position of a disc as well as
	 * a board, return how many consecutive discs of type $board[$column][$num]
	 * are placed in the given direction.
	 *
	 */
	public function count_in_direction($direction, $row, $column, $board){

		$playing = $board[$column][$row];

		$steps = 0;
		$count = 0;
		for ($steps = 0; $steps < 3; $steps ++){
			$next_row = $row + $direction['row'];
			$next_column = $coulmn + $direction['col'];

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
		}

		return $count;
	}
}