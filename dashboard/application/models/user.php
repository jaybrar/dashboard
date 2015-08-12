<?php
class User extends CI_Model{

	//get single record
	public function get_user_by_email($email){
		return $this->db->query("SELECT * FROM users where email = ?", array($email))->row_array();
	}
	public function get_user_by_id($id){
		return $this->db->query("SELECT concat_ws(' ',first_name,last_name) as name,created_at, id,
			email,description FROM users where id = ?", array($id))->row_array();
	}
	public function get_user_by_id2($id){
		return $this->db->query("SELECT * FROM users where id = ?", array($id))->row_array();
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
		$desc = $description['text'];
		$id = $this->session->userdata('user')['id'];
		return $this->db->query("UPDATE users SET description= ? WHERE id = $id",array($desc));
	}
	public function delete_user($id){
		return $this->db->query("DELETE FROM messages WHERE user_id = $id");
		return $this->db->query("DELETE FROM users WHERE id = $id");
	}
	public function add_message($data){
		$query = "INSERT INTO messages (message,created_at,user_id,to_id) VALUES (?,?,?,?)";
		$values = array($data['message'],date("Y-m-d, H:i:s"),$data['user_id'],$data['to_id']);
		return $this->db->query($query,$values);
	}
	public function add_comment($data){
		$query = "INSERT INTO messages (message,created_at,user_id,to_id,original_msg) VALUES (?,?,?,?,?)";
		$values = array($data['message'],date("Y-m-d, H:i:s"),$data['user_id'],$data['to_id'],$data['original_msg']);
		return $this->db->query($query,$values);
	}
	public function get_message(){
		$id = $this->session->userdata('receiver_id');
		return $this->db->query("SELECT concat_ws(' ',u.first_name,u.last_name) as name,u.id as user_id, m.message, m.id,m.created_at from users u 
		left join messages m on u.id = m.user_id where m.to_id =$id  and m.original_msg is null order by m.created_at desc")->result_array();
	}
	public function get_comment(){
		$id = $this->session->userdata('receiver_id');
		return $this->db->query("SELECT concat_ws(' ',u.first_name,u.last_name) as name,m.user_id,message,m.original_msg,m.created_at from messages m 
		left join users u on u.id = m.user_id where to_id = $id and original_msg is not null order by m.created_at desc")->result_array();
	}

}




