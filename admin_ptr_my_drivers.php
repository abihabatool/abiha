<style>
#datatable_length{
    font-size: 12px;
  padding-right: 0px; 
  float: right;
  padding-top: 12px;
}
#datatable_filter {
  padding-top: 0px;
}
</style>
<!--driver modal-->

<div class="modal-dialog" style="width:1025px"> 
<div class="modal-content">
<div class="modal-header"> 
<button type="button" class="close" data-dismiss="modal">&times;</button> 
<h4 class="modal-title">Driver Data</h4> 
</div>  
<div class="modal-body">

<section class="panel panel-default">
 <div class="row text-sm wrapper">
 <div class="col-sm-3"> 
 <div class="input-group"> 
 <input type="text" placeholder="Search" class="input-sm form-control"> 
 <span class="input-group-btn"> 
 <button type="button" class="bton btn-sm btn-default">Go!</button> 
 </span> 
 </div> 
 </div>

<div class="col-sm-5 m-b-xs">  
<select class="input-sm form-control input-s-sm inline" id="select_test_status"> 
<option value="">By Result</option> 
<option value="Failed">Failed</option> 
<option value="Passed">Passed</option>
 <option value="Not Attempted">Not Attempted</option> 
 </select>
 
 <select class="input-sm form-control input-s-sm inline" id="select_drv_status" > 
<option value="">Driver Status</option> 
<option value="Pending">Pending</option> 
<option value="Rejected">Rejected</option> 
<option value="Active">Accepted</option>
 </select>
 
 <select class="input-sm form-control input-s-sm inline" id="select_ActDeact_status"> 
<option value="">All</option> 
<option value="1">Active partner</option> 
<option value="0">De-Active partner</option>  
 </select>
 
 </div> 
 </div> 
  
  <div class="table-responsive"> 
  <table class="table table-striped table-bordered table-hover report" id="datatable" style="width:962px"> 
 <thead>
        <tr>
       	 	<th>S.No</th> 
            <th>Status</th>
            <th>Name</th>
  			<th>Test Result</th>
  			<!--th>Reg.Date</th>-->
            
            <th width=156>Status</th> 
           
        </tr>
        </thead>
			<tbody>
<?php 
		//echo "<pre>"; print_r($drv_profile);
		$i=0;
		$old_id="";
		if($drv_profile){
		foreach($drv_profile as $val):
		$i++;
		
			$drv_status=$this->admin_ptr_model->drv_doc_status($val['my_drv_id']); //get main status of driver

		
		if($val['passed'] == 1) // test result  status
			$test_result="Passed";
		else if($val['passed'] == Null)
			$test_result="Not Attempted";
		else
			$test_result="Failed"; // end of test result  status
		
		if($drv_status == "1") //main status of  driver
		{
			$class="accept";
			$cl_name="Active";
		}
		else if($drv_status == '2')
		{
			$class="reject";
			$cl_name="Rejected";
	
		}
	
		else
		{
			$class="pending";
			$cl_name="Pending";
	
		}
		
		$status="Accepted";
			$st_class="accept";
		/*
		if($val['doc_status_id']=='1') // doc status 
		{
			
					
		}else if($val['doc_status_id']=='2')
		{
		$status="Rejected";
		$st_class="reject";
					

		}else
		{
		$status="Pending";
		$st_class="pending";

		} // end of doc status
		*/
		
		
		if($val['my_drv_id'] != $old_id):
			if($val['my_drv_id'] == "")
							continue;
			$old_id=$val['my_drv_id'];
		
		?>
		<tr>
        <td class="sno" id="<?php echo $val['my_drv_id']?>"><?php echo $i;?></td>
        <td class="status"><span class="<?php echo $class; ?>"><?php echo $cl_name;?></span></td> 
        <td class="name"><?php echo $val['fname']." ".$val['lname'];?></td>
  		<td class="tst"><?php echo $test_result;?></td> 
  		<!--<td class="reg"></td>-->
  
            <td> <div class="can-toggle">
				<?php if ($val['drv_active'] ==1)
		{
			echo '<span class="hide">1</span>';
			 echo '<input id="a'.$val['my_drv_id'].'" class="drv_checkbox" type="checkbox" value="1" checked>';
		}
		else
		{
			echo '<input id="a'.$val['my_drv_id'].'" class="drv_checkbox" type="checkbox" value="0">';
			echo '<span class="hide">0</span>';
		}
		?>  <label for="a<?php echo $val['my_drv_id']; ?>">
    <div class="can-toggle__switch" data-checked="Active" data-unchecked="De-Active"></div>
  
  </label>
</div>
  </td> 
	
         
        </tr>
		
			
				   
				<?php endif; ?>
                  
                    
                  <?php  endforeach; 
				  }
				  ?>
                   
                    
       </tbody>     
		
      
        
    </table>
  
  
  
  </div>
  </section>
  
  </div> 

</div>
</div>
<!-- /.modal-dialog -->


<!-- /driver modal-->

 
<!-- /.modal --> 
  
  
  
  
<!-- Scripting Start -->

<!--Main js-->

<!--Table Toggle js--> 
<script type="text/javascript" cache="false" asyn="false">  
$(document).ready(function() {
        var anOpen = [];
        var mTable;
        var sImageUrl = "http://datatables.net/examples/resources/";

        /*var search = "";
         if ( window.location.hash !== "" ) {
         search = window.location.hash.substring( 1 );
         }*/

       var mTable=$('#datatable').dataTable({   //datatable start
        //"bJQueryUI": true,
		"processing": true,
        "serverSide": true,
        'sPaginationType':'full_numbers',
		"bSort" : false,
		"aaSorting": [[ 2, 'asc' ]],

		//"ajax": "<?php echo site_url(); ?>/admin_ptr_view/get_ptr"
		
		"fnInitComplete": function() {
                //this.fnAdjustColumnSizing();
                $('div.dataTables_filter input').focus();

                jQuery('#datatable .group-checkable').change(function() {
                    var set = jQuery(this).attr("data-set");
                    var checked = jQuery(this).is(":checked");
                    jQuery(set).each(function() {
                        if (checked) {
                            $(this).attr("checked", true);
                        } else {
                            $(this).attr("checked", false);
                        }
                    });
                    jQuery.uniform.update(set);
                });

				 jQuery('#datatable_wrapper .dataTables_filter').addClass("input-group");
                jQuery('#datatable_wrapper .dataTables_filter input').addClass("input-sm form-control"); // modify table search input
                jQuery('#datatable_wrapper .dataTables_length select').addClass("m-wrap xsmall"); // modify table per page dropdown
            }
    }); //end of data table
	
          

	
		
		 $("body").on('click','#datatable tbody .sno', function() {
			var ttr=$(this);
		  var drv_id=$(this).prop("id");
			//alert(drv_id);
			$.ajax
			({
				url: "<?php echo site_url(); ?>/su/admin_ptr_view/GetDrvDocs",   	// Url to which the request is send
				type: "POST",      				// Type of request to be send, called as method
				dataType: "JSON",
				data: 'drv_id='+drv_id, 		// Data sent to server, a set of key/value pairs representing form fields and values 
				success: function(json)  		// A function to be called if request succeeds
				{
					
					
					var nTr = $(ttr).parents('tr')[0];
				//alert(nTr)	
					if (mTable.fnIsOpen(nTr)) { //This row is already open - close it 
					mTable.fnClose(nTr);
					} else {  //Open this row 
					mTable.fnOpen(nTr, fnFormatDetails(json), 'details' );
					}
					
				}
			
			}) //ajax end
		  })
		  
	$('body').on('change','input:radio',function(){ // change status of docs
 	var rad_val=$(this).val();
	var rad_class=$(this).prop('class');
	var RDt=$(this).prop('id');
	check=$(this);
		var reg_date=RDt.split('_');
	//alert(reg_date[1])
	//alert(rad_val);
	//alert(rad_class);
	if(rad_val == 2)
	{
		swal({   title: "Reason!",   text: "Write Reason:",   type: "input",   showCancelButton: true,   closeOnConfirm: false,   animation: "slide-from-top",   inputPlaceholder: "Write Reason" },
			function(inputValue){
			if (inputValue === false)
			{
				//mTable.fnDraw();
				//check.attr('checked','checked');
				//check.prop('checked', true);
				return false;
			
			}
			if (inputValue === "")
			{  
				swal.showInputError("You need to write Reason!");
				//mTable.fnDraw();
				//check.attr('checked','checked');
				
				//check.prop('checked', true);
				return false 
			} 
			else
			{
				
				$.ajax({
					url: "<?php echo site_url(); ?>/su/admin_ptr_view/drv_change_status",   	// Url to which the request is send
					type: "POST",      				// Type of request to be send, called as method
					data: 'rad_val='+rad_val+'&rad_class='+rad_class+'&reason='+inputValue+'&reg_date='+reg_date[1], 		// Data sent to server, a set of key/value pairs representing form fields and values 
					//beforeSend:function(){ $('.loader').show(); },
					//complete:function(){ $('.loader').hide(); },	
					success: function(data)  		// A function to be called if request succeeds
					{
						if(data == '200')
							swal({   title: "Successful",   text: "Successfully change status of documents",   type: "success",   confirmButtonText: "OK" });
							//function (isConfirm){ window.location="<?php echo site_url('ptr/view_drivers_controller');?>" };
						else
							swal({   title: "Error!",   text: "some problems have been occured",   type: "error",   confirmButtonText: "OK" });
				},		
		
				})
				//swal("Nice!", "You wrote: " + inputValue, "success");
			}
		});
	}
	else
	{
		$.ajax({
					url: "<?php echo site_url(); ?>/su/admin_ptr_view/drv_change_status",   	// Url to which the request is send
					type: "POST",      				// Type of request to be send, called as method
					data: 'rad_val='+rad_val+'&rad_class='+rad_class, 		// Data sent to server, a set of key/value pairs representing form fields and values 
					//beforeSend:function(){ $('.loader').show(); },
					//complete:function(){ $('.loader').hide(); },	
					success: function(data)  		// A function to be called if request succeeds
					{
						if(data == '200')
							swal({   title: "Successful",   text: "Successfully change status of documents",   type: "success",   confirmButtonText: "OK" });
							//function (isConfirm){ window.location="<?php echo site_url('ptr/view_drivers_controller');?>" };
						else
							swal({   title: "Error!",   text: "some problems have been occured",   type: "error",   confirmButtonText: "OK" });
				},		
		
				})
		
	}	
	
	
	
	
	
 }) // end status of docs	 
		  
	
// change main status of driver
$('body').on('change','.drv_checkbox',function(){
	//alert("hi")
	//exit;
	
	var chk_val=$(this).val();
	var myString=$(this).prop('id');
	var chk_drv_id= myString.replace('a', '');
	var check=$(this);
	//alert(chk_val);
			//$(this).prop('checked', false);

	
	swal({
			title: "Are you sure?",
			text: "You want to change your status!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, change it!",
			cancelButtonText: "No, cancel please!",
			closeOnConfirm: false,
			closeOnCancel: false 
			},
	function(isConfirm){
	if (isConfirm) 
	{
	$.ajax({
		url: "<?php echo site_url(); ?>/su/admin_ptr_view/drv_main_status",   	// Url to which the request is send
		type: "POST",      				// Type of request to be send, called as method
		data: 'chk_val='+chk_val+'&chk_drv_id='+chk_drv_id, 		// Data sent to server, a set of key/value pairs representing form fields and values 
		success: function(data)  		// A function to be called if request succeeds
	    {
	if(data == '1')
	{		
		swal({   title: "Successful",   text: "This Driver is successfully activated",   type: "success",   confirmButtonText: "OK" },
		function (isConfirm){ //window.location="<?php echo site_url('su/admin_ptr_view');?>" 
			check.prop('checked', true);
				mTable.fnDraw();

		//oTable.fnClearTable(0);
		});
	}
	else if(data == '2')
	{

		swal({   title: "Error!",   text: "Driver is not activated because all Driver documents required to be active",   type: "error",   confirmButtonText: "OK" },
		
		function (isConfirm){ //window.location="<?php echo site_url('su/admin_ptr_view');?>" 
				
				check.prop('checked', false);
				mTable.fnDraw();

		//oTable.fnClearTable(0);
		});
	}	
	else if(data == '3')
	{
		swal({   title: "Successful",   text: "This Driver is successfully de-activated",   type: "success",   confirmButtonText: "OK" },
		
		function (isConfirm){ //window.location="<?php echo site_url('su/admin_ptr_view');?>" 
				
				check.prop('checked', false);
				mTable.fnDraw();

		//oTable.fnClearTable(0);
		});
	}
	//alert(data)
	},
	//async:false
	
	})
	
	}
	else {
							 
	swal("Cancelled", "Status is not changed ", "error");
		}
	 }
		
	);
	return false;
	//alert(a)
 })	
 //end main status

 
 $("body").on('change','#select_drv_status',function(){
	
	    var choosedFilter = $(this).val();
    
    mTable.fnFilter(choosedFilter,1,true,false);
	
	
})
 $("body").on('change','#select_test_status',function(){	
	    var choosedFilter = $(this).val();
    
    mTable.fnFilter(choosedFilter,3,true,false);
	
	
})
 $("body").on('change','#select_ActDeact_status',function(){
	
	    var choosedFilter = $(this).val();
    
    mTable.fnFilter(choosedFilter,4,true,false);
	
})
 
})// end of document ready function		

	
		  
		  
				
			
			
		 function fnFormatDetails(json)
		{
			//for(var i=0;i<json.length;i++){
			var old_id="";
			var sOut;
			//alert(json)
			$.each(json, function(key, val)
			{
				
					
					if(val.my_drv_id != old_id){
						if(val.my_drv_id == ""){
							
							return;
						}
							old_id=val.my_drv_id;	
				 sOut = '<tr>'+
					'<td class="table-extend" colspan="4" style="border:none;">'+
					'<a href="image_large_view.html" data-toggle="ajaxModal" >'+
					'<img class="img-circle" src="data:image/jpg;base64,'+val.drv_pic+'"  width="112" height="112">'+ 
					'<h4>Additional information</h4>'+
					'<ul class="ul_inform">'+
					'<li><label><a href="#">Email:</a> <span class="li_td">'+val.email+'</span></label></li>'+
                    <!--<li><label><a href="#">Password:</a> <span class="li_td">*****</span></label></li>-->
                    '<li><label><a href="#">Date of Birth:</a> <span class="li_td">'+val.dob+'</span></label></li>'+
                    '<li><label><a href="#">Mobile:</a> <span class="li_td'+val.mobile+'</span></label></li>'+
                    '<li><label><a href="#">License Number:</a> <span class="li_td">'+val.lic_no+'</span></label></li>'+
                    '<li><label><a href="#">Address:</a> <span class="li_td">'+val.address+'</span></label></li>'+
                    '<li><label><a href="#">Reg.Date:</a> <span class="li_td">'+val.reg_date+'</span></label></li>'+
                    '<br><br>';
					
					
						if(val.doc_status_id=='1'){
					sOut +='<div class="col-md-12">'+
                    '<li><a class="bton btn-dwn" href="#">'+
					'<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;'+val.name+'</a>'+
					'<span class="label bg-accept" id="status_id1">Active</span>'+
					'<br><br>'+
					'<div class="switch-toggle switch-3 switch-ios">'+
					
					
					'<input id="a_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="1" checked >'+
					'<label class="blue" for="a_'+val.reg_date+'">Accept</label>'+
					
					'<input id="p_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" disabled value="3">'+
					'<label class="red" for="p_'+val.reg_date+'" onclick="">Pending</label>'+
					
					'<input id="r_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="2">'+
					'<label class="green" for="r_'+val.reg_date+'" onclick="">Reject</label>';
						}
						if(val.doc_status_id=='3'){
					sOut +='<div class="col-md-12">'+
                    '<li><a class="bton btn-dwn" href="#">'+
					'<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;'+val.name+'</a>'+
					'<span class="label bg-pending" id="status_id1">Pending</span>'+
					'<br><br>'+
					'<div class="switch-toggle switch-3 switch-ios">'+

					'<input id="a_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="1">'+
					'<label class="blue" for="a_'+val.reg_date+'">Accept</label>'+
					
					'<input id="p_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" disabled value="3" checked>'+
					'<label class="red" for="p_'+val.reg_date+'" onclick="">Pending</label>'+
					
					'<input id="r_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="2">'+
					'<label class="green" for="r_'+val.reg_date+'" onclick="">Reject</label>';
					}
						if(val.doc_status_id=='2'){
					sOut +='<div class="col-md-12">'+
                    '<li><a class="bton btn-dwn" href="#">'+
					'<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;'+val.name+'</a>'+
					'<span class="label bg-reject" id="status_id1">Rejected</span>'+
					'<br><br>'+
					'<div class="switch-toggle switch-3 switch-ios">'+
					
					'<input id="a_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="1">'+
					'<label class="blue" for="a_'+val.reg_date+'">Accept</label>'+
					
					'<input id="p_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" disabled value="3">'+
					'<label class="red" for="p_'+val.reg_date+'" onclick="">Pending</label>'+
					
					'<input id="r_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="2" checked>'+
					'<label class="green" for="r_'+val.reg_date+'" onclick="">Reject</label>';
						}
          
					sOut += '</div>'+
                    '</li><br><br>';
					}
					else{
						if(val.my_drv_id == ""){
							return;
					}	
					old_id=val.my_drv_id;

				
					 
					if(val.doc_status_id=='1'){
					sOut +='<li><a class="bton btn-dwn" href="#">'+
					'<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;'+val.name+'</a>'+
					'<span class="label bg-accept" id="status_id1">Active</span>'+
					'<br><br>'+

					'<div class="switch-toggle switch-3 switch-ios">'+
					'<input id="c_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="1" checked >'+
					'<label class="blue" for="c_'+val.reg_date+'">Accept</label>'+
					
					'<input id="d_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" disabled value="3">'+
					'<label class="red" for="d_'+val.reg_date+'" onclick="">Pending</label>'+
					
					'<input id="e_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="2">'+
					'<label class="green" for="e_'+val.reg_date+'" onclick="">Reject</label>';
						}
						if(val.doc_status_id=='3'){
					sOut +='<li><a class="bton btn-dwn" href="#">'+
					'<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;'+val.name+'</a>'+
					'<span class="label bg-pending" id="status_id1">Pending</span>'+
					'<br><br>'+

					'<div class="switch-toggle switch-3 switch-ios">'+

					'<input id="c_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="1">'+
					'<label class="blue" for="c_'+val.reg_date+'">Accept</label>'+
					
					'<input id="d_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" disabled value="3" checked>'+
					'<label class="red" for="d_'+val.reg_date+'" onclick="">Pending</label>'+
					
					'<input id="e_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="2">'+
					'<label class="green" for="e_'+val.reg_date+'" onclick="">Reject</label>';
					}
						if(val.doc_status_id=='2'){
					sOut +='<li><a class="bton btn-dwn" href="#">'+
					'<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;'+val.name+'</a>'+
					'<span class="label bg-reject" id="status_id1">Rejected</span>'+
					'<br><br>'+

					'<div class="switch-toggle switch-3 switch-ios">'+
					
					'<input id="c_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="1">'+
					'<label class="blue" for="c_'+val.reg_date+'">Accept</label>'+
					
					'<input id="d_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" disabled value="3">'+
					'<label class="red" for="d_'+val.reg_date+'" onclick="">Pending</label>'+
					
					'<input id="e_'+val.reg_date+'" class="'+val.drv_doc_upload_id+'" name="as'+val.drv_doc_upload_id+'" type="radio" value="2" checked>'+
					'<label class="green" for="e_'+val.reg_date+'" onclick="">Reject</label>';
						}
          
					sOut += '</div>'+
					'</li>'+
					'</div></ul></td> </tr>';
					
					}
					
			})
			return sOut;
		
		}	
	
    </script> 
    
    
     
<!--end theme js-->
  
