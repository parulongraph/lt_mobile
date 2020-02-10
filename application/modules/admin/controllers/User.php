<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('users');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('user');
		$crud->columns('user_name', 'email', 'mobile_no', 'business_name', 'password','active');
		$this->unset_crud_fields('ip_address', 'last_login');

		// only webmaster and admin can reset user password
		// if ($this->ion_auth->in_group(array('webmaster', 'admin')))
		// {
		// 	$crud->add_action('Reset Password', '', 'admin/user/reset_password', 'fa fa-repeat');
		// }

		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Users';
		$this->render_crud();
	}

	// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if($this->input->post()) {
			$user_name = $this->input->post('user_name');
			$email = $this->input->post('email');
			$mobile_no = $this->input->post('mobile_no');
			$business_name = $this->input->post('business_name');
			$password = $this->input->post('password');

			// proceed to create user
			$userData = array(
                'user_name' => $user_name,
                'business_name' => $business_name,
                'password' => md5($password),
                'email' => $email,
                'mobile_no' => $mobile_no
            );
            $insert = $this->users->insert($userData);
			if ($insert)
			{
				// success
				$this->system_message->set_success('User Added successfully');
			}
			else
			{
				// failed
				$this->system_message->set_error('Some problems occurred, please try again');
			}
			refresh();
		}

		// get list of Frontend user groups
		$this->mPageTitle = 'Create User';

		$this->mViewData['form'] = $form;
		$this->render('user/create');
	}

	// Frontend User Reset Password
	public function reset_password($id)
	{
		//echo "<pre>";print_r($id);die;
		// only top-level users can reset user passwords
		$this->verify_auth(array('webmaster', 'admin'));

		$form = $this->form_builder->create_form();
		if ($form->validate())
		{
			// pass validation
			$data = array('password' => $this->input->post('new_password'));
			
			// [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
			$this->ion_auth_model->tables = array(
				'users'				=> 'user',
				'groups'			=> 'groups',
				'users_groups'		=> 'users_groups',
				'login_attempts'	=> 'login_attempts',
			);

			// proceed to change user password
			if ($this->ion_auth->update($id, $data))
			{
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
			}
			else
			{
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			refresh();
		}

		$this->load->model('users', 'user');
		$target = $this->users->get($id);
		echo "<pre>";print_r($target);die;
		$this->mViewData['target'] = $target;

		$this->mViewData['form'] = $form;
		$this->mPageTitle = 'Reset User Password';
		$this->render('user/reset_password');
	}
}
