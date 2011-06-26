<?php
class Auth extends Controller {

	function Auth()
	{
		parent::Controller();	
		$this->load->model('irsdp_model');
	}
	
	function index()
	{
		// session check
		/*if($this->session->userdata('group')!='') redirect($this->session->userdata('group'));	
				
		$data['main'] = 'auth/index';
		$this->load->view('auth/index', $data);*/
		$this->home();
	}
	
	function login()
	{
		// session check
		if($this->session->userdata('group')!='') redirect($this->session->userdata('group'));	
				
		$data['main'] = 'auth/index';
		$this->load->view('auth/index', $data);
	}
	
	function home()
	{
		$data['main'] = 'auth/home';
		$data['header']='Selamat Datang';
		$data['headerside']='Open Project';
		$this->load->view('auth/home', $data);
	}
	
	function open_project()
	{
		$data['page'] = 'auth/open_project';
		$data['menu'] = 'auth/menu';
		$data['header']='Open Project';
		$this->load->view('auth/container', $data);
	}
	
	function daftar()
	{		
		$data['menu'] = 'auth/menu';
		$this->load->library('captcha');
        $this->load->library('validation');
		$data['form_title'] = 'Registration Form';
		$data['msg_captcha']='';
		$expiration = time()-300;
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
		$vals = array(
					//'word'         => 'Random word',
					'img_path'     => './uploads/',
					'img_url'     => base_url().'uploads/',
					'font_path'     => './system/fonts/arialbd.ttf',
					'img_width'     => '130',
					'img_height' => '40',
					'expiration' => '3600'
				);

		$cap = $this->captcha->create_captcha($vals);
		//load gambar captcha
		$data['image']= $cap['image'];
		//atribut captcha
		$param = array(
					'captcha_id'    => '',
					'captcha_time'    => time(),
					'ip_address'    => $this->input->ip_address(),
					'word'            => $cap['word']
				);
		//input captcha di db
		$query = $this->db->insert_string('captcha', $param);
		$this->db->query($query);
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama', 'Nama Konsultan (Perusahaan)', 'required|xss_clean');
			$this->form_validation->set_rules('jenis', 'Tipe Konsultan', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|xss_clean');
			$this->form_validation->set_rules('telpon', 'Nomor Telepon', 'required|xss_clean');
			$this->form_validation->set_rules('captcha', 'Teks Captcha', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
				if($this->irsdp_model->cek_captcha($this->input->post('captcha'),$this->input->ip_address()) == FALSE)
					$data['msg_captcha']="Teks Captcha Salah";
			}			
			else
			{						
				$param = array('nama' => $this->input->post('nama'),
								'jenis' => $this->input->post('jenis'),
								'alamat' => $this->input->post('alamat'),
								'telpon' => $this->input->post('telpon'),
								'fax' => $this->input->post('fax'),
								'hp' => $this->input->post('hp'),
								'email' => $this->input->post('email'),
								'website' => $this->input->post('website'),
								'status' => '0'
								);
									
				$this->irsdp_model->add_konsultan($param);
				redirect('auth/reg_info');
			}	
		}	
		$this->load->view('auth/reg_konsultan', $data);		
	}
	
	function cek_captcha($captcha,$ip)
    {
		//Cek captcha
		$exp=time()-600;
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($captcha, $ip, $exp);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}  
	
	function reg_info()
	{		
		$data['menu'] = 'auth/menu';
		$data['main'] = 'auth/home';
		$data['header']='Pendaftaran Berhasil';
		$data['headerside']='Open Project';
		$this->load->view('auth/reg_info', $data);
	}
	
	function login_verify()
	{
		$username = $this->input->post('username');	
		$password = $this->input->post('password');	
		
		$check = $this->irsdp_model->auth_login($username, $password);
		if($check['valid']) 
		{
			$this->session->set_userdata('loggedin', TRUE);
			if($check['group']=='pas' OR $check['group']=='tas' OR $check['group']=='konsultan'): /* FIXME */
				$this->session->set_userdata('group', 'petugas');
				$this->session->set_userdata('idperusahaan', $check['idperusahaan']);
				$this->session->set_userdata('sub_group', $check['group']);
			else:
				$this->session->set_userdata('group', $check['group']);
			endif;
			$this->session->set_userdata('id_user', $check['id_user']);
			$this->session->set_userdata('username', $check['username']);
			redirect($this->session->userdata('group'));
		}
		else 
		{
			$this->session->set_flashdata('errorlogin', 'Your username or password are incorrect'); 
			redirect('auth/login');
		}
	}
	
	function register($type=null)
	{
		$data['menu'] = 'auth/menu';
		$data['main'] = 'auth/register';		
		$this->load->view('layout', $data);		
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}

/* End of file auth.php */
/* Location: ./system/application/controllers/auth.php */