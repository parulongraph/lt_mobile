<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
        $this->load->model('customers');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('customer');
		$crud->columns('name', 'mobile_no', 'services_id','reminder_period','created_user_id', 'active');

		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Customers';
		$this->render_crud();
	}

	// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if($this->input->post('name')) {
			
			$name = $this->input->post('name');
	        $mobile_no = $this->input->post('mobile_no');
	        $services_id = $this->input->post('services_id');
	        $reminder_period = $this->input->post('reminder_period');
	        $created_user_id = $this->input->post('created_user_id');

			// proceed to create service
			$customerData = array(
                'name' => $name,
                'mobile_no' => $mobile_no,
                'services_id' => $services_id,
                'reminder_period' => $reminder_period,
                'created_user_id' => $created_user_id
            );
            $insert = $this->customers->insert($customerData);
			if ($insert)
			{
				// success
				$this->system_message->set_success('Customer has been added successfully.');
			}
			else
			{
				// failed
				$this->system_message->set_error('Some problems occurred, please try again');
			}
			refresh();
		}

		$this->mPageTitle = 'Create Customers';

		$this->mViewData['form'] = $form;
		$this->render('customer/create');
	}

}
