<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require_once(APPPATH.'third_party/rest_server/libraries/REST_Controller.php');

class Authentication extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('users');
    }
    
    public function login_post() {
        // Get the post data
        $email = $this->post('email');
        $password = $this->post('password');
        
        // Validate the post data
        if(!empty($email) && !empty($password)) {
            
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'email' => $email,
                'password' => md5($password),
                'active' => 1
            );
            $user = $this->users->getRows($con);
            
            if($user) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User login successful.',
                    'data' => $user
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response("Wrong email or password.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide email and password.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function registration_post() {
        // Get the post data
        $user_name = strip_tags($this->post('user_name'));
        $email = strip_tags($this->post('email'));
        $business_name = strip_tags($this->post('business_name'));
        $password = $this->post('password');
        $mobile_no = strip_tags($this->post('mobile_no'));
        
        // Validate the post data
        if(!empty($user_name) && !empty($business_name)  && !empty($email) && !empty($mobile_no) && !empty($password)){

            // Check if the given email already exists
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'email' => $email,
            );
            $userCount = $this->users->getRows($con);
            
            if($userCount > 0) {
                // Set the response and exit
                $this->response("The given email already exists.", REST_Controller::HTTP_BAD_REQUEST);
            } else {
            // Insert user data
            $userData = array(
                'user_name' => $user_name,
                'business_name' => $business_name,
                'password' => md5($password),
                'email' => $email,
                'mobile_no' => $mobile_no
            );
            $insert = $this->user->insert($userData);
            
           // Check if the user data is inserted
                if($insert) {
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'The user has been added successfully.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                } else {
                    // Set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        } else {
            // Set the response and exit
            $this->response("Provide complete user info to add.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function reset_password_post() {

        // Get the post data
        $email = strip_tags($this->post('email'));

        $con['returnType'] = 'count';
        $con['conditions'] = array(
            'email' => $email,
        );
        $userCount = $this->user->getRows($con);
        
        if($userCount < 0) {
            // Set the response and exit
            $this->response("The given email not exist.", REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.googlemail.com';
            $config['smtp_port'] = '465';
            // $config['smtp_timeout'] = '30';
            $config['smtp_user'] = 'parul.ongraph@gmail.com';
            $config['smtp_pass'] = 'ongraph123';
            // $config['charset'] = 'utf-8';
            // $config['mailtype'] = 'html';
            // $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n";

            $this->email->initialize($config);
            $this->load->library('email',$config);
            $this->email->from('parul.ongraph@gmail.com', 'LT Mobile APP');
            $this->email->to('parulgupta7510@gmail.com');

            $this->email->subject('Reset Password');
            $this->email->message('Testing the email class.');

            $email_send = $this->email->send();
            echo $this->email->print_debugger();
            if (!$email_send) {
                 $this->response('Failed to send password, please try again!');
            } else {
               $this->response('Password sent to your email!');
            }
        }

    }
    
    public function user_profileData_get($id = 0) {
        $data = $this->get();
        // Returns all the users data if the id not specified,
        // Otherwise, a single user will be returned.
        $con = $data ? $data : '';
        $users = $this->user->getRows($con);

        // Check if the user data exists
        if(!empty($users)) {
            // Set the response and exit
            //OK (200) being the HTTP response code
            $this->response($users, REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //NOT_FOUND (404) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'No user was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function user_profile_post() {
        $id = $this->post('id');
        
        // Get the post data
        $user_name = strip_tags($this->post('user_name'));
        $email = strip_tags($this->post('email'));
        $business_name = strip_tags($this->post('business_name'));
        $password = $this->post('password');
        $mobile_no = strip_tags($this->post('mobile_no'));
        
        // Validate the post data
        if(!empty($id) && (!empty($user_name) || !empty($email) || !empty($business_name) || !empty($password) || !empty($mobile_no))) {
            // Update user's account data
            $userData = array();
            if(!empty($user_name)) {
                $userData['user_name'] = $user_name;
            }
            if(!empty($email)) {
                $userData['email'] = $email;
            }
            if(!empty($email)) {
                $userData['business_name'] = $business_name;
            }
            if(!empty($password)) {
                $userData['password'] = md5($password);
            }
            if(!empty($mobile_no)) {
                $userData['mobile_no'] = $mobile_no;
            }
            $update = $this->user->update($userData, $id);
            
            // Check if the user data is updated
            if($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The user info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide at least one user info to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}