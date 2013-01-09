 <div class="accordion">
 <h3 href="<?php echo base_url()?>index.php/adm/gridr/ep_kom_harga_barang">HARGA BARANG</h3>
            <div>
   <fieldset class="ui-widget-content">
        <legend>Pencarian</legend>
			<form id="frmSearch" method="POST" action="" >
			
			<div id="mysearch"></div>
			<p>	
				<label>SUB KELOMPOK BARANG</label>
                                        <select id="kelbarang">
                                            <option value="" >SEMUA</option>
                                            <?php
                                            foreach ($rskel as $row) {
                                                echo "<option value='" . $row->KODE_SUBKELOMPOK . "' >".$row->NAMA_SUBKELOMPOK."</option>";
                                                
                                            }
                                            ?>
                                        
                                        </select>
                               
			</p>
                        <p>	
				<label>STATUS</label>
                                        <select id="status">
                                            <option value="">SEMUA</option>
                                            <option value="SUDAH DISETUJUI">SUDAH DISETUJUI</option>
                                            <option value="BELUM DISETUJUI">BELUM DISETUJUI</option>
                                        </select>
                              
		
			</p>
                        <p>
                                <label>CARI BERDASARKAN</label>
                            		<select  id="kolom" name="kolom"  > 
                                            <option value="KODE_BARANG">KODE BARANG</option>
                                            <option value="NAMA_BARANGA">DESKRIPSI</option>
                                            <option value="NAMA_VENDOR">VENDOR</option>
                                            <option value="NAMA_SUMBER">SUMBER</option>
                                            
                                         </select>    
                                <input type="text" id="cari" name="cari"  />
                                <button type="button" id="btnSrc"  >Cari</button> 
                        </p>
			</form>
         </fieldset>   
                
			<p>
                            <button type="button" id="btnAdd"  >Tambah  Harga Barang</button> 
                            <button type="button" id="btnBanding"  >Bandingkan  Harga Barang</button> 
				 
			
			</p>
			
			
			 
			<div id="list" ></div>
			</div>
  </div>			
 <script>
  
  $(document).ready(function(){
	//$("#mysearch").jqGrid('filterGrid','#grid_ep_kom_kelompok_jasa');
	
	
    $(".accordion")
    .addClass("ui-accordion ui-widget ui-helper-reset")
    //.css("width", "auto")
    .find('h3')
    .addClass("current ui-accordion-header ui-helper-reset ui-state-active ui-corner-top")
    .css("padding", ".5em .5em .5em .7em")
    //.prepend('<span class="ui-icon ui-icon-triangle-1-s"><span/>')
    .next()
    .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active")
    .css('overflow','visible')
	
	$("#btnSrc").click(function() {
                KODE_SUB_BARANG = $("#kelbarang").val();
                STATUS = $("#status").val();
        		srcval = $("#kolom").val();
		var myfilter = { groupOp: "AND", rules: []};
		var kolom = $("#kolom").val(); 
                var cari = $("#cari").val();
                
                alert(KODE_SUB_BARANG);
                
                if (KODE_SUB_BARANG.length > 0) { 
                        myfilter = { groupOp: "AND", rules: []};
                        myfilter.rules.push({field:'KODE_SUB_BARANG' ,op:"eq",data: KODE_SUB_BARANG}, {field: kolom ,op:"cn",data: cari } );
                        if (STATUS != "") {
                            myfilter.rules.push({field:'KODE_SUB_BARANG' ,op:"eq",data: KODE_SUB_BARANG}, {field:'STATUS' ,op:"eq",data: STATUS} , {field: kolom ,op:"cn",data: cari } );
                        } else {
                            myfilter.rules.push({field:'KODE_SUB_BARANG' ,op:"eq",data: KODE_SUB_BARANG},   {field: kolom ,op:"cn",data: cari } ); 
                        }
                        
                } else { 
                        if (STATUS != "") {
                            myfilter = { groupOp: "AND", rules: []};
                            myfilter.rules.push({field:'STATUS' ,op:"eq",data: STATUS} , {field: kolom ,op:"cn",data: cari } );
                        } else {
                            myfilter.rules.push({field: kolom ,op:"cn",data: cari } );
                        }
                    
                }       
                  
		var grid = $("#grid_ep_kom_harga_barang");
			
	 
		grid[0].p.search = myfilter.rules.length>0;
		$.extend(grid[0].p.postData,{filters:JSON.stringify(myfilter)});
		grid.trigger("reloadGrid",[{page:1}]);
	 
	 	
	});
	
	
	$(".accordion" ).each(function(){
                 
                
                $('h3', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $("#list") ;
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
	$("#btnAdd" ).click(function() {
		window.location = "<?php echo base_url() ."index.php/adm/harga_barang/add"; ?>";  
	});
	
	$("#btnBanding" ).click(function() {
	 
	 var selected = $('#grid_ep_kom_harga_barang').jqGrid('getGridParam', 'selrow');
		 if (selected) {
                    selected = jQuery('#grid_ep_kom_harga_barang').jqGrid('getRowData',selected);
                    var keys = <?php echo json_encode(Array ( 0  => "KODE_HARGA_BARANG" )); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    window.location = "<?php echo base_url() . "index.php/adm/harga_barang/banding"; ?>?" + str;
		}			
	});
	
		
	$("#btnBanding" ).click(function() {

            var selected = $('#grid_ep_kom_jasa').jqGrid('getGridParam', 'selrow');
		 if (selected) {
                    selected = jQuery('#grid_ep_kom_jasa').jqGrid('getRowData',selected);
                    var keys = <?php echo json_encode(Array ( 0  => "KODE_JASA" )); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    window.location = "<?php echo base_url() . "index.php/jasa/edit"; ?>?" + str;
		}
		
	});
	 
	 

	 });
  
</script>   			