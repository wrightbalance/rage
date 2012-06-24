<?php
	class Vote extends MY_Controller
	{
		var $accountid;
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('vote_db');
			$this->load->model('char_db');
		}
		
		function index()
		{
			$this->benchmark->mark('code_start');

			$data['cssgroup'] 	= "loggedin";
			$data['jsgroup'] 	= "loggedin";
			$data['page'] 		= "index";
			$data['mod'] 		= "vote";

			$details = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$data['details'] = $details;
			$data['banners'] = array();
			
			$banners = $this->vote_db->getBanners(array(),true);
			$data['cashpoints'] = $this->vote_db->getCashpoint($this->accountid);
			
			$count_last_mac  = 0;
			$last_mac_vote = "";
			
			
			
			foreach($banners as $b)
			{
				$lastvote = $this->vote_db->getLastVote(array('banner_id'=>$b['id'],'account_id'=>$this->accountid),true);

				if(config_item('use_mac_address'))
				{
					$lastmac = $this->vote_db->getLastVote(array('banner_id'=>$b['id']),true);
			
					if($lastmac)
					{
						$last_mac_vote = $lastmac['vote_date'];
						$count_last_mac = count($lastmac);
					}
				}
				
				$data['banners'][] = array(
					'id' 				=> $b['id'],
					'credits' 			=> $b['credits'],
					'hours' 			=> $b['hours'],
					'image_url' 		=> $b['image_url'],
					'vote_url' 			=> $b['vote_url'],
					'lastvote'			=> $lastvote,
					'last_mac'  		=> $count_last_mac,
					'last_mac_vote' 	=> $last_mac_vote
					);
			}
			
			$data['char'] = $this->char_db->getChar(array('account_id'=>$this->accountid));

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
		
		function banner()
		{
			$admin = $this->session->userdata('groupid');
			if($admin < config_item('group_level')) exit(); // If not authorize just exit
		
			$this->benchmark->mark('code_start');
			$this->load->model('accounts_db');

			$data['cssgroup'] = "loggedin";
			$data['jsgroup'] = "loggedin";
			$data['page'] 	= 'vote';

			$details = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$data['details'] = $details;

			if(!$this->input->is_ajax_request())
			{
				if(!$this->accountid) redirect();

				$data['content'] = $this->load->view('vote/vote',$data,true);

				$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
				$this->load->vars($data);
				$this->load->view('default',$data);

			}
			else
			{
				checkSession();

				$this->load->vars($data);
				$this->load->view('vote/widget/w_vote',$data);
			}
			$this->minify->html();
		}
		
		function getList()
		{
			$this->benchmark->mark('code_start');

			$data 			= $this->vote_db->getList();
			$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->view('vote/table/banner',$data);
		}
		
		function post()
		{
			if(!$this->input->is_ajax_request()) exit();
			$admin = $this->session->userdata('groupid');
			if($admin < config_item('group_level')) exit(); // If not authorize just exit
			
			
			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('hours','Interval','required');
			$this->form_validation->set_rules('credits','Credits','required');
			$this->form_validation->set_rules('vote_url','Vote URL','required');
			$this->form_validation->set_rules('image_url','Image URL','required');
			
			if($this->form_validation->run() === FALSE)
			{
				$this->form_validation->set_error_delimiters('<li>','</li>');

				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message res_alert\">";
				$data['message'] .= "<ul>".validation_errors()."</ul>";
				$data['message'] .="</div>";
				$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Retry</button>";
				$data['action'] = "retry";

			}
			else
			{
				$id = $this->input->post('id');
				
				$db['name'] 		= trim($this->input->post('name'));
				$db['hours'] 		= trim($this->input->post('hours'));
				$db['credits'] 		= trim($this->input->post('credits'));
				$db['image_url'] 	= trim($this->input->post('image_url'));
				$db['vote_url'] 	= trim($this->input->post('vote_url'));
				$db['created'] 	= date('Y-m-d H:i:s');
				
				$data['action'] = "reset";
				$data['source']	= "vote";
				
				$this->vote_db->save($db,$id);
			}
			
			$data['json'] = $data;
			$this->load->view('ajax/json',$data);
		}
		
		function getBanners()
		{
			if(!$this->input->is_ajax_request()) exit();
			
			$cond = array('id'=>$this->input->post('id'));
			$data['db'] = $this->vote_db->getBanners($cond);
			$data['json'] = $data;
			$this->load->view('ajax/json',$data);
		}
		
		function in($id)
		{
			if(empty($id)) redirect('vote');
			
			$banner = $this->vote_db->getBanners(array('id'=>$id));
			
			
			if($banner)
			{
				$db['banner_id'] = $id;
				$db['account_id'] = $this->accountid;
				$db['credits'] = $banner['credits'];
				$db['vote_date'] = date('Y-m-d H:i:s');
				$db['vote_ip'] = $this->input->ip_address();
				$allowed = true;
				
				if(config_item('use_mac_address'))
				{
					$account = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
					$lastvote = $this->vote_db->getLastVote(array('banner_id'=>$id,'account_id'=>$this->accountid));
					
					$db['mac_address'] = $account['last_mac'];
					
					if($lastvote['mac_address'] == $account['last_mac'])
					{
						$allowed = false;
					}

					$vote = $this->vote_db->getVotes(array('account_id'=>$this->accountid,'banner_id'=>$id,'mac_address'=>$account['last_mac']));
				
				}
				else
				{

					$vote = $this->vote_db->getVotes(array('account_id'=>$this->accountid,'banner_id'=>$id));
				}

				if($allowed && isset($vote['vote_date']) && strtotime($vote['vote_date']) + (60*60*($banner['hours'])) > time())
				{
					echo "Not allowed to vote";
					redirect('vote');
				}
				else
				{
					// Not allowes to vote if mac_address
					
					if(config_item('use_mac_address'))
					{
						
					}
					
					$this->vote_db->save_vote($db);
					redirect($banner['vote_url']);
				}
			}
			else
			{
				redirect('vote');
			}
			
			exit();
		}
		
		function delete()
		{
			if(!$this->input->is_ajax_request()) exit();
			
			$id = $this->input->post('id');
			
			$this->vote_db->delete(array('id'=>$id));
			
			$data['deleted'] = "true";
			$data['json'] = $data;
			$this->load->view('ajax/json',$data);
		}
	}
?>
