<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function login2(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM users where email = '".$email."' and password = '".md5($password)."'  and type= 2 ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}
	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($cpass) && !empty($password)){
			$data .= ", password=md5('$password') ";
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", profile_pic = '$fname' ";
			
			// Update session variable with new profile picture
			$_SESSION['login_profile_pic'] = $fname;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}
	
		// Update session variable with new first name
		$_SESSION['login_firstname'] = $_POST['firstname'];
	
		if($save){
			return 1;
		}
	}
	
	
	function signup()
	{
    extract($_POST);
    $data = "";
    foreach ($_POST as $k => $v) {
        if (!in_array($k, array('id', 'cpass', 'month', 'day', 'year', 'subscription_id')) && !is_numeric($k)) {
            if ($k == 'password') {
                if (empty($v))
                    continue;
                $v = md5($v);
            }
            if (empty($data)) {
                $data .= " $k='$v' ";
            } else {
                $data .= ", $k='$v' ";
            }
        }
    }
    if (isset($email)) {
        $check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
        if ($check > 0) {
            return 2;
            exit;
        }
    }
    if (isset($_FILES['pp']) && $_FILES['pp']['tmp_name'] != '') {
        $fnamep = strtotime(date('y-m-d H:i')).'_'.$_FILES['pp']['name'];
        $move = move_uploaded_file($_FILES['pp']['tmp_name'], 'assets/uploads/'. $fnamep);
        $data .= ", profile_pic = '$fnamep' ";
    }
    if (empty($id)) {
        $save = $this->db->query("INSERT INTO users set $data, subscription_id = '$subscription_id'");
    } else {
        $save = $this->db->query("UPDATE users set $data, subscription_id = '$subscription_id' where id = $id");
    }

    if ($save) {
        if (empty($id)) {
            $id = $this->db->insert_id;
        }
        foreach ($_POST as $key => $value) {
            if (!in_array($key, array('id', 'cpass', 'password')) && !is_numeric($key)) {
                if ($key == 'pp') {
                    $key = 'profile_pic';
                }
                if ($key == 'cover') {
                    $key = 'cover_pic';
                }
                $_SESSION['login_'.$key] = $value;
            }
        }
        $_SESSION['login_id'] = $id;
        if (isset($_FILES['pp']) && $_FILES['pp']['tmp_name'] != '') {
            $_SESSION['login_profile_pic'] = $fnamep;
        }
        if (!isset($type)) {
            $_SESSION['login_type'] = 2;
        }
        return 1;
    }
}


function update_user(){
    extract($_POST);
    $data = "";
    foreach($_POST as $k => $v){
        if(!in_array($k, array('id','cpass','table')) && !is_numeric($k)){
            if($k =='password')
                $v = md5($v);
            if(empty($data)){
                $data .= " $k='$v' ";
            }else{
                $data .= ", $k='$v' ";
            }
        }
    }
    if($_FILES['img']['tmp_name'] != ''){
        $targetDir = "assets/uploads/";
        $fileName = basename($_FILES['img']['name']);
        $targetFilePath = $targetDir . $fileName;
        $move = move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath);
        if($move){
            $data .= ", profile_pic = '$fname' ";
        }else{
            // Handle the case when the file upload fails
            return 4;
        }
    }
    $check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
    if($check > 0){
        return 2;
    }
    if(empty($id)){
        $save = $this->db->query("INSERT INTO users set $data");
    }else{
        $save = $this->db->query("UPDATE users set $data where id = $id");
    }
    if($save){
        foreach ($_POST as $key => $value) {
            if($key != 'password' && !is_numeric($key))
                $_SESSION['login_'.$key] = $value;
        }
        return 1;
    }
}

	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function save_genre(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cover')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
			}

		if(isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", cover_photo = '$fname' ";
		}
		if(empty($id)){
			if(empty($_FILES['cover']['tmp_name']))
			$data .= ", cover_photo = 'default_cover.jpg' ";
			$save = $this->db->query("INSERT INTO genres set $data");
		}else{
			$save = $this->db->query("UPDATE genres set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_genre(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM genres where id = $id");
		if($delete){
			return 1;
		}
	}

	function sanitizeFilename($filename) {
		$filename = preg_replace("/[^a-zA-Z0-9_.\-]/", "", $filename);
		return $filename;
	  }
	  function save_music()
{
    extract($_POST);
    $data = "";

    foreach ($_POST as $k => $v) {
        if (!in_array($k, array('id', 'cover', 'audio', 'item_code')) && !is_numeric($k)) {
            if ($k == 'description') {
                $v = htmlentities(str_replace("'", "&#x2019;", $v));
            }
            if (empty($data)) {
                $data .= " $k='" . addslashes($v) . "' ";
            } else {
                $data .= ", $k='" . addslashes($v) . "' ";
            }
        }
    }

    if (isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != '') {
        $coverName = $_FILES['cover']['name'];
        $coverTmpName = $_FILES['cover']['tmp_name'];
        $coverExtension = pathinfo($coverName, PATHINFO_EXTENSION);
        $coverFilename = strtotime(date('y-m-d H:i')) . '_' . uniqid() . '.' . $coverExtension;
        $coverDestination = 'assets/uploads/' . $coverFilename;
        $moveCover = move_uploaded_file($coverTmpName, $coverDestination);
        $data .= ", cover_image = '$coverFilename' ";
    }

    if (isset($_FILES['audio']) && $_FILES['audio']['tmp_name'] != '') {
        $audioName = $_FILES['audio']['name'];
        $audioTmpName = $_FILES['audio']['tmp_name'];
        $audioExtension = pathinfo($audioName, PATHINFO_EXTENSION);
        $audioFilename = strtotime(date('y-m-d H:i')) . '_' . uniqid() . '.' . $audioExtension;
        $audioDestination = 'assets/uploads/' . $audioFilename;
        $moveAudio = move_uploaded_file($audioTmpName, $audioDestination);
        $data .= ", upath = '$audioFilename' ";
    }

    if (empty($id)) {
        if (empty($_FILES['cover']['tmp_name'])) {
            $data .= ", cover_image = 'default_cover.jpg' ";
        }
        $save = $this->db->prepare("INSERT INTO uploads SET $data");
    } else {
        $save = $this->db->prepare("UPDATE uploads SET $data WHERE id = ?");
        $save->bind_param('i', $id);
    }

    if ($save->execute()) {
        // Retrieve the artist name entered by the user
        $artistName = $_POST['artist'];

        // Check if the artist already exists in the database
        $existingArtistQuery = $this->db->prepare("SELECT id FROM artists WHERE name = ?");
        $existingArtistQuery->bind_param("s", $artistName);
        $existingArtistQuery->execute();
        $existingArtistResult = $existingArtistQuery->get_result();

        if ($existingArtistResult->num_rows > 0) {
            // Artist already exists, do nothing
        } else {
            // Artist does not exist, save the artist name
            $insertArtistQuery = $this->db->prepare("INSERT INTO artists (name) VALUES (?)");
            $insertArtistQuery->bind_param("s", $artistName);
            $insertArtistQuery->execute();
        }

        return 1;
    }
}


	
	
	  
	  
	function delete_music(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM uploads where id = $id");
		if($delete){
			return 1;
		}
	}
	function get_details(){
		extract($_POST);
		$get = $this->db->query("SELECT * FROM uploads where id = $id")->fetch_array();
		$data = array("cover_image"=>$get['cover_image'],"title"=>$get['title'],"artist"=>$get['artist']);
		return json_encode($data);
	}
	function save_playlist(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cover')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
			}
			$data .=",user_id = '{$_SESSION['login_id']}' ";
			if(isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", cover_image = '$fname' ";
		}
		if(empty($id)){
			if(empty($_FILES['cover']['tmp_name']))
			$data .= ", cover_image = 'play.jpg' ";
			$save = $this->db->query("INSERT INTO playlist set $data");
		}else{
			$save = $this->db->query("UPDATE playlist set $data where id = $id");
		}
		if($save){
			if(empty($id))
			$id = $this->db->insert_id;
			return $id;
		}
	}
	function delete_playlist(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM playlist where id = $id");
		if($delete){
			return 1;
		}
	}
	function find_music(){
		extract($_POST);
		$get = $this->db->query("SELECT id,title,upath,artist,cover_image FROM uploads where title like '%$search%' or artist like '%$search%' ");
		$data = array();
		while($row = $get->fetch_assoc()){
			$data[] = $row;
		}
		return json_encode($data);
	}
	function save_playlist_items()
	{
    extract($_POST);
    $ids = [];

    // Delete all playlist items for the given playlist_id
    $this->db->query("DELETE FROM playlist_items WHERE playlist_id = $playlist_id");

    if (!empty($music_id)) {
        foreach ($music_id as $k => $v) {
            $data = " playlist_id = $playlist_id ";
            $data .= ", music_id = {$music_id[$k]} ";

            $check = $this->db->query("SELECT * FROM playlist_items WHERE playlist_id = $playlist_id AND music_id = {$music_id[$k]}")->num_rows;

            if ($check <= 0) {
                if ($this->db->query("INSERT INTO playlist_items SET $data")) {
                    $ids[] = $music_id[$k];
                }
            }
        }
    }

    return 1;
}

	
}