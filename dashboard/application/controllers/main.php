<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler();
		$this->load->model("User");
	}

	//Homepage
	public function index()
	{
		// $this->session->sess_destroy();
		$this->load->view('home');
	}
	//sign in page for both user and admin
	public function sign_in()
	{
		//load sign in page when user come to sign in
		$this->load->view("sign_in");
		//process user after form is submitted
			if($this->input->post()){
			//check for errors
			$this->load->library('form_validation');
			$this->form_validation->set_rules("email", "Email", "required|valid_email");
			$this->form_validation->set_rules("password", "Password", "required");
			//if erorrs exist then redirect
			if($this->form_validation->run() === FALSE){
				$this->view_data['errors'] = validation_errors();
				$this->session->set_flashdata('errors2', $this->view_data['errors']);
				redirect('/signin');
				}
			//if validations pass then check email and password
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));
			$user = $this->User->get_user_by_email($email);
			// var_dump($user);
			// die();
			if($user && $user['password'] === $password){
				if($user['user_level']== 1){
				$user = array(
					'id' => $user['id'],
					'first_name' => $user['first_name'],
					'last_name' => $user['last_name'],
					'email' => $user['email'],
					'user_level'=>1,
					'logged_in' => TRUE);
				$this->session->set_userdata('user',$user);
					redirect('/dashboard');
				}elseif($user['user_level']== 9){
					// echo "test";
					// die();
					$user = array(
					'id' => $user['id'],
					'first_name' => $user['first_name'],
					'last_name' => $user['last_name'],
					'email' => $user['email'],
					'user_level'=>9,
					'logged_in' => TRUE);
				$this->session->set_userdata('user',$user);
					redirect(base_url().'admin/dashboard');
				}
			//if email and password don't match then redirect
			}else{
				$this->session->set_flashdata('login_error', "Invalid email or password");
				redirect('/signin');
			}
		}
	}
	//register page
	public function register()
	{
		//load the register page when user clicks the register link
		$this->load->view('register');
	}
	//admin dashboard to edti and remove users
	public function admin_dashboard()
	{
		if($this->session->userdata('user')['logged_in'] === TRUE){
			$users = $this->User->get_users();

			$this->load->view('admin_dashboard',array('users'=>$users));
		}else{
			redirect(base_url());
		}
	}
	//user dashboard to view profile
	public function user_dashboard()
	{	
		if($this->session->userdata('logged_in')['logged_in'] === TRUE){
			$users = $this->User->get_users();

			$this->load->view('user_dashboard',array('users'=>$users));
		}else{
			redirect(base_url());
		}
	}
	//loads the add a new user for admin
	public function user_new(){
		$this->load->view('new_user');
	}
	//method to process new user
	public function add_user()
	{
	//-----------this method is for adding user through admin as well as registrtion page------------->
			$this->load->library('form_validation');
			$this->form_validation->set_rules("first_name", "First Name", "trim|required");
			$this->form_validation->set_rules("last_name", "Last Name", "trim|required");
			$this->form_validation->set_rules("email", "Email", "required|valid_email");
			$this->form_validation->set_rules("password", "Password", "required");
			$this->form_validation->set_rules("password2", "Password2", "required|matches[password]");
			//check if errors exist
			if($this->form_validation->run() === FALSE){
				$this->view_data['errors'] = validation_errors();
				$this->session->set_flashdata('errors', $this->view_data['errors']);
				if($this->input->post('action')=="register"){
					redirect('/register');
				}else{
					redirect('/users/new');
				}
			//if field validation passes, check for existing email in db
			}else{
				$email = $this->input->post('email');
				$email_exists = $this->User->get_user_by_email($email);
				//if email does not exist add the user
				if(empty($email_exists)){
					$add = $this->User->add_user($this->input->post());
					//this for registering a new user
					if($add && $this->input->post('action')=="register"){
						$get_id = $this->User->get_user_by_email($email);
						$user = array(
							'id' => $get_id['id'],
							'first_name' => $this->input->post('first_name'),
							'last_name' => $this->input->post('last_name'),
							'email' => $this->input->post('email'),'logged_in' => TRUE);
						$this->session->set_userdata('user',$user);
						redirect('/dashboard');
					}else{
						$this->session->set_flashdata('errors',"user added");
						redirect('/users/new');
					}
				}
			}
			if($email_exists && $this->input->post('action')=="register"){
				redirect('/register');
			}else{
				redirect('/users/new');
			}
	}
	//user page to edit their profile
	public function profile()
	{
		$id = $this->session->userdata('user')['id'];
		$user_info = $this->User->get_user_by_id2($id);
		$this->load->view('edit_profile',array('user'=>$user_info));
		// $this->load->view('edit_profile');
	}
	//user can edit their profile
	public function edit_profile()
	{
		$this->load->library('form_validation');
		if($this->input->post('action')==='information'){
			$this->form_validation->set_rules("first_name", "First Name", "trim|required");
			$this->form_validation->set_rules("last_name", "Last Name", "trim|required");
			$this->form_validation->set_rules("email", "Email", "required|valid_email");
		}
		if($this->input->post('action')==='password'){
			$this->form_validation->set_rules("password", "Password", "required");
			$this->form_validation->set_rules("password2", "Password2", "required|matches[password]");
		}
		if($this->input->post('action')==='description'){
		    $this->form_validation->set_rules("text", "description", "required");
		}
		//check if errors exist
		if($this->form_validation->run() === FALSE){
			$this->view_data['errors'] = validation_errors();
			$this->session->set_flashdata('info', $this->view_data['errors']);
			redirect('/user/profile');
	//<---------------------if errors pass------------------------------>
		//to update information
		}elseif($this->input->post('action')==='information'){
			$email = $this->input->post('email');
			$email_exists = $this->User->get_user_by_email($email);
			//if email does not exist...
			if(empty($email_exists)){
			$update = $this->User->update_information($this->input->post());
			$this->session->set_flashdata('info',"informaton updated");
			redirect('/user/profile');
		}else{
			$this->session->set_flashdata('info',"eamail exists");
			redirect('/user/profile');
		}
		//to update password
		}elseif($this->input->post('action')==='password'){
			$results = array('id' =>$this->session->userdata('user')['id'],
				'password' => $this->input->post('password'));
			$password = $this->User->update_password($results);
			$this->session->set_flashdata('info',"password updated");
			redirect('/user/profile');
		//to add description
		}elseif($this->input->post('action')==='description'){
			$description = $this->User->update_description($this->input->post());
			$this->session->set_flashdata('info',"decription updated");
			if($description){
			redirect('/user/profile');
			}else{
			$this->session->set_flashdata('info',"decription not updated");
			redirect('/user/profile');
			}
		}
	}
	
	//allows admin to edit user profile and set user level
	public function edit_user($id)
	{

		if($this->input->post()){
			$this->load->library('form_validation');
			if($this->input->post('action')==='information'){
				$this->form_validation->set_rules("first_name", "First Name", "trim|required");
				$this->form_validation->set_rules("last_name", "Last Name", "trim|required");
				$this->form_validation->set_rules("email", "Email", "required|valid_email");
			}
			if($this->input->post('action')==='password'){
				$this->form_validation->set_rules("password", "Password", "required");
				$this->form_validation->set_rules("password2", "Password2", "required|matches[password]");
			}
			//check if errors exist
			if($this->form_validation->run() === FALSE){
				$this->view_data['errors'] = validation_errors();
				$this->session->set_flashdata('info', $this->view_data['errors']);
				redirect('/users/edit/'.$id);
		//<---------------------if errors pass------------------------------>
			//to update information
			}elseif($this->input->post('action')==='information'){
				$email = $this->input->post('email');
				$email_exists = $this->User->get_user_by_email($email);
				//if email does not exist...
				if(empty($email_exists)){
				$info = array('id' =>$id,'email'=>$this->input->post('email'),
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'level'=>$this->input->post('level'));
				$update = $this->User->update_information_by_admin($info);
				$this->session->set_flashdata('info',"informaton updated");
				redirect('/users/edit/'.$id);
				}else{
				$this->session->set_flashdata('info',"eamail exists");
				redirect('/users/edit/'.$id);
				}
			//to update password
			}elseif($this->input->post('action')==='password'){
				$results = array('id' =>$id,
					'password' => $this->input->post('password'));
				$password = $this->User->update_password($results);
				$this->session->set_flashdata('info',"password updated");
				redirect(base_url().'users/edit/'.$id);
			}
		}else{
			$user_info = $this->User->get_user_by_id2($id);
			// $this->load->view('edit_user',array('id'=>$id));
			$this->load->view('edit_user',array('user'=>$user_info));
		}
	}
	//takes user to the wall and displays user information
	public function user_info($id)
	{
		//get user info for the wall
		$receiver_info = $this->User->get_user_by_id($id);
		$this->session->set_userdata('receiver_info',$receiver_info);
		//set the user id in a session for use in add_message method
		$this->session->set_userdata('receiver_id',$receiver_info['id']);
		//fetch messages to display
		$message = $this->User->get_message();
		$comment = $this->User->get_comment();
		// var_dump($comment);
		// die();
		$this->load->view('wall',array('message'=>$message,'comment'=>$comment));

	}
	public function add_message()
	{
		//get id of user recieving message
		$id = $this->session->userdata('receiver_id');
		//if message form is submitted
		if($this->input->post('action')=='post'){
			$data = array('to_id'=>$this->session->userdata('receiver_id'),
				'user_id'=>$this->session->userdata('user')['id'],
				'message' => $this->input->post('text'));
			$message = $this->User->add_message($data);
			// echo 'here';
			// die();
			//redirect back to the wall
			redirect(base_url().'users/info/'.$id);
		}
		if($this->input->post('action')=='comment'){
			$data = array('to_id'=>$this->session->userdata('receiver_id'),
				'user_id'=>$this->session->userdata('user')['id'],
				'message' => $this->input->post('text'),
				'original_msg' => $this->input->post('msg_id'));
			$message = $this->User->add_comment($data);
			// echo 'here';
			// die();
			//redirect back to the wall
			redirect(base_url().'users/info/'.$id);
		}
	}
	//remove user from db
	public function remove($id)
	{
		if($id==33){
			redirect(base_url().'admin/dashboard');
		}
		$delete = $this->User->delete_user($id);
		redirect(base_url().'admin/dashboard');
	}

	
}

//end of main controller