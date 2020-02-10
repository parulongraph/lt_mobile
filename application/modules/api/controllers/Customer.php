<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require_once(APPPATH.'third_party/rest_server/libraries/REST_Controller.php');

class Customer extends REST_Controller {

	 public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('customers');
    }

    public function add_customer_post() {
        // Get the post data
        $name = strip_tags($this->post('name'));
        $mobile_no = strip_tags($this->post('mobile_no'));
        $services_id = strip_tags($this->post('services_id'));
        $reminder_period = strip_tags($this->post('reminder_period'));
        $created_user_id = strip_tags($this->post('created_user_id'));
        
        // Validate the post data
        if(!empty($name) && !empty($mobile_no)  && !empty($services_id) && !empty($reminder_period)){
            // Insert user data
            $customerData = array(
                'name' => $name,
                'mobile_no' => $mobile_no,
                'services_id' => $services_id,
                'reminder_period' => $reminder_period,
                'created_user_id' => $created_user_id
            );
            $insert = $this->customers->insert($customerData);
            
           // Check if the user data is inserted
                if($insert){
                    // Set  the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'The customer has been added successfully.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                } else {
                    // Set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
            // Set the response and exit
            $this->response("Provide complete customer info to add.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function view_customer_get($id = 0) {
    	$data = $this->get();

        // Returns all the users data if the id not specified,
        // Otherwise, a single user will be returned.
        $con = $data ? $data : '';
        $customers = $this->customers->getRows($con);
        
        // Check if the user data exists
        if(!empty($customers)) {
            // Set the response and exit
            //OK (200) being the HTTP response code
            $this->response($customers, REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //NOT_FOUND (404) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'No services was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function edit_customers_post() {
        $id = $this->post('id');
        
        // Get the post data
        $name = strip_tags($this->post('name'));
        $mobile_no = strip_tags($this->post('mobile_no'));
        $services_id = strip_tags($this->post('services_id'));
        $reminder_period = strip_tags($this->post('reminder_period'));
        
        // Validate the post data
        if(!empty($id) && (!empty($name) || !empty($mobile_no) || !empty($services_id) || !empty($reminder_period))) {
            // Update user's account data

            $customersData = array();
            if(!empty($name)) {
                $customersData['name'] = $name;
            }
            if(!empty($mobile_no)) {
                $customersData['mobile_no'] = $mobile_no;
            }
            if(!empty($services_id)) {
                $customersData['services_id'] = $services_id;
            }
            if(!empty($reminder_period)) {
                $customersData['reminder_period'] = md5($reminder_period);
            }
            if(!empty($mobile_no)) {
                $customersData['mobile_no'] = $mobile_no;
            }

            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'id' => $id,
            );
            
            $customerCount = $this->customers->getRows($con);
            if($customerCount <= 0)
            {
                $this->response("Please enter correct data", REST_Controller::HTTP_BAD_REQUEST);
            }
            $update = $this->customers->update($customersData, $id);
            
            // Check if the user data is updated
            if($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The customersData info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide at least one customer info to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


}
