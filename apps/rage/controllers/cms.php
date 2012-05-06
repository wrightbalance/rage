<?php

class Cms extends CI_Controller
{
	private $accountid;

	function __construct()
	{
		parent::__construct();
		
		checkSession();
		
		$this->load->model('accounts_db');
		$this->load->model('cms_db');
		$this->accountid = $this->session->userdata('accountid');
		
	}

	function news()
	{
		$this->benchmark->mark('code_start');
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'news';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];

		$data['accounts'] = $this->accounts_db->getAccounts();
		
		if(!$this->input->is_ajax_request())
		{
			
		
			$data['content'] = $this->load->view('cms/news',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('cms/widget/w_news',$data);
		}
		$this->minify->html();
	}
	
	function post()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('news_title','News Title','required');
		$this->form_validation->set_rules('news_body','News Body','required');
		
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
			$newsid 			= (string)$this->input->post('_id');
			$db['news_title'] 	= trim($this->input->post('news_title'));
			$db['news_body'] 	= trim($this->input->post('news_body'));
			$db['publish'] 		= (int)$this->input->post('publish');
			$db['category'] 	= $this->input->post('category');
			$db['friendly_url'] = url_friendly($db['news_title']);
			$db['created']		= date('Y-m-d H:i:s');
			$db['modified']		= "0000-00-00 00:00:00";
			$db['author']		= $this->accountid;
			$db['patcher']		= (int)$this->input->post('patcher');
			
			if($newsid)
				$db['modified'] = date('Y-m-d H:i:s');
			
			
			$this->cms_db->save($db,$newsid);
			
			$data['action'] = "reset";
			
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getListNews()
	{
		$admin = $this->session->userdata('groupid');
		if($admin < config_item('group_level')) exit();
		
		$this->benchmark->mark('code_start');
		
		$data 			= $this->cms_db->getListNews($cond);
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view('cms/table/news',$data);
	}
	
	function getNews()
	{
		$this->benchmark->mark('code_start');
		
		$cond = array('_id'=>$this->mongo_db->mongoID($this->input->post('newsid')));
		
		$news = $this->cms_db->getNews($cond);
		
		$data['db'] 			= $news[0];
		$data['db']['_id']		= (string)$data['db']['_id'];
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$data['json'] = $data;
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
}
