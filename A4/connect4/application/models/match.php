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

			if (!is_player_turn($player, $board){ return; }

			if ($column_num < 7{
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

	public function get_game_status($last_move){
		$board_obj = unserialze($this->board_state);
		$board = $board_obj->board;

		$row = count($board[$last_move]);
		$player = $board[$last_move][$row];

		//TODO: The win logic.
		//return determine_win($row, $column, $player, $board);
		return FALSE;
	}
}