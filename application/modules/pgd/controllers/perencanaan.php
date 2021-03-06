<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perencanaan extends MY_Controller {
 	
	function __construct()
    {
        parent::__construct();	
      
	}

	function index() {
		$this->layout->view("perencanaan_list");
	}
	
        
        function rekap_perencanaan() {
                $this->layout->view("perencanaan_rekap_list");
        }
        
        
	function add() {
            
          if ($this->input->post("JUDUL_PEKERJAAN")) {
              
            
              
              $this->load->model('Nomorurut','urut');	 
	      $urut = $this->urut->get("ALL","PERENCANAAN");	
	
              $sql = "INSERT INTO EP_PGD_PERENCANAAN (KODE_PERENCANAAN
                  , KODE_KANTOR
                  , JUDUL_PEKERJAAN
                  , LINGKUP_PEKERJAAN
                  , KODE_PERENCANA 
                  , PERENCANA
                  , MATA_UANG 
                  , RENCANA_KEBUTUHAN 
                  , RENCANA_PELAKSANAAN 
                  , SWAKELOLA
                  , TGL_REKAM
                  , PETUGAS_REKAM)";
              $sql .= "VALUES (" . $urut . "";
              $sql .= ",'" . $this->input->post("KODE_KANTOR") . "'";
              $sql .= ",'" . $this->input->post("JUDUL_PEKERJAAN") . "'";
              $sql .= ",'" . $this->input->post("LINGKUP_PEKERJAAN") . "'";
              $sql .= ",'" . $this->input->post("KODE_JABATAN") . "'";
              $sql .= ",'" . $this->input->post("NAMA_JABATAN") . "'";
              $sql .= ",'" . $this->input->post("MATA_UANG") . "'"; 
              $sql .= ",'" . $this->input->post("RENCANA_KEBUTUHAN") . "'";
              $sql .= ",'" . $this->input->post("RENCANA_PELAKSANAAN") . "'";
              $sql .= "," . $this->input->post("SWAKELOLA") . " ";
              $sql .= " ,   TO_DATE('" . date("Y-m-d") . "','YYYY-MM-DD')  ";
              $sql .= ",'" . $this->session->userdata("kode_user") . "')";
              
	        
             if ($this->db->simple_query($sql)) {
				$this->urut->set_plus( "ALL","PERENCANAAN") ;
                                
                                 
                                
				  echo $urut .  "/" . $this->input->post("KODE_KANTOR") ;
			 }	else {
				echo "0";
			 }
			
		return;
              
			 
              
               
          }  
            
            
          $this->load->model("periode", "periode"); 
          $data["arr_bulan"] = $this->periode->getBulan();       
          $data["arr_tahun"] = $this->periode->getTahun();       
          
          $sql = "SELECT MATA_UANG FROM GL_MATA_UANG ";
          $query = $this->db->query($sql);
          $result = $query->result_array();
            $data["mata_uang"] = $result;
            
            $this->load->model('alurkerja','alur');
                        
                $this->alur->mulai(4);
          
           $data["kode_alurkerja"] = 4;
                $data["kode_komentar"] = 0;
                $data["rs_transisi"] = $this->alur->getTransisi(40001);  
            
          $this->layout->view("perencanaan_add", $data);
	
	}

        function anggaran_delete() {
             $sql = "DELETE FROM EP_PGD_PERENCANAAN_ANGGARAN  ";
             $sql .= " WHERE KODE_PERENCANAAN = " . $this->input->post("KODE_PERENCANAAN") ;
               
                $sql .= " AND   KODE_KANTOR = '" .$this->input->post("KODE_KANTOR"). "'";
                $sql .= " AND TAHUN = '" .$this->input->post("TAHUN"). "'";
                $sql .= " AND KODE_KANTOR_ANGGARAN  = '" .$this->input->post("KODE_KANTOR_ANGGARAN"). "'";
                $sql .= " AND KELOMPOK_MA = '" .$this->input->post("KELOMPOK_MA"). "'";
                $sql .= " AND KODE_MA = '" .$this->input->post("KODE_MA"). "'";
               
                 if ($this->db->simple_query($sql)) {
			 	echo "1";
			 }	else {
				echo "0";
			 }
		
               
                    return;
        }
        
        function editor() {
            
            
           $sql = "SELECT T.KODE_PERENCANAAN
                  , T.KODE_KANTOR
                  , K.NAMA_KANTOR
                  , T.JUDUL_PEKERJAAN
                  , T.LINGKUP_PEKERJAAN
                  , T.KODE_PERENCANA 
                  , T.PERENCANA
                  , T.MATA_UANG 
                  , T.RENCANA_KEBUTUHAN 
                  , T.RENCANA_PELAKSANAAN 
                  , T.SWAKELOLA ";
          $sql .= " FROM EP_PGD_KOMENTAR_TENDER P "; 
          $sql .= " LEFT JOIN EP_PGD_PERENCANAAN T ON P.KODE_TENDER = T.KODE_PERENCANAAN   AND P.KODE_KANTOR = T.KODE_KANTOR ";
          $sql .= " LEFT JOIN MS_KANTOR K ON P.KODE_KANTOR = K.KODE_KANTOR ";
          $sql .= " WHERE P.KODE_KOMENTAR = " . $this->input->get("KODE_KOMENTAR");
          
           
          
          $query = $this->db->query($sql);
          $result = $query->result();
          $data["KODE_PERENCANAAN"] = "";
          
          $data["KODE_KANTOR"] = "";
          $data["NAMA_KANTOR"] = "";
          
            $data["JUDUL_PEKERJAAN"] = "";
            $data["LINGKUP_PEKERJAAN"] = "";
            $data["KODE_PERENCANA"] = "";
            $data["PERENCANA"] = "";
            $data["MATA_UANG"] = "";
            $data["RENCANA_KEBUTUHAN"] = "";
            $data["RENCANA_PELAKSANAAN"] = "";
            $data["SWAKELOLA"] = "";
            

          if (count($result)){
              $data["KODE_PERENCANAAN"] = $result[0]->KODE_PERENCANAAN;
          
              $data["KODE_KANTOR"] = $result[0]->KODE_KANTOR;
              $data["NAMA_KANTOR"] = $result[0]->NAMA_KANTOR;
              
              $data["JUDUL_PEKERJAAN"] = $result[0]->JUDUL_PEKERJAAN;
              $data["LINGKUP_PEKERJAAN"] = $result[0]->LINGKUP_PEKERJAAN;
              $data["KODE_PERENCANA"] = $result[0]->KODE_PERENCANA;
              $data["PERENCANA"] = $result[0]->PERENCANA;
              $data["RENCANA_KEBUTUHAN"] = $result[0]->RENCANA_KEBUTUHAN;
              $data["RENCANA_PELAKSANAAN"] = $result[0]->RENCANA_PELAKSANAAN;
              $data["MATA_UANG"] = $result[0]->MATA_UANG;
              $data["SWAKELOLA"] = $result[0]->SWAKELOLA;
               
          }
          
            
          $this->load->model("periode", "periode"); 
          $data["arr_bulan"] = $this->periode->getBulan();       
          $data["arr_tahun"] = $this->periode->getTahun();       
          
          $sql = "SELECT MATA_UANG FROM GL_MATA_UANG ";
            $query = $this->db->query($sql);

            $result = $query->result_array();
            $data["mata_uang"] = $result;
        
            $this->load->model('alurkerja','alur');
 
           $data["kode_alurkerja"] = 4;
           $data["kode_komentar"] =  $this->input->get("KODE_KOMENTAR");
           $data["rs_transisi"] = $this->alur->getTransisi(40002);
 
            
           
          if ($this->session->userdata("nama_jabatan") == "KAUR PERENCANAAN" || $this->session->userdata("nama_jabatan") == "KAUR PERENCANAAN PENGADAAN" ) { 
                $this->layout->view("perencanaan_anggaran_editor", $data);
          } else {
                 $data["pesan_error"] = "Persetujuan Anggaran Harus Oleh: KAUR PERENCANAAN";
                 $this->layout->view("tampilkan_error", $data);
          }
          
	
          
          
          
          
        }
        
	function anggaran_add($kode_perencanaan, $kode_kantor) {
            
            if ($this->input->post("AKUN")) {
                // print_r($_POST);
                
                $sql = "INSERT INTO EP_PGD_PERENCANAAN_ANGGARAN (
                          KODE_PERENCANAAN
                        , KODE_KANTOR
                        , TAHUN
                        , KODE_KANTOR_ANGGARAN
                        , KELOMPOK_MA
                        , KODE_MA
                        , AKUN
                        , NAMA_AKUN
                        , PAGU_ANGGARAN
                        , SISA_ANGGARAN
                        , TGL_REKAM
                        , PETUGAS_REKAM  ) ";
                
                $sql .= " VALUES ( ";
                $sql .=  $this->input->post("KODE_PERENCANAAN") ;
                $sql .= ",'" .$this->input->post("KODE_KANTOR"). "'";
                $sql .= ",'" .$this->input->post("TAHUN"). "'";
                $sql .= ",'" .$this->input->post("KODE_KANTOR_ANGGARAN"). "'";
                $sql .= ",'" .$this->input->post("KELOMPOK_MA"). "'";
                $sql .= ",'" .$this->input->post("KODE_MA"). "'";
                $sql .= ",'" .$this->input->post("AKUN"). "'";
                $sql .= ",'" .$this->input->post("NAMA_AKUN"). "'";
                $sql .= ", " .$this->input->post("PAGU_ANGGARAN"). "";
                $sql .= ", " .$this->input->post("SISA_ANGGARAN"). "";
                $sql .= ",   TO_DATE('" . date("Y-m-d") . "','YYYY-MM-DD')  ";
                $sql .= ",'" . $this->session->userdata("kode_user") . "')";
                
                
                      if ($this->db->simple_query($sql)) {
			 	echo "KODE_PERENCANAAN=" . $this->input->post("KODE_PERENCANAAN") . "&KODE_KANTOR_PERENCANAAN=" . $this->input->post("KODE_KANTOR");
			 }	else {
				echo "0";
			 }
		//echo $sql;	
		return;
                
                
                
            }
            
            
             
          $sql = "SELECT P.KODE_PERENCANAAN
                  , P.KODE_KANTOR
                  , K.NAMA_KANTOR
                  , P.JUDUL_PEKERJAAN
                  , P.LINGKUP_PEKERJAAN
                  , P.KODE_PERENCANA 
                  , P.PERENCANA
                  , P.MATA_UANG 
                  , P.RENCANA_KEBUTUHAN 
                  , P.RENCANA_PELAKSANAAN 
                  , P.SWAKELOLA ";
          $sql .= " FROM EP_PGD_PERENCANAAN P ";
          $sql .= " LEFT JOIN MS_KANTOR K ON P.KODE_KANTOR = K.KODE_KANTOR ";
          
          $sql .= " WHERE P.KODE_PERENCANAAN = " . $kode_perencanaan;
          $sql .= " AND P.KODE_KANTOR = '" . $kode_kantor . "'";
          
          $query = $this->db->query($sql);
          $result = $query->result();
          $data["KODE_PERENCANAAN"] = $kode_perencanaan;
          
          $data["KODE_KANTOR"] = $kode_kantor;
          $data["NAMA_KANTOR"] = "";
          
            $data["JUDUL_PEKERJAAN"] = "";
            $data["LINGKUP_PEKERJAAN"] = "";
            $data["KODE_PERENCANA"] = "";
            $data["PERENCANA"] = "";
            $data["MATA_UANG"] = "";
            $data["RENCANA_KEBUTUHAN"] = "";
            $data["RENCANA_PELAKSANAAN"] = "";
            $data["SWAKELOLA"] = "";
            

          if (count($result)){
              $data["KODE_KANTOR"] = $result[0]->KODE_KANTOR;
              $data["NAMA_KANTOR"] = $result[0]->NAMA_KANTOR;
              
              $data["JUDUL_PEKERJAAN"] = $result[0]->JUDUL_PEKERJAAN;
              $data["LINGKUP_PEKERJAAN"] = $result[0]->LINGKUP_PEKERJAAN;
              $data["KODE_PERENCANA"] = $result[0]->KODE_PERENCANA;
              $data["PERENCANA"] = $result[0]->PERENCANA;
              $data["RENCANA_KEBUTUHAN"] = $result[0]->RENCANA_KEBUTUHAN;
              $data["RENCANA_PELAKSANAAN"] = $result[0]->RENCANA_PELAKSANAAN;
              $data["MATA_UANG"] = $result[0]->MATA_UANG;
              $data["SWAKELOLA"] = $result[0]->SWAKELOLA;
               
          }
          
            
          $this->load->model("periode", "periode"); 
          $data["arr_bulan"] = $this->periode->getBulan();       
          $data["arr_tahun"] = $this->periode->getTahun();       
          
          $sql = "SELECT MATA_UANG FROM GL_MATA_UANG ";
            $query = $this->db->query($sql);

            $result = $query->result_array();
            $data["mata_uang"] = $result;
        
            $this->load->model('alurkerja','alur');
 
           $data["kode_alurkerja"] = 4;
           $data["kode_komentar"] = 0;
           $data["rs_transisi"] = $this->alur->getTransisi(40001);
           
            $data["kode_transisi"] = 10;
            
          $this->layout->view("perencanaan_anggaran_add", $data);
	
	}
        
}	