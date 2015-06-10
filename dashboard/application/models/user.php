<?php
class User extends CI_Model{

	//get single record
	public function get_user_by_email($email){
		return $this->db->query("SELECT * FROM users where email = ?", array($email))->row_array();
	}
	//get all users
	public function get_users(){
		return $this->db->query("SELECT *, concat_ws(' ',first_name,last_name) as name FROM users")->result_array();
	}
	//add users to db
	public function add_user($users){
		$password = md5($users['password']);
		$query = "INSERT INTO users (first_name,last_name,email,password,user_level,created_at,updated_at) values (?,?,?,?,?,?,?)";
		$values = array($users['first_name'],$users['last_name'],$users['email'],$password,1,date("Y-m-d, H:i:s"),date("Y-m-d, H:i:s"));
		return $this->db->query($query,$values);
	}
	public function update_information($info){
		$id = $this->session->userdata('user')['id'];
		return $this->db->query("UPDATE users SET email = ?,first_name = ?, last_name = ? WHERE id = $id",array($info['email'],$info['first_name'],$info['last_name']));
	}
	public function update_information_by_admin($info){
		$id = $info['id'];
		return $this->db->query("UPDATE users SET email = ?,first_name = ?, last_name = ?, user_level = ? 
		WHERE id = $id",array($info['email'],$info['first_name'],$info['last_name'],$info['level']));
	}
	public function update_password($password){
		$id = $password['id'];
		$newpass = md5($password['password']);
		return $this->db->query("UPDATE users SET password = ? WHERE id = $id",array($newpass));
	}
	public function update_description($description){
		
	}
	public function delete_user($id){
		return $this->db->query("DELETE FROM users WHERE id = $id");
	}

}