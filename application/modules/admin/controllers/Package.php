<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
        $this->load->model('packages');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('packages');
		$crud->columns('name', 'messages', 'price', 'active');

		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Packages';
		$this->render_crud();
	}

	// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if($this->input->post('name')) {
			
			$name = $this->input->post('name');
	        $messages = $this->input->post('messages');
	        $price = $this->input->post('price');

			// proceed to create service
			$packageData = array(
                'name' => $name,
                'messages' => $messages,
                'price' => $price
            );
            $insert = $this->packages->insert($packageData);
			if ($insert)
			{
				// success
				$this->system_message->set_success('packages has been added successfully.');
			}
			else
			{
				// failed
				$this->system_message->set_error('Some problems occurred, please try again');
			}
			refresh();
		}

		$this->mPageTitle = 'Create Package';

		$this->mViewData['form'] = $form;
		$this->render('package/create');
	}

}
