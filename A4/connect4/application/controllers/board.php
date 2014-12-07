<?php

class Board extends CI_Controller {

	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		session_start();
	}

	public function _remap($method, $params = array()) {
		// enforce access control to protected functions

		if (!isset($_SESSION['user']))
			redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again

                $this->load->model('user_model');
                $user = $_SESSION['user'];
                $user = $this->user_model->get($user->login);

                if (!($user->user_status_id == User::WAITING) &&
                                !($user->user_status_id == User::PLAYING))
                        redirect('arcade/index', 'refresh');

		return call_user_func_array(array($this, $method), $params);
	}


	function index() {
		$user = $_SESSION['user'];

		$this->load->model('user_model');
		$this->load->model('invite_model');
		$this->load->model('match_model');

		$user = $this->user_model->get($user->login);

		$invite = $this->invite_model->get($user->invite_id);

		if ($user->user_status_id == User::WAITING) {
			$invite = $this->invite_model->get($user->invite_id);
			$otherUser = $this->user_model->getFromId($invite->user2_id);
		}
		else if ($user->user_status_id == User::PLAYING) {
			$match = $this->match_model->get($user->match_id);
			if ($match->user1_id == $user->id)
				$otherUser = $this->user_model->getFromId($match->user2_id);
			else
				$otherUser = $this->user_model->getFromId($match->user1_id);
		}

		$data['user']=$user;
		$data['otherUser']=$otherUser;

		switch($user->user_status_id) {
		case User::PLAYING:
			$data['status'] = 'playing';
			break;
		case User::WAITING:
			$data['status'] = 'waiting';
			break;
		}

		load_view($this, 'match/board',$data);
	}

	function postMsg() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('msg', 'Message', 'required');

		if ($this->form_validation->run() == TRUE) {
			$this->load->model('user_model');
			$this->load->model('match_model');

			$user = $_SESSION['user'];

			$user = $this->user_model->getExclusive($user->login);
			if ($user->user_status_id != User::PLAYING) {
				$errormsg="Not in PLAYING state";
				goto error;
			}

			$match = $this->match_model->get($user->match_id);

			$msg = $this->input->post('msg');

			if ($match->user1_id == $user->id)  {
				$msg = $match->u1_msg == ''? $msg :  $match->u1_msg . "\n" . $msg;
				$this->match_model->updateMsgU1($match->id, $msg);
			}
			else {
				$msg = $match->u2_msg == ''? $msg :  $match->u2_msg . "\n" . $msg;
				$this->match_model->updateMsgU2($match->id, $msg);
			}

			echo json_encode(array('status'=>'success'));

			return;
		}

		$errormsg="Missing argument";

		error:
			echo json_encode(array('status'=>'failure','message'=>$errormsg));
	}

	function getMsg() {
		$this->load->model('user_model');
		$this->load->model('match_model');

		$user = $_SESSION['user'];

		$user = $this->user_model->get($user->login);
		if ($user->user_status_id != User::PLAYING) {
			$errormsg="Not in PLAYING state";
			goto error;
		}
		// start transactional mode
		$this->db->trans_begin();

		$match = $this->match_model->getExclusive($user->match_id);

		if ($match->user1_id == $user->id) {
			$msg = $match->u2_msg;
			$this->match_model->updateMsgU2($match->id,"");
		}
		else {
			$msg = $match->u1_msg;
			$this->match_model->updateMsgU1($match->id,"");
		}

		if ($this->db->trans_status() === FALSE) {
			$errormsg = "Transaction error";
			goto transactionerror;
		}

		// if all went well commit changes
		$this->db->trans_commit();

		echo json_encode(array('status'=>'success','message'=>$msg));
		return;

		transactionerror:
			$this->db->trans_rollback();

		error:
			echo json_encode(array('status'=>'failure','message'=>$errormsg));
	}


	/*
	 * If the current user is in a playing state, return a the game board,
	 * if the player is player 1 or player 2, the status of the game and
	 * the status of the request.
	 */
	function getBoard(){

		$this->load->model('match_model');
		$this->load->model('user_model');

		$user = $_SESSION['user'];

		$user = $this->user_model->get($user->login);


		$errormsg = "";
		if ($user->user_status_id != User::PLAYING) {
			$errormsg="Not in PLAYING state";
			goto error;
		}

		$match = $this->match_model->getExclusive($user->match_id);

		$player_id = is_player_1($match, $user)? 1 : 2;

		$win_status = $match->match_status_id;

		// TODO: If board is an object, has to return the proper field that
		// only includes the array.
		$board = unserialize($match->board_state);

		echo json_encode(array('status' => 'success',
			'win_status'=> $win_status,
			'board' => $board->board,
			'player_id' => $player_id,
			'player_turn' => $board->player_turn));
		return;

		error:
			echo json_encode(array('status'=>'failure','message'=>$errormsg));
	}


	/*
	 * Given a column number to which the user input a disc, return a the
	 * game board, the win state, the player id and the player turn of the
	 * match.
	 * The player has to be in the playing state and the match has to be active.
	 * The $column_num has to be confirmed as a valid move and only made in the
	 * user's turn. If any of the above conditions are not satisfied, return
	 * an error code with an appropriate error message.
	 */
	function drop_disc_in_column(){
		$this->load->model('user_model');
		$this->load->model('match_model');

		$user = $_SESSION['user'];
		$column_num = $this->input->post('column_num');

		$user = $this->user_model->get($user->login);
		if ($user->user_status_id != User::PLAYING) {
			$code = 401;
			$errormsg="Not in PLAYING state";
			goto error;
		}

		$this->db->trans_begin();

		$win_state;
		// Confirm that the match is still active.
		$match = $this->match_model->getExclusive($user->match_id);
		if ($match->match_status_id != Match::ACTIVE) {
			$errormsg = "The match has finished.";
			$code = 401;
			goto error;
		} else {
			$win_state = $match->match_status_id;
		}

		$player_id = is_player_1($match, $user)? 1 : 2;

		// Confirm that the player made a valid move.
		$move_state = $match->drop_disc_in_column($player_id, $column_num);
		if ($move_state < 0){
			$errormsg = ($move_state == -1)? "Not player turn." : "Invalid move";
			$code = 400;
			goto error;
		}

		// The player made a valid move. First we update the board to the
		// state after the player made the move. Then
		// we check if the move resulted in the player winning the match.
		// If it did, then we update the match state as well
		$this->match_model->updateBoard($match->id, $match->board_state);


		$win_state = $match->get_match_status($column_num);
		if ($win_state == 2){
			$win_state = is_player_1($match, $user)? Match::U1WON : Match::U2WON;
			$this->match_model->updateStatus($match->id, $win_state);
		} else if ($win_state == 4){
			$this->match_model->updateStatus($match->id, $win_state);
		}

		if ($this->db->trans_status() === FALSE) {
			$errormsg = "Transaction error";
			$code = 400;
			goto error;
		}

		$this->db->trans_commit();

		$board = unserialize($match->board_state);

		echo json_encode(array('status' => 'success',
			'win_status'=> $win_state,
			'board' => $board->board,
			'player_id' => $player_id,
			'player_turn' => $board->player_turn));

		return;

		error:
			$this->db->trans_rollback();
			
		echo json_encode(array('status' => 'failure',
			'message' => $errormsg,
			'code'  => $code));
	}

	function end_game(){
		// If the user is in playing state.
		$user = $_SESSION['user'];

		$this->load->model('user_model');
		$this->load->model('match_model');

		$user = $this->user_model->getExclusive($user->login);
		if ($user->user_status_id != User::PLAYING) {
			return True;
		}

		$this->db->trans_begin();

		// Confirm that the match is still active.
		$match = $this->match_model->getExclusive($user->match_id);

		$errormsg = "";
		if ($match->match_status_id == Match::ACTIVE) {
			$errormsg = "Cannot quit an existing game.";
			$code = 401;
			goto error;
		}

		$this->user_model->updateStatus($user->id, User::AVAILABLE);

		if ($this->db->trans_status() === FALSE)
			goto error;

		// if all went well commit changes
		$this->db->trans_commit();

		echo json_encode(array('status'=>'success'));

		return;

		error:
			$this->db->trans_rollback();

		echo json_encode(array('status'=>'failure',
			'message' => $errormsg));
	}

}
