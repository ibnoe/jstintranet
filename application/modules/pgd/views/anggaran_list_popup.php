  <div class="accordion">
 <h3 id="h3_harga_jasa_popup" href="<?php echo base_url(); ?>index.php/pgd/gridpopup_anggaran/bg_ms_anggaran">MATA ANGGARAN</h3>
            <div>
			<p>
			<div id="mysearch"></div>
                        <select id="myfieldanggaran" >
                            <option value="AKUN" >Kode Akun</option>
                            <option value="NAMA_AKUN" >Nama Akun</option>
                        </select>
                        
                        
				<input type="text" id="kolomanggaran" name="kolomanggaran"  value="" /> 
				<input type="button" id="btnSrc"  value="Cari" /> 
			</p>
			 
			
			
			 
			<div id="listpopup" ></div>
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
	

	
		//alert($("#kolom").val());
		
		
		myfield = $("#myfieldanggaran").val();
		srcval = $("#kolomanggaran").val();
		var myfilter = { groupOp: "AND", rules: []};
		myfilter.rules.push({field:myfield,op:"cn",data:srcval});
		
		var grid = $("#grid_bg_ms_anggaran");
			 
		
		grid[0].p.search = myfilter.rules.length>0;
		$.extend(grid[0].p.postData,{filters:JSON.stringify(myfilter)});
		grid.trigger("reloadGrid",[{page:1}]);
		 
		 
		//$('#grid_ep_kom_kelompok_jasa').jqGrid().trigger("reloadGrid");
		
	});
	
	
	$(".accordion" ).each(function(){
                 
                
                $('#h3_harga_jasa_popup', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $("#listpopup") ;
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
 
	 

	 });
  
</script>   			