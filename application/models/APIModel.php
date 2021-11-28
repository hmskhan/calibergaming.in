<?php
class APIModel extends CI_Model {

    public function isRegistrationExist($data) {

        try {

            $callSignExist = $this->isCallSignExist('registration', $data['vCallSign']);
            $contactExist = $this->isContactExist('registration', $data['vContact']);

            if ($callSignExist['status']) {
                return $callSignExist;
            }

            if ($contactExist['status']) {
                return $contactExist;
            }

            $result['status'] = FALSE;
            $result['message'] = "Not Exist";
            return $result;

        } catch(Exception $e) {
            $result['status'] = TRUE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function register($data) {

        try {

            $this->db->insert('registration', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Registration successful';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Some error occurred';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function registerManager($data) {

        try {

            $callSignExist = $this->isCallSignExist('event_managers', $data['vCallSign']);
            $contactExist = $this->isContactExist('event_managers', $data['vContact']);

            if ($callSignExist['status']) {
                $result['status'] = FALSE;
                $result['message'] = $callSignExist['message'];
                return $result;
            }

            if ($contactExist['status']) {
                $result['status'] = FALSE;
                $result['message'] = $contactExist['message'];
                return $result;
            }

            $this->db->insert('event_managers', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Registration successful';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Some error occurred';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function login($data) {

        try {

            $callSignExist = $this->isCallSignExist('registration', $data['vCallSign']);

            if (!$callSignExist['status']) {
                $result['status'] = FALSE;
                $result['message'] = $callSignExist['message'];
                return $result;
            }

            if ($callSignExist['result']->bBlockStatus == 1) {
                $result['status'] = FALSE;
                $result['message'] = "block";
                return $result;
            }

            if ($callSignExist['result']->vPassword != $data['vPassword']) {
                $result['status'] = FALSE;
                $result['message'] = "Incorrect password";
            } else {
                // $call_sign = $data['vCallSign'];
                // unset($data['vCallSign']);
                // unset($data['vPassword']);
                // $this->updateRegistration($call_sign, $data);
                $result['status'] = TRUE;
                $result['message'] = "You are Logged In";
                $result['result'] = $callSignExist['result'];
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function loginManager($data) {

        try {

            $callSignExist = $this->isCallSignExist('event_managers', $data['vCallSign']);

            if (!$callSignExist['status']) {
                $result['status'] = FALSE;
                $result['message'] = $callSignExist['message'];
                return $result;
            }

            if ($callSignExist['result']->bBlockStatus == 1) {
                $result['status'] = FALSE;
                $result['message'] = "Your account has been blocked by Caliber Gaming";
                return $result;
            }

            if ($callSignExist['result']->vPassword != $data['vPassword']) {
                $result['status'] = FALSE;
                $result['message'] = "Incorrect password";
            } else {
                $result['status'] = TRUE;
                $result['message'] = "You are Logged In";
                $result['result'] = $callSignExist['result'];
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateRegistration($call_sign, $data) {

        try {

            $this->db->where('vCallSign', $call_sign);
            $this->db->update('registration', $data);

            $user = $this->getUser($call_sign);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            $result['result'] = $user['result'];
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }
                    
    public function updateRegistrationContact($contact, $data) {

        try {

            $this->db->where('vContact', $contact);
            $this->db->update('registration', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function updateManager($call_sign, $data) {

        try {

            $this->db->where('vCallSign', $call_sign);
            $this->db->update('event_managers', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function getUser($callSign) {

        try {

            $this->db->select("r.*, g.vGameName, g.vPlatform");
            $this->db->join("games as g", "r.nGameId = g.nGameId", "left");
            $this->db->where("r.vCallSign = '$callSign'");
            $res = $this->db->get('registration as r');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'CallSign found';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'CallSign not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getManager($callSign) {

        try {

            $res = $this->db->get_where('event_managers', array('vCallSign' => $callSign));

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Manager fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Manager not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getCallSigns() {

        try {

            $this->db->select('registration.vCallSign');
            $this->db->order_by('registration.vCallSign', 'ASC');
            $res = $this->db->get('registration');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'CallSigns fetched';
                $result['result'] = array_column($res->result_array(), 'vCallSign');
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'CallSigns not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function setNewsFeed($data) {

        try {

            $this->db->insert('news_feed', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Article submitted';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Some error occurred';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getNewsFeed() {

        try {

            $this->db->order_by('tTimestamp', 'DESC');
            $res = $this->db->get('news_feed');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Articles fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Articles not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getNewsFeedById($id) {

        try {

            $res = $this->db->get_where('news_feed', array('vId' => $id));

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Article fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Article not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateNewsFeed($id, $data) {

        try {

            $this->db->where('vId', $id);
            $this->db->update('news_feed', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function setTransactions($data) {

        try {

            $this->db->insert('transactions', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Transaction completed';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Transaction not completed';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getTransactionById($id) {

        try {

            $res = $this->db->get_where('transactions', array('vCaliberTransactionId' => $id));

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Transaction fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Transaction not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getTransactionByCallSign($call_sign) {

        try {

            $this->db->order_by('tTimestamp', 'DESC');
            $this->db->where("vReceiver = '$call_sign' OR vSender = '$call_sign'");
            $res = $this->db->get('transactions');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Transactions fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Transaction not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getTransactionByLimit($call_sign, $limit) {

        try {

            $this->db->order_by('tTimestamp', 'DESC');
            $this->db->where("vReceiver = '$call_sign' OR vSender = '$call_sign'");
            $this->db->limit($limit);
            $res = $this->db->get('transactions');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Transactions fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Transaction not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateTransactions($id, $data) {

        try {

            $this->db->where('vCaliberTransactionId', $id);
            $this->db->update('transactions', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function setTeam($data) {

        try {

            $this->db->insert('teams', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Team created';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Team not created';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getTeam($callSign) {

        try {

            $this->db->select("t.*, g.vGameName, g.vPlatform");
            $this->db->join("games as g", "t.nGameId = g.nGameId", "left");
            $this->db->where("t.vTeamId = (SELECT r.vTeamId FROM registration as r WHERE r.vCallSign = '$callSign')");
            $res = $this->db->get('teams as t');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Team fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Team not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }
    
    public function getTeamInvites($call_sign) {

        try {

            $this->db->select("team_players.*, teams.vTeamName, teams.vImageUrl");
            $this->db->where("team_players.vCallSign = '$call_sign'");
            $this->db->join('teams',"team_players.vTeamId=teams.vTeamId",'Left');
            $res = $this->db->get('team_players');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Team names fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Teams not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getTeamById($id) {

        try {

            $res = $this->db->get_where('teams', array('vTeamId' => $id));

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Team fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Team not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getTeamNames() {

        try {

            $this->db->select("vTeamId, vTeamName");
            $res = $this->db->get('teams');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Team names fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Teams not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateTeam($id, $data) {

        try {

            $this->db->where('vTeamId', $id);
            $this->db->update('teams', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "update successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function addPlayer($data) {

        try {

            $this->db->insert('team_players', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Player added';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Player not added';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }
    
     public function updatePlayer($id, $call_sign, $data) {

        try {

            $this->db->where(array('vTeamId' => $id, 'vCallSign' => $call_sign));
            $this->db->update('team_players', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "update successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }
    
    public function removePlayer($id, $call_sign) {

        try {

            $this -> db -> where(array('vTeamId' => $id, 'vCallSign' => $call_sign));
            $this -> db -> delete('team_players');
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Player removed';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Player not removed';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getPlayer($call_sign) {

        try {

            $this->db->select("team_players.*, registration.vName, teams.vTeamName");
            $this->db->where("team_players.vCallSign = '$call_sign'");
            $this->db->join('teams',"team_players.vTeamId=teams.vTeamId",'Left');
            $this->db->join('registration',"team_players.vCallSign=registration.vCallSign",'Left');
            $res = $this->db->get('team_players');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Player fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Player not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getPlayers($call_sign) {

        try {

            $this->db->select("team_players.*, registration.vName, registration.vImageUrl, game_registration.vUserName");
            $this->db->where("team_players.vTeamId = (SELECT r.vTeamId FROM registration as r WHERE r.vCallSign = '$call_sign')");
            $this->db->join('registration',"team_players.vCallSign=registration.vCallSign",'Left');
            $this->db->join('game_registration',"team_players.nGameId=game_registration.nGameId",'Left');
            $res = $this->db->get('team_players');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Players fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Players not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getPlayersByGame($team_id, $game_id) {

        try {

            $this->db->select("team_players.*, registration.vName");
            $this->db->where("vTeamId = '$team_id' AND nGameId = '$game_id'");
            $this->db->join('registration',"team_players.vCallSign=registration.vCallSign",'Left');
            $res = $this->db->get('team_players');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Players fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Players not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function setEvent($data) {

        try {

            $this->db->insert('events', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Event created';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Event not created';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getEvents($callSign) {

        try {

            $res = $this->db->query("SELECT e.*, COUNT(p.vEventId) as participantsCount, 
                IF (EXISTS(SELECT * FROM event_participants as ep WHERE e.vEventId = ep.vEventId AND 
                IFNULL(ep.vTeamId, ep.vCallSign) 
                IN((SELECT r.vTeamId FROM registration as r WHERE r.vCallSign = '$callSign'), '$callSign')) = 1, 'true', 'false') as isExists
                FROM events as e
                LEFT JOIN event_participants as p ON e.vEventId = p.vEventId
                GROUP BY e.vEventId 
                ORDER BY e.tTimestamp DESC");

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Events fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Events not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateEvent($id, $data) {

        try {

            $this->db->where('vEventId', $id);
            $this->db->update('events', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function setEventParticipant($data) {

        try {
            
            $transactionData = array(
                'vCaliberTransactionId' => $data[0]['vCaliberTransactionId'],
                'vEventId' => $data[0]['vEventId'],
                'nGameId' => $data[0]['nGameId'],
                'nAmount' => $data[0]['nAmount'],
                'vModeOfPayment' => $data[0]['vModeOfPayment'],
                'vPaymentStatus' => $data[0]['vPaymentStatus'],
                'vReason' => $data[0]['vReason'],
                'vReceiver' => $data[0]['vReceiver'],
                'vSender' => $data[0]['vSender'],
                'vTransactionId' => array_key_exists('vTransactionId', $data[0])?$data[0]['vTransactionId']:null,
            );
            unset($data[0]['nGameId']);
            unset($data[0]['nAmount']);
            unset($data[0]['vModeOfPayment']);
            unset($data[0]['vPaymentStatus']);
            unset($data[0]['vReason']);
            unset($data[0]['vReceiver']);
            unset($data[0]['vSender']);
            unset($data[0]['vTransactionId']);
            
            $tran = $this->setTransactions($transactionData);

            $this->db->insert_batch('event_participants', $data);

            $id = $transactionData['vCaliberTransactionId'];
            $res = $this->db->query("SELECT tTimestamp FROM event_participants 
            WHERE vCaliberTransactionId = '$id'");
        
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['result'] = $res->row()->tTimestamp;
                $result['message'] = 'Participant added';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Participant not added';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getEventParticipantByCallSign($id, $call_sign) {

        try {

            $this->db->select("*");
            $this->db->where("vEventId = '$id' AND vCallSign = '$call_sign'");
            $res = $this->db->get('event_participants');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($res->num_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Participant fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Participant not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateEventParticipant($id, $call_sign, $data) {

        try {

            $this->db->where("vEventId = '$id' AND vCallSign = '$call_sign'");
            $this->db->update('events', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function setGames($data) {

        try {

            $this->db->insert('games', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Game added';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Some error occurred';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getGames() {

        try {

            $res = $this->db->get('games');

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Games fetched';
                $result['result'] = $res->result_array();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Games not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function getGameById($id) {

        try {

            $res = $this->db->get_where('games', array('vId' => $id));

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Game fetched';
                $result['result'] = $res->row();
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Game not found';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function updateGame($id, $data) {

        try {

            $this->db->where('vId', $id);
            $this->db->update('games', $data);

            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false; // unreachable retrun statement !!!
            }

            $result['status'] = TRUE;
            $result['message'] = "updated successful";
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    public function gameRegistration($data) {

        try {

            $this->db->insert('game_registration', $data);
            
            $db_error = $this->db->error();
            if (!empty($db_error) && $db_error['code'] != 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return FALSE;
            }

            if ($this->db->affected_rows() > 0) {
                $result['status'] = TRUE;
                $result['message'] = 'Registration Successful';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Some error occurred';
            }
            return $result;
        } catch(Exception $e) {
            $result['status'] = FALSE;
            $result['message'] = $e->getMessage();
            return $result;
        }
    }

    public function isCallSignExist($table, $call_sign) {

        $result = $this->db->get_where($table, array('vCallSign' => $call_sign))->row();

        if(empty($result))
            return array('status'=>FALSE, 'message'=>'Callsign not exist', 'result'=>$result);
        else
            return array('status'=>TRUE, 'message'=>'Callsign already exist', 'result'=>$result);
    }

    public function isContactExist($table, $contact) {

        $result = $this->db->get_where($table, array('vContact' => $contact))->row();

        if(empty($result))
            return array('status'=>FALSE, 'messsage'=>'Contact not exist', 'result'=>$result);
        else
            return array('status'=>TRUE, 'message'=>'Contact already exist', 'result'=>$result);
    }
}