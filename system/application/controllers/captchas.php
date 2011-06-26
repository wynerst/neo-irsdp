<?php
class Captchas extends Controller 
{
	function Captchas()
	{
		parent::Controller();	
		$this->load->model('irsdp_model');
	}
	
	function index()
	{
        $this->load->library('captcha');
        $this->load->library('validation');
        $rules['user']    = "required";
        $rules['captcha']    = "required|callback_captcha_check";
        $this->validation->set_rules($rules);

        $fields['user']    = 'Username';
        $fields['captcha']    = 'codice';
        $this->validation->set_fields($fields);
		
        if ($this->validation->run() == FALSE)
        {
            $expiration = time()-5; // Two hour limit
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
            //
            $dati['image']= $cap['image'];
            //mette nel db
            $data = array(
                        'captcha_id'    => '',
                        'captcha_time'    => $cap['time'],
                        'ip_address'    => $this->input->ip_address(),
                        'word'            => $cap['word']
                    );

            $query = $this->db->insert_string('captcha', $data);
            $this->db->query($query);
            $this->load->view('captcha',$dati);
        }
		else
		{
            echo time();
			echo "OK";
        }
    }

    function captcha_check()
    {
		// Then see if a captcha exists:
		$exp=time()-600;
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($this->input->post('captcha'), $this->input->ip_address(), $exp);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0)
		{
			$this->validation->set_message('_captcha_check', 'Codice di controllo non valido');
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}  
}