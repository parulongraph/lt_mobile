<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'template';
    }

      /*
     * Insert user data
     */
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("created_on", $data)){
            $data['created_on'] = date("Y-m-d H:i:s");
        }
        
        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);
        
        //return the status
        return $insert?$this->db->insert_id():false;
    }

    /*
     * Get rows from the users table
     */
    function getRows($params = array()) {
        $this->db->select('*');
        $this->db->from($this->userTbl);
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)) {
            foreach($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("id",$params)) {
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)) {
                $this->db->limit($params['limit'],$params['start']);
            } elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)) {
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count') {
                $result = $this->db->count_all_results();    
            } elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single') {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->row_array():false;
            } else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():false;
            }
        }

        //return fetched data
        return $result;
    }

     /*
     * Update service data
     */
    public function update($data, $id) {
        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('id'=>$id));
        //return the status
        return $update ? true : false;
    }
}