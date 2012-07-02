<div class="modal" id="view">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3 class="mtitle"></h3>
  </div>
  <div class="modal-body">
    <ul class="tab nav nav-tabs">
		<li class="active" onclick="$('.btnSave').hide();"><a href="#">Account</a></li>
		<li><a href="#" onclick="$('.btnSave').hide();">Characters</a></li>
		<li><a href="#" onclick="$('.btnSave').hide();">Account Storage</a></li>
		<li><a href="#" onclick="$('.btnSave').show();">Modify</a></li>
	</ul>
	<div class="tpane pactive">
		<table class="flexme">
				<thead>
					<tr>
						<th width="100" colspan="2"></th>
						<th width="300" colspan="2"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="120"><span style="padding: 0 20px 0 0">Display Name</span></td>
						<td width="400"><div  class="nickname"></div></td>
					</tr>
					<tr>
						<td width="120">User Name</td>
						<td><div  class="userid"></div></td>
					</tr>
					<tr>
						<td width="120">Gender</td>
						<td><div  class="sex"></div></td>
					</tr>
					<tr>
						<td width="120">Birth Date</td>
					
						<td><div  class="birthdate"></div></td>
			
					</tr>
					<tr>
						<td width="120">Last IP</td>
						<td><div  class="last_ip"></div></td>
					</tr>
					<tr>
						<td width="120">Last Login</td>
						<td><div  class="lastlogincge"></div></td>
					</tr>
				</tbody>
			</table>
	</div>
	
	<div class="tpane">
		<table class="characters"></table>
	</div>
	
	<div class="tpane">
		<table class="storageFlex"></table>
	</div>
	
	<div class="tpane">
		
		<?php $this->load->view('account/modify')?>
		
	</div>
    
    
  </div>
  <div class="modal-footer">
	<button class="btn btn-primary btnSave" style="display: none;" onclick="$('.updateAccount').trigger('click');">Save Changes</button>
    <a href="#" class="btn" onclick="$('#view').modal('hide');">Close</a>
  </div>
</div>
