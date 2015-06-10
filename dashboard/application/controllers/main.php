<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
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
		if($this->session->userdata('logged_in') === TRUE){
			$users = $this->User->get_users();

			$this->load->view('admin_dashboard',array('users'=>$users));
		}else{
			redirect(base_url());
		}
	}
	//user dashboard to view profile
	public function user_dashboard()
	{	
		if($this->session->userdata('logged_in') === TRUE){
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
		// if($this->input->post()){
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
				//if email does not exist...
				if(empty($email_exists)){
					$add = $this->User->add_user($this->input->post());
					if($add && $this->input->post('action')=="register"){
						$user = array(
							'first_name' => $this->input->post('first_name'),
							'last_name' => $this->input->post('last_name'),
							'email' => $this->input->post('email'),'logged_in' => TRUE);
						$this->session->set_userdata($user);
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
		// }
	}
	//user page to edit their profile
	public function profile()
	{
		$this->load->view('edit_profile');
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
			redirect('/user/profile');
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
		//to add description
		}
		}else{

			$this->load->view('edit_user',array('id'=>$id));
		}
	}
	//takes user to the wall and displays user information
	public function user_info($id)
	{
		echo "Welcome to CodeIgniter. The default Controller is user_info";
		echo $id;
	}
	//remove user from db
	public function remove($id)
	{
		$delete = $this->User->delete_user($id);
		redirect(base_url().'admin/dashboard');
	}

	
}

//end of main controller