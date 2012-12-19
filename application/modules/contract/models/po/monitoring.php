<?php

class monitoring extends MY_Model {

    public $table = 'EP_KTR_PO';
    
    public $sql_select = "( select a.*, '' as act from EP_KTR_PO a )";
    
    public $columns_conf = array(
        'KODE_PO',
        'KODE_KONTRAK',
        'KODE_VENDOR',
        'KODE_KANTOR',
        'NAMA_VENDOR',
        'CATATAN_PO',
        'STATUS',
        'ACT',
    );
    public $dir = 'po';
    
    function __construct() {
        parent::__construct();
        $this->init();
        
        $this->js_grid_completed = '
                var ids = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getDataIDs\');
		for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    
                    var data = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getRowData\', cl);
                    
                    //alert(data[\'KODE_PROSES\']);
                    
                    var param = "referer_url=/contract/po/monitoring&KODE_KONTRAK=" + data[\'KODE_KONTRAK\'] + "&KODE_VENDOR=" + data[\'KODE_VENDOR\'] + "&KODE_KANTOR=" + data[\'KODE_KANTOR\'] + "&KODE_PO=" + data[\'KODE_PO\'];
                    var href = $site_url + "/contract/po/detail?" + param;
                    
                    be = "<button onclick=\"javascript:window.location=\'" +href+ "\'\" type=\"button\" id=\"btnProses\" class=\"ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">LIHAT DETAIL</span></button>";
                    jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'setRowData\',ids[i],{ACT:be});
		}';
    }

}

?>