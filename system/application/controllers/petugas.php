<?php
class Petugas extends Controller {

	function Petugas()
	{
		parent::Controller();
		
		// session check
		if($this->session->userdata('loggedin')==NULL) redirect('auth');			
		if($this->session->userdata('group')!='petugas') redirect('auth');
		
		$this->load->model('irsdp_model');
		$this->load->helper('irsdp');
	}
	
	
	function index()
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/dashboard';
/*		$data['submenu'] = array('url' => 'petugas/input_usulan_proyek_baru',
								'title' => 'Propose New Project');
*/
								
		$data['sel_pro'] = $this->irsdp_model->get_proyek_status_count('sel_pro');
		$data['sel_app'] = $this->irsdp_model->get_proyek_status_count('sel_app');
		
		$data['ready_pfs'] = $this->irsdp_model->get_proyek_status_count('ready_pfs');
		$data['ready_trs'] = $this->irsdp_model->get_proyek_status_count('ready_trs');
		$data['ready_inv'] = $this->irsdp_model->get_proyek_status_count('ready_inv');
		
		$data['ong_pfs'] = $this->irsdp_model->get_proyek_status_count('ong_pfs');
		$data['ong_trs'] = $this->irsdp_model->get_proyek_status_count('ong_trs');
		$data['ong_inv'] = $this->irsdp_model->get_proyek_status_count('ong_inv');

		$data['contract_pfs'] = $this->irsdp_model->get_proyek_status_count('contract_pfs');
		$data['contract_trs'] = $this->irsdp_model->get_proyek_status_count('contract_trs');
		$data['contract_inv'] = $this->irsdp_model->get_proyek_status_count('contract_inv');						
		
		$data['dikontrak'] = $this->irsdp_model->get_proyek_status_count('dikontrak');
		
		$data['total_disb_rupiah'] = $this->irsdp_model->get_total_disbursement('rupiah');
		$data['total_disb_dollar'] = $this->irsdp_model->get_total_disbursement('dollar');
		$this->load->view('layout', $data);						
	}
	
	function daftar_proyek()
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/daftar_proyek';
/*		$data['submenu'] = array('url' => 'petugas/input_usulan_proyek_baru',
								'title' => 'Propose New Project');		
*/
		
		// Notification (flashdata)
		if($this->session->flashdata('notif')!="")
		{
			$data['notif'] = array('message' => $this->session->flashdata('notif'),
									'type' => 'notif_'.$this->session->flashdata('notif_type'));	
		}
		
				
		if($_POST) // Search mode
		{
			if($this->input->post('submit_text'))
			{
				$param['search_text'] = $this->input->post('search_text');
				$search_order = array('project_profile.pin','kategori.subsectorname', 'project_profile.nama',
									'project_profile.lokasi');
				
				foreach($search_order as $tmp)
				{
					$param['search_by'] = $tmp;
					$data['proyek'] = $this->irsdp_model->get_proyek_usulan($param);
					
					if($data['proyek']->num_rows()!=0) // stop if we found result
						break;	
				}
				
				$data['notif'] = array('message' => "Search result for <em>".$param['search_text']."</em>",
										'type' => 'notif_yellow');			
			}
			else
			{
				$param['tanggal_mulai'] = $this->input->post('search_start');
				$param['tanggal_akhir'] = $this->input->post('search_end');
				$data['proyek'] = $this->irsdp_model->get_proyek_usulan($param);
				$data['notif'] = array('message' => "Search result from <em>".$param['tanggal_mulai']."</em> to <em>".$param['tanggal_akhir']."</em>",
										'type' => 'notif_yellow');
			}
			$data['no'] = 0;
		}
		else if($this->uri->segment(3)!="" && !is_numeric($this->uri->segment(3))) // By status (Selection, Ready to tender, Ongoing tender, Contracted)
		{
			$valid_type = array('selection', 'ready_to_tender', 'ongoing_tender', 'contracted');
			if(!in_array($this->uri->segment(3), $valid_type)) die('Invalid type');
			
			$valid_subtype = array('proposed', 'approved', 'pra_fs', 'transaction', 'investor');
			if(!in_array($this->uri->segment(4), $valid_subtype)) die('Invalid subtype');
			
			$param['tahap'] = $this->uri->segment(3)."-".$this->uri->segment(4);
			$data['proyek'] = $this->irsdp_model->get_proyek_usulan($param);
			$data['no'] = 0;
		}
		else // Normal mode (Show all)
		{
			$this->load->library('pagination');
			$proyek_all = $this->irsdp_model->get_proyek_usulan(array('uid' => $this->session->userdata('id_user')))->num_rows();		
			$config['base_url'] = site_url('petugas/daftar_proyek');
			$config['total_rows'] = $proyek_all;
			$config['per_page'] = '10'; 
			$this->pagination->initialize($config); 
			
			$param = array('uid' => $this->session->userdata('id_user'),
							'limit' => $config['per_page'],
							'offset' => $this->uri->segment(3,0));
			$data['proyek'] = $this->irsdp_model->get_proyek_usulan($param);
			$data['paging'] = $this->pagination->create_links();
			$data['pagination_mode'] = TRUE;
			$data['no'] = $this->uri->segment(3,0);
		}		
		
		$this->load->view('layout', $data);
	}
	
	function input_usulan_proyek_baru()
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/input_usulan_proyek_baru';
		$data['submenu'] = array('url' => 'petugas/daftar_proyek','title' => 'Back to Projects Summary');
										
		$data['propinsi'] = $this->irsdp_model->get_propinsi();
		$data['kategori'] = $this->irsdp_model->get_kategori();
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('project_title', 'Project Title', 'required');
			$this->form_validation->set_rules('tgl_usulan', 'Tanggal Usulan', 'required');
			$this->form_validation->set_rules('project_location', 'Project Location', 'required');
			$this->form_validation->set_rules('idkategori', 'Category', 'required');
			$this->form_validation->set_rules('tipe_proyek', 'Proyect Type', 'required');
			$this->form_validation->set_rules('province_code', 'Province', 'required');
			$this->form_validation->set_rules('proposed_agency', 'Proposed Agency', 'required');
			$this->form_validation->set_rules('surat_lpd', 'Letter from Proposed Agency', '');
			$this->form_validation->set_rules('appr_dprd', 'Approval Letter From DPRD', '');
			$this->form_validation->set_rules('ppp_form', 'PPP Proposal Document', '');
			$this->form_validation->set_rules('doc_fs', 'First Study Document', '');
			
			$config['upload_path'] = './upload/dokumen/'; /* FIXME */
			$config['allowed_types'] = 'pdf|doc|docx'; /* FIXME */
			$this->load->library('upload', $config);
					
			if ($this->form_validation->run()==FALSE OR !$this->upload->do_upload("doc_usulan"))
			{
				$data['upload_error'] = $this->upload->display_errors();
			}
			else
			{
				$param = array('project_title' => $this->input->post('project_title'),
								'pin' => $this->input->post('pin'),
								'ppp_book_code' => $this->input->post('ppp_book_code'),
							  	'project_location' => $this->input->post('project_location'), 
							  	'idkategori' => $this->input->post('idkategori'),
							  	'project_type' => $this->input->post('project_type'),
							   	'province_code' => $this->input->post('province_code'),
							   	'proposed_agency' => $this->input->post('proposed_agency'),
							   	'tgl_usulan' => $this->input->post('tgl_usulan'),
							   	'tgl_diisi' => date('Y-m-d'),
							   	'surat_lpd' => $this->input->post('surat_lpd'),
							   	'ppp_form' => $this->input->post('ppp_form'),
							   	'appr_dprd' => $this->input->post('appr_dprd'),
							   	'doc_fs' => $this->input->post('doc_fs'),
							   	'idoperator' => $this->session->userdata('id_user'),
							   	'nama_berkas' => $this->upload->data(),		
							   	'view' => $this->input->post('view'),
								);
				$project_id = $this->irsdp_model->input_proyek_usulan($param);				
				$this->session->set_flashdata('notif', 'Project added');
				$this->session->set_flashdata('notif_type', 'green');
				redirect('petugas/modify_project_info/'.$project_id);				
			}
			$this->load->view('layout', $data);
		}		
		else 
		{
			$this->load->view('layout', $data);
		}
	}
	
	function edit_proyek($id_proj=null)
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/edit_proyek';
		$data['submenu'] = array('url' => 'petugas/daftar_proyek',
								'title' => 'Back to Projects Summary');
										
		$data['propinsi'] = $this->irsdp_model->get_propinsi();
		$data['kategori'] = $this->irsdp_model->get_kategori();	
		$data['proyek'] = $this->irsdp_model->get_proyek($id_proj);

		if($_POST)
		{		
				$param = array('idproject_profile' => $this->input->post('idproject_profile'),
								'project_title' => $this->input->post('project_title'),
								'pin' => $this->input->post('pin'),
								'ppp_book_code' => $this->input->post('ppp_book_code'),
							  	'project_location' => $this->input->post('project_location'), 
							  	'idkategori' => $this->input->post('idkategori'),
							  	'project_type' => $this->input->post('project_type'),
							   	'province_code' => $this->input->post('province_code'),
							   	'proposed_agency' => $this->input->post('proposed_agency'),
							   	'tgl_usulan' => $this->input->post('tgl_usulan'),
							   	'tgl_revisi' => date('Y-m-d'),
							   	'surat_lpd' => $this->input->post('surat_lpd'),
							   	'ppp_form' => $this->input->post('ppp_form'),
							   	'appr_dprd' => $this->input->post('appr_dprd'),
							   	'idoperator' => $this->session->userdata('id_user'),
							   	'view' => $this->input->post('view'),
								);
				$this->irsdp_model->update_proyek($param);
				$this->session->set_flashdata('notif', 'Project updated');
				$this->session->set_flashdata('notif_type', 'green');
				redirect('petugas/daftar_proyek');
		}		
		
		$this->load->view('layout', $data);	
	}
	
	function modify_project_info($id_proj=NULL)
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/modify_project_info';
		$data['submenu'] = array('url' => 'petugas/daftar_proyek',
								'title' => 'Back to Projects Summary');
		if($_POST)
		{				
			foreach($_POST as $tag=>$value):
				$param['tag'] = $tag;
				$param['value'] = $value;
				$param['proyek_id'] = $id_proj;
				$this->irsdp_model->modify_project_info($param);
			endforeach;
			
			$this->session->set_flashdata('notif', 'Project info updated');
			$this->session->set_flashdata('notif_type', 'green');			
			redirect('petugas/daftar_proyek');
		}
										
		$data['proyek'] = $this->irsdp_model->get_proyek_info($id_proj);
		$this->load->view('layout', $data);	
	}
	
	function detil_proyek($id_proj=NULL, $mode=NULL)
	{
		// Exception
		// id_proj not found
		// ...
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/detil_proyek';
		$data['submenu'] = array('url' => 'petugas/daftar_proyek',
								'title' => 'Back to Projects Summary');		
		
		// get project detail from all status
		$data['detil'] = $this->irsdp_model->get_detail_proyek($id_proj);
		$data['proyek_info'] = $this->irsdp_model->get_proyek_info($id_proj);
		$data['kontraktor'] = $this->irsdp_model->get_kontraktor_proyek($id_proj);
		
 		//echo "<pre>";
		//print_r($data['detil']->result_array());
		//print_r($data['proyek_info']->result_array());
		//echo "</pre>";
		
		if($mode=="fullscreen")
			$this->load->view('petugas/proyek/detil_proyek', $data);
		else
			$this->load->view('layout', $data);				
	}
	
	function detil_proyek_ringkas($id_proj=NULL, $mode=NULL)
	{
		// Exception
		// id_proj not found
		// ...
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/detil_proyek';
		$data['submenu'] = array('url' => 'petugas/daftar_proyek',
								'title' => 'Back to Projects Summary');		
		
		// get project detail from all status
		$data['detil'] = $this->irsdp_model->get_detail_proyek_ringkas($id_proj);
		$data['proyek_info'] = $this->irsdp_model->get_proyek_info($id_proj);
		$data['kontraktor'] = $this->irsdp_model->get_kontraktor_proyek($id_proj);
		
		//echo "<pre>";
		//print_r($data['detil']->result_array());
		//echo "<pre";
		
		if($mode=="fullscreen")
			$this->load->view('petugas/proyek/detil_proyek', $data);
		else
			$this->load->view('layout', $data);				
	}
	
	function detil_status_proyek($id_proj, $id_flow)
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/detil_status_proyek';
		$data['submenu'] = array('url' => 'petugas/detil_proyek/'.$id_proj,
								'title' => 'Back to Project Details');
												
		if($_POST)
		{
			if($this->input->post('submit_komentar'))
			{
				$param = array('idproj_flow' => $this->input->post('id_flow'),
								'idpic' => $this->session->userdata('id_user'),
								'tgl_cerita' => date('Y-m-d'),
								'deskripsi' => $this->input->post('deskripsi'),
								'follow_up' => $this->input->post('follow_up'),
								'tgl_mulai' => $this->input->post('tgl_mulai'),
								'tgl_akhir' => $this->input->post('tgl_akhir'),
								'tgl_diisi' => date('Y-m-d')
								);
				$this->irsdp_model->input_cerita($param);
				$this->session->set_flashdata('notif', 'Problem added');
				$this->session->set_flashdata('notif_type', 'green');
				redirect($this->uri->uri_string());
			}
			else if($this->input->post('submit_step'))
			{
				$idproject_profile = $this->input->post('idproject_profile');
				$idref_status = $this->input->post('idref_status');
				$is_kontrak = $this->input->post('is_kontrak');
				
				if($idref_status==0): // tender
					$jenis_tender = $this->input->post('jenis_tender'); // jenis tender
					switch($this->input->post('current_idref_status')) // check current id
					{
						case 4:
							if($jenis_tender=='qcs') $idref_status = 49;
							else if($jenis_tender=='qcbs') $idref_status = 5;
						break;
						
						case 83:
							if($jenis_tender=='qcs') $idref_status = 129;
							else if($jenis_tender=='qcbs') $idref_status = 84;
						break;
						
						// others tenders id
						// ...
					}
				elseif($is_kontrak==1): // kontrak
					// 1. get kontrak flow --> insert into ref_kontrak
					// count row
					$count = $this->input->post('row_count');
					for($i=2;$i<=$count;$i++)
					{
						$param['detil_status'] = $this->input->post($i.'_0');
						$param['next_step'] = $this->irsdp_model->get_last_ref_kontrak_id(); /* FIXME */
						$this->irsdp_model->insert_ref_kontrak($param);
						
						if($i==2) $init_id = $param['next_step']-1; /* FIXME */
					}
					$param['detil_status'] = $this->input->post('1_0'); /* FIXME */
					$param['next_step'] = 0; /* FIXME */
					$this->irsdp_model->insert_ref_kontrak($param); /* FIXME */

					$param = array('tgl_rencana' => $this->input->post('tgl_rencana'),
									'pic' => $this->session->userdata('id_user'),
									'status' => 'on going',
									'idproject_profile' => $this->input->post('idproject_profile'),
									'idref_status' => $idref_status,
									'idref_kontrak' => $init_id, /* FIXME */
									'init' => TRUE,
									'idproj_flow' => $this->input->post('idproj_flow')
									);
					$this->irsdp_model->update_step_proyek_terkontrak($param);
					$this->irsdp_model->set_proj_flow_master_status($this->input->post('idproj_flow'));
					
					redirect('petugas/detil_proyek/'.$idproject_profile);
					exit(0);
				endif;
					
				
				$param = array('tgl_rencana' => $this->input->post('tgl_rencana'),
								'pic' => $this->session->userdata('id_user'),
								'status' => 'on going',
								'idproject_profile' => $this->input->post('idproject_profile'),
								'idref_status' => $idref_status,
								'idproj_flow' => $this->input->post('idproj_flow')
								);				
				$this->irsdp_model->update_step($param);
								
				// Set current proj_flow to ok
				$this->irsdp_model->set_proj_flow_master_status($this->input->post('idproj_flow'));
				
				redirect('petugas/detil_proyek/'.$idproject_profile);
			}
			else if($this->input->post('submit_dokumen'))
			{
				$config['upload_path'] = './upload/dokumen/'; /* FIXME */
				$config['allowed_types'] = 'pdf|doc|docx'; /* FIXME */
				$this->load->library('upload', $config);
				
				if($this->upload->do_upload("nama_berkas"))
				{
					$param = array('idproj_flow' => $this->input->post('id_flow'),
								'idoperator' => $this->session->userdata('id_user'),
								'tgl_upload' => date('Y-m-d'),
								'nama_berkas' => $this->upload->data()
								);
					$this->irsdp_model->input_dokumen($param);
					$this->session->set_flashdata('notif', 'Document added');
					$this->session->set_flashdata('notif_type', 'green');
				}
				else
				{
					$this->session->set_flashdata('notif', $this->upload->display_errors());
					$this->session->set_flashdata('notif_type', 'red');
				}
				redirect($this->uri->uri_string());
			}			
		}
		
		// get project detail (dokumen, cerita)
		$data['detil'] = $this->irsdp_model->get_detail_proyek($id_proj, $id_flow);
		$data['dokumen'] = $this->irsdp_model->get_dokumen($id_flow);
		$data['cerita'] = $this->irsdp_model->get_cerita($id_flow);		
		$this->load->view('layout', $data);
	}
	
	function toggle_view()
	{
		$mode=$this->uri->segment(4);
		$idproj=$this->uri->segment(3);

		$this->irsdp_model->visibility($mode, $idproj);
		redirect('petugas/daftar_proyek');
	}
	
	function set_problem_status($id_proj, $id_proj_flow, $idstatusproject)
	{
		// TODO: security check
		// ..
		$this->irsdp_model->set_problem_status($idstatusproject);
		$this->session->set_flashdata('notif', 'Problem closed');
		$this->session->set_flashdata('notif_type', 'green');
		redirect('petugas/detil_status_proyek/'.$id_proj.'/'.$id_proj_flow);
	}
	
	function set_problem_status_kontrak($id_proj, $id_kontrak_flow, $idstatuskontrak)
	{
		$this->irsdp_model->set_problem_status_kontrak($idstatuskontrak);
		$this->session->set_flashdata('notif', 'Problem closed');
		$this->session->set_flashdata('notif_type', 'green');
		redirect('petugas/detil_status_proyek_terkontrak/'.$id_proj.'/'.$id_kontrak_flow);		
	}
	
	function set_proj_flow_status($id_proj, $idproj_flow)
	{
		// TODO: security check
		// ..
		$this->irsdp_model->set_proj_flow_status($idproj_flow);
		$this->session->set_flashdata('notif', 'Project step updated');
		$this->session->set_flashdata('notif_type', 'green');
		redirect('petugas/detil_status_proyek/'.$id_proj.'/'.$idproj_flow);
	}

	function set_kontrak_flow_status($id_proj, $idkontrak_flow)
	{
		// TODO: security check
		// ..
		$this->irsdp_model->set_kontrak_flow_status($idkontrak_flow);
		$this->session->set_flashdata('notif', 'Project step updated');
		$this->session->set_flashdata('notif_type', 'green');
		redirect('petugas/detil_status_proyek_terkontrak/'.$id_proj.'/'.$idkontrak_flow);
	}	
	
	function update_followup()
	{
		$param = array('idcerita' => $this->input->post('id'),
						'idpic' => $this->session->userdata('id_user'),
						'follow_up' => $this->input->post('value'),
						'tgl_cerita' => date('Y-m-d'));
						
		$this->irsdp_model->update_followup($param);
		echo $this->input->post('value');
	}
	
	
	function proyek_terkontrak()
	{
		$perusahaan=$this->uri->segment(3);
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontrak/proyek_terkontrak';
/*		$data['submenu'] = array('url' => 'petugas/input_usulan_proyek_baru',
								'title' => 'Propose New Project');		
*/
								
		$this->load->library('pagination');
		$proyek_all = $this->irsdp_model->get_proyek_terkontrak($perusahaan)->num_rows();		
		$config['base_url'] = site_url('petugas/proyek_terkontrak');
		$config['total_rows'] = $proyek_all;
		$config['per_page'] = '10'; 
		$this->pagination->initialize($config); 
		
		$param = array('uid' => $this->session->userdata('id_user'),
						'limit' => $config['per_page'],
						'offset' => $this->uri->segment(3,0));
		$data['proyek'] = $this->irsdp_model->get_proyek_terkontrak($param);			
			
		$data['no'] = $this->uri->segment(3,0);
		$this->load->view('layout', $data);			
	}

	function detil_proyek_terkontrak($id_proj=NULL, $mode=NULL)
	{
		// Exception
		// id_proj not found
		// ...
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontrak/detil_proyek_terkontrak';
		$data['submenu'] = array('url' => 'petugas/proyek_terkontrak',
								'title' => 'Back to Contract Summary');		
		
		// get project detail from all status
		$data['detil'] = $this->irsdp_model->get_detail_proyek_terkontrak($id_proj);
		
		if($mode=="fullscreen")
			$this->load->view('petugas/proyek/detil_proyek', $data);
		else
			$this->load->view('layout', $data);				
	}	

	function detil_status_proyek_terkontrak($id_proj, $id_flow)
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontrak/detil_status_proyek_terkontrak';
		$data['submenu'] = array('url' => 'petugas/detil_proyek_terkontrak/'.$id_proj,
								'title' => 'Back to Project Details');
												
		if($_POST)
		{
			if($this->input->post('submit_komentar'))
			{
				$param = array('idkontrak_flow' => $this->input->post('id_flow'),
								'idpic' => $this->session->userdata('id_user'),
								'tgl_cerita' => date('Y-m-d'),
								'deskripsi' => $this->input->post('deskripsi'),
								'follow_up' => $this->input->post('follow_up'),
								'tgl_mulai' => $this->input->post('tgl_mulai'),
								'tgl_akhir' => $this->input->post('tgl_akhir'),
								'tgl_diisi' => date('Y-m-d')
								);
				$this->irsdp_model->input_cerita_kontrak($param);
				$this->session->set_flashdata('notif', 'Problem added');
				$this->session->set_flashdata('notif_type', 'green');
				redirect($this->uri->uri_string());
			}
			else if($this->input->post('submit_step'))
			{
				$idproject_profile = $this->input->post('idproject_profile');
				$idref_kontrak = $this->input->post('idref_kontrak');
									
				$param = array('tgl_rencana' => $this->input->post('tgl_rencana'),
								'pic' => $this->session->userdata('id_user'),
								'status' => 'on going',
								'idref_kontrak' => $idref_kontrak,
								'idproj_flow' => $this->input->post('idproj_flow')
								);				
				$this->irsdp_model->update_step_proyek_terkontrak($param);
								
				// Set current kontrak_flow to ok
				$this->irsdp_model->set_kontrak_flow_master_status($this->input->post('idkontrak_flow'));
				
				redirect('petugas/detil_proyek_terkontrak/'.$idproject_profile);
			}
			else if($this->input->post('submit_dokumen'))
			{
				$config['upload_path'] = './upload/dokumen/'; /* FIXME */
				$config['allowed_types'] = 'pdf|doc|docx'; /* FIXME */
				$this->load->library('upload', $config);
				
				if($this->upload->do_upload("nama_berkas"))
				{
					$param = array('idkontrak_flow' => $this->input->post('id_flow'),
								'idoperator' => $this->session->userdata('id_user'),
								'tgl_upload' => date('Y-m-d'),
								'nama_berkas' => $this->upload->data()
								);
					$this->irsdp_model->input_dokumen_kontrak($param);
					$this->session->set_flashdata('notif', 'Document added');
					$this->session->set_flashdata('notif_type', 'green');
				}
				else
				{
					$this->session->set_flashdata('notif', $this->upload->display_errors());
					$this->session->set_flashdata('notif_type', 'red');
				}
				redirect($this->uri->uri_string());
			}			
		}
		
		// get project detail (dokumen, cerita)
		$data['detil'] = $this->irsdp_model->get_detail_proyek_terkontrak($id_proj, $id_flow);
		$data['dokumen'] = $this->irsdp_model->get_dokumen_terkontrak($id_flow);
		$data['cerita'] = $this->irsdp_model->get_cerita_terkontrak($id_flow);		
		$this->load->view('layout', $data);
	}	
	
	
	function selesai_kontrak($id_proj, $id_kontrak_flow)
	{
		$this->irsdp_model->set_kontrak_flow_master_status($id_kontrak_flow);
		redirect('petugas/detil_status_proyek_terkontrak/'.$id_proj.'/'.$id_kontrak_flow);
	}
	
	
	/* ==============================
	/* Modul Keuangan
	/* ============================== */
	
	function keuangan()
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/keuangan/proyek_terkontrak';
/*		$data['submenu'] = array('url' => 'petugas/input_usulan_proyek_baru',
								'title' => 'Propose New Project');
*/
		
		$this->load->library('pagination');
		$proyek_all = $this->irsdp_model->get_proyek_terkontrak(array('uid' => $this->session->userdata('id_user')))->num_rows();		
		$config['base_url'] = site_url('petugas/keuangan');
		$config['total_rows'] = $proyek_all;
		$config['per_page'] = '10'; 
		$this->pagination->initialize($config); 
		
		$param = array('uid' => $this->session->userdata('id_user'),
						'limit' => $config['per_page'],
						'offset' => $this->uri->segment(3,0));
		$data['proyek'] = $this->irsdp_model->get_proyek_terkontrak($param);			
			
		$data['no'] = $this->uri->segment(3,0);
		$this->load->view('layout', $data);			
	}
	
	function detil_keuangan($id_proj)
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/keuangan/detil_proyek_terkontrak';
		$data['submenu'] = array('url' => 'petugas/keuangan',
								'title' => 'Back to Finance Summary');		
		
		// get project detail from all status
		$data['detil'] = $this->irsdp_model->get_detail_proyek_terkontrak($id_proj);
		
		$this->load->view('layout', $data);				
	}
	
	function detil_nilai_keuangan($id_proj, $id_kontrak)
	{
		if($_POST)
		{			
			if($this->input->post('submit_add_payment'))
			{
				$config['upload_path'] = './upload/dokumen/'; /* FIXME */
				$config['allowed_types'] = 'pdf|doc|docx'; /* FIXME */
				$this->load->library('upload', $config);
	
				if($this->upload->do_upload("document_request"))
				{
					$param = array('idtermin_bayar' => $this->input->post('idtermin_bayar'),
								'tgl_permohonan' => date('Y-m-d'),
								'idoperator' => $this->session->userdata('id_user'),
								'nilai_permintaan_rupiah' => $this->input->post('nilai_permintaan_rupiah'),
								'nilai_permintaan_dollar' => $this->input->post('nilai_permintaan_dollar'),
								'tgl_upload' => date('Y-m-d'),
								'nama_berkas' => $this->upload->data()
								);
					$this->irsdp_model->input_payment_request($param);
				}		
				// else ...
			}
			elseif($this->input->post('submit_confirm_payment'))
			{
					$param = array('idpermohonan' => $this->input->post('idpermohonan'),
								'tgL_dikirim' => $this->input->post('sent_date'),
								'tgL_disetujui' => $this->input->post('approved_date'),
								'dibayarkan' => $this->input->post('paid_date'),
								'disetujui' => '1',
								'nilai_disetujui_rupiah' => $this->input->post('nilai_disetujui_rupiah'),
								'nilai_disetujui_dollar' => $this->input->post('nilai_disetujui_dollar'),
								'nilai_disetujui_eq_idr_usd' => $this->input->post('nilai_disetujui_eq_idr_usd'),
								'loan_adb_usd' => $this->input->post('loan_adb_usd'),
								'grant_gov_usd' => $this->input->post('grant_gov_usd'),
								);
					$this->irsdp_model->confirm_payment_request($param);					
			}
			redirect($this->uri->uri_string());
		}
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/keuangan/detil_nilai_keuangan';
		$data['submenu'] = array('url' => 'petugas/detil_keuangan/'.$id_proj,
								'title' => 'Back to Finance Detail');		
		
		// get project detail from all status
		$data['detil'] = $this->irsdp_model->get_detail_proyek_terkontrak($id_proj);
		$data['payment'] = $this->irsdp_model->get_termin_bayar($id_kontrak);
		$this->load->view('layout', $data);
	}
	
	function inisialisasi_nilai_kontrak($id_proj, $id_kontrak)
	{
		if($_POST)
		{
			// count row
			$count = $this->input->post('row_count');
			for($i=1;$i<=$count;$i++)
			{
				$param['nilai_rupiah'] = $this->input->post($i.'_0');
				$param['nilai_dollar'] = $this->input->post($i.'_1');
				$param['eq_idr_usd'] = $this->input->post($i.'_2');
				$param['idref_kontrak'] = $this->input->post('idref_kontrak');
				$this->irsdp_model->insert_termin_bayar($param);				
			}
			redirect('petugas/detil_keuangan/'.$id_proj);
		}
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/keuangan/inisialisasi_nilai_kontrak';
		$data['submenu'] = array('url' => 'petugas/keuangan',
								'title' => 'Back to Finance Summary');				
		// get project detail from all status
		$data['detil'] = $this->irsdp_model->get_detail_proyek_terkontrak($id_proj);
		
		$this->load->view('layout', $data);				
	}
	
	function laporan_keuangan($type=NULL)
	{		
		$data['sub_layout'] = 'petugas/layout';
		$data['submenu'] = array('url' => 'petugas/laporan_keuangan',
								'title' => 'Back to Finance Report');				

		switch($type)
		{
			case 'table_01':
				$data['main'] = 'petugas/keuangan/laporan/tabel1';
				$report = $this->irsdp_model->laporan_tabel_01a()->result_array();
				
				foreach($report as $key => $tmp):	
					$payment = $this->irsdp_model->laporan_tabel_01b($tmp['idproject_profile']);
					$report[$key]['payment'] = $payment->result_array();
				endforeach;
				
				$data['report'] = $report;								
				$this->load->view($data['main'], $data);	
			break;

			case 'table_02':
				$data['main'] = 'petugas/keuangan/laporan/tabel2c';
				$report = $this->irsdp_model->laporan_tabel_02a()->result_array();
				
				foreach($report as $key => $tmp):	
					$konsultan = $this->irsdp_model->laporan_tabel_02b($tmp['idproject_profile'],$tmp['idkontraktor']);
					$report[$key]['consultant'] = $konsultan->result_array();
				endforeach;
				
				$data['report'] = $report;								
				$this->load->view('layout', $data);	
			break;
			
//			case 'table_02':
//				$data['main'] = 'petugas/keuangan/laporan/tabel2';
//				$data['report'] = $this->irsdp_model->laporan_tabel_02();
//				$this->load->view('layout', $data);
//			break;
			
			case 'table_03':
				$data['main'] = 'petugas/keuangan/laporan/tabel3';
				$data['report'] = $this->irsdp_model->laporan_tabel_03();
				$this->load->view('layout', $data);				
			break;

			case 'table_04':
				$data['main'] = 'petugas/keuangan/laporan/tabel4';
				$data['report'] = $this->irsdp_model->laporan_tabel_04();
				$this->load->view('layout', $data);				
			break;			
			
			case 'table_05':
				$data['main'] = 'petugas/keuangan/laporan/tabel5';
				$report = $this->irsdp_model->laporan_tabel_05a()->result_array();
				
				foreach($report as $key => $tmp):	
					$payment = $this->irsdp_model->laporan_tabel_05b($tmp['idproject_profile']);
					$report[$key]['payment'] = $payment->result_array();
				endforeach;
				
				$data['report'] = $report;								
				$this->load->view($data['main'], $data);	
			break;	
			
			case 'table_08':
				$data['main'] = 'petugas/keuangan/laporan/tabel2b';
				$report = $this->irsdp_model->laporan_tabel_02a()->result_array();
				
				foreach($report as $key => $tmp):	
					$konsultan = $this->irsdp_model->laporan_tabel_02b($tmp['idproject_profile'],$tmp['idkontraktor']);
					$report[$key]['consultant'] = $konsultan->result_array();
				endforeach;
				
				$data['report'] = $report;								
				$this->load->view('layout', $data);	
			break;

			case 'table_09':
				$data['main'] = 'petugas/keuangan/laporan/tabel9';
				$report = $this->irsdp_model->laporan_tabel_09a()->result_array();
				
				foreach($report as $key => $tmp):	
					$konsultan = $this->irsdp_model->laporan_tabel_09b($tmp['idproject_profile'],$tmp['idkontraktor']);
					$report[$key]['consultant'] = $konsultan->result_array();
				endforeach;
				
				$data['report'] = $report;								
				$this->load->view($data['main'], $data);	
			break;

			default:
				$data['main'] = 'petugas/keuangan/laporan/index';
/*				$data['submenu'] = array('url' => 'petugas/input_usulan_proyek_baru',
										'title' => 'PDF Proj. Registration');	
*/
				$this->load->view('layout', $data);									
			break;
		}		
	}
	
	/* ------------------------------------*/
	/* NEW REPORT --> ADB CRAM */
	/* ------------------------------------*/
	
	function adb_list_project_default()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah proyek
		$jml_proyek = $this->irsdp_model->get_jml_proyek_adb($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/petugas/adb_list_project/';
		$config['total_rows'] = $jml_proyek;
		$config['per_page'] = '15';
		$config['num_links'] = '4';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_user ke model dengan paging offsetnya
		$data['proyek'] = $this->irsdp_model->get_all_proyek_adb($config['per_page'],$key);
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/daftar_proyek_adb';
		
		//view tabel group
		$this->load->view('layout',$data);
	}
	
	function adb_list_project()
	{
		$key = $this->input->post('keyword');
		$modesort = $this->uri->segment(3);
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah proyek
		$jml_proyek = $this->irsdp_model->get_jml_proyek_adb($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/petugas/adb_list_project/'.$modesort.'/';
		$config['total_rows'] = $jml_proyek;
		$config['per_page'] = '15';
		$config['num_links'] = '4';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['uri_segment'] = 4;
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_user ke model dengan paging offsetnya
		$data['proyek'] = $this->irsdp_model->get_all_proyek_adb($config['per_page'],$key, $modesort);
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/proyek/daftar_proyek_adb';
		
		//view tabel group
		$this->load->view('layout',$data);
	}
	
	function adb_all_preview()//fullscreen all
	{
		$lap=$this->uri->segment(2);		
		$id=$this->uri->segment(3);		
		$modesort=$this->uri->segment(4);
		$data['proyek']=$this->irsdp_model->get_proyek_adb($id);
		$data['adb_report']=$this->irsdp_model->adb_report_all($id);
		$this->load->view('petugas/proyek/laporan/adb_report', $data);	
	}
	
	function adb_pac_preview()//fullscreen pac
	{	
		$id=$this->uri->segment(3);		
		$modesort=$this->uri->segment(4);
		$data['proyek']=$this->irsdp_model->get_proyek_adb($id);
		$data['adb_report']=$this->irsdp_model->adb_report_pac($id, $modesort);
		$data['main'] = 'petugas/proyek/laporan/adb_print';
//		$data['main'] = 'petugas/proyek/laporan/adb_report';
		$data['sub_layout'] = 'petugas/empty_layout';
		$this->load->view('empty_layout', $data);	
	}
	
	function adb_tac_preview()//fullscreen pac
	{	
		$id=$this->uri->segment(3);		
		$modesort=$this->uri->segment(4);
		$data['proyek']=$this->irsdp_model->get_proyek_adb($id);
		$data['adb_report']=$this->irsdp_model->adb_report_tac($id, $modesort);
		$data['main'] = 'petugas/proyek/laporan/adb_print';
//		$data['main'] = 'petugas/proyek/laporan/adb_report';
		$data['sub_layout'] = 'petugas/empty_layout';
		$this->load->view('empty_layout', $data);
	}
	
	function adb_report_all()
	{
		$id=$this->uri->segment(3);		
		$modesort=$this->uri->segment(4);
		$data['proyek']=$this->irsdp_model->get_proyek_adb($id);
		$data['adb_report']=$this->irsdp_model->adb_report_all($id, $modesort);
		$data['main'] = 'petugas/proyek/laporan/adb_report';
		$data['sub_layout'] = 'petugas/layout';
		$this->load->view('layout', $data);		
	}
	
	function adb_report_pac()
	{
		$id=$this->uri->segment(3);
		$modesort=$this->uri->segment(4);
		$data['proyek']=$this->irsdp_model->get_proyek_adb($id);
		$data['adb_report']=$this->irsdp_model->adb_report_pac($id,$modesort);
		$data['main'] = 'petugas/proyek/laporan/adb_report';
		$data['sub_layout'] = 'petugas/layout';
		$this->load->view('layout', $data);		
	}
	
	function adb_report_tac()
	{
		$id=$this->uri->segment(3);
		$modesort=$this->uri->segment(4);
		$data['proyek']=$this->irsdp_model->get_proyek($id);
		$data['adb_report']=$this->irsdp_model->adb_report_tac($id, $modesort);
		$data['main'] = 'petugas/proyek/laporan/adb_report';
		$data['sub_layout'] = 'petugas/layout';
		$this->load->view('layout', $data);		
	}
	
	/* end of ADB CRAM REPORT */
	/* ------------------------------------*/
	
	/* KONTRAKTOR for PETUGAS */
	function list_kontraktor()//with paging
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah kontraktor
		$jml_kontraktor = $this->irsdp_model->get_jml_kontraktor($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/petugas/list_kontraktor/';
		$config['total_rows'] = $jml_kontraktor;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_kontraktor ke model dengan paging offsetnya
		$data['kontraktor'] = $this->irsdp_model->get_all_kontraktor($config['per_page'],$key);
		//$data['kontraktor_per_project'] = $this->irsdp_model->get_kontraktor_per_project($config['per_page'],$key);
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontraktor/daftar_kontraktor';
		
		//view tabel kontraktor
		$this->load->view('layout',$data);
	}

	function add_kontraktor()
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontraktor/add_kontraktor';
		$data['form_title'] = 'Choose Contractor';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('idproject_profile', 'Project Name', 'required');
			$this->form_validation->set_rules('idperusahaan', 'Consultant Name', 'required');
			$this->form_validation->set_rules('tgl_mulai', 'Start Date', 'required');
			$this->form_validation->set_rules('tgl_selesai', 'End Date', 'required');
			$this->form_validation->set_rules('tgl_disetujui', 'Contract Date', 'required');
			$this->form_validation->set_rules('tahapan', 'Tender Phase', 'required');
			$this->form_validation->set_rules('anggaran_usd', 'Contract Budget (US$)', 'required|numeric');
			$this->form_validation->set_rules('anggaran_idr', 'Contract Budget (IDR)', 'required|numeric');
			$this->form_validation->set_rules('anggaran_total_usd', 'Total Contract Budget (US$)', 'required|numeric');
			$this->form_validation->set_rules('catatan', 'Tender Phase', 'xss_clean');
			$this->form_validation->set_rules('no_kontrak', 'Contract Number', 'xss_clean|required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idproject_profile' => $this->input->post('idproject_profile'),
								'idperusahaan' => $this->input->post('idperusahaan'),
								'tgl_mulai' => $this->input->post('tgl_mulai'),
								'tgl_selesai' => $this->input->post('tgl_selesai'),
								'tgl_disetujui' => $this->input->post('tgl_disetujui'),
								'tahapan' => $this->input->post('tahapan'),
								'anggaran_usd' => $this->input->post('anggaran_usd'),
								'anggaran_idr' => $this->input->post('anggaran_idr'),
								'anggaran_total_usd' => $this->input->post('anggaran_total_usd'),
								'catatan' => $this->input->post('catatan'),
								'pcss_no' => $this->input->post('pcss_no'),
								'pcss_date' => $this->input->post('pcss_date'),
								'no_kontrak' => $this->input->post('no_kontrak')
								);
				
				$msg = 'Choosing new contractor is successful';
									
				$this->irsdp_model->add_kontraktor($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('petugas/list_kontraktor');
			}	
		}	
		$this->load->view('layout', $data);		
	}
	
	function modify_kontraktor($id=NULL)
	{
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontraktor/modify_kontraktor';
		$data['form_title'] = 'Choose Contractor';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('idproject_profile', 'Project Name', 'required');
			$this->form_validation->set_rules('idperusahaan', 'Consultant Name', 'required');
			$this->form_validation->set_rules('tgl_mulai', 'Start Date', 'required');
			$this->form_validation->set_rules('tgl_selesai', 'End Date', 'required');
			$this->form_validation->set_rules('tgl_disetujui', 'Contract Date', 'required');
			$this->form_validation->set_rules('tahapan', 'Tender Phase', 'required');
			$this->form_validation->set_rules('anggaran_usd', 'Contract Budget (US$)', 'required|numeric');
			$this->form_validation->set_rules('anggaran_idr', 'Contract Budget (IDR)', 'required|numeric');
			$this->form_validation->set_rules('anggaran_total_usd', 'Total Contract Budget (US$)', 'required|numeric');
			$this->form_validation->set_rules('catatan', 'Tender Phase', 'xss_clean');
			$this->form_validation->set_rules('no_kontrak', 'Contract Number', 'xss_clean|required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idkontraktor' => $this->input->post('idkontraktor'),
								'idproject_profile' => $this->input->post('idproject_profile'),
								'idperusahaan' => $this->input->post('idperusahaan'),
								'tgl_mulai' => $this->input->post('tgl_mulai'),
								'tgl_selesai' => $this->input->post('tgl_selesai'),
								'tgl_disetujui' => $this->input->post('tgl_disetujui'),
								'tahapan' => $this->input->post('tahapan'),
								'anggaran_usd' => $this->input->post('anggaran_usd'),
								'anggaran_idr' => $this->input->post('anggaran_idr'),
								'anggaran_total_usd' => $this->input->post('anggaran_total_usd'),
								'catatan' => $this->input->post('catatan'),
								'pcss_no' => $this->input->post('pcss_no'),
								'pcss_date' => $this->input->post('pcss_date'),
								'no_kontrak' => $this->input->post('no_kontrak')
								);
				
				$msg = 'Contractor data has been already updated';
				$this->irsdp_model->modify_kontraktor($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('petugas/list_kontraktor');
			}	
		}
		
		if($id!=NULL) 
		{ 
			$data['kontraktor'] = $this->irsdp_model->get_kontraktor($id);
			$data['form_title'] = 'Edit detail contractor';
		}		
		$this->load->view('layout', $data);		
	}
	
	function hapus_kontraktor($id)
	{
		
		/*
		$this->irsdp_model->delete_kontraktor($id);
		$msg = 'Contractor data has been deleted';
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('petugas/list_kontraktor');
		*/
		$msg = 'You cannot delete Kontraktor\'s data in here!<br />Contact the administrator to confirm your action!';
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('petugas/list_kontraktor');
		
	}
	
	function detail_kontraktor($id)
	{
		$data['detail'] = $this->irsdp_model->get_kontraktor($id);
		$data['form_title'] = "Detail Contractor";
		
		$data['sub_layout'] = 'petugas/layout';
		$data['main'] = 'petugas/kontraktor/view_kontraktor';
		$this->load->view('layout', $data);	
	}
	
	/* ==============================
	/* End of Kontraktor
	/* ============================== */
	
	/* end of KONTRAKTOR for PETUGAS */
}

/* End of file petugas.php */
/* Location: ./system/application/controllers/petugas.php */
