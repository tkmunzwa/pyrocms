<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Galleries extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->load->model('galleries_m');
		$this->lang->load('galleries');
	}
	
	// Public: List Galleries
	function index()
	{
		$this->data->galleries = $this->galleries_m->getGalleries(array('parent'=>0));
		$this->template->build('index', $this->data);
	}
	
	// Public: View an Gallery
	function view($slug = '')
	{
		$this->load->model('comments/comments_m');
		
		if($this->data->gallery = $this->galleries_m->getGallery($slug))
		{
			$this->data->photos = $this->galleries_m->getPhotos($slug);		
			$this->data->children = $this->galleries_m->getGalleries(array('parent'=>$this->data->gallery->id));		
			$this->template->title($this->data->gallery->title);
			$this->template->build('view', $this->data);
		}		
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('gal_already_exist_error'));
			redirect('galleries');
		}
	}    
}
?>