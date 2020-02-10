<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
        $this->load->model('trades');
	}

	// Frontend User CRUD
	public function index()
	{
		$crud = $this->generate_crud('trade');
		$crud->columns('name', 'created_user_id', 'active');

		// disable direct create / delete Frontend User
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Trade';
		$this->render_crud();
	}

	// Create Frontend User
	public function create()
	{
		$form = $this->form_builder->create_form();

		if($this->input->post('name')) {
			
			$name = $this->input->post('name');
	        $created_user_id = $this->input->post('created_user_id');

			// proceed to create service
			$TradeData = array(
                'name' => $name,
                'created_user_id' => $created_user_id
            );
            $insert = $this->trades->insert($TradeData);
			if ($insert)
			{
				// success
				$this->system_message->set_success('Trade has been added successfully.');
			}
			else
			{
				// failed
				$this->system_message->set_error('Some problems occurred, please try again');
			}
			refresh();
		}

		$this->mPageTitle = 'Create Trade';

		$this->mViewData['form'] = $form;
		$this->render('trade/create');
	}

}
