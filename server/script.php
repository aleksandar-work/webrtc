<?php

session_start();
include_once 'connect.php';

function checkLogin($username, $pass) {
    global $dbPrefix, $pdo;
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'users WHERE username = ? AND password = ?');
        $stmt->execute([$username, md5($pass)]);
        $user = $stmt->fetch();

        if ($user) {
            return 200;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function checkLoginToken($token, $roomId, $isAdmin = false) {
    global $dbPrefix, $pdo;
    try {
        if ($isAdmin) {
            $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents WHERE token = ? AND roomId = ?');
            $stmt->execute([$token, $roomId]);
        } else {
            $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'users WHERE token = ? AND roomId = ? AND is_blocked = 0');
            $stmt->execute([$token, $roomId]);
        }

        $user = $stmt->fetch();

        if ($user) {
            return json_encode($user);
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function insertScheduling($agent, $agenturl, $visitorurl, $session, $datetime, $shortagenturl, $shortvisitorurl, $agentId = null, $agenturl_broadcast = null, $visitorurl_broadcast = null, $shortagenturl_broadcast = null, $shortvisitorurl_broadcast = null) {
    global $dbPrefix, $pdo;
    try {
        $sql = "INSERT INTO " . $dbPrefix . "rooms (agent, agenturl, visitorurl,  roomId, datetime, shortagenturl, shortvisitorurl, agent_id, agenturl_broadcast, visitorurl_broadcast, shortagenturl_broadcast, shortvisitorurl_broadcast) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$agent, $agenturl, $visitorurl, $session, $datetime,  $shortagenturl, $shortvisitorurl, $agentId, $agenturl_broadcast, $visitorurl_broadcast, $shortagenturl_broadcast, $shortvisitorurl_broadcast]);
        return 200;
    } catch (Exception $e) {
        return 'Error';
    }
}

function editRoom($roomId, $agent, $agenturl, $visitorurl,  $session, $datetime,  $shortagenturl, $shortvisitorurl, $agentId = null, $agenturl_broadcast = null, $visitorurl_broadcast = null, $shortagenturl_broadcast = null, $shortvisitorurl_broadcast = null) {
    global $dbPrefix, $pdo;
    try {
        $sql = "UPDATE " . $dbPrefix . "rooms set agent=?,  agenturl=?, visitorurl=?, roomId=?,  datetime=?, shortagenturl=?, shortvisitorurl=?, agent_id=?, agenturl_broadcast=?, visitorurl_broadcast=?, shortagenturl_broadcast=?, shortvisitorurl_broadcast=?"
                . " WHERE room_id = ?;";
        $pdo->prepare($sql)->execute([$agent, $agenturl, $visitorurl, $session, $datetime, $shortagenturl, $shortvisitorurl, $agentId, $agenturl_broadcast, $visitorurl_broadcast, $shortagenturl_broadcast, $shortvisitorurl_broadcast, $roomId]);
        return 200;
    } catch (Exception $e) {
        return 'Error ' . $e->getMessage();
    }
}

function insertRecording($roomId, $file, $agentId) {
    global $dbPrefix, $pdo;
    try {

        $sql = "INSERT INTO " . $dbPrefix . "recordings (`room_id`, `filename`, `agent_id`, `date_created`) "
                . "VALUES (?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$roomId, $file, $agentId, date("Y-m-d H:i:s")]);
        return 200;
    } catch (Exception $e) {
        return 'Error ' . $e->getMessage();
    }
}

function deleteRecording($recordingId) {
    global $dbPrefix, $pdo;
    try {

        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'recordings WHERE recording_id = ?');
        $stmt->execute([$recordingId]);
        $rec = $stmt->fetch();

        if ($rec) {
            unlink('../server/recordings/' . $rec['filename']);
        }

        $array = [$recordingId];
        $sql = 'DELETE FROM ' . $dbPrefix . 'recordings WHERE recording_id = ?';
        $pdo->prepare($sql)->execute($array);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getRecordings($agentId=false) {
    global $dbPrefix, $pdo;
    $additional = '';
    $array = [];
    if ($agentId && $agentId != 'admin') {
        $additional = ' where agent_id = ?';
        $array = [$agentId];
    }
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'recordings '.$additional.' order by date_created desc');
        $stmt->execute($array);
        $rows = array();
        while ($r = $stmt->fetch()) {
            if ($r['filename']) {
                if (file_exists('recordings/' . $r['filename'])) {
                    $rows[] = $r;
                }
                if (file_exists('recordings/' . $r['filename'] . '.mp4')) {
                    $r['filename'] = $r['filename'] . '.mp4';
                    $rows[] = $r;
                }

            }
        }
        return json_encode($rows);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function insertChat($roomId, $message, $agent, $from, $participants, $agentId = null, $system = null, $avatar = null, $datetime = null) {
    global $dbPrefix, $pdo;
    try {

        $sql = "INSERT INTO " . $dbPrefix . "chats (`room_id`, `message`, `agent`, `agent_id`, `from`, `date_created`, `participants`, `system`, `avatar`) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$roomId, $message, $agent, $agentId, $from, date("Y-m-d H:i:s", strtotime($datetime)), $participants, $system, $avatar]);
        return 200;
    } catch (Exception $e) {
        return 'Error';
    }
}

function getChat($roomId, $sessionId, $agentId = null) {

    global $dbPrefix, $pdo;
    try {

        $additional = '';
        $array = [$roomId, "%$sessionId%"];
        if ($agentId && $agentId != 'admin') {
            $additional = ' AND agent_id = ?';
            $array = [$roomId, $agentId, "%$sessionId%"];
        }
        $stmt = $pdo->prepare("SELECT * FROM " . $dbPrefix . "chats WHERE (`room_id`= ? or `room_id` = 'dashboard') $additional and participants like ? order by date_created asc");
        $stmt->execute($array);
        $rows = array();
        while ($r = $stmt->fetch()) {
            $r['date_created'] = strtotime($r['date_created']);
            $rows[] = $r;
        }
        return json_encode($rows);
    } catch (Exception $e) {
        return false;
    }
}

function getAgent($tenant) {

    global $dbPrefix, $pdo;
    try {
        $array = [$tenant];
        $stmt = $pdo->prepare("SELECT * FROM " . $dbPrefix . "agents WHERE `tenant`= ?");
        $stmt->execute($array);
        $user = $stmt->fetch();

        if ($user) {
            return json_encode($user);
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function getAdmin($id) {

    global $dbPrefix, $pdo;
    try {
        $array = [$id];
        $stmt = $pdo->prepare("SELECT * FROM " . $dbPrefix . "agents WHERE `agent_id`= ?");
        $stmt->execute($array);
        $user = $stmt->fetch();

        if ($user) {
            return json_encode($user);
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function getUser($id) {

    global $dbPrefix, $pdo;
    try {
        $array = [$id];
        $stmt = $pdo->prepare("SELECT * FROM " . $dbPrefix . "users WHERE `user_id`= ?");
        $stmt->execute($array);
        $user = $stmt->fetch();

        if ($user) {
            return json_encode($user);
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function getRoom($roomId) {

    global $dbPrefix, $pdo;
    try {
        $array = [$roomId];
        $stmt = $pdo->prepare("SELECT * FROM " . $dbPrefix . "rooms WHERE `room_id`= ? AND `is_active` = 1");
        $stmt->execute($array);
        $room = $stmt->fetch();
        if ($room) {
            return json_encode($room);
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function getRooms($agentId = false) {

    global $dbPrefix, $pdo;
    try {
        if ($agentId){
            $additional = '';
            $array = [];
            if ($agentId && $agentId != 'admin') {
                $additional = ' WHERE r.agent_id = ? and r.agent_id = a.tenant';
                $array = [$agentId];
            }

            if ($agentId == 'admin') {
                $additional = ' WHERE r.agent_id = a.tenant';
                $array = [];
            }
            $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents a, '. $dbPrefix . 'rooms r ' . $additional . ' order by room_id desc');
            $stmt->execute($array);
            $rows = array();
            while ($r = $stmt->fetch()) {
                $rows[] = $r;
            }
            return json_encode($rows);
        }else{

            $array = [];

            $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'rooms  order by room_id desc');
            $stmt->execute($array);
            $rows = array();
            while ($r = $stmt->fetch()) {
                $rows[] = $r;
            }
            return json_encode($rows);
        }

    } catch (Exception $e) {
        return false;
    }
}

function deleteRoom($roomId, $agentId = false) {
    global $dbPrefix, $pdo;
    try {
        $additional = '';
        $array = [$roomId];
        if ($agentId && $agentId != 'admin') {
            $additional = ' AND agent_id = ?';
            $array = [$roomId, $agentId];
        }
        $sql = 'DELETE FROM ' . $dbPrefix . 'rooms WHERE room_id = ?' . $additional;
        $pdo->prepare($sql)->execute($array);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getAgents() {
    global $dbPrefix, $pdo;
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents order by agent_id desc');
        $stmt->execute();
        $rows = array();
        while ($r = $stmt->fetch()) {
            $rows[] = $r;
        }
        return json_encode($rows);
    } catch (Exception $e) {
        return false;
    }
}

function deleteAgent($agentId) {
    global $dbPrefix, $pdo;
    try {

        $sql = 'DELETE FROM ' . $dbPrefix . 'agents WHERE agent_id = ?';
        $pdo->prepare($sql)->execute([$agentId]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function editAgent($agentId, $firstName, $lastName, $email, $tenant, $pass = null, $usernamehidden = null) {
    global $dbPrefix, $pdo;
    try {
        $array = [$firstName, $lastName, $email, $tenant, $agentId];
        $additional = '';
        if ($pass) {
            $additional = ', password = ?';
            $array = [$firstName, $lastName, $email, $tenant, md5($pass), $agentId];
        }

        $sql = 'UPDATE ' . $dbPrefix . 'agents SET first_name=?, last_name=?, email=?, tenant=? ' . $additional . ' WHERE agent_id = ?';

        if ($_SESSION["username"] == $usernamehidden) {
            $_SESSION["agent"] = array('agent_id' => $agentId, 'first_name' => $firstName, 'last_name' => $lastName, 'tenant' => $tenant, 'email' => $email);
        }

        $pdo->prepare($sql)->execute($array);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function endMeeting($roomId, $agentId = null) {
    global $dbPrefix, $pdo;
    try {
        $additional = '';
        $array = [$roomId];
        if ($agentId) {
            $additional = ' AND agent_id = ?';
            $array = [$roomId, $agentId];
        }
//        $sql = 'UPDATE ' . $dbPrefix . 'rooms SET is_active=0 WHERE roomId = ? ' . $additional;
//        $pdo->prepare($sql)->execute($array);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function blockUser($username) {
    global $dbPrefix, $pdo;
    try {
        $sql = 'UPDATE ' . $dbPrefix . 'users SET is_blocked=1 WHERE username = ?';

        $pdo->prepare($sql)->execute(array($username));
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function editAdmin($agentId, $firstName, $lastName, $email, $tenant, $pass = null) {
    global $dbPrefix, $pdo;
    try {
        $array = [$firstName, $lastName, $email, $tenant, $agentId];
        $additional = '';
        if ($pass) {
            $additional = ', password = ?';
            $array = [$firstName, $lastName, $email, $tenant, md5($pass), $agentId];
        }

        $sql = 'UPDATE ' . $dbPrefix . 'agents SET first_name=?, last_name=?, email=?, tenant=? ' . $additional . ' WHERE agent_id = ?';
        $_SESSION["agent"] = array('agent_id' => $agentId, 'first_name' => $firstName, 'last_name' => $lastName, 'tenant' => $tenant, 'email' => $email);
        $pdo->prepare($sql)->execute($array);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function addAgent($user, $pass, $firstName, $lastName, $email, $tenant) {
    global $dbPrefix, $pdo;
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents WHERE username = ? or email = ?');
        $stmt->execute([$user, $email]);
        $userName = $stmt->fetch();
        if ($userName) {
            return false;
        }

        $sql = 'INSERT INTO ' . $dbPrefix . 'agents (username, password, first_name, last_name, email, tenant) VALUES (?, ?, ?, ?, ?, ?)';
        $pdo->prepare($sql)->execute([$user, md5($pass), $firstName, $lastName, $email, $tenant]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function addFeedback($sessionId, $roomId, $rate, $text = '', $userId = '') {
    global $dbPrefix, $pdo;
    try {

        $sql = 'INSERT INTO ' . $dbPrefix . 'feedbacks (session_id, room_id, rate, text, user_id, date_added) VALUES (?, ?, ?, ?, ?, ?)';
        $pdo->prepare($sql)->execute([$sessionId, $roomId, $rate, $text, $userId, date("Y-m-d H:i:s")]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getUsers() {

    global $dbPrefix, $pdo;
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'users order by user_id desc');
        $stmt->execute();
        $rows = array();
        while ($r = $stmt->fetch()) {
            $rows[] = $r;
        }
        return json_encode($rows);
    } catch (Exception $e) {
        return false;
    }
}

function deleteUser($userId) {
    global $dbPrefix, $pdo;
    try {
        $sql = 'DELETE FROM ' . $dbPrefix . 'users WHERE user_id = ?';
        $pdo->prepare($sql)->execute([$userId]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function editUser($userId, $name, $user) {
    global $dbPrefix, $pdo;
    try {
        $sql = 'UPDATE ' . $dbPrefix . 'users SET username=?, name=? WHERE user_id = ?';
        $pdo->prepare($sql)->execute([$user, $name, $userId]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function addUser($user, $name, $pass, $firstName = null, $lastName = null) {

    global $dbPrefix, $pdo;
    try {

        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'users WHERE username = ?');
        $stmt->execute([$user]);
        $userName = $stmt->fetch();
        if ($userName) {
            return false;
        }


        $sql = 'INSERT INTO ' . $dbPrefix . 'users (username, name, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)';
        $pdo->prepare($sql)->execute([$user, $name, md5($pass), $firstName, $lastName]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function loginAgent($username, $pass) {
    global $dbPrefix, $pdo;
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents WHERE username = ? AND password=?');
        $stmt->execute([$username, md5($pass)]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION["tenant"] = ($user['is_master']) ? 'lsv_mastertenant' : $user['tenant'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["agent"] = array('agent_id' => $user['agent_id'], 'first_name' => $user['first_name'], 'last_name' => $user['last_name'], 'tenant' => $user['tenant'], 'email' => $user['email']);
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function loginAdmin($email, $pass) {
    global $dbPrefix, $pdo;
    try {
        $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents WHERE email = ? AND password = ?');
        $stmt->execute([$email, md5($pass)]);
        $user = $stmt->fetch();

        if ($user) {
            return 200;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function getChats($agentId = false) {
    global $dbPrefix, $pdo;
    try {
        $additional = '';
        $array = [];
        if ($agentId) {
            $additional = ' WHERE agent_id = ? ';
            $array = [$agentId];
        }
        $stmt = $pdo->prepare('SELECT max(room_id) as room_id, max(date_created) as date_created, max(agent) as agent FROM ' . $dbPrefix . 'chats ' . $additional . ' group by room_id order by date_created desc');
        $stmt->execute($array);
        $rows = array();
        while ($r = $stmt->fetch()) {
            $stmt1 = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'chats where room_id=? order by date_created asc ');
            $stmt1->execute([$r['room_id']]);
            $rows1 = '<table>';
            while ($r1 = $stmt1->fetch()) {
                $rows1 .= '<tr><td><small>' . $r1['date_created'] . '</small></td><td>' . $r1['from'] . ': ' . $r1['message'] . '</td></tr>';
            }
            $rows1 .= '</table>';
            $r['messages'] = $rows1;
            $rows[] = $r;
        }
        return json_encode($rows);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}


function getHistory($agentId = false) {
    global $dbPrefix, $pdo;
    $rows = array();
    $stmt = $pdo->prepare('SELECT * FROM ' . $dbPrefix . 'agents');
    $stmt->execute();
    $doctors = array();
    while ($r = $stmt->fetch()) {
        $doctors[] = $r;
    }
    try {
    foreach ($doctors as $doctor){
        $additional = '';
        $array = [];
        $additional = ' WHERE agent_id = ? ';
        $array = [$doctor['tenant']];
        $stmt = $pdo->prepare('SELECT max(room_id) as room_id, max(date_created) as date_created, max(agent) as agent FROM ' . $dbPrefix . 'chats ' . $additional . ' group by room_id order by date_created desc');
        $stmt->execute($array);
        $rows[$doctor['username']]['conversations'] =  $stmt->rowCount();
        $stmt = $pdo->prepare('SELECT count(recording_id) as recording_num FROM ' . $dbPrefix . 'recordings ' . $additional . ' order by date_created desc');
        $stmt->execute($array);
        $rows[$doctor['username']]['recordings'] =  $stmt->fetch();
        $rows[$doctor['username']]['agent_id'] = $doctor['tenant'];
    }


        return json_encode($rows);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type']) && $_POST['type'] == 'login') {
        echo checkLogin($_POST['email'], $_POST['password']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'logintoken') {
        echo checkLoginToken($_POST['token'], $_POST['roomId'], @$_POST['isAdmin']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'scheduling') {
        echo insertScheduling($_POST['agent'], $_POST['agenturl'], $_POST['visitorurl'], $_POST['session'], $_POST['datetime'],  $_POST['shortAgentUrl'], $_POST['shortVisitorUrl'], $_POST['agentId'], @$_POST['agenturl_broadcast'], @$_POST['visitorurl_broadcast'], @$_POST['shortAgentUrl_broadcast'], @$_POST['shortVisitorUrl_broadcast']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'editroom') {
        echo editRoom($_POST['room_id'], $_POST['agent'], $_POST['agenturl'], $_POST['visitorurl'], $_POST['session'], $_POST['datetime'], $_POST['shortAgentUrl'], $_POST['shortVisitorUrl'], $_POST['agentId'], @$_POST['agenturl_broadcast'], @$_POST['visitorurl_broadcast'], @$_POST['shortAgentUrl_broadcast'], @$_POST['shortVisitorUrl_broadcast']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'addchat') {
        echo insertChat($_POST['roomId'], $_POST['message'], $_POST['agent'], $_POST['from'], $_POST['participants'], @$_POST['agentId'], @$_POST['system'], @$_POST['avatar'], @$_POST['datetime']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getchat') {
        echo getChat($_POST['roomId'], $_POST['sessionId'], @$_POST['agentId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getrooms') {
        echo getRooms(@$_POST['agentId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getchats') {
        echo getChats(@$_POST['agentId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'deleteroom') {
        echo deleteRoom($_POST['roomId'], $_POST['agentId']);
    }

    if (isset($_POST['type']) && $_POST['type'] == 'getagents') {
        echo getAgents();
    }
    if (isset($_POST['type']) && $_POST['type'] == 'deleteagent') {
        echo deleteAgent($_POST['agentId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'editagent') {
        echo editAgent($_POST['agentId'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['tenant'], $_POST['password'], @$_POST['usernamehidden']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'editadmin') {
        echo editAdmin($_POST['agentId'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['tenant'], $_POST['password']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'loginagent') {
        echo loginAgent($_POST['username'], $_POST['password']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'loginadmin') {
        echo loginAdmin($_POST['email'], $_POST['password']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'addagent') {
        echo addAgent($_POST['username'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['tenant']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'addrecording') {
        echo insertRecording($_POST['roomId'], $_POST['filename'], $_POST['agentId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getrecordings') {
        echo getRecordings($_POST['agentId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'deleterecording') {
        echo deleteRecording($_POST['recordingId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getusers') {
        echo getUsers();
    }
    if (isset($_POST['type']) && $_POST['type'] == 'deleteuser') {
        echo deleteUser($_POST['userId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'edituser') {
        echo editUser($_POST['userId'], $_POST['name'], $_POST['username'], @$_POST['firstName'], @$_POST['lastName']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'adduser') {
        echo addUser($_POST['username'], $_POST['name'], $_POST['password'], @$_POST['firstName'], @$_POST['lastName']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getagent') {
        echo getAgent($_POST['tenant']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getuser') {
        echo getUser($_POST['id']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getadmin') {
        echo getAdmin($_POST['id']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'blockuser') {
        echo blockUser($_POST['username']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'feedback') {
        echo addFeedback($_POST['sessionId'], $_POST['roomId'], $_POST['rate'], @$_POST['text'], @$_POST['userId']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'getroom') {
        echo getRoom($_POST['room_id']);
    }
    if (isset($_POST['type']) && $_POST['type'] == 'gethistory') {
        echo getHistory();
    }
    if (isset($_POST['type']) && $_POST['type'] == 'endmeeting') {
        echo endMeeting($_POST['roomId'], @$_POST['agentId']);
    }
}
