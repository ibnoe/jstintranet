<?php if(!isset($read_only) || $read_only != true): ?>
<button type="button" id="btnSimpan">SIMPAN</button>
<button type="button" id="btnBatal">BATAL</button>
<script>
    $(document).ready(function(){
        // stylish button and input date
        $(function() {
            $( "input:submit, button").button();
            $( ".datepicker" ).datepicker();
            //$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        
        });
    
        var validator = $("#<?php echo $form->id; ?>").validate({
            meta: "validate",
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit();
            }
        });
    
        // attach event to button
        $("#<?php echo $form->id; ?> #btnSimpan").click(function() {
            if(validator.form()) {
                jQuery("#<?php echo $form->id; ?>").ajaxSubmit({
                    //clearForm: <?php echo $form->clear_form ? "true" : "false"; ?>,
                    success: function(data){
                        <?php if($form->clear_form): ?>
                            $("#<?php echo $form->id; ?>").resetForm();
                            $("#<?php echo $form->id; ?>").clearForm();
                            validator.prepareForm();
                            validator.hideErrors();
                            
                            // new : for load form from server with default attributes 
                            var url = window.location.href;
                            var tempArray = url.split("?");
                            var additionalURL = tempArray[1];
                            var action = $("#<?php echo $form->id; ?>").attr("action");
                            var newAction = action.split("?");
                            var newAction = newAction[0] + "?" + additionalURL;
                            $("#<?php echo $form->id; ?>").parent().load(newAction);
                            
//                            $("#<?php echo $form->id; ?>").replaceWith(data);
                        <?php else: ?>
                            // replace form
                            $("#<?php echo $form->id; ?>").replaceWith(data);
                        <?php endif; ?>
                                
                        alert('Data berhasil disimpan');
                        
                        
                        //reload grid
                        $('#grid_<?php echo strtolower(get_class($form->model)); ?>').trigger("reloadGrid");
                        
                    },
                    error: function(){
                        alert('Data gagal disimpan')
                    }
                });
            }
        });
        
        $("#<?php echo $form->id; ?> #btnBatal").click(function() {
            $("#<?php echo $form->id; ?>").resetForm();
            validator.prepareForm();
            validator.hideErrors();
            
            // new : for load form from server with default attributes 
            var url = window.location.href;
            var tempArray = url.split("?");
            var additionalURL = tempArray[1];
            
            var action = $("#<?php echo $form->id; ?>").attr("action");
            var newAction = action.split("?");
            var newAction = newAction[0] + "?" + additionalURL;
            $("#<?php echo $form->id; ?>").parent().load(newAction);
        });
    });
    
</script>
<?php endif; ?>