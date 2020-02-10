<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
        $this->load->model('templates');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('template');
		$crud->columns('name', 'type', 'message');

		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Templates';
		$this->render_crud();
	}

	// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if($this->input->post('name')) {
			
			$name = $this->input->post('name');
	        $type = $this->input->post('type');
	        $message = $this->input->post('message');

			// proceed to create service
			$TemplateData = array(
                'name' => $name,
                'type' => $type,
                'message' => $message
            );
            $insert = $this->templates->insert($TemplateData);
			if ($insert)
			{
				// success
				$this->system_message->set_success('Template has been added successfully.');
			}
			else
			{
				// failed
				$this->system_message->set_error('Some problems occurred, please try again');
			}
			refresh();
		}

		$this->mPageTitle = 'Create Template';

		$this->mViewData['form'] = $form;
		$this->render('template/create');
	}

}
