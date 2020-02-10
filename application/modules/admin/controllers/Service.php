<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
        $this->load->model('services');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('services');
		$crud->columns('name', 'active');

		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Services';
		$this->render_crud();
	}

	// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if($this->input->post('name')) {
			$name = $this->input->post('name');

			// proceed to create service
			$ServiceData = array(
                'name' => $name
            );
            $insert = $this->services->insert($ServiceData);
			if ($insert)
			{
				// success
				$this->system_message->set_success('Service Added successfully');
			}
			else
			{
				// failed
				$this->system_message->set_error('Service Not Added');
			}
			refresh();
		}

		$this->mPageTitle = 'Create Service';

		$this->mViewData['form'] = $form;
		$this->render('service/create');
	}

}
