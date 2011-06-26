<?php
class Irsdp_model extends Model {
	
	function Irsdp_model()
	{
		parent::Model();	
	}
		
	/* =============================
	/* Login
	/* ============================= */
	function auth_login($username, $password)
	{
		$this->db->from('pic');
		$this->db->join('group', 'pic.group=group.idgroup');
		$this->db->where('nama', $username);
		$this->db->where('password', $password);
		
		$res = $this->db->get();
		if($res->num_rows()==1)
		{
			$auth['valid'] = TRUE;
			$auth['id_user'] = $res->row('idpic');
			$auth['idperusahaan'] = $res->row('idperusahaan');
			$auth['username'] = $res->row('nama');
			$auth['group'] = $res->row('group');
			return $auth;
		}
		else
		{
			$auth['valid'] = FALSE;
			return $auth;			
		}
	}
	
	
	/* ==============================
	/* Input Proyek Usulan
	/* ============================== */
	function input_proyek_usulan($param)
	{
		$this->db->set('nama', $param['project_title']);
		$this->db->set('pin', $param['pin']);
		$this->db->set('ppp_book_code', $param['ppp_book_code']);
		$this->db->set('usulan_lpd', $param['proposed_agency']);
		$this->db->set('lokasi', $param['project_location']);
		$this->db->set('id_kategori', $param['idkategori']);
		$this->db->set('tipe_proyek', $param['project_type']);
		$this->db->set('bpsid_propinsi', $param['province_code']);
		$this->db->set('tgl_usulan', $param['tgl_usulan']);
		$this->db->set('tgl_diisi', $param['tgl_diisi']);
		$this->db->set('surat_lpd', $param['surat_lpd']);
		$this->db->set('ppp_form', $param['ppp_form']);
		$this->db->set('appr_dprd', $param['appr_dprd']);
		$this->db->set('doc_fs', $param['doc_fs']);
		$this->db->set('idoperator', $param['idoperator']);
		$this->db->set('view', $param['view']);
		$this->db->insert('project_profile');
		
		$project_id = $this->db->insert_id(); // get project id
		
		// project info
		// get template based on category
		$this->db->from('template');
		$this->db->where('idcategory', $param['idkategori']);
		$template = $this->db->get();
		
		// insert into isian_ruas
		foreach($template->result() as $tmp):
			$this->db->set('proyek_id', $project_id);
			$this->db->set('tag', $tmp->tag);
			$this->db->set('value', '');
			$this->db->insert('isian_ruas');
		endforeach;
		
		// proj_flow
		$this->db->set('idproject_profile', $project_id);
		$this->db->set('idref_status', 1);
		$this->db->set('tgl_rencana', date('Y-m-d'));
		$this->db->set('status', 'on going');
		$this->db->insert('proj_flow');		
				
		// ref status project profile (PAS dan TAS)
		$status_project = $this->db->insert_id(); // Flow ID
		$this->db->set('idref_status', $status_project);
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', date('Y-m-d'));	
		$this->db->set('status_akhir', 'on going');	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 1); /* FIXME */
		$this->db->insert('ref_status_project_profile');
		$pas_id = $this->db->insert_id();
		
		$this->db->set('idref_status', $status_project);
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', date('Y-m-d'));	
		$this->db->set('status_akhir', 'on going');	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 3); /* FIXME */
		$this->db->insert('ref_status_project_profile');
		$tas_id = $this->db->insert_id();

		// proj_flow_status
		$this->db->set('status', 'on going');
		$this->db->set('idproj_flow', $status_project);
		$this->db->set('idpic', 1); /* FIXME */
		$this->db->insert('proj_flow_status');
		
		$this->db->set('status', 'on going');
		$this->db->set('idproj_flow', $status_project);
		$this->db->set('idpic', 3); /* FIXME */
		$this->db->insert('proj_flow_status');

		// dokumen
		$this->db->set('idstatus_project', $status_project);
		$this->db->set('idoperator', $param['idoperator']);
		$this->db->set('nama_berkas', $param['nama_berkas']['file_name']);
		$this->db->set('tgl_upload', date('Y-m-d'));
		//$this->db->set('jenis_dok', );
		$this->db->insert('jenis_dok');		
		
		// cerita (default)
		/* FIXME */
		$this->db->set('idproj_flow', $pas_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'PAS begin to check administrative requirement.');	
		$this->db->set('idpic', 1); /* FIXME */
		$this->db->insert('cerita');

		$this->db->set('idproj_flow', $tas_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'TAS begin to check technical requirement.');	
		$this->db->set('idpic', 3); /* FIXME */
		$this->db->insert('cerita');
		
		return $project_id;
	}
	
	function update_proyek($param)
	{
		$this->db->set('nama', $param['project_title']);
		$this->db->set('pin', $param['pin']);
		$this->db->set('ppp_book_code', $param['ppp_book_code']);
		$this->db->set('usulan_lpd', $param['proposed_agency']);
		$this->db->set('lokasi', $param['project_location']);
		$this->db->set('id_kategori', $param['idkategori']);
		$this->db->set('tipe_proyek', $param['project_type']);
		$this->db->set('bpsid_propinsi', $param['province_code']);
		$this->db->set('tgl_usulan', $param['tgl_usulan']);
		$this->db->set('tgl_revisi', $param['tgl_revisi']);
		$this->db->set('surat_lpd', $param['surat_lpd']);
		$this->db->set('ppp_form', $param['ppp_form']);
		$this->db->set('appr_dprd', $param['appr_dprd']);
		$this->db->set('idoperator', $param['idoperator']);
		$this->db->set('view', $param['view']);	
		$this->db->where('idproject_profile', $param['idproject_profile']);
		$this->db->update('project_profile');		
	}
	
	function visibility($mode, $idproj)
	{
		if($mode=='Visible')
			$this->db->set('view', 1);
		else
			$this->db->set('view', 2);
			
		$this->db->where('idproject_profile', $idproj);
		$this->db->update('project_profile');				
	}
	
	function get_proyek_usulan($param)
	{
		$this->db->from('project_profile', 'proj_flow');	
		$this->db->join('proj_flow', 'project_profile.idproject_profile=proj_flow.idproject_profile');
		$this->db->join('ref_status', 'ref_status.idref_status=proj_flow.idref_status');
		$this->db->join('kategori', 'project_profile.id_kategori=kategori.idkategori');
		$this->db->where('project_profile.pin like \'A%\'', null, false);
		//$this->db->join('proj_flow_status', 'proj_flow.idproj_flow=proj_flow_status.idproj_flow');		
		//$this->db->where('idoperator', $param['uid']);
		$this->db->where('proj_flow.status', 'on going');
		//$this->db->where('project_profile.view', 2); 		/* FIXME */
		//$this->db->where('tahap', 1); /* FIXME */
		
		if(isset($param['tanggal_mulai']) && isset($param['tanggal_akhir']))
		{
			$this->db->where('proj_flow.tgl_rencana BETWEEN "'.$param['tanggal_mulai'].'" AND "'.$param['tanggal_akhir'].'"', NULL, FALSE);
		}
		else if(isset($param['search_text']) && isset($param['search_by']))
		{
			$this->db->like($param['search_by'], $param['search_text']);
		}
		else if(isset($param['tahap']))
		{
			switch($param['tahap'])
			{
				case 'selection-proposed':
					$this->db->where('proj_flow.idref_status <=', 2);						
					//$this->db->where('proj_flow.status !=', 'done');
				break;
				
				case 'selection-approved':
					$this->db->where('proj_flow.idref_status BETWEEN 3 and 4');	
				break;
				
				case 'ready_to_tender-pra_fs':
					$this->db->where('proj_flow.idref_status BETWEEN 5 and 14');
					$this->db->where('proj_flow.status !=', 'done');
					$this->db->or_where('proj_flow.idref_status BETWEEN 49 and 58');
					$this->db->where('proj_flow.status !=', 'done');					
				break;
				
				case 'ready_to_tender-transaction':
					$this->db->where('proj_flow.idref_status BETWEEN 84 and 94');
					$this->db->where('proj_flow.status !=', 'done');
					$this->db->or_where('proj_flow.idref_status BETWEEN 129 and 139');
					$this->db->where('proj_flow.status !=', 'done');					
				break;
				
				case 'ready_to_tender-investor':
					$this->db->where('proj_flow.idref_status', 176);
				break;

				case 'ongoing_tender-pra_fs':
					$this->db->where('proj_flow.idref_status BETWEEN 15 and 45');
					$this->db->where('proj_flow.status !=', 'done');
					$this->db->or_where('proj_flow.idref_status BETWEEN 49 and 78');
					$this->db->where('proj_flow.status !=', 'done');					
				break;
				
				case 'ongoing_tender-transaction':
					$this->db->where('proj_flow.idref_status BETWEEN 95 and 125');
					$this->db->where('proj_flow.status !=', 'done');
					$this->db->or_where('proj_flow.idref_status BETWEEN 139 and 162');
					$this->db->where('proj_flow.status !=', 'done');					
				break;
				
				case 'ongoing_tender-investor':
					$this->db->where('proj_flow.idref_status', 177);
				break;
				
				case 'contracted-pra_fs':
					$this->db->where('proj_flow.idref_status BETWEEN 46 and 48');
					$this->db->where('proj_flow.status !=', 'done');
					$this->db->or_where('proj_flow.idref_status BETWEEN 79 and 83');
					$this->db->where('proj_flow.status !=', 'done');				
				break;

				case 'contracted-transaction':
					$this->db->where('proj_flow.idref_status BETWEEN 126 and 128');
					$this->db->where('proj_flow.status !=', 'done');
					$this->db->or_where('proj_flow.idref_status BETWEEN 140 and 175');
					$this->db->where('proj_flow.status !=', 'done');				
				break;	
				
				case 'contracted-investor':
					$this->db->where('proj_flow.idref_status', 177);
				break;											
			}
		}
		
		$this->db->order_by('pin', 'asc');
		$this->db->order_by('subsectorname', 'asc');
		$this->db->order_by('nama', 'asc');		
		
		// Limit offset
		if(isset($param['limit']) && isset($param['offset'])) 
			$this->db->limit($param['limit'], $param['offset']);

		return $this->db->get();
	}
	
	function get_proyek_terkontrak($param)
	{
//		$this->db->distinct();
//		$this->db->select('pin','subsectorname','nama','lokasi');
		$this->db->from('project_profile', 'proj_flow');	
		$this->db->join('proj_flow', 'project_profile.idproject_profile=proj_flow.idproject_profile');
		$this->db->join('ref_status', 'ref_status.idref_status=proj_flow.idref_status');
		$this->db->join('kontrak_flow', 'kontrak_flow.idproj_flow=proj_flow.idproj_flow');
		$this->db->join('kategori', 'project_profile.id_kategori=kategori.idkategori');
		$this->db->join('ref_kontrak', 'kontrak_flow.idref_kontrak=ref_kontrak.idref_kontrak');		
		$this->db->where('ref_status.kontrak_step', 1);
		$this->db->where('kontrak_flow.status', 'on going'); /* FIXME */
		$this->db->order_by('pin', 'asc');
		$this->db->order_by('subsectorname', 'asc');
		$this->db->order_by('nama', 'asc');		
		
		// Limit offset
		if(isset($param['limit']) && isset($param['offset'])) 
			$this->db->limit($param['limit'], $param['offset']);
		
		return $this->db->get();		
	}
	
	function get_proyek($idproj)
	{
		$this->db->from('project_profile');	
		$this->db->where('idproject_profile', $idproj);
		return $this->db->get();
	}

	function get_proyek_info($idproj)
	{
		$this->db->from('project_profile');	
		$this->db->join('isian_ruas', 'isian_ruas.proyek_id = project_profile.idproject_profile');
		$this->db->join('daftar_ruas', 'isian_ruas.tag = daftar_ruas.tag');
		$this->db->where('idproject_profile', $idproj);
		return $this->db->get();
	}	
	
	function modify_project_info($param)
	{
		$this->db->set('value', $param['value']);
		$this->db->where('tag', $param['tag']);
		$this->db->where('proyek_id', $param['proyek_id']);
		$this->db->update('isian_ruas');
	}
	
	function insert_ref_kontrak($param)
	{
		$this->db->set('detil_status', $param['detil_status']);
		$this->db->set('next_step', $param['next_step']);
		$this->db->insert('ref_kontrak');	
		return $this->db->insert_id();	
	}
	
	function get_last_ref_kontrak_id()
	{
		$this->db->select('max(idref_kontrak) as last');
		$this->db->from('ref_kontrak');
		$res = $this->db->get();
		
		if($res->row('last')==NULL) 
			$last = 2; /* FIXME */
		else 
			$last = $res->row('last')+2; /* FIXME    HERE...... */
		
		return $last;
	}
	
	/* ==============================
	/* Detail Proyek
	/* ============================== */
	function get_detail_proyek($id_proj, $id_flow=NULL)
	{
		//$this->db->select('proj_flow.*, project_profile.*, ref_status.kode_status, ref_status.detil_status');
		
		$this->db->from('proj_flow');
		$this->db->join('project_profile', 'project_profile.idproject_profile=proj_flow.idproject_profile');	
		$this->db->join('ref_status', 'ref_status.idref_status=proj_flow.idref_status');
		//$this->db->join('ref_status_project_profile', 'ref_status_project_profile.idref_status=proj_flow.idproj_flow');	
		$this->db->where('project_profile.idproject_profile', $id_proj);
		if($id_flow!=NULL)
			$this->db->where('proj_flow.idproj_flow', $id_flow);
		//else 
			//$this->db->where('proj_flow.status', 'on going'); /* FIXME */
		$this->db->order_by('proj_flow.idref_status','desc');
		return $this->db->get();
	}
	
	/* detail ringkas yang dipilih hanya laporan_flag> 0 dari ref_status */
	function get_detail_proyek_ringkas($id_proj, $id_flow=NULL)
	{
		//$query = "SELECT detil_status, kode_status, laporan_flag FROM ref_status where laporan_flag>0 ORDER BY laporan_flag ASC";
		
		$this->db->from('proj_flow');
		$this->db->join('project_profile', 'project_profile.idproject_profile=proj_flow.idproject_profile');	
		$this->db->join('ref_status', 'ref_status.idref_status=proj_flow.idref_status');
		//$this->db->join('ref_status_project_profile', 'ref_status_project_profile.idref_status=proj_flow.idproj_flow');	
		
		$this->db->where('ref_status.laporan_flag >', 0);
		
		$this->db->where('project_profile.idproject_profile', $id_proj);
		if($id_flow!=NULL)
			$this->db->where('proj_flow.idproj_flow', $id_flow);
		//else 
			//$this->db->where('proj_flow.status', 'on going'); /* FIXME */
		$this->db->order_by('ref_status.laporan_flag','desc');
		return $this->db->get();
	}

	function get_detail_proyek_terkontrak($id_proj, $id_flow=NULL)
	{
		$this->db->select('*');
		$this->db->select('kontrak_flow.tgl_rencana as tanggal_rencana');
		$this->db->from('kontrak_flow');
		$this->db->join('proj_flow', 'proj_flow.idproj_flow=kontrak_flow.idproj_flow');
		$this->db->join('project_profile', 'project_profile.idproject_profile=proj_flow.idproject_profile');
		$this->db->join('kategori', 'project_profile.id_kategori=kategori.idkategori');	
		$this->db->join('ref_kontrak', 'kontrak_flow.idref_kontrak=ref_kontrak.idref_kontrak');
		//$this->db->join('ref_status', 'ref_status.idref_status=proj_flow.idref_status');
		//$this->db->join('ref_status_project_profile', 'ref_status_project_profile.idref_status=proj_flow.idproj_flow');	
		$this->db->where('project_profile.idproject_profile', $id_proj);
		if($id_flow!=NULL)
			$this->db->where('kontrak_flow.idkontrak_flow', $id_flow);
		//else 
			//$this->db->where('proj_flow.status', 'on going'); /* FIXME */
		$this->db->order_by('kontrak_flow.idkontrak_flow','desc');
		return $this->db->get();
	}	
	
	
	/* ==============================
	/* Get Status Proyek by PAS/TAS
	/* ============================== */ 
	function get_status_proyek($idproj_flow, $type)
	{
		$this->db->from('proj_flow');
		$this->db->join('ref_status_project_profile', 'ref_status_project_profile.idref_status=proj_flow.idproj_flow');
		$this->db->join('cerita', 'cerita.idproj_flow=ref_status_project_profile.idstatusproject');
		$this->db->where('proj_flow.idproj_flow', $idproj_flow);
		
		switch($type)
		{
			case 'pas':
				$this->db->where('ref_status_project_profile.idoperator', 1); /* FIXME */
				$this->db->where('cerita.idpic', 1); /* FIXME */
			break;
			
			case 'tas':
				$this->db->where('ref_status_project_profile.idoperator', 3); /* FIXME */
				$this->db->where('cerita.idpic', 3); /* FIXME */
			break;
		}
		$this->db->order_by('tgl_cerita', 'desc');
		$this->db->order_by('idcerita', 'desc');
		$this->db->limit(1); /* FIXME */
		
		return $this->db->get();
	}

	function get_status_proyek_terkontrak($idkontrak_flow, $type)
	{
		$this->db->from('kontrak_flow');
		$this->db->join('proj_flow', 'kontrak_flow.idproj_flow=proj_flow.idproj_flow');
		$this->db->join('ref_status_kontrak', 'ref_status_kontrak.idkontrak_flow=kontrak_flow.idkontrak_flow');
		$this->db->join('cerita', 'cerita.idstatuskontrak=ref_status_kontrak.idstatuskontrak');
		$this->db->where('kontrak_flow.idkontrak_flow', $idkontrak_flow);
		
		switch($type)
		{
			case 'pas':
				$this->db->where('ref_status_kontrak.idoperator', 1); /* FIXME */
				$this->db->where('cerita.idpic', 1); /* FIXME */
			break;
			
			case 'tas':
				$this->db->where('ref_status_kontrak.idoperator', 3); /* FIXME */
				$this->db->where('cerita.idpic', 3); /* FIXME */
			break;
		}
		$this->db->order_by('tgl_cerita', 'desc');
		$this->db->order_by('idcerita', 'desc');
		$this->db->limit(1); /* FIXME */
		
		return $this->db->get();
	}	
	
	function get_status_single($idproj_flow, $type)
	{
		$this->db->select('proj_flow_status.status as status');
		$this->db->from('proj_flow_status');
		$this->db->join('proj_flow', 'proj_flow.idproj_flow=proj_flow_status.idproj_flow');
		$this->db->where('proj_flow.status', 'on going');
		$this->db->where('proj_flow_status.idproj_flow', $idproj_flow);
		switch($type)
		{
			case 'pas':
				$this->db->where('idpic', 1); /* FIXME */
			break;
			
			case 'tas':
				$this->db->where('idpic', 3); /* FIXME */
			break;
		}	
		return $this->db->get()->row('status');	
	}

	function get_kontrak_status_single($idproj_flow, $type)
	{
		$this->db->select('kontrak_flow_status.status as status');
		$this->db->from('kontrak_flow_status');
		$this->db->join('kontrak_flow', 'kontrak_flow.idkontrak_flow=kontrak_flow_status.idkontrak_flow');
		$this->db->join('proj_flow', 'kontrak_flow.idproj_flow=proj_flow.idproj_flow');
		$this->db->where('kontrak_flow.status', 'on going');
		$this->db->where('proj_flow.idproj_flow', $idproj_flow);
		switch($type)
		{
			case 'pas':
				$this->db->where('idpic', 1); /* FIXME */
			break;
			
			case 'tas':
				$this->db->where('idpic', 3); /* FIXME */
			break;
			
			case 'consultant':
				$this->db->where('idpic', 4); /* FIXME */
			break;
		}	
		return $this->db->get()->row('status');	
	}	
	
	function get_current_step($id_proj)
	{
		$this->db->select('idref_status');
		$this->db->from('proj_flow');
		$this->db->where('idproject_profile', $id_proj);
		$this->db->where('status !=', 'done');
		return $this->db->get()->row('idref_status');
	}
	
	function get_current_contract_step($id_kontrak_flow)
	{
		$this->db->select('idref_kontrak');
		$this->db->from('kontrak_flow');
		$this->db->where('idkontrak_flow', $id_kontrak_flow);
		$this->db->where('status !=', 'done');
		return $this->db->get()->row('idref_kontrak');		
	}
	
	function count_problem_step($idproj_flow, $type)
	{
		$this->db->from('proj_flow');
		$this->db->join('ref_status_project_profile', 'ref_status_project_profile.idref_status=proj_flow.idproj_flow');
		$this->db->join('cerita', 'cerita.idproj_flow=ref_status_project_profile.idstatusproject');
		$this->db->where('proj_flow.idproj_flow', $idproj_flow);
		$this->db->where('ref_status_project_profile.status_akhir !=', 'done');
		
		switch($type)
		{
			case 'pas':
				$this->db->where('ref_status_project_profile.idoperator', 1); /* FIXME */
				$this->db->where('cerita.idpic', 1); /* FIXME */
			break;
			
			case 'tas':
				$this->db->where('ref_status_project_profile.idoperator', 3); /* FIXME */
				$this->db->where('cerita.idpic', 3); /* FIXME */
			break;
		}
		
		$this->db->select('count(*) as prob_count');
		
		return $this->db->get()->row('prob_count');
	}	

	function count_problem_step_kontrak($idkontrak_flow, $type)
	{
		$this->db->from('kontrak_flow');
		$this->db->join('ref_status_kontrak', 'ref_status_kontrak.idkontrak_flow=kontrak_flow.idkontrak_flow');
		$this->db->join('cerita', 'cerita.idstatuskontrak=ref_status_kontrak.idstatuskontrak');
		$this->db->where('kontrak_flow.idkontrak_flow', $idkontrak_flow);
		$this->db->where('ref_status_kontrak.status_akhir !=', 'done');
		
		switch($type)
		{
			case 'pas':
				$this->db->where('ref_status_kontrak.idoperator', 1); /* FIXME */
				$this->db->where('cerita.idpic', 1); /* FIXME */
			break;
			
			case 'tas':
				$this->db->where('ref_status_kontrak.idoperator', 3); /* FIXME */
				$this->db->where('cerita.idpic', 3); /* FIXME */
			break;

			case 'konsultan':
				$this->db->where('ref_status_kontrak.idoperator', 4); /* FIXME */
				$this->db->where('cerita.idpic', 4); /* FIXME */
			break;			
		}
		
		$this->db->select('count(*) as prob_count');
		
		return $this->db->get()->row('prob_count');
	}		
	
	/* ==============================
	/* Update Step Proyek
	/* ============================== */
	function update_step($param)
	{
		// proj_flow
		$this->db->set('idproject_profile', $param['idproject_profile']);
		$this->db->set('idref_status', $param['idref_status']);
		$this->db->set('tgl_rencana', $param['tgl_rencana']);
		$this->db->set('status', $param['status']);
		$this->db->insert('proj_flow');	

		// ref status project profile (PAS dan TAS)
		$status_project = $this->db->insert_id(); // Flow ID
		$this->db->set('idref_status', $status_project);
		$this->db->set('idproject_profile', $param['idproject_profile']);	// cek lagi, bisa dibuang?
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', $param['tgl_rencana']);	
		$this->db->set('status_akhir', $param['status']);	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 1); /* FIXME */
		$this->db->insert('ref_status_project_profile');
		$pas_id = $this->db->insert_id();
		
		$this->db->set('idref_status', $status_project);
		$this->db->set('idproject_profile', $param['idproject_profile']);	// cek lagi, bisa dibuang?
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', $param['tgl_rencana']);	
		$this->db->set('status_akhir', $param['status']);	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 3); /* FIXME */
		$this->db->insert('ref_status_project_profile');
		$tas_id = $this->db->insert_id();
		
		// cerita
		/* FIXME */
		$this->db->set('idproj_flow', $pas_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'PAS begin to check administrative requirement.');	
		$this->db->set('idpic', 1); /* FIXME */
		$this->db->insert('cerita');

		$this->db->set('idproj_flow', $tas_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'TAS begin to check technical requirement.');	
		$this->db->set('idpic', 3); /* FIXME */
		$this->db->insert('cerita');		
			
		
		// proj_flow_status
		$this->db->set('status', $param['status']);
		$this->db->set('idproj_flow', $status_project);
		$this->db->set('idpic', 1); /* FIXME */
		$this->db->insert('proj_flow_status');
		
		$this->db->set('status', $param['status']);
		$this->db->set('idproj_flow', $status_project);
		$this->db->set('idpic', 3); /* FIXME */
		$this->db->insert('proj_flow_status');
	}

	function update_step_proyek_terkontrak($param)
	{
		if(isset($param['init']))
		{
			// insert project_flow
			$this->update_step($param);
			
			// get last proj_flow id
			$this->db->select('max(idproj_flow) as last'); /* FIXME */
			$idproj_flow = $this->db->get('proj_flow')->row('last');			
		}
		else $idproj_flow = $param['idproj_flow'];
		
		// kontrak_flow
		$this->db->set('idproj_flow', $idproj_flow);
		$this->db->set('idref_kontrak', $param['idref_kontrak']);
		$this->db->set('tgl_rencana', $param['tgl_rencana']);
		$this->db->set('status', $param['status']);
		$this->db->insert('kontrak_flow');	

		// ref_status_kontrak (PAS dan TAS)
		$status_project = $this->db->insert_id(); // Flow ID
		$this->db->set('idkontrak_flow', $status_project);
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', $param['tgl_rencana']);	
		$this->db->set('status_akhir', $param['status']);	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 1); /* FIXME */
		$this->db->insert('ref_status_kontrak');
		$pas_id = $this->db->insert_id();
		
		$this->db->set('idkontrak_flow', $status_project);
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', $param['tgl_rencana']);	
		$this->db->set('status_akhir', $param['status']);	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 3); /* FIXME */
		$this->db->insert('ref_status_kontrak');
		$tas_id = $this->db->insert_id();

		$this->db->set('idkontrak_flow', $status_project);
		$this->db->set('tgl_mulai', date('Y-m-d'));
		$this->db->set('tgl_akhir', $param['tgl_rencana']);	
		$this->db->set('status_akhir', $param['status']);	
		$this->db->set('tgl_diisi', date('Y-m-d'));
		$this->db->set('idoperator', 4); /* FIXME */
		$this->db->insert('ref_status_kontrak');
		$cons_id = $this->db->insert_id();		
		
		// cerita
		/* FIXME */
		$this->db->set('idstatuskontrak', $pas_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'PAS begin to check administrative requirement.');	
		$this->db->set('idpic', 1); /* FIXME */
		$this->db->insert('cerita');

		$this->db->set('idstatuskontrak', $tas_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'TAS begin to check technical requirement.');	
		$this->db->set('idpic', 3); /* FIXME */
		$this->db->insert('cerita');		

		$this->db->set('idstatuskontrak', $cons_id);
		$this->db->set('tgl_cerita', date('Y-m-d'));
		$this->db->set('deskripsi', 'Step initialized.');	
		$this->db->set('follow_up', 'Consultant begin to check requirement.');	
		$this->db->set('idpic', 4); /* FIXME */
		$this->db->insert('cerita');			
		
		// kontrak_flow_status
		$this->db->set('status', $param['status']);
		$this->db->set('idkontrak_flow', $status_project);
		$this->db->set('idpic', 1); /* FIXME */
		$this->db->insert('kontrak_flow_status');
		
		$this->db->set('status', $param['status']);
		$this->db->set('idkontrak_flow', $status_project);
		$this->db->set('idpic', 3); /* FIXME */
		$this->db->insert('kontrak_flow_status');

		$this->db->set('status', $param['status']);
		$this->db->set('idkontrak_flow', $status_project);
		$this->db->set('idpic', 4); /* FIXME */
		$this->db->insert('kontrak_flow_status');
	}	
	
	
	function set_problem_status($idstatusproject)
	{
		$this->db->set('status_akhir', 'done');
		$this->db->where('idstatusproject', $idstatusproject);
		$this->db->update('ref_status_project_profile');
	}

	function set_problem_status_kontrak($idstatuskontrak)
	{
		$this->db->set('status_akhir', 'done');
		$this->db->where('idstatuskontrak', $idstatuskontrak);
		$this->db->update('ref_status_kontrak');
	}	

	function set_proj_flow_status($idproj_flow)
	{
		$this->db->set('status', 'done');
		$this->db->where('idproj_flow', $idproj_flow);
		$this->db->where('idpic', $this->session->userdata('id_user'));
		$this->db->update('proj_flow_status');
	}

	function set_kontrak_flow_status($idkontrak_flow)
	{
		$this->db->set('status', 'done');
		$this->db->where('idkontrak_flow', $idkontrak_flow);
		$this->db->where('idpic', $this->session->userdata('id_user'));
		$this->db->update('kontrak_flow_status');
	}	
	
	function set_proj_flow_master_status($idproj_flow)
	{
		$this->db->set('status', 'done');
		$this->db->where('idproj_flow', $idproj_flow);
		$this->db->update('proj_flow');
	}	

	function set_kontrak_flow_master_status($idkontrak_flow)
	{
		$this->db->set('status', 'done');
		$this->db->where('idkontrak_flow', $idkontrak_flow);
		$this->db->update('kontrak_flow');
	}	

	function get_proj_flow_status($idproj_flow, $type)
	{
		$this->db->select('status');
		$this->db->from('proj_flow_status');
		switch($type)
		{
			case 'pas':
				$this->db->where('idpic', 1); /* FIXME */
			break;
				
			case 'tas':
				$this->db->where('idpic', 3); /* FIXME */
			break;
		}
		$this->db->where('idproj_flow', $idproj_flow);
		return $this->db->get()->row('status');
	}

	function get_kontrak_flow_status($idkontrak_flow, $type)
	{
		$this->db->select('status');
		$this->db->from('kontrak_flow_status');
		switch($type)
		{
			case 'pas':
				$this->db->where('idpic', 1); /* FIXME */
			break;
				
			case 'tas':
				$this->db->where('idpic', 3); /* FIXME */
			break;

			case 'konsultan':
				$this->db->where('idpic', 4); /* FIXME */
			break;			
		}
		$this->db->where('idkontrak_flow', $idkontrak_flow);
		return $this->db->get()->row('status');
	}	
	
	function check_proj_flow_status($idproj_flow)
	{
		$this->db->select('count(*) as cek');
		$this->db->from('proj_flow_status');
		$this->db->where('idproj_flow', $idproj_flow);
		$this->db->where('status', 'done');
		return $this->db->get()->row('cek');
	}

	function check_kontrak_flow($idproj_flow)
	{
		$this->db->select('count(*) as cek');
		$this->db->from('kontrak_flow');
		$this->db->where('idproj_flow', $idproj_flow);
		$this->db->where('status !=', 'done');
		return $this->db->get()->row('cek');
	}	

	function check_kontrak_flow_status($idkontrak_flow)
	{
		$this->db->select('count(*) as cek');
		$this->db->from('kontrak_flow_status');
		$this->db->where('idkontrak_flow', $idkontrak_flow);
		$this->db->where('status', 'done');
		return $this->db->get()->row('cek');
	}	
	
	function get_next_step($id_ref)
	{
		$this->db->from('ref_status');
		$this->db->where('idref_status', $id_ref);
		return $this->db->get();
	}

	function get_next_kontrak_step($id_ref)
	{
		$this->db->from('ref_kontrak');
		$this->db->where('idref_kontrak', $id_ref);
		return $this->db->get();
	}

	function get_next_step_id($id_ref)
	{
		$this->db->select('next_step');
		$this->db->from('ref_status');
		$this->db->where('idref_status', $id_ref);
		return $this->db->get()->row('next_step');
	}

	function get_next_kontrak_step_id($id_ref)
	{
		$this->db->select('next_step');
		$this->db->from('ref_kontrak');
		$this->db->where('idref_kontrak', $id_ref);
		return $this->db->get()->row('next_step');
	}		
	
	function is_kontrak($id_ref)
	{
		$this->db->select('kontrak_step');
		$this->db->from('ref_status');
		$this->db->where('idref_status', $id_ref);
		return $this->db->get()->row('kontrak_step');		
	}	
	
	/* ==============================
	/* Dokumen
	/* ============================== */	
	function get_dokumen($id_flow)
	{
		$this->db->from('jenis_dok');
		$this->db->join('pic', 'jenis_dok.idoperator=pic.idpic');
		$this->db->where('idstatus_project', $id_flow);
		return $this->db->get();
	}

	function get_dokumen_terkontrak($id_flow)
	{
		$this->db->from('jenis_dok');
		$this->db->join('pic', 'jenis_dok.idoperator=pic.idpic');
		$this->db->where('idkontrak_flow', $id_flow);
		return $this->db->get();
	}

	function input_dokumen($param)
	{
		$this->db->set('idstatus_project', $param['idproj_flow']);
		$this->db->set('idoperator', $param['idoperator']);
		$this->db->set('tgl_upload', $param['tgl_upload']);
		$this->db->set('nama_berkas', $param['nama_berkas']['file_name']);
		$this->db->insert('jenis_dok');
	}	

	function input_dokumen_kontrak($param)
	{
		$this->db->set('idkontrak_flow', $param['idkontrak_flow']);
		$this->db->set('idoperator', $param['idoperator']);
		$this->db->set('tgl_upload', $param['tgl_upload']);
		$this->db->set('nama_berkas', $param['nama_berkas']['file_name']);
		$this->db->insert('jenis_dok');
	}	

	/* ==============================
	/* Cerita
	/* ============================== */	
	function get_cerita($id_flow)
	{
		$this->db->from('ref_status_project_profile');
		$this->db->join('cerita', 'cerita.idproj_flow=ref_status_project_profile.idstatusproject');
		$this->db->join('pic', 'cerita.idpic=pic.idpic');
		$this->db->where('ref_status_project_profile.idref_status', $id_flow);
		$this->db->order_by('tgl_cerita');
		return $this->db->get();
	}	

	function get_cerita_terkontrak($id_flow)
	{
		$this->db->from('ref_status_kontrak');
		$this->db->join('cerita', 'cerita.idstatuskontrak=ref_status_kontrak.idstatuskontrak');
		$this->db->join('pic', 'cerita.idpic=pic.idpic');
		$this->db->where('ref_status_kontrak.idkontrak_flow', $id_flow);
		$this->db->order_by('tgl_cerita');
		return $this->db->get();
	}
	
	function input_cerita($param)
	{
		// insert ref_status_project_profile
		$this->db->set('idref_status', $param['idproj_flow']);
		$this->db->set('tgl_mulai', $param['tgl_mulai']);
		$this->db->set('tgl_akhir', $param['tgl_akhir']);
		$this->db->set('tgl_diisi', $param['tgl_diisi']);
		$this->db->set('idoperator', $param['idpic']);
		$this->db->set('status_akhir', 'pending'); /* FIXME */
		$this->db->insert('ref_status_project_profile');
		
		// insert cerita
		$status_project = $this->db->insert_id();
		$this->db->set('idproj_flow', $status_project);
		$this->db->set('idpic', $param['idpic']);
		$this->db->set('tgl_cerita', $param['tgl_cerita']);
		$this->db->set('deskripsi', $param['deskripsi']);
		$this->db->set('follow_up', $param['follow_up']);
		$this->db->insert('cerita');
	}

	function input_cerita_kontrak($param)
	{
		// insert ref_status_kontrak
		$this->db->set('idkontrak_flow', $param['idkontrak_flow']);
		$this->db->set('tgl_mulai', $param['tgl_mulai']);
		$this->db->set('tgl_akhir', $param['tgl_akhir']);
		$this->db->set('tgl_diisi', $param['tgl_diisi']);
		$this->db->set('idoperator', $param['idpic']);
		$this->db->set('status_akhir', 'pending'); /* FIXME */
		$this->db->insert('ref_status_kontrak');
		
		// insert cerita
		$status_project = $this->db->insert_id();
		$this->db->set('idstatuskontrak', $status_project);
		$this->db->set('idpic', $param['idpic']);
		$this->db->set('tgl_cerita', $param['tgl_cerita']);
		$this->db->set('deskripsi', $param['deskripsi']);
		$this->db->set('follow_up', $param['follow_up']);
		$this->db->insert('cerita');
	}	
	
	function update_followup($param)
	{
		$this->db->set('idpic', $param['idpic']);
		$this->db->set('follow_up', $param['follow_up']);
		$this->db->set('tgl_cerita', $param['tgl_cerita']);
		$this->db->where('idcerita', $param['idcerita']);
		$this->db->update('cerita');		
	}
	
	/* ==============================
	/* Kategori
	/* ============================== */	
	
	function get_kategori($id=NULL)
	{
		$this->db->from('kategori');
		
		if($id!=NULL) $this->db->where('idkategori', $id);
		return $this->db->get();
	}	
	
	function get_kategori_page()
	{
		$limit = 5;
		$offset = $this->uri->segment(3);
		$this->db->orderby('sectorCode', 'asc');
		$this->db->from('kategori');					
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_kategori_by_key($key)
	{
		$limit = 10;
		$offset = $this->uri->segment(3);
		$this->db->like('sectorName', $key);
		$this->db->or_like('subsectorname', $key);
		$this->db->orderby('sectorCode', 'asc');
		$this->db->from('kategori');					
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_jml_sektor()
	{
		return $this->db->count_all('kategori');
	}
	
	function get_jml_sektor_by_key($key)
	{
		$this->db->like('sectorName', $key);
		$this->db->or_like('subsectorname', $key);
		$this->db->from('kategori');
		return $this->db->count_all_results();
	}
	
	function modify_kategori($param)
	{
		$this->db->set('sectorCode', $param['sectorCode']);
		$this->db->set('sectorName', $param['sectorName']);
		$this->db->set('subsectorname', $param['subsectorname']);
		
		if(isset($param['idkategori'])) 
		{
			$this->db->where('idkategori', $param['idkategori']);
			$this->db->update('kategori');
		}
		else
		{
			$this->db->insert('kategori');
		}			
	}
	
	function add_kategori($param)
	{
		$this->db->set('idkategori','');
		$this->db->set('sectorCode', $param['sectorCode']);
		$this->db->set('sectorName', $param['sectorName']);
		$this->db->set('subsectorname', $param['subsectorname']);
		
		$this->db->insert('kategori');
	}
	
	function hapus_sektor($id)
	{
		$this->db->where('idkategori', $id);
		$this->db->delete('kategori');
	}
	
	function cek_kategori($code)
	{
		$this->db->where('sectorCode', $code);
		$query = $this->db->get('kategori');
		return $query->num_rows();
	}
	
	//end of kategori
	//---------------------------
	
	/* ==============================
	/* TAG atau DAFTAR RUAS
	/* ============================== */	
	
	function get_daftar_ruas($id=NULL)
	{
		$this->db->from('daftar_ruas');
		$this->db->orderby('tag', 'desc');
		
		if($id!=NULL) $this->db->where('iddaftar_ruas', $id);
		
		return $this->db->get();
	}	
	
	function get_daftar_ruas_page($key)
	{
		$this->db->like('label', $key);
		$this->db->or_like('tag', $key);
		$this->db->from('daftar_ruas');
		$limit = 15;
		$offset = $this->uri->segment(3);
					
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_jml_daftar_ruas($key)
	{
		$this->db->like('label', $key);
		$this->db->or_like('tag', $key);
		$this->db->from('daftar_ruas');
		return $this->db->count_all_results();
	}
	
	function modify_daftar_ruas($param)
	{
		$this->db->set('iddaftar_ruas', $param['iddaftar_ruas']);
		$this->db->set('tag', $param['tag']);
		$this->db->set('label', $param['label']);
		
		if(isset($param['iddaftar_ruas'])) 
		{
			$this->db->where('iddaftar_ruas', $param['iddaftar_ruas']);
			$this->db->update('daftar_ruas');
		}
		else
		{
			$this->db->insert('daftar_ruas');
		}			
	}
	
	function add_daftar_ruas($param)
	{
		$this->db->set('iddaftar_ruas','');
		$this->db->set('tag', $param['tag']);
		$this->db->set('label', $param['label']);
		
		$this->db->insert('daftar_ruas');
	}
	
	function hapus_daftar_ruas($id)
	{
		$this->db->where('iddaftar_ruas', $id);
		$this->db->delete('daftar_ruas');
	}
	
	function cek_tag($code)
	{
		$this->db->where('tag', $code);
		$query = $this->db->get('daftar_ruas');
		return $query->num_rows();
	}
	
	function get_latest_tag()
	{
		$this->db->select('tag');
		$this->db->orderby('tag', 'desc');
		$query = $this->db->get('daftar_ruas', 1);
		foreach($query->result() as $row)
			return $row->tag;
	}
	
	//end of tag
	//----------------------

	/* ==============================
	/* Tender
	/* ============================== */	
	
	function get_tender($id=NULL)//single data tender
	{
		$this->db->from('tender_data');
		
		if($id!=NULL) $this->db->where('idtender_data', $id);
		return $this->db->get();
	}	
	
	function get_tender_page($limit, $key)//with paging
	{
		$offset = $this->uri->segment(3);
		$this->db->like('deskripsi', $key);
		$this->db->from('tender_data');					
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_jml_tender($key)
	{
		$this->db->like('deskripsi', $key);
		$this->db->from('tender_data');
		return $this->db->count_all_results();
	}	
	
	function add_tender($param)
	{
		$this->db->set('idtender_data', '');
		$this->db->set('idproj', $param['idproj']);
		$this->db->set('deskripsi', $param['deskripsi']);
		$this->db->set('tgl_mulai', $param['tgl_mulai']);
		$this->db->set('tgl_selesai', $param['tgl_selesai']);
		$this->db->set('tipe_tender', $param['tipe_tender']);
		$this->db->set('penanggung_jawab', $param['penanggung_jawab']);
		$this->db->set('idproj_flow', $param['idproj_flow']);
		
		$this->db->insert('tender_data');			
	}
	
	function modify_tender($param)
	{
		$this->db->set('idproj', $param['idproj']);
		$this->db->set('deskripsi', $param['deskripsi']);
		$this->db->set('tgl_mulai', $param['tgl_mulai']);
		$this->db->set('tgl_selesai', $param['tgl_selesai']);
		$this->db->set('tipe_tender', $param['tipe_tender']);
		$this->db->set('penanggung_jawab', $param['penanggung_jawab']);
		$this->db->set('idproj_flow', $param['idproj_flow']);
		
		$this->db->where('idtender_data', $param['idtender_data']);
		$this->db->update('tender_data');		
	}
	
	function delete_tender($id)
	{
		$this->db->where('idtender_data', $id);
		$this->db->delete('tender_data');
	}
	
	function get_pinproj_for_tender($idproj)
	{
		$this->db->where('idproject_profile',$idproj);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
		{
			return $row->pin;
		}
	}
	
	function get_namaproj_for_tender($idproj)
	{
		$this->db->where('idproject_profile',$idproj);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
		{
			return $row->nama;
		}
	}
	
	function get_projflow_for_tender($idprojflow)
	{
		$this->db->where('idproject_profile',$idproj);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
		{
			return $row->nama;
		}
	}
	
	function get_user_by_id_for_tender($id)
	{
		$this->db->where('idpic', $id);
		$query = $this->db->get('pic');
		
		foreach($query->result() as $row)
		{
			return $row->nama;
		}
	}
	
	function get_proj_flow_latest_status($idproj)
	{
		$this->db->select('idproj_flow');
		$this->db->orderby('idref_status', 'desc');
		$this->db->where('idproject_profile', $idproj);
		$query = $this->db->get('proj_flow',1);
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row)
				return $row->idproj_flow;
		}
		else
			return "0";
		
	}
	
	/* ==============================
	/* Konsultan
	/* ============================== */	
	
	// here we go!!!
	
	function get_konsultan($id=NULL)//singel data
	{
		$this->db->from('perusahaan');
		
		if($id!=NULL) 
			$this->db->where('idperusahaan', $id);
		return $this->db->get();
	}	
	
	function get_konsultan_pic($id)
	{
		$this->db->where('idperusahaan', $id);
		$query = $this->db->get('pic');
		return $query->num_rows();
	}	
	
	function get_pic_consultant($id)
	{
		$this->db->where('idperusahaan', $id);
		$this->db->orderby('idpic', 'desc');
		return $this->db->get('pic');
	}
	
	function get_jml_perusahaan($key)
	{
		$this->db->like('nama',$key);
		$this->db->or_like('alamat',$key);
		$this->db->or_like('jenis',$key);
		$this->db->or_like('email',$key);
		$this->db->or_like('website',$key);
		$this->db->from('perusahaan');
		return $this->db->count_all_results();
	}
	
	function get_all_perusahaan($limit,$key)//with paging
	{
		if($key=='Active' || $key=='Actif' || $key=='Activ' || $key=='Aktif')
			$stat="1";
		else
			$stat="0";
			
		$offset = $this->uri->segment(3);
		$this->db->like('nama',$key);
		$this->db->or_like('alamat',$key);
		$this->db->or_like('jenis',$key);
		$this->db->or_like('email',$key);
		$this->db->or_like('website',$key);
		$this->db->or_like('status',$stat);
		$this->db->from('perusahaan');					
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function add_konsultan($param)
	{
		$this->db->set('idperusahaan','');
		$this->db->set('nama', $param['nama']);
		$this->db->set('jenis', $param['jenis']);
		$this->db->set('alamat', $param['alamat']);
		$this->db->set('telpon', $param['telpon']);
		$this->db->set('fax', $param['fax']);
		$this->db->set('hp', $param['hp']);
		$this->db->set('email', $param['email']);
		$this->db->set('website', $param['website']);
		$this->db->set('status', $param['status']);
		
		$this->db->insert('perusahaan');
	}
	
	function modify_konsultan($param)
	{
		$this->db->set('nama', $param['nama']);
		$this->db->set('jenis', $param['jenis']);
		$this->db->set('alamat', $param['alamat']);
		$this->db->set('telpon', $param['telpon']);
		$this->db->set('fax', $param['fax']);
		$this->db->set('hp', $param['hp']);
		$this->db->set('email', $param['email']);
		$this->db->set('website', $param['website']);
		$this->db->set('status', $param['status']);
		
		$this->db->where('idperusahaan', $param['idperusahaan']);
		$this->db->update('perusahaan');
	}
	
	function delete_konsultan($id)
	{
		$this->db->where('idperusahaan',$id);
		$this->db->delete('perusahaan');
	}
	
	function status_perusahaan($id,$param)
	{
		if($param==1)
			$this->db->set('status',0);
		else
			$this->db->set('status',1);
		
		$this->db->where('idperusahaan', $id);
		$this->db->update('perusahaan');		
	}
	
	function get_consultant_name($id)
	{
		if($id=='0')
			return "internal account";
		else
		{
			$this->db->where('idperusahaan', $id);
			$query = $this->db->get('perusahaan');
			foreach($query->result() as $row)
			{
				return $row->nama;				
			}
		}
	}
	
	function get_konsultan_properties($id, $param)
	{
		$this->db->where('idperusahaan', $id);
		$query = $this->db->get('perusahaan');
		foreach($query->result() as $row)
		{
			if($param=="email")
				return $row->email;
			else if($param=="phone")
				return $row->telpon;
			else if($param=="hp")
				return $row->hp;
			else if($param=="fax")
				return $row->fax;
			else if($param=="idperusahaan")
				return $row->idperusahaan;
			else
				return "";
		}
	}
	
	function get_pic_properties($id, $param)
	{
		$this->db->where('idperusahaan', $id);
		$query = $this->db->get('pic');
		foreach($query->result() as $row)
		{
			if($param=="email")
				return $row->email;
			else if($param=="phone")
				return $row->telpon;
			else if($param=="hp")
				return $row->hp;
			else if($param=="fax")
				return $row->fax;
			else
				return "";
		}
	}
	
	/* ==============================
	/* Kontraktor
	/* ============================== */	
	
	// here we go!!!

	function get_kontraktor_proyek($id_proj)
	{
		$this->db->select('kontraktor.tahapan, perusahaan.nama');
		$this->db->from('kontraktor');
		$this->db->join('perusahaan', 'perusahaan.idperusahaan=kontraktor.idperusahaan');
		$this->db->where('kontraktor.idproject_profile', $id_proj);
		$this->db->order_by('kontraktor.tgl_mulai','DESC');
		return $this->db->get();
	}
	
	function get_kontraktor($id=NULL)//singel data
	{
		$this->db->from('kontraktor');
		
		if($id!=NULL) $this->db->where('idkontraktor', $id);
		return $this->db->get();
	}	
	
	function get_jml_kontraktor($key)
	{	
		$this->db->from('kontraktor');					
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan');				
		$this->db->join('project_profile', 'kontraktor.idproject_profile = project_profile.idproject_profile');
		$this->db->like('perusahaan.nama', $key);	
		$this->db->or_like('project_profile.nama', $key);	
		$this->db->select('count(distinct kontraktor.idproject_profile) as jumlah');	
		//$this->db->from('kontraktor');
		return $this->db->get()->row('jumlah');
	}
	
	function get_all_kontraktor($limit,$key)//with paging
	{
		$offset = $this->uri->segment(3);		
		$this->db->select();
		$this->db->from('kontraktor');					
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan');				
		$this->db->join('project_profile', 'kontraktor.idproject_profile = project_profile.idproject_profile');
		$this->db->like('perusahaan.nama', $key);	
		$this->db->or_like('project_profile.nama', $key);	
		$this->db->group_by('kontraktor.idproject_profile');
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_group_kontraktor($idproj_prof)
	{
		$this->db->where('idproject_profile', $idproj_prof);
		$this->db->from('kontraktor');
		return $this->db->count_all_results();
	}
	
	function get_kontraktor_per_project($idproj_prof)
	{
		$this->db->where('idproject_profile', $idproj_prof);		
		//$this->db->group_by('idproject_profile');
		return $this->db->get('kontraktor');
	}
	
	function get_perusahaan_for_kontrak($idperusahaan)
	{
		$this->db->select('nama');
		$this->db->where('idperusahaan', $idperusahaan);
		$query = $this->db->get('perusahaan');
		foreach($query->result() as $row)
			return $row->nama;
	}
	
	function get_pinproject_for_kontrak($idproject_profile)
	{
		$this->db->select('pin');
		$this->db->where('idproject_profile', $idproject_profile);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
			return $row->pin;
	}
	
	function get_namaproject_for_kontrak($idproject_profile)
	{
		$this->db->select('nama');
		$this->db->where('idproject_profile', $idproject_profile);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
			return $row->nama;
	}
	
	function add_kontraktor($param)
	{
		$this->db->set('idkontraktor','');
		$this->db->set('idproject_profile', $param['idproject_profile']);
		$this->db->set('idperusahaan', $param['idperusahaan']);
		$this->db->set('tgl_mulai', $param['tgl_mulai']);
		$this->db->set('tgl_selesai', $param['tgl_selesai']);
		$this->db->set('tgl_disetujui', $param['tgl_disetujui']);
		$this->db->set('tahapan', $param['tahapan']);
		$this->db->set('anggaran_usd', $param['anggaran_usd']);
		$this->db->set('anggaran_idr', $param['anggaran_idr']);
		$this->db->set('anggaran_total_usd', $param['anggaran_total_usd']);
		$this->db->set('catatan', $param['catatan']);
		$this->db->set('pcss_no', $param['pcss_no']);
		$this->db->set('pcss_date', $param['pcss_date']);
		$this->db->set('no_kontrak', $param['no_kontrak']);
		
		$this->db->insert('kontraktor');
	}
	
	function modify_kontraktor($param)
	{
		$this->db->set('idproject_profile', $param['idproject_profile']);
		$this->db->set('idperusahaan', $param['idperusahaan']);
		$this->db->set('tgl_mulai', $param['tgl_mulai']);
		$this->db->set('tgl_selesai', $param['tgl_selesai']);
		$this->db->set('tgl_disetujui', $param['tgl_disetujui']);
		$this->db->set('tahapan', $param['tahapan']);
		$this->db->set('anggaran_usd', $param['anggaran_usd']);
		$this->db->set('anggaran_idr', $param['anggaran_idr']);
		$this->db->set('anggaran_total_usd', $param['anggaran_total_usd']);
		$this->db->set('catatan', $param['catatan']);
		$this->db->set('pcss_no', $param['pcss_no']);
		$this->db->set('pcss_date', $param['pcss_date']);
		$this->db->set('no_kontrak', $param['no_kontrak']);
		
		if(isset($param['idkontraktor'])) 
		{
			$this->db->where('idkontraktor', $param['idkontraktor']);
			$this->db->update('kontraktor');
		}
		else
		{
			$this->db->insert('kontraktor');
		}			
	}
	
	function delete_kontraktor($id)
	{
		$this->db->where('idkontraktor',$id);
		$this->db->delete('kontraktor');
	}

	/* ==============================
	/* Propinsi
	/* ============================== */	
	function get_propinsi()
	{
		$this->db->from('master_propinsi');
		return $this->db->get();
	}

	/* ==============================
	/* Siklus Proyek
	/* ============================== */
	function get_jml_siklus_proyek($key) //count siklus
	{
		$this->db->like('detil_status',$key);
		$this->db->or_like('kode_status',$key);
		$query = $this->db->count_all('ref_status');
        return $query;
	}
	
	function get_siklus_proyek_verbose($id=NULL) //get without paging
	{
		$this->db->from('ref_status');	
		$this->db->join('pic', 'ref_status.idpic=pic.idpic');
		if($id!=NULL) $this->db->where('idref_status', $id);
		return $this->db->get();
	}
	
	function get_siklus_proyek($key) //get with paging
	{
		$limit = 10;
		$offset = $this->uri->segment(3);
		
		$this->db->like('detil_status',$key);
		$this->db->or_like('kode_status',$key);
		$this->db->from('ref_status');	
		$this->db->order_by('status');
		$this->db->order_by('tahap');
		$this->db->order_by('id_detil');
		$this->db->join('pic', 'ref_status.idpic=pic.idpic');
			
		return $this->db->limit($limit, $offset)->get();
	}

	/* here we go!!! */
	function add_siklus($param)
	{
		$this->db->set('idref_status', '');
		$this->db->set('tahap', $param['tahap']);
		$this->db->set('status', $param['status']);
		$this->db->set('id_detil', $param['id_detil']);
		$this->db->set('detil_status', $param['detil_status']);
		$this->db->set('kode_status', $param['kode_status']);
		$this->db->set('formulir', $param['formulir']);
		$this->db->set('idpic', $param['idpic']);
		$this->db->set('kontrak_step', $param['kontrak_step']);
		$this->db->set('laporan_flag', $param['laporan_flag']);
		$this->db->set('next_step', $param['next_step']);
		
		$this->db->insert('ref_status');
	}
	
	function modify_siklus($param)
	{
		$this->db->set('tahap', $param['tahap']);
		$this->db->set('status', $param['status']);
		$this->db->set('id_detil', $param['id_detil']);
		$this->db->set('detil_status', $param['detil_status']);
		$this->db->set('kode_status', $param['kode_status']);
		$this->db->set('formulir', $param['formulir']);
		$this->db->set('idpic', $param['idpic']);
		$this->db->set('kontrak_step', $param['kontrak_step']);
		$this->db->set('laporan_flag', $param['laporan_flag']);
		$this->db->set('next_step', $param['next_step']);
		
		$this->db->where('idref_status', $param['idref_status']);
		$this->db->update('ref_status');
			
	}
	
	function hapus_siklus($id)
	{
		$this->db->where('idref_status', $id);
		$this->db->delete('ref_status');
	}
	
	function get_detail_siklus($id)
	{
		$this->db->from('ref_status');	
		$this->db->where('idref_status', $id);
		$query = $this->db->get();		
		return $query;
	}
	
	function count_tahap($tahap)
	{		
		$this->db->from('ref_status');
		$this->db->where('tahap', $tahap);
		$query = $this->db->count_all_results();
		return $query;
	}

	/* ==============================
	/* Dashboard
	/* ============================== */	
	
	function get_proyek_status_count($type)
	{
		$this->db->from('proj_flow');
		$this->db->join('project_profile', 'proj_flow.idproject_profile = project_profile.idproject_profile');
		$this->db->where('project_profile.pin like \'A%\'', null, false);
		$this->db->select('count(distinct(proj_flow.idproject_profile)) as jumlah');
		
		switch($type)
		{
			case 'sel_pro':
				$this->db->where('idref_status <=', 2);
				$this->db->where('status !=', 'done');
			break;
			
			case 'sel_app':
				$this->db->where('idref_status BETWEEN 3 and 4');
				$this->db->where('status !=', 'done');
			break;
			
			
			case 'ready_pfs':
				$this->db->where('idref_status BETWEEN 5 and 14');
				$this->db->where('status !=', 'done');
				$this->db->or_where('idref_status BETWEEN 49 and 58');
				$this->db->where('status !=', 'done');
			break;			
			
			case 'ready_trs':
				$this->db->where('idref_status BETWEEN 84 and 94');
				$this->db->where('status !=', 'done');
				$this->db->or_where('idref_status BETWEEN 129 and 139');	
				$this->db->where('status !=', 'done');
			break;

			case 'ready_inv':
				$this->db->where('idref_status', 176);
				$this->db->where('status !=', 'done');
			break;	

			case 'ong_pfs':
				$this->db->where('idref_status BETWEEN 15 and 45');
				$this->db->where('status !=', 'done');
				$this->db->or_where('idref_status BETWEEN 49 and 78');
				$this->db->where('status !=', 'done');
			break;			
			
			case 'ong_trs':
				$this->db->where('idref_status BETWEEN 95 and 125');
				$this->db->where('status !=', 'done');
				$this->db->or_where('idref_status BETWEEN 139 and 162');	
				$this->db->where('status !=', 'done');
			break;

			case 'ong_inv':
				$this->db->where('idref_status', 177);
				$this->db->where('status !=', 'done');
			break;						

			case 'contract_pfs':
				$this->db->where('idref_status BETWEEN 46 and 48');
				$this->db->where('status !=', 'done');
				$this->db->or_where('idref_status BETWEEN 79 and 83');
				$this->db->where('status !=', 'done');
			break;			
			
			case 'contract_trs':
				$this->db->where('idref_status BETWEEN 126 and 128');
				$this->db->where('status !=', 'done');
				$this->db->or_where('idref_status BETWEEN 140 and 175');	
				$this->db->where('status !=', 'done');
			break;

			case 'contract_inv':
				$this->db->where('idref_status', 177);
				$this->db->where('status !=', 'done');
			break;						
		}		
		
		return $this->db->get()->row('jumlah');
	}
	
	
	/* ==============================
	/* Keuangan
	/* ============================== */	
	function get_contract_step_count($id_proj)
	{
		$this->db->select('count(*) as jumlah');
		$this->db->from('kontrak_flow');
		$this->db->where('idproj_flow', $id_proj);
		
		return $this->db->get()->row('jumlah');
	}

	function get_payment_step_count($id, $opt)
	{
		switch($opt)
		{
			case 'project':	
				$this->db->select('count(*) as jumlah');
				$this->db->from('kontrak_flow');
				$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');	
				$this->db->where('idproj_flow', $id);				
			break;	
			
			case 'kontrak_step':
				$this->db->select('count(*) as jumlah');
				$this->db->from('termin_bayar');
				$this->db->join('kontrak_flow', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');	
				$this->db->where('kontrakflow_id', $id);						
			break;			
		}
		return $this->db->get()->row('jumlah');
	}	

	function get_contract_value_grand_total($id, $opt)
	{
		switch($opt)
		{
			case 'project':	
				$this->db->from('termin_bayar');
				$this->db->join('kontrak_flow', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
				$this->db->where('idproj_flow', $id);
			break;	
			
			case 'kontrak_step':		
				$this->db->from('termin_bayar');
				$this->db->join('kontrak_flow', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
				$this->db->where('kontrakflow_id', $id);
			break;
		}
	
		$this->db->select('nilai_dollar');
		$this->db->select('eq_idr_usd');
		$tmp = $this->db->get();
		$res = $tmp->row('nilai_dollar') + $tmp->row('eq_idr_usd');
		
		if(is_array($res)) return ""; /* FIXME */
		else return $res;	
	}	

	function get_contract_value_total($id, $opt, $type)
	{
		switch($opt)
		{
			case 'project':	
				$this->db->from('termin_bayar');
				$this->db->join('kontrak_flow', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
				$this->db->where('idproj_flow', $id);
			break;	
			
			case 'kontrak_step':		
				$this->db->from('termin_bayar');
				$this->db->join('kontrak_flow', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
				$this->db->where('kontrakflow_id', $id);
			break;
		}
		
		switch($type)
		{
			case 'rupiah':
				$this->db->select_sum('nilai_rupiah');
				return $this->db->get()->row('nilai_rupiah');
			break;	
			
			case 'dollar':	
				$this->db->select_sum('nilai_dollar');
				return $this->db->get()->row('nilai_dollar');					
			break;
		}
	}	

	function get_contract_value_paid($id, $opt, $type)
	{
		switch($opt)
		{
			case 'project':	
			
			break;	
			
			case 'kontrak_step':		
				$this->db->from('permohonan');
				$this->db->join('termin_bayar', 'permohonan.idtermin_bayar = termin_bayar.idtermin_bayar');
				$this->db->where('kontrakflow_id', $id);
				$this->db->where('disetujui', '1');
			break;
		}

		switch($type)
		{
			case 'rupiah':
				$this->db->select_sum('nilai_disetujui_rupiah');
				return $this->db->get()->row('nilai_disetujui_rupiah');
			break;	
			
			case 'dollar':	
				$this->db->select_sum('nilai_disetujui_dollar');
				return $this->db->get()->row('nilai_disetujui_dollar');					
			break;
		}		
	}	
	
	function get_total_disbursement($type)
	{
		$this->db->from('termin_bayar');
		switch($type)
		{
			case 'rupiah':
				$this->db->select_sum('nilai_rupiah');
				return $this->db->get()->row('nilai_rupiah');
			break;
			
			case 'dollar':
				$this->db->select_sum('nilai_dollar');
				return $this->db->get()->row('nilai_dollar');			
			break;
		}		
	}
	
	function get_termin_bayar($id_kontrak)
	{
		$this->db->select('*');
		$this->db->select('termin_bayar.idtermin_bayar as idtermin_bayar');
		$this->db->from('termin_bayar');
		$this->db->join('permohonan', 'permohonan.idtermin_bayar = termin_bayar.idtermin_bayar', 'LEFT');
		$this->db->where('kontrakflow_id', $id_kontrak);
		return $this->db->get();
	}
	
	function insert_termin_bayar($param)
	{
		$this->db->set('nilai_rupiah', $param['nilai_rupiah']);
		$this->db->set('nilai_dollar', $param['nilai_dollar']);
		$this->db->set('eq_idr_usd', $param['eq_idr_usd']);
		$this->db->set('kontrakflow_id', $param['idref_kontrak']);		
		$this->db->insert('termin_bayar');		
	}
	
	function get_payment_request($idtermin_bayar)
	{
		$this->db->from('permohonan');
		$this->db->join('jenis_dok', 'jenis_dok.idanggaran = permohonan.idpermohonan');
		$this->db->where('idtermin_bayar', $idtermin_bayar);
		return $this->db->get();
	}
	
	function input_payment_request($param)
	{
		// permohonan
		$this->db->set('idtermin_bayar', $param['idtermin_bayar']);
		$this->db->set('tgl_permohonan', $param['tgl_permohonan']);
		$this->db->set('nilai_permintaan_rupiah', $param['nilai_permintaan_rupiah']);
		$this->db->set('nilai_permintaan_dollar', $param['nilai_permintaan_dollar']);		
		$this->db->insert('permohonan');
				
		$idpermohonan = $this->db->insert_id();
	
		// dokumen
		$this->db->set('idanggaran', $idpermohonan);
		$this->db->set('idoperator', $param['idoperator']);
		$this->db->set('nama_berkas', $param['nama_berkas']['file_name']);
		$this->db->set('tgl_upload', date('Y-m-d'));
		$this->db->insert('jenis_dok');			
	}
	
	function confirm_payment_request($param)
	{
		$this->db->set('dibayarkan', $param['dibayarkan']);
		$this->db->set('tgl_dikirim', $param['tgL_dikirim']);
		$this->db->set('tgl_disetujui', $param['tgL_disetujui']);
		$this->db->set('dibayarkan', $param['dibayarkan']);
		$this->db->set('disetujui', $param['disetujui']);	
		$this->db->set('nilai_disetujui_rupiah', $param['nilai_disetujui_rupiah']);
		$this->db->set('nilai_disetujui_dollar', $param['nilai_disetujui_dollar']);
		$this->db->set('nilai_disetujui_eq_idr_usd', $param['nilai_disetujui_eq_idr_usd']);	
		$this->db->set('loan_adb_usd', $param['loan_adb_usd']);	
		$this->db->set('grant_gov_usd', $param['grant_gov_usd']);	
		$this->db->where('idpermohonan', $param['idpermohonan']);		
		$this->db->update('permohonan');		
	}
	
	
	/* =============================== */
	/* == Az - Laporan Tabel 01-04 	== */
	/* =============================== */

	/* Progress Report Of PDF - IRSDP Disbursement */
	function laporan_tabel_01a()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('period_diff(concat(year(kontraktor.tgl_selesai), substr(kontraktor.tgl_selesai, 6, 2 )), concat(year(kontraktor.tgl_mulai), substr(kontraktor.tgl_mulai, 6, 2))) AS total_bln', FALSE);
		$this->db->select('loan.catatan AS project_component');
		$this->db->select('loan.category1 AS category');
		$this->db->select('perusahaan.nama AS nama_kontraktor');
		$this->db->select('kontraktor.no_kontrak, kontraktor.tgl_disetujui, kontraktor.pcss_no, kontraktor.pcss_date');
		$this->db->select('kontraktor.anggaran_usd, kontraktor.anggaran_idr');
		$this->db->select('kontrak_flow.kegiatan, kontrak_flow.status AS kontrak_status');
		$this->db->select('loan.loan_grand, loan.loan, loan.grand');
		$this->db->select('project_profile.idproject_profile, project_profile.pin, project_profile.nama AS project_name');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');	
		$this->db->select('kontraktor.anggaran_total_usd');
		//$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		//$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		//$this->db->select_sum('permohonan.loan_adb_usd');
		//$this->db->select_sum('permohonan.grant_gov_usd');
		$this->db->from('project_profile');
		$this->db->join('kontraktor', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow', 'left');
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan', 'left');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		//$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->join('loan', 'SUBSTR(project_profile.pin, 1, 2) = loan.kategori', 'left');		
//		$this->db->group_by('category');
		$this->db->group_by('project_profile.pin, kontraktor.idperusahaan');
		$this->db->order_by('category', 'ASC');
		$this->db->order_by('idproject_profile', 'ASC');
		$this->db->where('kontraktor.idperusahaan IS NOT NULL'); /* FIXME */
		//$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */
		
		return $this->db->get();
	}
	
	function laporan_tabel_01b($id_proj)
	{
/* new query
SELECT SUM(permohonan.nilai_disetujui_rupiah) AS nilai_disetujui_rupiah, SUM(permohonan.nilai_disetujui_dollar) AS nilai_disetujui_dollar, SUM(permohonan.nilai_disetujui_eq_idr_usd) AS nilai_disetujui_eq_idr_usd, SUM(permohonan.loan_adb_usd) AS loan_adb_usd, SUM(permohonan.grant_gov_usd) AS grant_gov_usd, ref_kontrak.detil_status, tgl_permohonan, tgl_dikirim, permohonan.tgl_disetujui, dibayarkan FROM (kontraktor) JOIN project_profile ON kontraktor.idproject_profile=project_profile.idproject_profile JOIN proj_flow ON project_profile.idproject_profile = proj_flow.idproject_profile JOIN kontrak_flow ON kontraktor.idkontraktor=kontrak_flow.idkontraktor JOIN ref_kontrak ON ref_kontrak.idref_kontrak = kontrak_flow.idref_kontrak JOIN termin_bayar ON kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id JOIN permohonan ON termin_bayar.idtermin_bayar = permohonan.idtermin_bayar WHERE `project_profile`.`idproject_profile` = '62' AND `dibayarkan` != '0000-00-00' GROUP BY ref_kontrak.idref_kontrak
*/
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->select_sum('permohonan.loan_adb_usd');
		$this->db->select_sum('permohonan.grant_gov_usd');		
		$this->db->select('ref_kontrak.detil_status');
		$this->db->select('tgl_permohonan, tgl_dikirim, permohonan.tgl_disetujui, dibayarkan');
		$this->db->from('kontraktor');
		$this->db->join('project_profile', 'project_profile.idproject_profile = kontraktor.idproject_profile');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile');
		$this->db->join('kontrak_flow', 'kontraktor.idkontraktor = kontrak_flow.idkontraktor');
		$this->db->join('ref_kontrak', 'ref_kontrak.idref_kontrak = kontrak_flow.idref_kontrak');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar');	
		$this->db->group_by('ref_kontrak.idref_kontrak');
		$this->db->where('project_profile.idproject_profile', $id_proj);
		$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */

/* old query
SELECT SUM(permohonan.nilai_disetujui_rupiah) AS nilai_disetujui_rupiah, SUM(permohonan.nilai_disetujui_dollar) AS nilai_disetujui_dollar, SUM(permohonan.nilai_disetujui_eq_idr_usd) AS nilai_disetujui_eq_idr_usd, SUM(permohonan.loan_adb_usd) AS loan_adb_usd, SUM(permohonan.grant_gov_usd) AS grant_gov_usd, ref_kontrak.detil_status, tgl_permohonan, tgl_dikirim, tgl_disetujui, dibayarkan FROM (project_profile) JOIN proj_flow ON project_profile.idproject_profile = proj_flow.idproject_profile JOIN kontrak_flow ON proj_flow.idproj_flow = kontrak_flow.idproj_flow JOIN ref_kontrak ON ref_kontrak.idref_kontrak = kontrak_flow.idref_kontrak JOIN termin_bayar ON kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id JOIN permohonan ON termin_bayar.idtermin_bayar = permohonan.idtermin_bayar WHERE `project_profile`.`idproject_profile` = '1' AND `xdibayarkan` != '0000-00-00' GROUP BY ref_kontrak.idref_kontrak
*/

/*		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->select_sum('permohonan.loan_adb_usd');
		$this->db->select_sum('permohonan.grant_gov_usd');		
		$this->db->select('ref_kontrak.detil_status');
		$this->db->select('tgl_permohonan, tgl_dikirim, tgl_disetujui, dibayarkan');
		$this->db->from('project_profile');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow');
		$this->db->join('ref_kontrak', 'ref_kontrak.idref_kontrak = kontrak_flow.idref_kontrak');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar');	
		$this->db->group_by('ref_kontrak.idref_kontrak');
		$this->db->where('project_profile.idproject_profile', $id_proj);
		$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */

		return $this->db->get();
	}
	
	/* IRSDP Fund Disburstment Progress Status per Contract - for multiple personal consultant */
	function laporan_tabel_02a()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('project_profile.idproject_profile, project_profile.pin, project_profile.nama AS project_name');
		$this->db->select('kontraktor.idkontraktor');
		$this->db->from('kontraktor');
		$this->db->join('project_profile', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'kontraktor.idkontraktor = kontrak_flow.idkontraktor');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->group_by('kontraktor.idproject_profile');
		$this->db->group_by(array('short_pin, project_profile.pin, project_profile.nama'));
		$this->db->order_by('project_profile.pin', 'ASC');
		$this->db->order_by('project_profile.nama', 'ASC');
		return $this->db->get();
	}

	function laporan_tabel_02b($id_proj)
	{
		$this->db->select('perusahaan.nama');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->from('kontraktor');
		$this->db->join('project_profile', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'kontraktor.idkontraktor = kontrak_flow.idkontraktor');
		$this->db->join('perusahaan', 'perusahaan.idperusahaan = kontraktor.idperusahaan');	
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->group_by('kontraktor.idkontraktor');
		$this->db->where('kontraktor.idproject_profile', $id_proj);
		return $this->db->get();
	}

	/* IRSDP Fund Disburstment Progress Status per Contract */
	function laporan_tabel_02()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('project_profile.pin, project_profile.nama AS project_name');
		$this->db->select('perusahaan.nama AS consultan_firm, kontraktor.tahapan, proj_flow.status AS proj_status');
		$this->db->select('kontrak_flow.kegiatan, kontrak_flow.status AS kontrak_status');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->from('project_profile');
		$this->db->join('kontraktor', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow', 'left');
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan', 'left');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->group_by(array('short_pin, project_profile.pin, project_profile.nama'));
		$this->db->order_by('project_profile.pin', 'ASC');
		$this->db->order_by('project_profile.nama', 'ASC');
		$this->db->order_by('permohonan.tgl_permohonan', 'DESC');
		$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */
		
		return $this->db->get();
	}
	
	/* Recapitulation of Disbursment Progress of IRSDP per Fund Source */
	function laporan_tabel_03()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('loan.catatan AS project_component');
		$this->db->select('loan.category1 AS category');
		$this->db->select('kontrak_flow.kegiatan, kontrak_flow.status AS kontrak_status');
		$this->db->select('loan.loan_grand, loan.loan, loan.grand');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');	
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.loan_adb_usd');
		$this->db->select_sum('permohonan.grant_gov_usd');
		$this->db->from('project_profile');
		$this->db->join('kontraktor', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow', 'left');
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan', 'left');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->join('loan', 'SUBSTR(project_profile.pin, 1, 2) = loan.kategori', 'left');		
		$this->db->group_by('category');
		$this->db->order_by('category', 'ASC');
		$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */
		//$this->db->where('kategori', );
		
		return $this->db->get();
	}
	
	/* Status of Realization DIPA IRSDP */
	function laporan_tabel_04()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('loan.catatan AS project_component');
		$this->db->select('loan.category1 AS category');
		$this->db->select('kontrak_flow.kegiatan, kontrak_flow.status AS kontrak_status');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');	
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->from('project_profile');
		$this->db->join('kontraktor', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow', 'left');
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan', 'left');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->join('loan', 'SUBSTR(project_profile.pin, 1, 2) = loan.kategori', 'left');		
		$this->db->group_by('category');
		$this->db->order_by('category', 'ASC');
		$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */
		
		return $this->db->get();		
	}
	
	/* Contract Financial List -- seperti DIPA, tapi berdasarkan list kontrak bukan proyek */
	function laporan_tabel_05a()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('period_diff(concat(year(kontraktor.tgl_selesai), substr(kontraktor.tgl_selesai, 6, 2 )), concat(year(kontraktor.tgl_mulai), substr(kontraktor.tgl_mulai, 6, 2))) AS total_bln', FALSE);
		$this->db->select('loan.catatan AS project_component');
		$this->db->select('loan.category1 AS category');
		$this->db->select('perusahaan.nama AS nama_kontraktor');
		$this->db->select('kontraktor.no_kontrak, kontraktor.tgl_disetujui, kontraktor.pcss_no, kontraktor.pcss_date');
		$this->db->select('kontraktor.anggaran_usd, kontraktor.anggaran_idr');
		$this->db->select('kontrak_flow.kegiatan, kontrak_flow.status AS kontrak_status');
		$this->db->select('loan.loan_grand, loan.loan, loan.grand');
		$this->db->select('project_profile.idproject_profile, project_profile.pin, project_profile.nama AS project_name');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');	
		$this->db->select('kontraktor.anggaran_total_usd');
		//$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		//$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		//$this->db->select_sum('permohonan.loan_adb_usd');
		//$this->db->select_sum('permohonan.grant_gov_usd');
		$this->db->from('project_profile');
		$this->db->join('kontraktor', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow', 'left');
		$this->db->join('kontrak_flow AS kf', 'kf.idkontraktor = kontraktor.idkontraktor', 'left');
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan', 'left');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		//$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->join('loan', 'SUBSTR(project_profile.pin, 1, 2) = loan.kategori', 'left');		
		$this->db->group_by('category', 'project_profile.pin');
		$this->db->order_by('category', 'ASC');
		//$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */
		
		return $this->db->get();
	}
	
	function laporan_tabel_05b($id_proj)
	{
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->select_sum('permohonan.loan_adb_usd');
		$this->db->select_sum('permohonan.grant_gov_usd');		
		$this->db->select('ref_kontrak.detil_status');
		$this->db->select('tgl_permohonan, tgl_dikirim, tgl_disetujui, dibayarkan');
		$this->db->from('project_profile');
		$this->db->join('proj_flow', 'project_profile.idproject_profile = proj_flow.idproject_profile');
		$this->db->join('kontrak_flow', 'proj_flow.idproj_flow = kontrak_flow.idproj_flow');
		$this->db->join('ref_kontrak', 'ref_kontrak.idref_kontrak = kontrak_flow.idref_kontrak');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar');	
		$this->db->group_by('ref_kontrak.idref_kontrak');
		$this->db->where('project_profile.idproject_profile', $id_proj);
		$this->db->where('dibayarkan !=', '0000-00-00'); /* FIXME */
		return $this->db->get();	
	}
	
	/* IRSDP Fund Disburstment Progress Status per Contract - for multiple personal consultant */
	function laporan_tabel_09a()
	{
		$this->db->select('SUBSTR(project_profile.pin, 1, 2) AS short_pin', FALSE);
		$this->db->select('project_profile.idproject_profile, project_profile.pin, project_profile.nama AS project_name');
		$this->db->select('loan.catatan AS project_component');
		$this->db->select('loan.category1 AS category');
		$this->db->select('kontraktor.idkontraktor');
		$this->db->select('period_diff(concat(year(kontraktor.tgl_selesai), substr(kontraktor.tgl_selesai, 6, 2 )), concat(year(kontraktor.tgl_mulai), substr(kontraktor.tgl_mulai, 6, 2))) AS total_bln', FALSE);
		$this->db->select('perusahaan.nama AS nama_kontraktor');
		$this->db->select('kontraktor.no_kontrak, kontraktor.tgl_disetujui, kontraktor.pcss_no, kontraktor.pcss_date');
		$this->db->select('kontraktor.anggaran_usd, kontraktor.anggaran_idr');
		$this->db->select('kontrak_flow.kegiatan, kontrak_flow.status AS kontrak_status');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');	
		$this->db->select('kontraktor.anggaran_total_usd');
		$this->db->from('kontraktor');
		$this->db->join('project_profile', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'kontraktor.idkontraktor = kontrak_flow.idkontraktor');
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('perusahaan', 'kontraktor.idperusahaan = perusahaan.idperusahaan', 'left');
		$this->db->join('loan', 'SUBSTR(project_profile.pin, 1, 2) = loan.kategori', 'left');	
		$this->db->group_by('kontraktor.idkontraktor');
		$this->db->group_by(array('short_pin, project_profile.pin, project_profile.nama'));
		$this->db->order_by('project_profile.pin', 'ASC');
		$this->db->order_by('project_profile.nama', 'ASC');
		return $this->db->get();
	}

	function laporan_tabel_09b($id_proj,$id_konsultan)
	{
		$this->db->select_sum('permohonan.nilai_disetujui_rupiah');
		$this->db->select_sum('permohonan.nilai_disetujui_dollar');
		$this->db->select_sum('permohonan.nilai_disetujui_eq_idr_usd');
		$this->db->select_sum('permohonan.loan_adb_usd');
		$this->db->select_sum('permohonan.grant_gov_usd');		
		$this->db->select('ref_kontrak.detil_status');
		$this->db->select('tgl_permohonan, tgl_dikirim, permohonan.tgl_disetujui, dibayarkan');
		$this->db->select('perusahaan.nama');
		$this->db->select_sum('termin_bayar.nilai_rupiah');
		$this->db->select_sum('termin_bayar.nilai_dollar');
		$this->db->select_sum('termin_bayar.eq_idr_usd');
		$this->db->from('kontraktor');
		$this->db->join('project_profile', 'project_profile.idproject_profile = kontraktor.idproject_profile', 'left');
		$this->db->join('kontrak_flow', 'kontraktor.idkontraktor = kontrak_flow.idkontraktor', 'left');
		$this->db->join('ref_kontrak', 'ref_kontrak.idref_kontrak = kontrak_flow.idref_kontrak', 'left');
		$this->db->join('perusahaan', 'perusahaan.idperusahaan = kontraktor.idperusahaan', 'left');	
		$this->db->join('termin_bayar', 'kontrak_flow.idkontrak_flow = termin_bayar.kontrakflow_id', 'left');
		$this->db->join('permohonan', 'termin_bayar.idtermin_bayar = permohonan.idtermin_bayar', 'left');
		$this->db->group_by('kontrak_flow.idkontrak_flow');
		$this->db->where('kontraktor.idproject_profile', $id_proj);
		$this->db->where('kontrak_flow.idkontraktor', $id_konsultan);
		$this->db->where('dibayarkan !=', '0000-00-00');
		return $this->db->get();
	}

	/* NEW REPORT -- ADB REPORT */
	function laporan_adb_pac()//unused
	{
		/*return $this->db->query('SELECT l.idlap_monitor, l.idref_status, l.hari_kerja, l.tgl_batas, l.hari_kalender, rspp.tgl_mulai, rspp.tgl_akhir,
					datediff(rspp.tgl_akhir, l.tgl_batas) as \'Days\', sum(datediff(rspp.tgl_akhir, l.tgl_batas)) as \'Cummulative\', r.detil_status
					FROM cerita AS c
					LEFT JOIN ref_status_project_profile AS rspp ON c.idproj_flow = rspp.idstatusproject
					LEFT JOIN proj_flow_status AS pfs ON pfs.idproj_flow = rspp.idref_status
					LEFT JOIN proj_flow AS pf ON pf.idproj_flow = pfs.idproj_flow
					LEFT JOIN lap_monitor AS l ON l.idproject_profile = pf.idproject_profile
					LEFT JOIN ref_status AS r ON l.idref_status = r.idref_status');
		
		$this->db->group_by('lap_monitor.idlap_monitor');
		$this->db->where('ref_status_project_profile.idproject_profile', 'proj_flow.idproject_profile ');
		$this->db->where('ref_status_project_profile.idref_status', 'proj_flow.idproj_flow');
		$this->db->where('proj_flow.idref_status','lap_monitor.idref_status');*/
		
		$this->db->from('cerita');
		$this->db->select('lap_monitor.idlap_monitor');
		$this->db->select('lap_monitor.idref_status');
		$this->db->select('lap_monitor.hari_kerja');
		$this->db->select('lap_monitor.hari_kalender');
		$this->db->select('ref_status_project_profile.tgl_mulai');
		$this->db->select('ref_status_project_profile.tgl_akhir');
		$this->db->select('datediff(ref_status_project_profile.tgl_akhir, lap_monitor.tgl_batas) as Days', FALSE);
		$this->db->select('datediff(ref_status_project_profile.tgl_akhir, lap_monitor.tgl_batas) as Cummulative', FALSE);
		$this->db->select('ref_status.detil_status');
		
		$this->db->join('ref_status_project_profile', 'cerita.idproj_flow = ref_status_project_profile.idstatusproject', 'left');
		$this->db->join('proj_flow_status', 'proj_flow_status.idproj_flow = ref_status_project_profile.idref_status', 'left');
		$this->db->join('proj_flow', 'proj_flow.idproj_flow = proj_flow_status.idproj_flow', 'left');
		$this->db->join('lap_monitor', 'lap_monitor.idproject_profile = proj_flow.idproject_profile', 'left');
		$this->db->join('ref_status', 'lap_monitor.idref_status = ref_status.idref_status', 'left');
		
		//return $this->db->count_all_results();
		return $this->db->get();
	}
	
	function get_jml_proyek_adb($key)
	{
		$this->db->like('nama', $key);
		//$this->db->or_like('pin', $key);
		$this->db->or_like('lokasi', $key);
		$this->db->where('SUBSTR(pin,1,1) = \'A\'', null, false);
		$this->db->from('project_profile');
		return $this->db->count_all_results();
	}
	
	function get_all_proyek_adb_default($limit,$key)//with paging
	{
		$offset = $this->uri->segment(3);
		$this->db->like('nama', $key);
		//$this->db->or_like('pin', $key);
		$this->db->or_like('lokasi', $key);			
		$this->db->where('SUBSTR(pin,1,1) = \'A\'', null, false);
		$this->db->from('project_profile');				
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_all_proyek_adb($limit,$key,$modesort)//with paging
	{
		$offset = $this->uri->segment(4);
		$this->db->like('nama', $key);
		//$this->db->like('pin', $key);
		$this->db->like('lokasi', $key);
		$this->db->where('SUBSTR(pin,1,1) = \'A\'', null, false);
		$this->db->from('project_profile');				
		
		if($modesort=='pin_asc')
			$this->db->order_by('pin', 'asc');
		else if($modesort=='pin_desc')
			$this->db->order_by('pin', 'desc');
		else if($modesort=='sector_asc')
			$this->db->order_by('id_kategori', 'asc');
		else if($modesort=='sector_desc')
			$this->db->order_by('id_kategori', 'desc');
		else if($modesort=='proj_asc')
			$this->db->order_by('nama', 'asc');
		else if($modesort=='proj_desc')
			$this->db->order_by('nama', 'desc');
		else if($modesort=='location_asc')
			$this->db->order_by('lokasi', 'asc');
		else if($modesort=='location_desc')
			$this->db->order_by('lokasi', 'desc');
		else if($modesort=='status_asc')
			$this->db->order_by('last_idref_status', 'asc');
		else if($modesort=='status_desc')
			$this->db->order_by('last_idref_status', 'desc');
		else if($modesort=='id_asc')
			$this->db->order_by('idproject_profile', 'asc');
		else if($modesort=='id_desc')
			$this->db->order_by('idproject_profile', 'desc');
		else			
			$this->db->order_by('idproject_profile', 'asc');
		
		return $this->db->limit($limit, $offset)->get();
	}	
	
	function get_budget($id, $param)
	{
		$this->db->where('idproject_profile', $id);			
		$query = $this->db->get('kontraktor');
		if($query->num_rows() >0)
		{
			foreach($query->result() as $row);		
			{
				if($param==1)
					return $row->anggaran_usd;
				else if($param==2)
					return $row->anggaran_idr;
				else if($param==3)
					return $row->anggaran_total_usd;
				else
					return "-";
			}
		}
		else
			return "-";
	}
	
	function get_proyek_adb($id)//ambil properti proyek
	{
		$this->db->where('idproject_profile', $id);
		return $this->db->get('project_profile');
	}
	
	function pejabat_adb($id)
	{
		$this->db->where('proyek_id', $id);
		$query = $this->db->get('isian_ruas');
		
		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}
	
	function pejabat_adb_tag($id, $tag)//print nama pejabat di isian_ruas
	{
		$this->db->where('tag',$tag);
		$this->db->where('proyek_id', $id);
		$query = $this->db->get('isian_ruas');
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
				return $row->value;
		}
		else
			return "-";
	}
	
	function cek_tipe_proyek($id) //solicite==Full, unsolicite==Partial
	{
		$this->db->where('idproject_profile', $id);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
			return $row->tipe_proyek;
	}
	
	function cek_status_proyek($id)//QCBS or CBS
	{
		$this->db->where('idproject_profile', $id);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
		{
			$this->db->where('idref_status',$row->last_idref_status);
			$query2 = $this->db->get('ref_status');
			foreach($query2->result() as $row2)
				return $row2->kode_status;
		}
	}
	
	function adb_report_all($id, $modesort)//get semua lap_mon dari proyek
	{
		$this->db->where('idproject_profile', $id);
		$this->db->where('view',2);
		
		if($modesort=='1_asc')
			$this->db->order_by('idlap_monitor', 'asc');
		else if($modesort=='1_desc')
			$this->db->order_by('idlap_monitor', 'desc');
		else if($modesort=='2_asc')
			$this->db->order_by('hari_kerja', 'asc');
		else if($modesort=='2_desc')
			$this->db->order_by('hari_kerja', 'desc');
		else if($modesort=='3_asc')
			$this->db->order_by('tgl_batas', 'asc');
		else if($modesort=='3_desc')
			$this->db->order_by('tgl_batas', 'desc');
		else if($modesort=='4_asc')
			$this->db->order_by('hari_kalender', 'asc');
		else if($modesort=='4_desc')
			$this->db->order_by('hari_kalender', 'desc');
		else
			$this->db->order_by('idlap_monitor', 'desc');
			
		return $this->db->get('lap_monitor');
	}
	
	function adb_report_pac($id,  $modesort)//get semua lap_mon  PAC (idref_status 5-85) dari proyek
	{
		$this->db->where('idproject_profile', $id);
		$this->db->where('idref_status >=', '5');
		$this->db->where('idref_status <=', '85');
		
		if($modesort=='1_asc')
			$this->db->order_by('idlap_monitor', 'asc');
		else if($modesort=='1_desc')
			$this->db->order_by('idlap_monitor', 'desc');
		else if($modesort=='2_asc')
			$this->db->order_by('hari_kerja', 'asc');
		else if($modesort=='2_desc')
			$this->db->order_by('hari_kerja', 'desc');
		else if($modesort=='3_asc')
			$this->db->order_by('tgl_batas', 'asc');
		else if($modesort=='3_desc')
			$this->db->order_by('tgl_batas', 'desc');
		else if($modesort=='4_asc')
			$this->db->order_by('hari_kalender', 'asc');
		else if($modesort=='4_desc')
			$this->db->order_by('hari_kalender', 'desc');
		else
			$this->db->order_by('idlap_monitor', 'desc');
		
		return $this->db->get('lap_monitor');
	}
	
	function adb_report_tac($id, $modesort)//get semua lap_mon  TAC (idref_status 86-180) dari proyek
	{
		$this->db->where('idproject_profile', $id);
		$this->db->where('idref_status >=', '86');
		$this->db->where('idref_status <=', '180');
		
		if($modesort=='1_asc')
			$this->db->order_by('idlap_monitor', 'asc');
		else if($modesort=='1_desc')
			$this->db->order_by('idlap_monitor', 'desc');
		else if($modesort=='2_asc')
			$this->db->order_by('hari_kerja', 'asc');
		else if($modesort=='2_desc')
			$this->db->order_by('hari_kerja', 'desc');
		else if($modesort=='3_asc')
			$this->db->order_by('tgl_batas', 'asc');
		else if($modesort=='3_desc')
			$this->db->order_by('tgl_batas', 'desc');
		else if($modesort=='4_asc')
			$this->db->order_by('hari_kalender', 'asc');
		else if($modesort=='4_desc')
			$this->db->order_by('hari_kalender', 'desc');
		else
			$this->db->order_by('idlap_monitor', 'desc');
		
		return $this->db->get('lap_monitor');
	}
	
	function get_status_adb($id)///ambil ref_status dari lap_mon
	{
		$this->db->where('idref_status', $id);
		$query = $this->db->get('ref_status');
		foreach($query->result() as $row)
			return $row->detil_status;
	}
	
	function get_kodestatus_adb($id)///ambil ref_status dari lap_mon
	{
		$this->db->where('idref_status', $id);
		$query = $this->db->get('ref_status');
		foreach($query->result() as $row)
			return $row->kode_status;
	}
	
	function get_achive_date($idproject_profile, $idref_status)
	/*
	SELECT DISTINCT ref_status_project_profile.*
	FROM ref_status_project_profile
	LEFT JOIN proj_flow ON proj_flow.idproj_flow = ref_status_project_profile.idref_status
	LEFT JOIN ref_status ON ref_status.idref_status = proj_flow.idref_status
	LEFT JOIN lap_monitor ON lap_monitor.idref_status = ref_status.idref_status
	WHERE proj_flow.idref_status = 
	AND ref_status_project_profile.status_akhir='done'
	AND proj_flow.idproject_profile =

	SELECT `ref_status_project_profile`.* 
	FROM (`ref_status_project_profile`) 
	LEFT JOIN `proj_flow` ON `proj_flow`.`idproj_flow` = `ref_status_project_profile`.`idref_status`
	LEFT JOIN `ref_status` ON `ref_status`.`idref_status` = `proj_flow`.`idref_status`
	LEFT JOIN `lap_monitor` ON `lap_monitor`.`idref_status` = `ref_status`.`idref_status`
	WHERE `proj_flow`.`idref_status` = '82'
	AND `ref_status_project_profile`.`status_akhir` = 'done'
	AND `proj_flow`.`idproject_profile` = '2'
	ORDER BY `ref_status_project_profile`.`tgl_akhir` desc
	LIMIT 1
	*/

	{
		$this->db->from('ref_status_project_profile');
		$this->db->join('proj_flow','proj_flow.idproj_flow = ref_status_project_profile.idref_status','left');
		$this->db->join('ref_status','ref_status.idref_status = proj_flow.idref_status','left');
		$this->db->join('lap_monitor', 'lap_monitor.idref_status = ref_status.idref_status','left');
		$this->db->where('proj_flow.idref_status', $idref_status);
		$this->db->where('ref_status_project_profile.status_akhir', 'done');
		$this->db->where('proj_flow.idproject_profile', $idproject_profile);
		//$this->db->orderby('idstatusproject', 'desc');
		$this->db->orderby('ref_status_project_profile.tgl_akhir', 'desc');
		//$query = $this->db->get('ref_status_project_profile',1);
		$this->db->select('ref_status_project_profile.*', 'DISTINCT');
		$query = $this->db->limit(1,0)->get();
		foreach($query->result() as $row)
			return $row->tgl_akhir;
	}
	
	
	/*---------*/
	/* model for ref_status_tahapan, ref_status_proyek, ref_status */
	/*---------*/
	
	/* ref_status_tahapan */	
	function get_nama_tahapan($id)
	{
		$this->db->select('nama_tahapan');
		$this->db->from('ref_status_tahapan');
		$this->db->where('id_tahapan', $id);
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row)
			{
				return $row->nama_tahapan;
			}
		}
		else
			return "not registered yet";
	}
	
	/* ref_status_proyek */	
	function get_nama_status($id)
	{
		$this->db->select('nama_status');
		$this->db->from('ref_status_proyek');
		$this->db->where('id_status', $id);
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row)
			{
				return $row->nama_status;
			}
		}
		else
			return "<i>not registered yet</i>";
	}
	
	
	/* ref_status */
	function get_latest_lap_flag()
	{
		$this->db->select('laporan_flag',1);
		$this->db->from('ref_status');
		$this->db->orderby('laporan_flag', 'desc');
		$query = $this->db->get();
		
		foreach($query->result() as $row)
		{
			return $row->laporan_flag;
		}
	}
	
	function count_distinct($param)
	{
		if($param==1)//tahap
		{
			$run = 'SELECT COUNT(DISTINCT tahap) AS jml FROM ref_status';
			$query = $this->db->query($run);
			foreach($query->result() as $row)
				return $row->jml;
		}
		else if($param==2)//status
		{
			$run = 'SELECT COUNT(DISTINCT status) AS jml FROM ref_status';
			$query = $this->db->query($run);
			foreach($query->result() as $row)
				return $row->jml;
		}
		else if($param==3)//step
		{
			$query = $this->db->count_all('ref_status');
			return $query;
		}
		else//laporan_flag
		{
			$this->db->from('ref_status');
			$this->db->where('laporan_flag >', 0);			
			$query = $this->db->count_all_results();
			return $query;
		}			
	}
	
	function cek_kode($kode)
	{
		$this->db->select();
		$this->db->where('kode_status', $kode);
		$query = $this->db->get('ref_status');
		return $query->num_rows();
	}
	
	/* ==============================
	/* User
	/* ============================== */	
	function get_user()
	{
		$this->db->from('pic');
		return $this->db->get();
	}
	
	/* ---------- */
	/* model for user management */
	/* ---------- */
	
	function get_jml_user($key)
	{
		$this->db->like('nama', $key);
		$this->db->from('pic');
		return $this->db->count_all_results();
	}
	
	function get_all_user($limit, $key)
	{
		$this->db->like('nama', $key);
		$this->db->order_by('nama', 'desc'); 
		return $this->db->get('pic',$limit, $this->uri->segment(3));
	}
	
	function get_user_by_id($id)
	{
		
		$this->db->from('pic');
		$this->db->where('idpic', $id);
		$query = $this->db->get();
		return $query;
	}
	
	function get_group_name($id)
	{
		$this->db->select('group'); 
		$this->db->from('group');
		$this->db->where('idgroup',$id);
        $query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row)
			{
				return $row->group;
			}
		}
		else
			return "<i>not registered yet</i>";
	}
	
	function cek_user($username)
	{
		$this->db->select();
		$this->db->where('nama', $username);
		$query = $this->db->get('pic');
		return $query->num_rows();
	}
	
	function add_user($param)
	{
		$this->db->set('idpic', '');
		$this->db->set('nama', $param['nama']);
		$this->db->set('group', $param['group']);
		$this->db->set('password', $param['password']);
		$this->db->set('email', $param['email']);
		$this->db->set('phone', $param['phone']);
		$this->db->set('hp', $param['hp']);
		$this->db->set('fax', $param['fax']);
		$this->db->set('idperusahaan', $param['idperusahaan']);
		
		$this->db->insert('pic');
	}
	
	function add_user_account($param)//for consultants
	{
		$this->db->set('idpic', '');
		$this->db->set('nama', $param['nama']);
		$this->db->set('group', $param['group']);
		$this->db->set('password', $param['password']);
		$this->db->set('email', $param['email']);
		$this->db->set('phone', $param['phone']);
		$this->db->set('hp', $param['hp']);
		$this->db->set('fax', $param['fax']);
		$this->db->set('idperusahaan', $param['idperusahaan']);
		
		$this->db->insert('pic');
		
		//update status perusahaan
		$this->db->set('status',1);
		$this->db->where('idperusahaan', $param['idperusahaan']);
		$this->db->update('perusahaan');
	}
	
	function edit_user($param)
	{
		$this->db->set('nama', $param['nama']);
		$this->db->set('group', $param['group']);
		$this->db->set('email', $param['email']);
		$this->db->set('phone', $param['phone']);
		$this->db->set('hp', $param['hp']);
		$this->db->set('fax', $param['fax']);
		$this->db->set('idperusahaan', $param['idperusahaan']);
		
		$this->db->where('idpic', $param['idpic']);
		$this->db->update('pic');
	}
	
	function update_password_pic($param)
	{
		$this->db->set('password', $param['password']);
		
		$this->db->where('idpic', $param['idpic']);
		$this->db->update('pic');
	}
	
	function cek_password($id,$pass)
	{
		$this->db->where('idpic', $id);
		$this->db->where('password', $pass);
		$query=$this->db->get('pic');
		if($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	function delete_user($id)
	{
		$this->db->where('idpic', $id);
		$this->db->delete('pic');
	}
	
	/* ---------- */
	/* model for group management */
	/* ---------- */
	
	function get_jml_group($key)
	{
		$this->db->like('group', $key);
		$this->db->from('group');
		return $this->db->count_all_results();
	}
	
	function count_group_member($idgroup)
	{
		$this->db->where('group', $idgroup);
		$this->db->from('pic');
		return $this->db->count_all_results();
	}
	
	function get_all_group($limit, $key)
	{
		$this->db->like('group', $key);
		$this->db->order_by('group', 'asc'); 
		return $this->db->get('group',$limit, $this->uri->segment(3));
	}
	
	function get_group_by_id($id)
	{
		
		$this->db->from('group');
		$this->db->where('idgroup', $id);
		$query = $this->db->get();
		return $query;
	}
	
	function cek_group($group)
	{
		$this->db->select();
		$this->db->where('group', $group);
		$query = $this->db->get('group');
		return $query->num_rows();
	}
	
	function add_group($param)
	{
		$this->db->set('idgroup', '');
		$this->db->set('group', $param['group']);
		$this->db->insert('group');
	}
	
	function edit_group($param)
	{
		$this->db->set('group', $param['group']);
		
		$this->db->where('idgroup', $param['idgroup']);
		$this->db->update('group');
	}
	
	function delete_group($id)
	{
		$this->db->where('idgroup', $id);
		$this->db->delete('group');
	}
	
	//---------------------------------
	//TEMPLATE PROJECT INFO
	function get_jml_template($key)
	{
		$this->db->like('tag', $key);
		$this->db->from('template');
		return $this->db->count_all_results();
	}
	
	function get_template_page($limit, $key)
	{
		$this->db->like('tag', $key);		
		$this->db->orderby('idcategory', 'asc'); 
		$this->db->orderby('tag', 'asc');
		return $this->db->get('template',$limit, $this->uri->segment(3));
	}
	
	function get_namakategori($idkategori)
	{
		$this->db->where('idkategori', $idkategori);
		$query = $this->db->get('kategori');
		foreach($query->result() as $row)
			return $row->subsectorname;
	}
	
	function get_tagcode($tag)
	{
		$this->db->where('tag', $tag);
		$query = $this->db->get('daftar_ruas');
		foreach($query->result() as $row)
			return $row->tag;
	}
	
	function get_tagname($tag)
	{
		$this->db->where('tag', $tag);
		$query = $this->db->get('daftar_ruas');
		foreach($query->result() as $row)
			return $row->label;
	}
	
	function get_template($id)
	{
		$this->db->where('idtemplate', $id);
		return $this->db->get('template');
	}
	
	function add_template($param)
	{
		$this->db->set('idtemplate', '');
		$this->db->set('tag', $param['tag']);
		$this->db->set('idcategory', $param['idcategory']);
		
		$this->db->insert('template');
	}
	
	function modify_template($param)
	{
		$this->db->set('tag', $param['tag']);
		$this->db->set('idcategory', $param['idcategory']);
		
		$this->db->where('idtemplate', $param['idtemplate']);
		$this->db->update('template');
	}
	
	function hapus_template($id)
	{
		$this->db->where('idtemplate', $id);
		$this->db->delete('template');
	}
	
	/* ---------- */
	/* model for kota/kabupaten and province management */
	/* ---------- */
	
	function get_jml_provinsi()
	{
		$query = $this->db->count_all('master_propinsi');
		return $query;
	}
	
	function count_provinsi_member($id_propinsi)
	{
		$this->db->where('id_propinsi', $id_propinsi);
		$this->db->from('master_kabupaten');
		return $this->db->count_all_results();
	}
	
	function get_all_provinsi($limit)
	{
		$this->db->order_by('nama_propinsi', 'asc'); 
		return $this->db->get('master_propinsi',$limit, $this->uri->segment(3));
	}
	
	function get_provinsi_by_id($id)
	{
		
		$this->db->from('master_propinsi');
		$this->db->where('id_propinsi', $id);
		$query = $this->db->get();
		return $query;
	}
	
	function cek_provinsi($nama)
	{
		$this->db->select();
		$this->db->where('nama_propinsi', $nama);
		$query = $this->db->get('master_propinsi');
		return $query->num_rows();
	}
	
	function add_provinsi($param)
	{
		$count = $this->db->count_all('master_propinsi');
		
		$this->db->set('id_propinsi', $count+1);
		$this->db->set('nama_propinsi', $param['nama_propinsi']);
		$this->db->insert('master_propinsi');
	}
	
	function edit_provinsi($param)
	{
		$this->db->set('nama_propinsi', $param['nama_propinsi']);
		
		$this->db->where('id_propinsi', $param['id_propinsi']);
		$this->db->update('master_propinsi');
	}
	
	function delete_provinsi($id)
	{
		$this->db->where('id_propinsi', $id);
		$this->db->delete('master_propinsi');
	}
	
	function count_current_project($id_propinsi)
	{
		$this->db->where('bpsid_propinsi', $id_propinsi);
		$this->db->from('project_profile');
		return $this->db->count_all_results();
	}
	
	// model kota/kabupaten
	function get_jml_kabupaten()
	{
		$query = $this->db->count_all('master_kabupaten');
		return $query;
	}
	
	function get_nama_provinsi($id_propinsi)
	{
		$this->db->select('nama_propinsi');
		$this->db->where('id_propinsi', $id_propinsi);
		$query = $this->db->get('master_propinsi');
		foreach($query->result() as $row)
		{
			return $row->nama_propinsi;
		}
	}
	
	function get_all_kabupaten($limit)
	{
		$this->db->order_by('nama_kabupaten', 'asc'); 
		return $this->db->get('master_kabupaten',$limit, $this->uri->segment(3));
	}
	
	function get_kabupaten_by_id($id)
	{
		
		$this->db->from('master_kabupaten');
		$this->db->where('id_kabupaten', $id);
		$query = $this->db->get();
		return $query;
	}
	
	function add_kabupaten($param)
	{
		$count = $this->db->count_all('master_kabupaten');
		$this->db->set('id_kabupaten', $count+1);
		$this->db->set('nama_kabupaten', $param['nama_kabupaten']);
		$this->db->set('id_propinsi', $param['id_propinsi']);
		$this->db->insert('master_kabupaten');
	}
	
	function edit_kabupaten($param)
	{
		$this->db->set('nama_kabupaten', $param['nama_kabupaten']);		
		$this->db->set('id_propinsi', $param['id_propinsi']);
		
		$this->db->where('id_kabupaten', $param['id_kabupaten']);
		$this->db->update('master_kabupaten');
	}
	
	function delete_kabupaten($id)
	{
		$this->db->where('id_kabupaten', $id);
		$this->db->delete('master_kabupaten');
	}
	
	//custom
	function cari_kab_by_key($key)
	{
		$this->db->like('nama_kabupaten', $key);
		$query = $this->db->get('master_kabupaten');
		return $query;
	}
	
	function count_jml_kab_by_key($key)
	{
		$this->db->like('nama_kabupaten', $key);
		$this->db->from('master_kabupaten');
		return $this->db->count_all_results();
	}
	
	function get_all_kab_by_key($limit, $key)
	{
		$this->db->like('nama_kabupaten', $key);
		$this->db->order_by('nama_kabupaten', 'asc'); 
		return $this->db->get('master_kabupaten',$limit, $this->uri->segment(3));
	}
	
	function cari_prov_by_key($key)
	{
		$this->db->like('nama_propinsi', $key);
		$query = $this->db->get('master_propinsi');
		return $query;
	}
	
	function count_jml_prov_by_key($key)
	{
		$this->db->like('nama_propinsi', $key);
		$this->db->from('master_propinsi');
		return $this->db->count_all_results();
	}
	
	function get_all_prov_by_key($limit, $key)
	{
		$this->db->like('nama_propinsi', $key);
		$this->db->order_by('nama_propinsi', 'asc'); 
		return $this->db->get('master_propinsi',$limit, $this->uri->segment(3));
	}
	
	/*etc*/
	function get_nama_proyek_for_welcome($idproj)
	{
		$this->db->where('idproject_profile', $idproj);
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
			return $row->nama;
	}
	
	/*captcha*/
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
	
	/* LOAN MODEL */
	function count_jml_loan($key)
	{
		$this->db->like('catatan', $key);
		$this->db->from('loan');
		return $this->db->count_all_results();
	}
	
	function get_all_loan_by_key($limit, $key)
	{
		$this->db->like('catatan', $key);
		$this->db->order_by('idloan', 'asc'); 
		return $this->db->get('loan',$limit, $this->uri->segment(3));
	}
	
	function get_loan_by_id($id)
	{
		
		$this->db->from('loan');
		$this->db->where('idloan', $id);
		$query = $this->db->get();
		return $query;
	}
	
	function add_loan($param)
	{
		$this->db->set('kategori', $param['kategori']);
		$this->db->set('catatan', $param['catatan']);
		$this->db->set('loan_grand', $param['loan_grand']);
		$this->db->set('category1', $param['category1']);
		$this->db->set('loan', $param['loan']);
		$this->db->set('grand', $param['grand']);
		$this->db->insert('loan');
	}
	
	function edit_loan($param)
	{
		$this->db->set('kategori', $param['kategori']);
		$this->db->set('catatan', $param['catatan']);
		$this->db->set('loan_grand', $param['loan_grand']);
		$this->db->set('category1', $param['category1']);
		$this->db->set('loan', $param['loan']);
		$this->db->set('grand', $param['grand']);
		$this->db->where('idloan', $param['idloan']);
		$this->db->update('loan');
	}
	
	function delete_loan($id)
	{
		$this->db->where('idloan', $id);
		$this->db->delete('loan');
	}
}

/* End of file irsdp_model.php */ 
/* Location: ./system/application/model/irsdp_model.php */ 