<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {

	public function index()
	{
		$this->load->model('users');
		$data = array('$id',1);
		$con = $data ? $data : '';
		$this->mViewData['count'] = array(
			'users' => count($this->users->getRows($con))
		);

		$this->load->model('services');
		$data = array('$id',1);
		$con = $data ? $data : '';
		$this->mViewData['services'] = array(
			'services' => count($this->services->getRows($con)),
		);

		$this->load->model('packages');
		$data = array('$id',1);
		$con = $data ? $data : '';
		$this->mViewData['packages'] = array(
			'packages' => count($this->packages->getRows($con)),
		);

		$this->load->model('trades');
		$data = array('$id',1);
		$con = $data ? $data : '';
		$this->mViewData['trades'] = array(
			'trades' => count($this->trades->getRows($con)),
		);

		$this->render('home');
	}
}
