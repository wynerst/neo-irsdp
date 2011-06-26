<?php
class Admin extends Controller {

	function Admin()
	{
		parent::Controller();
		
		// session check
		if($this->session->userdata('loggedin')==NULL) redirect('auth');			
		if($this->session->userdata('group')!='admin') redirect('auth');
		
		$this->load->model('irsdp_model');
		$this->load->helper('irsdp');
	}
	
	function index()
	{
		redirect('admin/siklus_proyek');
	}
	
	//-----------------------------------
	//project profile
	//-----------------------------------
	
	
	function daftar_proyek()
	{
		$data['sub_layout'] = 'admin/layout';
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
			$config['base_url'] = site_url('admin/daftar_proyek');
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
	
	/* ==============================
	/* Siklus Proyek
	/* ============================== */
	
	function siklus_proyek()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah siklus
		$jml_siklus = $this->irsdp_model->get_jml_siklus_proyek($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/siklus_proyek/';
		$config['total_rows'] = $jml_siklus;
		$config['per_page'] = '10';
		$config['num_links'] = '5';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_user ke model dengan paging offsetnya
		$data['siklus'] = $this->irsdp_model->get_siklus_proyek($key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/step_cycle/siklus_proyek';
		
		//view tabel user
		$this->load->view('layout',$data);
	}
	
	function add_siklus()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/step_cycle/add_siklus';
		$data['form_title'] = 'Add New Project Cycle';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('tahap', 'Phase', 'required');
			$this->form_validation->set_rules('status', 'Steps', 'required');
			$this->form_validation->set_rules('id_detil', 'ID Detil (sequencial)', 'required');
			$this->form_validation->set_rules('detil_status', 'State Detail', 'required');
			$this->form_validation->set_rules('kode_status', 'State Code', 'required');
			$this->form_validation->set_rules('formulir', 'Formulir', 'required');
			$this->form_validation->set_rules('idpic', 'ID User PIC in Charge', 'required');
			$this->form_validation->set_rules('next_step', 'Next Step', 'required');
			$this->form_validation->set_rules('kontrak_step', 'Kontrak Step', 'required');
			$this->form_validation->set_rules('laporan_flag', 'Laporan Flag', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				if($this->irsdp_model->cek_kode($this->input->post('kode_status')) > 0)
				{
					$msg = 'Process to input new step cycle is failed!<br />Step Code has already available, input a new one!';
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/siklus_proyek');
				}
				else
				{
					$param = array('tahap' => $this->input->post('tahap'),
									'status' => $this->input->post('status'),
									'id_detil' => $this->input->post('id_detil'),
									'detil_status' => $this->input->post('detil_status'),
									'kode_status' => $this->input->post('kode_status'),
									'formulir' => $this->input->post('formulir'),
									'idpic' => $this->input->post('idpic'),
									'next_step' => $this->input->post('next_step'),
									'kontrak_step' => $this->input->post('kontrak_step'),
									'laporan_flag' => $this->input->post('laporan_flag')
									);
					
					$msg = 'Add a new step is successful';
									
					$this->irsdp_model->add_siklus($param);
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/siklus_proyek');
				}
			}
		}
		$this->load->view('layout', $data);
	}
	
	function modify_siklus($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/step_cycle/modify_siklus';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('tahap', 'Phase', 'required');
			$this->form_validation->set_rules('status', 'Steps', 'required');
			$this->form_validation->set_rules('id_detil', 'ID Detil (sequencial)', 'required');
			$this->form_validation->set_rules('detil_status', 'State Detail', 'required');
			$this->form_validation->set_rules('kode_status', 'State Code', 'required');
			$this->form_validation->set_rules('formulir', 'Formulir', 'required');
			$this->form_validation->set_rules('idpic', 'ID User PIC in Charge', 'required');
			$this->form_validation->set_rules('next_step', 'Next Step', 'required');
			$this->form_validation->set_rules('kontrak_step', 'Kontrak Step', 'required');
			$this->form_validation->set_rules('laporan_flag', 'Laporan Flag', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idref_status' => $this->input->post('idref_status'),
								'tahap' => $this->input->post('tahap'),
								'status' => $this->input->post('status'),
								'id_detil' => $this->input->post('id_detil'),
								'detil_status' => $this->input->post('detil_status'),
								'kode_status' => $this->input->post('kode_status'),
								'formulir' => $this->input->post('formulir'),
								'idpic' => $this->input->post('idpic'),
								'next_step' => $this->input->post('next_step'),
								'kontrak_step' => $this->input->post('kontrak_step'),
								'laporan_flag' => $this->input->post('laporan_flag')
								);
				
				$msg = 'Step cycle details edited successfully';								
				$this->irsdp_model->modify_siklus($param);
				redirect('admin/siklus_proyek');
			}	
		}		
		$data['siklus'] = $this->irsdp_model->get_detail_siklus($id);				
		$data['form_title'] = 'Edit Form';
		$this->load->view('layout', $data);		
	}
	
	function delete_siklus($id)
	{
		$this->irsdp_model->hapus_siklus($id);
		$this->index();
	}

	/* ==============================
	/* End Siklus Proyek
	/* ============================== */

	/* ==============================
	/* Kategori/Sektor
	/* ============================== */
		
	function sektor()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/sector/list_sector';
		
		$data['sektor'] = $this->irsdp_model->get_kategori();		
		$this->load->view('layout', $data);
	}
	
	function list_sector()//with paging
	{
		$key = $this->input->post('keyword');
		
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah siklus
		$jml_sektor = $this->irsdp_model->get_jml_sektor_by_key($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_sector/';
		$config['total_rows'] = $jml_sektor;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query kategori ke model dengan paging offsetnya
		$data['sektor'] = $this->irsdp_model->get_kategori_by_key($key);	
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/sector/list_sector';
		
		//view tabel user
		$this->load->view('layout',$data);
	}
	
	function add_sektor()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/sector/add_sector';
		$data['form_title'] = 'Add new sector';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('sectorCode', 'Sector Code', 'required');
			$this->form_validation->set_rules('sectorName', 'Sector Name', 'required');
			$this->form_validation->set_rules('subsectorname', 'Sub Sector Name', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				if($this->irsdp_model->cek_kategori($this->input->post('sectorCode')) > 0)
				{
					$msg = 'Sector Code is not available<br />Input a new code instead';
					$this->session->set_flashdata('form_submit_status', $msg);					
					redirect('admin/list_sector');
				}
				else
				{
					$param = array('sectorCode' => $this->input->post('sectorCode'),
									'sectorName' => $this->input->post('sectorName'),
									'subsectorname' => $this->input->post('subsectorname')
									);
					
					$this->irsdp_model->add_kategori($param);
					$msg = 'Sector Category has been added succesfully';								
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/list_sector');
				}
			}
		}
		$this->load->view('layout', $data);		
	}
	
	function modify_sektor($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/sector/modify_sector';
		$data['form_title'] = 'Eidt project sector';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('sectorCode', 'Sector Code', 'required');
			$this->form_validation->set_rules('sectorName', 'Sector Name', 'required');
			$this->form_validation->set_rules('subsectorname', 'Sub Sector Name', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('sectorCode' => $this->input->post('sectorCode'),
								'sectorName' => $this->input->post('sectorName'),
								'subsectorname' => $this->input->post('subsectorname')
								);
				
				$msg = 'Sector Category has been modified succesfully';
								
				// edit mode				
				if($this->input->post('idkategori'))
				{
					$param['idkategori'] = $this->input->post('idkategori');
					$msg = 'Category has been modify';
				}
								
				$this->irsdp_model->modify_kategori($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_sector');
			}
		}
		
		if($id!=NULL) 
		{ 
			$data['sektor'] = $this->irsdp_model->get_kategori($id);		
			$data['form_title'] = 'Edit Sector';
		}		
		$this->load->view('layout', $data);		
	}
	
	function hapus_sektor($id)
	{
		$this->irsdp_model->hapus_sektor($id);
		$msg = "Project sector has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_sector');
	}
	
	/* ==============================
	/* Tender
	/* ============================== */
	
	function daftar_tender()//no paging
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/tender/daftar_tender';
		
		$data['tender'] = $this->irsdp_model->get_tender();		
		$this->load->view('layout', $data);
	}
	
	function list_tender()//with paging
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah user
		$jml_tender = $this->irsdp_model->get_jml_tender($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_tender/';
		$config['total_rows'] = $jml_tender;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_tender ke model dengan paging offsetnya
		$data['tender'] = $this->irsdp_model->get_tender_page($config['per_page'],$key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/tender/daftar_tender';
		
		//view tabel perusahaan
		$this->load->view('layout',$data);
	}

	function add_tender()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/tender/add_tender';
		$data['form_title'] = 'Tender Registration Form';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('idproj', 'Project ID', 'required');
			$this->form_validation->set_rules('deskripsi', 'Tender Descryption', 'required');
			$this->form_validation->set_rules('tgl_mulai', 'Start Date', 'required');
			$this->form_validation->set_rules('tgl_selesai', 'End Date', 'required');
			$this->form_validation->set_rules('tipe_tender', 'Tender Type', 'required');
			$this->form_validation->set_rules('penanggung_jawab', 'Project Manager', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idproj' => $this->input->post('idproj'),
								'deskripsi' => $this->input->post('deskripsi'),
								'tgl_mulai' => $this->input->post('tgl_mulai'),
								'tgl_selesai' => $this->input->post('tgl_selesai'),
								'tipe_tender' => $this->input->post('tipe_tender'),
								'penanggung_jawab' => $this->input->post('penanggung_jawab'),
								'idproj_flow' => $this->irsdp_model->get_proj_flow_latest_status($this->input->post('idproj')),
								);
				
				$msg = 'Tender has successfully added';			
				$this->irsdp_model->add_tender($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_tender');
			}	
		}	
		$this->load->view('layout', $data);		
	}
	
	function modify_tender($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/tender/modify_tender';
		$data['form_title'] = 'Add new Tender data';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('idproj', 'Project ID', 'required');
			$this->form_validation->set_rules('deskripsi', 'Tender Descryption', 'required');
			$this->form_validation->set_rules('tgl_mulai', 'Start Date', 'required');
			$this->form_validation->set_rules('tgl_selesai', 'End Date', 'required');
			$this->form_validation->set_rules('tipe_tender', 'Tender Type', 'required');
			$this->form_validation->set_rules('penanggung_jawab', 'Project Manager', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idtender_data' => $this->input->post('idtender_data'),
								'idproj' => $this->input->post('idproj'),
								'deskripsi' => $this->input->post('deskripsi'),
								'tgl_mulai' => $this->input->post('tgl_mulai'),
								'tgl_selesai' => $this->input->post('tgl_selesai'),
								'tipe_tender' => $this->input->post('tipe_tender'),
								'penanggung_jawab' => $this->input->post('penanggung_jawab'),
								'idproj_flow' => $this->irsdp_model->get_proj_flow_latest_status($this->input->post('idproj')),
								);
				

				$msg = 'Tender data has updated with successful';
								
				$this->irsdp_model->modify_tender($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_tender');
			}
		}		

		$data['tender'] = $this->irsdp_model->get_tender($id);		
		$data['form_title'] = 'Edit Tender Form';		
		$this->load->view('layout', $data);		
	}
	
	function detail_tender($id)
	{
		$data['detail'] = $this->irsdp_model->get_tender($id);
		$data['form_title'] = "Detail Tender";
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/tender/view_tender';
		$this->load->view('layout', $data);	
	}
	
	function hapus_tender($id)
	{
		$this->irsdp_model->delete_tender($id);
		$msg = 'Tender has been deleted';
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_tender');
	}

	/* ==============================
	/* End Tender
	/* ============================== */

	
	/* ==============================
	/* Konsultan
	/* ============================== */
	
	function konsultan()//no paging
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/konsultan/daftar_konsultan';
		
		$data['konsultan'] = $this->irsdp_model->get_konsultan();		
		$this->load->view('layout', $data);
	}
	
	function list_konsultan()//with paging
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah user
		$jml_konsul = $this->irsdp_model->get_jml_perusahaan($key );
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_konsultan/';
		$config['total_rows'] = $jml_konsul;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_user ke model dengan paging offsetnya
		$data['konsultan'] = $this->irsdp_model->get_all_perusahaan($config['per_page'],$key );
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/konsultan/daftar_konsultan';
		
		//view tabel perusahaan
		$this->load->view('layout',$data);
	}

	function add_konsultan()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/konsultan/add_konsultan';
		$data['form_title'] = 'New Consultant Form Registration';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama', 'Consultant Name', 'required');
			$this->form_validation->set_rules('jenis', 'Consultant Type', 'required');
			$this->form_validation->set_rules('alamat', 'Address', 'required');
			$this->form_validation->set_rules('telpon', 'Fixed Phone', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
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
								'status' => $this->input->post('status')
								);
				
				$msg = 'Adding new consultant data is successful';
									
				$this->irsdp_model->add_konsultan($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_konsultan');
			}	
		}	
		$this->load->view('layout', $data);		
	}
	
	function modify_konsultan($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/konsultan/modify_konsultan';
		$data['form_title'] = 'Add new Consultant data';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama', 'Consultant Name', 'required');
			$this->form_validation->set_rules('jenis', 'Consultant Type', 'required');
			$this->form_validation->set_rules('alamat', 'Address', 'required');
			$this->form_validation->set_rules('telpon', 'Fixed Phone', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idperusahaan' => $this->input->post('idperusahaan'),
								'nama' => $this->input->post('nama'),
								'jenis' => $this->input->post('jenis'),
								'alamat' => $this->input->post('alamat'),
								'telpon' => $this->input->post('telpon'),
								'fax' => $this->input->post('fax'),
								'hp' => $this->input->post('hp'),
								'email' => $this->input->post('email'),
								'website' => $this->input->post('website'),
								'status' => $this->input->post('status')
								);
				
				$msg = 'Consultant data has been already updated';
				$this->irsdp_model->modify_konsultan($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_konsultan');
			}	
		}
		
		if($id!=NULL) 
		{ 
			$data['konsultan'] = $this->irsdp_model->get_konsultan($id);
			$data['form_title'] = 'Edit detail';
		}		
		$this->load->view('layout', $data);		
	}
	
	function hapus_konsultan($id)
	{
		$this->irsdp_model->delete_konsultan($id);
		$msg = 'Consultant data has been deleted';
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_konsultan');
		
	}
	
	function detail_konsultan($id)
	{
		$data['detail'] = $this->irsdp_model->get_konsultan($id);
		$data['form_title'] = "Detail Consultant";
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/konsultan/view_konsultan';
		$this->load->view('layout', $data);	
	}
	
	function deactivation_perusahaan($id)
	{
		$this->irsdp_model->status_perusahaan($id,1);
		redirect('admin/list_konsultan');
	}
	
	function activation_perusahaan($id)
	{
		$this->irsdp_model->status_perusahaan($id,2);
		redirect('admin/list_konsultan');
	}
	
	function account_konsultan($id)
	{
		$this->db->where('idperusahaan', $id);
		$query = $this->db->get('pic');
		
		if($query->result() == 1)
		{
			redirect('admin/edit_user/'.$id);
		}
		else
		{
			redirect('admin/add_user_account/'.$id);
		}
	}
	
	/* ==============================
	/* End Konsultan
	/* ============================== */

	function input_ref_status()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/input_ref_status';
		
		/* $data['tender'] = $this->irsdp_model->get_daftar_tender();		
		'$this->load->view('layout', $data); */
	}
	
	
	/* ---------- */
	/* user management */
	/* ---------- */
	
	function list_user()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah user
		$jml_user = $this->irsdp_model->get_jml_user($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_user/';
		$config['total_rows'] = $jml_user;
		$config['per_page'] = '5';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_user ke model dengan paging offsetnya
		$data['user'] = $this->irsdp_model->get_all_user($config['per_page'],$key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/list_user';
		
		//view tabel user
		$this->load->view('layout',$data);
	}
	
	function add_user()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/add_user';
		$data['form_title'] = 'Add New User';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama', 'Username', 'required');
			$this->form_validation->set_rules('group', 'Group Name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');			
			$this->form_validation->set_rules('repassword', 'Retype Password', 'required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				if($this->irsdp_model->cek_user($this->input->post('nama')) > 0)
				{
					$msg = 'Process to input new user is failed!<br />Username has already available, choose a new one!';
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/add_user');
				}
				else
				{
					$param = array('nama' => $this->input->post('nama'),
									'group' => $this->input->post('group'),
									'password' => $this->input->post('password'),
									'email' => $this->input->post('email'),
									'phone' => $this->input->post('phone'),
									'hp' => $this->input->post('hp'),
									'fax' => $this->input->post('fax'),
									'idperusahaan' => $this->input->post('idperusahaan')
									);
					
					$msg = 'Add a new user is successful';
									
					$this->irsdp_model->add_user($param);
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/list_user');
				}
			}
		}
		$this->load->view('layout', $data);
	}
	
	function edit_user($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/edit_user';
		$data['form_title'] = 'Edit User Data';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama', 'Username', 'required');
			$this->form_validation->set_rules('group', 'Group Name', 'required');		
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array('idpic' => $this->input->post('idpic'),
								'nama' => $this->input->post('nama'),
								'group' => $this->input->post('group'),
								'email' => $this->input->post('email'),
								'phone' => $this->input->post('phone'),
								'hp' => $this->input->post('hp'),
								'fax' => $this->input->post('fax'),
								'idperusahaan' => $this->input->post('idperusahaan')
								);
				
				$msg = 'Edit user data is successful';
								
				$this->irsdp_model->edit_user($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_user');
			}
		}
		$data['user'] = $this->irsdp_model->get_user_by_id($id);
		$this->load->view('layout', $data);
	}
	
	function hapus_user($id)
	{		
		$this->irsdp_model->delete_user($id);
		$msg = "User data has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_user');
	}
	
	function add_user_account()
	{
		$id = $this->uri->segment(3);
		$namaperusahaan = $this->irsdp_model->get_consultant_name($id);
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/add_user_account';
		$data['form_title'] = 'Add New User for Consultant '.$namaperusahaan;
		$data['nama']=$namaperusahaan;
		$data['id']=$id;
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');		
			$this->form_validation->set_rules('repassword', 'Retype Password', 'required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{
				if($this->irsdp_model->cek_user($this->input->post('nama')) > 0)
				{
					$msg = 'Process to input new user is failed!<br />Username has already available, choose a new one!';
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/add_user_account/'.$id);
				}
				else
				{
					$param = array('nama' => $this->input->post('nama'),
									'group' => '4',
									'password' => $this->input->post('password'),
									'email' => $this->input->post('email'),
									'phone' => $this->input->post('phone'),
									'hp' => $this->input->post('hp'),
									'fax' => $this->input->post('fax'),
									'idperusahaan' => $this->input->post('idperusahaan')
									);
												
					$this->irsdp_model->add_user_account($param);
					//masuk ke form pengiriman email untuk konsultan baru
					redirect('admin/send_email_to_consultant/'.$this->input->post('idperusahaan'));
					//$this->send_email_to_consultant($this->input->post('idperusahaan'),$this->input->post('nama'),$this->input->post('password'),$this->input->post('email'));
				}
			}
		}
		$this->load->view('layout', $data);
	}
	
	function send_email_to_consultant()
	{
		$id=$this->uri->segment(3);
		
		//$data['username']=$username;
		//$data['password']=$password;
		//$data['email']=$email;
		$data['konsultan']=$this->irsdp_model->get_pic_consultant($id);
		//$data['id']=$id;
		
		$data['sub_layout'] = 'admin/layout';
		$data['form_title']='Send Email';		
		$data['main'] = 'admin/user/send_email';
		$this->load->view('layout',$data);
	}
	
	function sending_email()
	{
		$this->load->library('email');

		$this->email->from('irsdp-admin-do-not-reply@irsdp.bappenas.go.id', 'Administrator');
		$this->email->to($this->input->post('email'));
		//$this->email->cc('another@another-example.com');
		$this->email->bcc('mail-log@irsdp.bappenas.go.id');
		
		$message=	
"
Selamat!<br />
Registrasi data diri Anda atau Perusahaan Anda pada sistem IRSDP kami telah berhasil.<br />
Silahkan gunakan login account dibawah ini untuk melakukan login.<br /><br />
Username: ".$this->input->post('username')."<br />
Password: ".$this->input->post('password')."<br /><br />
Silahkan klik link dibawah ini untuk melakukan login<br />
<a href='http://localhost/irsdp'>irsdp bappenas</a>

Silahkan hubungi nomor dibawah ini untuk mendapatkan informasi lebih lengkap:<br />
Kantor Bappenas: 021-123123123

Administrator
";
		
		$this->email->subject('Login Account untuk IRSDP Bappenas');
		$this->email->message($message);

		if(!$this->email->send())
		{
			echo "<h1>pengiriman email gagal!<br /></h1>";
			echo $this->email->print_debugger();

		}
		else		
		{		
			$msg = 'Add a new user for consultant and sending email are successful';
			$this->session->set_flashdata('form_submit_status', $msg);
			redirect('admin/detail_konsultan/'.$this->input->post('idperusahaan'));
		}
	}
	
	function edit_password($id=NULL)
	{
		//$id=$this->uri->segment(3);
		$data['sub_layout'] = 'admin/layout';
		$data['form_title']='Change Password Form';		
		$data['main'] = 'admin/user/edit_password';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('oldpass', 'Old Password', 'required');
			$this->form_validation->set_rules('pass', 'New Password', 'required');		
			$this->form_validation->set_rules('repass', 'Retype New Password', 'required|matches[pass]');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
				//redirect('admin/edit_password/'.$this->input->post('idpic'));
			}
			else if($this->irsdp_model->cek_password($this->input->post('idpic'), $this->input->post('oldpass'))== TRUE)
			{
				$msg = 'Old Password for this user is wrong!';			
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/edit_password/'.$this->input->post('idpic'));
			}
			else
			{
				$param = array('password' => $this->input->post('pass'),
								'idpic' => $this->input->post('idpic'),
								);
											
				$this->irsdp_model->update_password_pic($param);
				$msg = 'Changing password for '.$this->input->post('nama').'is succesfull';			
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_user');
			}
		}				
		$data['pic']=$this->irsdp_model->get_user_by_id($id);
		$this->load->view('layout',$data);
	}
	
	/* ---------- */
	/* group management */
	/* ---------- */
	
	function list_group()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah user
		$jml_group = $this->irsdp_model->get_jml_group($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_group/';
		$config['total_rows'] = $jml_group;
		$config['per_page'] = '5';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_user ke model dengan paging offsetnya
		$data['group'] = $this->irsdp_model->get_all_group($config['per_page'],$key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/list_group';
		
		//view tabel group
		$this->load->view('layout',$data);
	}
	
	function add_group()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/add_group';
		$data['form_title'] = 'Add New Group';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('group', 'Group Name', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				if($this->irsdp_model->cek_group($this->input->post('group')) > 0)
				{
					$msg = 'Process to input new user is failed!<br />Group Name has already available, choose a new one!';
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/add_group');
				}
				else
				{
					$param = array(	'group' => $this->input->post('group'));
					
					$msg = 'Add a new group is successful';
									
					$this->irsdp_model->add_group($param);
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/list_group');
				}
			}
		}
		$this->load->view('layout', $data);
	}
	
	function edit_group($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/user/edit_group';
		$data['form_title'] = 'Edit Group Name';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('group', 'Group Name', 'required');	

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array('idgroup' => $this->input->post('idgroup'),
								'group' => $this->input->post('group')
								);
				
				$msg = 'Edit group data is successful';
								
				$this->irsdp_model->edit_group($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_group');
			}
		}
		$data['user'] = $this->irsdp_model->get_group_by_id($id);
		$this->load->view('layout', $data);
	}
	
	function hapus_group($id)
	{		
		$this->irsdp_model->delete_group($id);
		$msg = "Group has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_group');
	}
	
	/* ==============================
	/* Kontraktor
	/* ============================== */
	
	function kontraktor()//no paging
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/kontraktor/daftar_kontraktor';
		
		$data['kontraktor'] = $this->irsdp_model->get_kontraktor();		
		$this->load->view('layout', $data);
	}
	
	function list_kontraktor()//with paging
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah kontraktor
		$jml_kontraktor = $this->irsdp_model->get_jml_kontraktor($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_kontraktor/';
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
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/kontraktor/daftar_kontraktor';
		
		//view tabel kontraktor
		$this->load->view('layout',$data);
	}

	function add_kontraktor()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/kontraktor/add_kontraktor';
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
				redirect('admin/list_kontraktor');
			}	
		}	
		$this->load->view('layout', $data);		
	}
	
	function modify_kontraktor($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/kontraktor/modify_kontraktor';
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
				redirect('admin/list_kontraktor');
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
		$this->irsdp_model->delete_kontraktor($id);
		$msg = 'Contractor data has been deleted';
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_kontraktor');
		
	}
	
	function detail_kontraktor($id)
	{
		$data['detail'] = $this->irsdp_model->get_kontraktor($id);
		$data['form_title'] = "Detail Contractor";
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/kontraktor/view_kontraktor';
		$this->load->view('layout', $data);	
	}
	
	/* ==============================
	/* End of Kontraktor
	/* ============================== */
	
	/* ==============================
	/* TAG / DAFTAR RUAS
	/* ============================== */
		
	function tag()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/project_info/list_tag';
		
		$data['tag'] = $this->irsdp_model->get_daftar_ruas();		
		$this->load->view('layout', $data);
	}
	
	function list_tag()//with paging
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah siklus
		$jml_tag = $this->irsdp_model->get_jml_daftar_ruas($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_tag/';
		$config['total_rows'] = $jml_tag;
		$config['per_page'] = '15';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query kategori ke model dengan paging offsetnya
		$data['tag'] = $this->irsdp_model->get_daftar_ruas_page($key);	
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/project_info/list_tag';
		
		//view tabel daftar ruas
		$this->load->view('layout',$data);
	}
	
	function add_tag()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/project_info/add_tag';
		$data['form_title'] = 'Add new tag for project info';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('tag', 'Tag Code', 'required');
			$this->form_validation->set_rules('label', 'Project Information Label', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				if($this->irsdp_model->cek_tag($this->input->post('tag')) > 0)
				{
					$msg = 'Tag Code is not available<br />Input a new tag instead';
					$this->session->set_flashdata('form_submit_status', $msg);					
					redirect('admin/list_tag');
				}
				else
				{
					$param = array('tag' => $this->input->post('tag'),
									'label' => $this->input->post('label'),
									);
					
					$this->irsdp_model->add_daftar_ruas($param);
					$msg = 'Tag Information has been added succesfully';								
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/list_tag');
				}
			}
		}
		$this->load->view('layout', $data);		
	}
	
	function modify_tag($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/project_info/modify_tag';
		$data['form_title'] = 'Modify Project Information Tag';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('tag', 'Tag Code', 'required');
			$this->form_validation->set_rules('label', 'Project Information Label', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('iddaftar_ruas' => $this->input->post('iddaftar_ruas'),
								'tag' => $this->input->post('tag'),
								'label' => $this->input->post('label')
								);
				
				$msg = 'Tag Information has been added succesfully';
								
				// edit mode				
				if($this->input->post('iddaftar_ruas'))
				{
					$param['iddaftar_ruas'] = $this->input->post('iddaftar_ruas');
					$msg = 'Tag has been added';
				}
								
				$this->irsdp_model->modify_daftar_ruas($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_tag');
			}
		}
		
		if($id!=NULL) 
		{ 
			$data['tagvalue'] = $this->irsdp_model->get_daftar_ruas($id);		
			$data['form_title'] = 'Edit Tag Information';
		}		
		$this->load->view('layout', $data);		
	}
	
	function hapus_tag($id)
	{
		$this->irsdp_model->hapus_daftar_ruas($id);
		$msg = "Tag information sector has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_tag');
	}
	
	//end of tag
	//-----------------------
	
	//-----------------------
	//TEMPLATE PROJECT INFO
	//-----------------------
	function list_template()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah template
		$jml_tag = $this->irsdp_model->get_jml_template($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_template/';
		$config['total_rows'] = $jml_tag;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query template ke model dengan paging offsetnya
		$data['template'] = $this->irsdp_model->get_template_page($config['per_page'], $key);	
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/template/list_template';
		
		//view tabel template
		$this->load->view('layout',$data);
	}
	
	function add_template()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/template/add_template';
		$data['form_title'] = 'Add New Information Template for Project Info';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('tag', 'Tag Code', 'required');
			$this->form_validation->set_rules('idcategory', 'Project Sector Category', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('tag' => $this->input->post('tag'),
								'idcategory' => $this->input->post('idcategory'),
								);
				
				$this->irsdp_model->add_template($param);
				$msg = 'Information template has been added succesfully';								
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_template');
			}
		}
		$this->load->view('layout', $data);		
	}
	
	function modify_template($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/template/modify_template';
		$data['form_title'] = 'Modify Project Information Tag';
		
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('tag', 'Tag Code', 'required');
			$this->form_validation->set_rules('idcategory', 'Project Sector Category', 'required');

			if ($this->form_validation->run()==FALSE)
			{
				// validation failed
			}
			else
			{						
				$param = array('idtemplate' => $this->input->post('idtemplate'),
								'tag' => $this->input->post('tag'),
								'idcategory' => $this->input->post('idcategory')
								);
				
				$msg = 'Information template has been added succesfully';
								
								
				$this->irsdp_model->modify_template($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_template');
			}
		}
		
		if($id!=NULL) 
		{ 
			$data['template'] = $this->irsdp_model->get_template($id);		
			$data['form_title'] = 'Edit Information Template';
		}		
		$this->load->view('layout', $data);		
	}
	
	function hapus_template($id)
	{
		$this->irsdp_model->hapus_template($id);
		$msg = "Information template has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_template');
	}
	
	/* ---------- */
	/* kabupaten/kota and provinsi management */
	/* ---------- */
	
	function list_provinsi()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah kabupaten
		$jml_provinsi = $this->irsdp_model->count_jml_prov_by_key($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_provinsi/';
		$config['total_rows'] = $jml_provinsi;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_provinsi ke model dengan paging offsetnya
		$data['provinsi'] = $this->irsdp_model->get_all_prov_by_key($config['per_page'], $key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/daerah/list_provinsi';
		
		//view tabel kabupaten
		$this->load->view('layout',$data);
	}
	
	function add_provinsi()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/daerah/add_provinsi';
		$data['form_title'] = 'Add New Province';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama_propinsi', 'Provinsi Name', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				if($this->irsdp_model->cek_provinsi($this->input->post('nama_propinsi')) > 0)
				{
					$msg = 'Process to input new province is failed!<br />Province Name has already available, choose a new one!';
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/add_provinsi');
				}
				else
				{
					$param = array(	'nama_propinsi' => $this->input->post('nama_propinsi'));
					
					$msg = 'Add a new province is successful';
									
					$this->irsdp_model->add_provinsi($param);
					$this->session->set_flashdata('form_submit_status', $msg);
					redirect('admin/list_provinsi');
				}
			}
		}
		$this->load->view('layout', $data);
	}
	
	function edit_provinsi($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/daerah/edit_provinsi';
		$data['form_title'] = 'Edit Province Name';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama_propinsi', 'Province Name', 'required');	

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array('id_propinsi' => $this->input->post('id_propinsi'),
								'nama_propinsi' => $this->input->post('nama_propinsi')
								);
				
				$msg = 'Edit province data is successful';
								
				$this->irsdp_model->edit_provinsi($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_provinsi');
			}
		}
		$data['provinsi'] = $this->irsdp_model->get_provinsi_by_id($id);
		$this->load->view('layout', $data);
	}
	
	function hapus_provinsi($id)
	{		
		$this->irsdp_model->delete_provinsi($id);
		$msg = "Province has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_provinsi');
	}
	
	
	// kota/kabupaten		
	function list_kabupaten()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah kabupaten
		$jml_kabupaten = $this->irsdp_model->count_jml_kab_by_key($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_kabupaten/';
		$config['total_rows'] = $jml_kabupaten;
		$config['per_page'] = '20';
		$config['num_links'] = '10';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_kabupaten ke model dengan paging offsetnya
		$data['kab_by_key'] = $this->irsdp_model->get_all_kab_by_key($config['per_page'], $key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/daerah/list_kota';
		
		//view tabel kabupaten
		$this->load->view('layout',$data);
	}
	
	function add_kabupaten()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/daerah/add_kota';
		$data['form_title'] = 'Add New City';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama_kabupaten', 'City Name', 'required|xss_clean');
			$this->form_validation->set_rules('id_propinsi', 'Province Name', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array(	'nama_kabupaten' => $this->input->post('nama_kabupaten'),
								'id_propinsi' => $this->input->post('id_propinsi')
								);
				
				$msg = 'Add a new province is successful';
								
				$this->irsdp_model->add_kabupaten($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_kabupaten');
			}
		}
		$this->load->view('layout', $data);
	}
	
	function edit_kabupaten($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/daerah/edit_kota';
		$data['form_title'] = 'Edit City Data';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nama_kabupaten', 'City Name', 'required|xss_clean');
			$this->form_validation->set_rules('id_propinsi', 'Province Name', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array('id_kabupaten' => $this->input->post('id_kabupaten'),
								'nama_kabupaten' => $this->input->post('nama_kabupaten'),
								'id_propinsi' => $this->input->post('id_propinsi')
								);
				
				$msg = 'Edit city data is successful';
								
				$this->irsdp_model->edit_kabupaten($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_kabupaten');
			}
		}
		$data['kabupaten'] = $this->irsdp_model->get_kabupaten_by_id($id);
		$this->load->view('layout', $data);
	}
	
	function hapus_kabupaten($id)
	{		
		$this->irsdp_model->delete_kabupaten($id);
		$msg = "City has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_kabupaten');
	}
	
	//------------------------
	/* LOAN */
	//------------------------
	
	function list_loan()
	{
		$key = $this->input->post('keyword');
		/* here we go!!! */
		$this->load->library('pagination');
		//ambil jumlah kabupaten
		$jml_loan = $this->irsdp_model->count_jml_loan($key);
		//setingan paging
		$config['base_url'] = base_url().'index.php/admin/list_loan/';
		$config['total_rows'] = $jml_loan;
		$config['per_page'] = '10';
		$config['num_links'] = '2';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		//kirim setingan paging
		$this->pagination->initialize($config);
		
		//bikin link paging
		$data['paging'] = $this->pagination->create_links();
		
		//kirim query get_provinsi ke model dengan paging offsetnya
		$data['loan'] = $this->irsdp_model->get_all_loan_by_key($config['per_page'], $key);
		
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/loan/list_loan';
		
		//view tabel kabupaten
		$this->load->view('layout',$data);
	}
	
	function add_loan()
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/loan/add_loan';
		$data['form_title'] = 'Add New Loan';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('kategori', 'Category Loan', 'required|xss_clean');
			$this->form_validation->set_rules('catatan', 'Loan Information', 'required|xss_clean');
			$this->form_validation->set_rules('loan_grand', 'Loan Grand', 'required|xss_clean');
			$this->form_validation->set_rules('category1', 'Category', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array('kategori' => $this->input->post('kategori'),
								'catatan' => $this->input->post('catatan'),
								'loan_grand' => $this->input->post('loan_grand'),
								'loan' => $this->input->post('loan'),
								'grand' => $this->input->post('grand'),
								'category1' => $this->input->post('category1')
								);
				
				$msg = 'Add loan data is successful';
								
				$this->irsdp_model->add_loan($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_loan');
			}
		}
		$this->load->view('layout', $data);
	}
	
	function edit_loan($id=NULL)
	{
		$data['sub_layout'] = 'admin/layout';
		$data['main'] = 'admin/loan/edit_loan';
		$data['form_title'] = 'Edit Loan Data';
				
		if($_POST)
		{
			// validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('kategori', 'Category Loan', 'required|xss_clean');
			$this->form_validation->set_rules('catatan', 'Loan Information', 'required|xss_clean');
			$this->form_validation->set_rules('loan_grand', 'Loan Grand', 'required|xss_clean');
			$this->form_validation->set_rules('category1', 'Category', 'required|xss_clean');

			if ($this->form_validation->run()==FALSE)
			{
				//back to view with error messages!
			}
			else
			{						
				$param = array('kategori' => $this->input->post('kategori'),
								'catatan' => $this->input->post('catatan'),
								'loan_grand' => $this->input->post('loan_grand'),
								'loan' => $this->input->post('loan'),
								'grand' => $this->input->post('grand'),
								'category1' => $this->input->post('category1'),
								'idloan' => $this->input->post('idloan')
								);
				
				$msg = 'Edit loan data is successful';
								
				$this->irsdp_model->edit_loan($param);
				$this->session->set_flashdata('form_submit_status', $msg);
				redirect('admin/list_loan');
			}
		}
		$data['loan'] = $this->irsdp_model->get_loan_by_id($id);
		$this->load->view('layout', $data);
	}
	
	function hapus_loan($id)
	{		
		$this->irsdp_model->delete_loan($id);
		$msg = "Loan has already deleted";
		$this->session->set_flashdata('form_submit_status', $msg);
		redirect('admin/list_loan');
	}
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */	