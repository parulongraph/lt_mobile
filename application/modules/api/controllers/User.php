<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require_once(APPPATH.'third_party/rest_server/libraries/REST_Controller.php');

class User extends REST_Controller {

	 public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('services');
    }

    public function add_services_post() {
        // Get the post data
        $name = strip_tags($this->post('name'));
        
        // Validate the post data
        if(!empty($name)) {
            // Insert user data
            $ServiceData = array(
                'name' => $name
            );
            $insert = $this->services->insert($ServiceData);
            
           // Check if the user data is inserted
                if($insert){
                    // Set  the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'The service has been added successfully.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                } else {
                    // Set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
            // Set the response and exit
            $this->response("Please Enter service name.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function view_service_get($id = 0) {
    	$data = $this->get();
        // Returns all the users data if the id not specified,
        // Otherwise, a single user will be returned.
        $con = $data ? $data : '';
        $services = $this->services->getRows($con);
        
        // Check if the user data exists
        if(!empty($services)) {
            // Set the response and exit
            //OK (200) being the HTTP response code
            $this->response($services, REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //NOT_FOUND (404) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'No services was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function edit_service_post() {
        $id = $this->post('id');
        
        // Get the post data
        $name = strip_tags($this->post('name'));
        
        // Validate the post data
        if(!empty($id) && (!empty($name))) {
            // Update user's account data
            $serviceData = array();
            if(!empty($name)) {
                $serviceData['name'] = $name;
            }
            
            $update = $this->services->update($serviceData, $id);
            
            // Check if the user data is updated
            if($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The service info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide at least one service info to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


}
