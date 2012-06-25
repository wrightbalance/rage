<?php

class Cms extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	
		$this->load->model('accounts_db');
		$this->load->model('cms_db');
		$this->load->model('notif_db');
		
		
	}
	
	function getPubPage()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$furl = $this->input->post('furl');

		$cond = array('friendly_url'=>$furl);
		
		$page = $this->cms_db->getPage($cond);
		$data['db'] 			= isset($page[0]) ? $page[0] : array();
		
		if(!$data['db'])
		{
			$data['db']['page_title'] = "Page Under Construction";
			$data['db']['page_body'] = "This page is either under construction.";
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}

	function news()
	{
		$this->benchmark->mark('code_start');
		
		$mod 				= $this->uri->segment(1);
		$page 				= $this->uri->segment(2);
		
		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= $page;
		$data['mod'] 		= $mod;
		
		if(!$this->input->is_ajax_request())
		{
			$data['content'] = $this->load->view('layout/content',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			$this->load->vars($data);
			$this->load->view("{$data['mod']}/{$data['page']}",$data);
		}
		$this->minify->html();
	}
	
	function pages()
	{
		$this->benchmark->mark('code_start');
		
		$mod 				= $this->uri->segment(1);
		$page 				= $this->uri->segment(2);
		
		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= $page;
		$data['mod'] 		= $mod;
		
		if(!$this->input->is_ajax_request())
		{
			$data['content'] = $this->load->view('layout/content',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			$this->load->vars($data);
			$this->load->view("{$data['mod']}/{$data['page']}",$data);
		}
		$this->minify->html();
	}
	
	function post()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('title','News Title','required');
		$this->form_validation->set_rules('body','News Body','required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['action'] = "retry";
			$this->form_validation->set_error_delimiters('<li>','</li>');
			
			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message res_alert\">";
			$data['message'] .= "<ul>".validation_errors()."</ul>";
			$data['message'] .="</div>";
			$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Retry</button>";
			$data['action'] = "retry2";
		}
		else
		{
			$newsid 			= (string)$this->input->post('id');
			$db['title'] 	= trim($this->input->post('title'));
			$db['body'] 	= trim($this->input->post('body'));
			$db['status'] 		= (int)$this->input->post('status');
			$db['category'] 	= $this->input->post('category');
			$db['friendly_url'] = url_friendly($db['title']);
			$db['created_on']		= date('Y-m-d H:i:s');
			$db['modified_on']		= "0000-00-00 00:00:00";
			$db['author']		= $this->accountid;
			$db['patcher']		= $this->input->post('patcher');
			
			if($newsid)
				$db['modified_on'] = date('Y-m-d H:i:s');
			
			$data['source']	= "news";
			
			
			$this->cms_db->save($db,$newsid);
			
			$data['action'] = "reset";
			
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function post_page()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('title','Page Title','required');
		$this->form_validation->set_rules('body','Page Body','required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['action'] = "retry";
			$this->form_validation->set_error_delimiters('<li>','</li>');
			
			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message res_alert\">";
			$data['message'] .= "<ul>".validation_errors()."</ul>";
			$data['message'] .="</div>";
			$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Retry</button>";
			$data['action'] = "retry2";
		}
		else
		{
			$pageid 				= $this->input->post('id');
			$db['title'] 			= trim($this->input->post('title'));
			$db['body'] 			= trim($this->input->post('body'));
			$db['status'] 			= $this->input->post('status');
			$db['friendly_url'] 	= url_friendly($db['title']);
			$db['created_on']		= date('Y-m-d H:i:s');
			$db['modified_on']		= "0000-00-00 00:00:00";
			
			if($pageid)	
				$db['modified_on'] = date('Y-m-d H:i:s');
				
			$data['source'] = "pages";
			
			
			$this->cms_db->save_page($db,$pageid);
			
			$data['action'] = "reset";
			
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getListNews()
	{
		if($this->authorize == false) exit();
		
		$this->benchmark->mark('code_start');
		$cond = array();
		$data 			= $this->cms_db->getListNews($cond);
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view('cms/table/news',$data);
		
	}
	
	function getListPages()
	{
		if($this->authorize == false) exit();
		
		$this->benchmark->mark('code_start');
		$cond = array();
		$data 			= $this->cms_db->getListPages($cond);
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view('cms/table/pages',$data);
	}
	
	function getNews()
	{
		$this->benchmark->mark('code_start');
		
		$newsid = $this->input->post('newsid');
		$kind = $this->input->post('kind');
		
		$cond = array('id'=>$newsid);
		
		$news = $this->cms_db->getNews($cond);
		
		$data['db'] 			= $news;
		
		$sdb['source_id'] 		= $newsid;
		$sdb['kind'] 			= $kind;
		$sdb['n_created'] 		= date('Y-m-d H:i:s');
		$sdb['account_id'] 		= $this->accountid;
		
		///$data['count'] 	= $this->notif_db->saveNotif($sdb);
		$data['kind'] 	= $kind;
		
		$data['elapsed'] 		= $this->benchmark->elapsed_time('code_start', 'code_end');
		
		$data['json'] 			= $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getPage()
	{
		$this->benchmark->mark('code_start');
		
		$pageid = $this->input->post('pageid');
		$kind = $this->input->post('kind');
		
		$cond = array('id'=>$pageid);
		
		$page 					= $this->cms_db->getPage($cond);
		$data['db'] 			= $page;

		$data['elapsed'] 		= $this->benchmark->elapsed_time('code_start', 'code_end');
		
		$data['json'] 			= $data;
		$this->load->view('ajax/json',$data);
	}
	
	
	function newsdelete()
	{
		$admin = $this->session->userdata('groupid');
		if($admin < config_item('group_level')) exit();
		
		$cond = array('_id'=>$this->mongo_db->mongoID($this->input->post('newsid')));
		$this->cms_db->deleteNews($cond);
		
		$data['msg'] = "deleted";
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
	
	function getNewsList()
	{
		$cond = array('category'=>$this->input->post('kind'));
		
		$news = $this->cms_db->getNewsList($cond);
		
		$y = array();
		
		foreach($news as $n)
		{
			$y[] = array(
				'category'		=> $n['category']
				,'news_title' 	=> $n['news_title']
				,'created' 		=> date('M d, Y',strtotime($n['created']))
				,'_id'			=> (string)$n['_id']
				);
		}
		
		$data['news'] = $y;
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function page($page="")
	{
		$this->benchmark->mark('code_start');
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		
		
		$data['page'] 		= "page";
		$data['mod']		= "cms";
		
		$data['page_details'] = $this->cms_db->getPage(array('friendly_url'=>$page));
		
		//print_r($data['page_details']); exit();
		
		if(!$this->input->is_ajax_request())
		{
			
			if($this->accountid)
			{
				$data['cssgroup'] 	= "loggedin";
				$data['jsgroup'] 	= "loggedin";
				$data['content'] = $this->load->view('layout/content',$data,true);
			}
			else
			{
				$data['form'] = "frm_register";
				$data['formtitle'] = "Create your Account";
				$data['page_content'] = $this->load->view("{$data['mod']}/{$data['page']}",$data,true);
				$data['content'] = $this->load->view("main/index",$data,true);
			}
		
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			$this->load->vars($data);
			$this->load->view("{$data['mod']}/{$data['page']}",$data);
		}
		$this->minify->html();
	}
}
