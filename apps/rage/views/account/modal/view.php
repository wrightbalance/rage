<div class="modal" id="view">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3 class="mtitle"></h3>
  </div>
  <div class="modal-body">
    <ul class="tab nav nav-tabs">
		<li class="active"><a href="#">Characters</a></li>
		<li><a href="#">Account Storage</a></li>
		<li><a href="#">Action</a></li>
	</ul>
	<div class="tpane pactive">
		
		<table class="table table-bordered table-striped">
		  <thead>
			  <tr>
				<th>Char ID</th>
				<th>Slot</th>
				<th>Name</th>
				<th>Job</th>
				<th>Level</th>
			  </tr>
			</thead>
			<tbody class="loadchar">
			  
			</tbody>
		</table>
		
	</div>
	
	<div class="tpane">
		<table class="table table-bordered table-striped">
		  <thead>
			  <tr>
				<th>Slot</th>
				<th>Name</th>
				<th>Job</th>
				<th>Level</th>
			  </tr>
			</thead>
			<tbody class="loadchar">
			  <tr>
				<td>1</td>
				<td>Name</td>
				<td>Sura</td>
				<td>99/70</td>
			  </tr>
		   
			</tbody>
		</table>
	</div>
	
	<div class="tpane">
		
	</div>
    
    
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="$('#view').modal('hide');">Close</a>
  </div>
</div>
