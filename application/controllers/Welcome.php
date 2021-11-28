<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model('APIModel');
	}

	/**
	 * Login/Registration Start
	 */
	public function register() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$result = $this->APIModel->register($data);
			echo json_encode($result);
		}
	}

	public function registerManager() {

		if ($this->input->post()) {
			$result = $this->APIModel->registerManager($this->input->post());
			echo json_encode($result);
		}
	}

	public function login() {

		if ($this->input->post()) {
			$result = $this->APIModel->login($this->input->post());
			echo json_encode($result);
		}
	}

	public function loginManager() {

		if ($this->input->post()) {
			$result = $this->APIModel->loginManager($this->input->post());
			echo json_encode($result);
		}
	}

	public function updateRegistration() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$call_sign = $data['vCallSign'];
			unset($data['vCallSign']);
			$result = $this->APIModel->updateRegistration($call_sign, $data);
			echo json_encode($result);
		}
	}

	public function updateRegistrationContact() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$contact = $data['vContact'];
			unset($data['vContact']);
			$result = $this->APIModel->updateRegistrationContact($contact, $data);
			echo json_encode($result);
		}
	}

	public function updateManager() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$call_sign = $data['vCallSign'];
			unset($data['vCallSign']);
			$result = $this->APIModel->updateManager($call_sign, $data);
			echo json_encode($result);
		}
	}

	public function getUser() {

		if ($this->input->post('vCallSign')) {
			$callSign = $this->input->post('vCallSign');
			$result = $this->APIModel->getUser($callSign);
			echo json_encode($result);
		}
	}

	public function getManager() {

		if ($this->input->post('vCallSign')) {
			$callSign = $this->input->post('vCallSign');
			$result = $this->APIModel->getManager($callSign);
			echo json_encode($result);
		}
	}

	public function getCallSigns() {

		$result = $this->APIModel->getCallSigns();
		echo json_encode($result);
	}
	/**
	 * Login/Registration End
	 */

	/**
	 * News Feed Start
	 */
	public function setNewsFeed() {

		if ($this->input->post()) {
			$result = $this->APIModel->setNewsFeed($this->input->post());
			echo json_encode($result);
		}
	}

	public function getNewsFeed() {

		$result = $this->APIModel->getNewsFeed();
		echo json_encode($result);
	}

	public function getNewsFeedById() {

		if ($this->input->post('vId')) {
			$id = $this->input->post('vId');
			$result = $this->APIModel->getNewsFeedById($id);
			echo json_encode($result);
		}
	}

	public function updateNewsFeed() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$id = $data['vId'];
			unset($data['vId']);
			$result = $this->APIModel->updateNewsFeed($id, $data);
			echo json_encode($result);
		}
	}
	/**
	 * News Feed End
	 */

	/**
	 * Transactions Start
	 */
	public function setTransactions() {

		if ($this->input->post()) {
			$result = $this->APIModel->setTransactions($this->input->post());
			echo json_encode($result);
		}
	}

	public function getTransactionById() {

		if ($this->input->post('vCaliberTransactionId')) {
			$id = $this->input->post('vCaliberTransactionId');
			$result = $this->APIModel->getTransactionById($id);
			echo json_encode($result);
		}
	}

	public function getTransactionByCallSign() {

		if ($this->input->post('vCallSign')) {
			$call_sign = $this->input->post('vCallSign');
			$result = $this->APIModel->getTransactionByCallSign($call_sign);
			echo json_encode($result);
		}
	}

	public function getTransactionByLimit() {

		if ($this->input->post('vCallSign')) {
			$call_sign = $this->input->post('vCallSign');
			$limit = $this->input->post('limit');
			$result = $this->APIModel->getTransactionByLimit($call_sign, $limit);
			echo json_encode($result);
		}
	}

	public function updateTransactions() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$id = $data['vCaliberTransactionId'];
			unset($data['vCaliberTransactionId']);
			$result = $this->APIModel->updateTransactions($id, $data);
			echo json_encode($result);
		}
	}
	/**
	 * Transactions End
	 */

	/**
	 * Teams Start
	 */
	public function setTeam() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			unset($data['flag']);
			$result = $this->APIModel->setTeam($data);
			echo json_encode($result);
		}
	}

	public function getTeam() {

		if ($this->input->post('vCallSign')) {
			$id = $this->input->post('vCallSign');
			$result = $this->APIModel->getTeam($id);
			echo json_encode($result);
		}
	}

	public function getTeamById() {

		if ($this->input->post('vTeamId')) {
			$id = $this->input->post('vTeamId');
			$result = $this->APIModel->getTeamById($id);
			echo json_encode($result);
		}
	}

	public function getTeamNames() {

		$result = $this->APIModel->getTeamNames();
		echo json_encode($result);
	}
	
	public function getTeamInvites() {

		if ($this->input->post('vCallSign')) {
			$call_sign = $this->input->post('vCallSign');
			$result = $this->APIModel->getTeamInvites($call_sign);
			echo json_encode($result);
		}
	}

	public function updateTeam() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['vTeamId'];
			unset($data['vTeamId']);
			$result = $this->APIModel->updateTeam($id, $data);
			echo json_encode($result);
		}
	}

	public function addPlayer() {

		if (file_get_contents('php://input')) {
		    $data = json_decode(file_get_contents('php://input'), true);
			$result = $this->APIModel->addPlayer($data);
			echo json_encode($result);
		}
	}
	
	public function removePlayer() {

		if ($this->input->post()) {
		    $team_id = $this->input->post('vTeamId');
			$call_sign = $this->input->post('vCallSign');
			$result = $this->APIModel->removePlayer($team_id, $call_sign);
			echo json_encode($result);
		}
	}
	
	public function updatePlayer() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['vTeamId'];
			unset($data['vTeamId']);
			$call_sign = $data['vCallSign'];
			unset($data['vCallSign']);
			$result = $this->APIModel->updatePlayer($id, $call_sign, $data);
			echo json_encode($result);
		}
	}

	public function getPlayer() {

		if ($this->input->post('vCallSign')) {
			$call_sign = $this->input->post('vCallSign');
			$result = $this->APIModel->getPlayer($call_sign);
			echo json_encode($result);
		}
	}

	public function getPlayers() {

		if ($this->input->post('vCallSign')) {
			$result = $this->APIModel->getPlayers($this->input->post('vCallSign'));
			echo json_encode($result);
		}
	}

	public function getPlayersByGame() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$id = $data['vTeamId'];
			$game_id = $data['nGameId'];
			$result = $this->APIModel->getPlayer($id, $game_id);
			echo json_encode($result);
		}
	}
	/**
	 * Team End
	 */

	/**
	 * Events Start 
	 */ 
	public function setEvent() {

		if ($this->input->post()) {
			$result = $this->APIModel->setEvent($this->input->post());
			echo json_encode($result);
		}
	}

	public function getEvents() {

		if ($this->input->post('vCallSign')) {
			$callSign = $this->input->post('vCallSign');
			$result = $this->APIModel->getEvents($callSign);
			echo json_encode($result);
		}
	}

	public function updateEvent() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['vEventId'];
			unset($data['vEventId']);
			$result = $this->APIModel->updateEvent($id, $data);
			echo json_encode($result);
		}
	}

	public function setEventParticipant() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$result = $this->APIModel->setEventParticipant($data);
			echo json_encode($result);
		}
	}

	public function getEventParticipantByCallSign() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$id = $data['vEventId'];
			$call_sign = $data['vCallSign'];
			$result = $this->APIModel->getEventParticipantByCallSign($id, $call_sign);
			echo json_encode($result);
		}
	}

	public function updateEventParticipant() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['vEventId'];
			$call_sign = $data['vCallSign'];
			unset($data['vEventId']);
			unset($data['vCallSign']);
			$result = $this->APIModel->updateEventParticipant($id, $call_sign, $data);
			echo json_encode($result);
		}
	}
	/**
	 * Events End
	 */

	/**
	 * Games Start
	 */
	public function setGames() {

		if ($this->input->post()) {
			$result = $this->APIModel->setGames($this->input->post());
			echo json_encode($result);
		}
	}

	public function getGames() {

		$result = $this->APIModel->getGames();
		echo json_encode($result);
	}

	public function getGameById() {

		if ($this->input->post('vId')) {
			$id = $this->input->post('vId');
			$result = $this->APIModel->getGameById($id);
			echo json_encode($result);
		}
	}

	public function updateGame() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['vId'];
			unset($data['vId']);
			$result = $this->APIModel->updateGame($id, $data);
			echo json_encode($result);
		}
	}
	/**
	 * Games End
	 */

	/**
	 * Platform Start
	 */
	public function gameRegistartion() {

		if (file_get_contents('php://input')) {
			$data = json_decode(file_get_contents('php://input'), true);
			$result = $this->APIModel->gameRegistartion($data);
			echo json_encode($result);
		}
	}
	/**
	 * Platform End
	 */

	/**
	 * Existence CallSign Start
	 */
	public function isRegistrationExist() {

		if ($this->input->post()) {
			$result = $this->APIModel->isRegistrationExist($this->input->post());
			echo json_encode($result);
		}
	}

	public function isCallSignExist() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$table = $data['tableName'];
			$call_sign = $data['vCallSign'];
			$result = $this->APIModel->isCallSignExist($table, $call_sign);
			echo json_encode($result);
		}
	}

	public function isContactExist() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$table = $data['tableName'];
			$call_sign = $data['vContact'];
			$result = $this->APIModel->isContactExist($table, $call_sign);
			echo json_encode($result);
		}
	}
	/**
	 * Existence CallSign End
	 */

	/**
	 * Upload image
	 */
	function profileUpload() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$callSign = $data['vCallSign'];
			unset($data['vCallSign']);
			if (isset($_FILES['file'])) {

				$config['upload_path'] = './uploads/profile/';
				$config['allowed_types'] = '*';
				$config['max_size'] = 100000;
				$config['overwrite'] = true;
				$this->load->library('upload', $config);

				$res = $this->db->query("SELECT vImageURL FROM registration WHERE vCallSign = '$callSign'");
				$num = 0;
				if ($res->num_rows() != '0') {
					$num = explode('.', explode('_', $res->row()->vImageURL)[2])[0];
					unlink('./uploads/profile/'.$callSign . "_" . $num . ".jpg");
				}
				
				$config['file_name'] = $callSign . "_" . ++$num . ".jpg";

				$this->upload->initialize($config);
				
				if (!$this->upload->do_upload('file')) {
					$msg2 = $this->upload->display_errors();
					$array = array('status' => false, 'message' => $msg2);
					echo json_encode($array, true);
				} else {
					$data['vImageURL'] = "http://192.168.29.196/calibergaming.in/uploads/profile/".$callSign."_".$num.".jpg";
					$result = $this->APIModel->updateRegistration($callSign, $data);
					echo json_encode($result);
				}
			} else {
				$array = array('status' => false, 'message' => 'File not selected');
				echo json_encode($array, true);
			}
		}
	}

	function teamProfileUpload() {

		if ($this->input->post()) {
			$data = $this->input->post();
			$teamId = $data['vTeamId'];
			$updateFlag = $data['updateFlag'];
			unset($data['updateFlag']);
			if (isset($_FILES['file'])) {

				$config['upload_path'] = './uploads/team/';
				$config['allowed_types'] = '*';
				$config['max_size'] = 100000;
				$config['overwrite'] = true;
				$this->load->library('upload', $config);

				$res = $this->db->query("SELECT vImageUrl FROM teams WHERE vTeamId = '$teamId'");
				$num = 0;
				if ($res->num_rows() != '0') {
					$num = explode('.', explode('_', $res->row()->vImageUrl)[3])[0];
					unlink('./uploads/team/'.$teamId . "_" . $num . ".jpg");
				}
				
				$config['file_name'] = $teamId . "_" . ++$num . ".jpg";

				$this->upload->initialize($config);
				
				if (!$this->upload->do_upload('file')) {
					$msg2 = $this->upload->display_errors();
					$array = array('status' => false, 'message' => $msg2);
					echo json_encode($array, true);
				} else {
					$data['vImageUrl'] = "http://192.168.29.196/calibergaming.in/uploads/team/".$teamId."_".$num.".jpg";
					if ($updateFlag) {
						unset($data['teamId']);
						$result = $this->APIModel->updateTeam($teamId, $data);
						echo json_encode($result);
					} else {
						$result = $this->APIModel->setTeam($data);
						echo json_encode($result);
					}
				}
			} else {
				$array = array('status' => false, 'message' => 'File not selected');
				echo json_encode($array, true);
			}
		}
	}
	/**
	 * End Upload Image
	 */
	
	/**
	 * Send Push Notification
	 */
    public function pushNotification() {
		
		if ($this->input->post()) {

			$data = $this->input->post();
			
			$notification = array();
			$message = array();

			/* API URL */
			$url = 'https://fcm.googleapis.com/v1/projects/calibergaming281117/messages:send';
	
			/* Init cURL resource */
			$ch = curl_init($url);
	
			/* Array Parameter Data */
			$notification['title'] = $data['title'];
			$notification['body'] = $data['body'];
			$message['message'] = array('token'=>$data['token'], 'notification'=>$notification);
	
			/* pass encoded JSON string to the POST fields */
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
				
			/* set the content type json */
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ya29.a0AfH6SMA-g_hxWI4RuY_BQ-vEWBqFaDbf3Nj5YGIrofoWVsyZtCKv8ixdXip9iUgXMad4FMXYpkA5ic6HgF6rV1H2BVeCZxbt9XvpaE8_2dQXj1Dp2fKOVthuAkBGWpByNGd9QjdU2VGPmqeg1fjdXj1zfIZ8tfW79AlYd1AtwaI'));
				
			/* set return type json */
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
			/* execute request */
			$result = curl_exec($ch);
				
			/* close cURL resource */
			curl_close($ch);
			
			echo json_encode($result);
		}
    }
}
