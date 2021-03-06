<?php

class ep_ktr_invoice_dok extends MY_Model {

    public $table = 'EP_KTR_INVOICE_DOK';
    public $elements_conf = array(
//        'KODE_DOKUMEN',
//        'KODE_INVOICE',
//        'KODE_KONTRAK',
//        'KODE_KANTOR',
//        'KODE_VENDOR',
//        'KATEGORI',
        'KETERANGAN',
        'NAMA_FILE' => array('type' => 'file'),
//        'STATUS'=>array('type'=>'dropdown', 'options'=>array('1' => 'TAMPIL DI VENDOR', '1')),
    );
    public $columns_conf = array(
//        'KODE_DOKUMEN',
//        'KODE_INVOICE',
//        'KODE_KONTRAK',
//        'KODE_KANTOR',
//        'KODE_VENDOR',
//        'KATEGORI',
        'KETERANGAN',
        'NAMA_FILE' => array('type' => 'file'),
//        'STATUS'=>array('type'=>'dropdown', 'options'=>array('1' => 'TAMPIL DI VENDOR', '1')),
    );
    public $dir = 'invoice';

    function __construct() {
        parent::__construct();
        $this->init();

        if (isset($_REQUEST['KODE_INVOICE']) && isset($_REQUEST['KODE_KONTRAK']) && isset($_REQUEST['KODE_KANTOR']) && isset($_REQUEST['KODE_VENDOR'])) {
            $this->attributes['KODE_INVOICE'] = $_REQUEST['KODE_INVOICE'];
            $this->attributes['KODE_KONTRAK'] = $_REQUEST['KODE_KONTRAK'];
            $this->attributes['KODE_KANTOR'] = $_REQUEST['KODE_KANTOR'];
            $this->attributes['KODE_VENDOR'] = $_REQUEST['KODE_VENDOR'];
        }
    }

    function _default_scope() {
        parent::_default_scope();
        return " KODE_INVOICE = '" . $_REQUEST['KODE_INVOICE'] . "'";
    }

    function _before_insert() {
        parent::_before_insert();
        // set auto increament
        if ($this->attributes['KODE_DOKUMEN'] == 0) {
            $row = $this->db->query("select nomorurut + 1 as NEXT_ID 
                from ep_nomorurut 
                where kode_nomorurut = 'EP_KTR_INVOICE_DOK'")->row_array();
            $this->attributes['KODE_DOKUMEN'] = $row['NEXT_ID'];
        }
    }

    public function _after_insert() {
        parent::_after_insert();

        $this->db->query("update ep_nomorurut set nomorurut = nomorurut + 1 
            where kode_nomorurut = 'EP_KTR_INVOICE_DOK'");
    }
    
    public function _before_save() {
        parent::_before_save();
        
        if (isset($this->attributes['NAMA_FILE']) && strlen($this->attributes['NAMA_FILE']) == 0)
            unset($this->attributes['NAMA_FILE']);
    }

}

?>