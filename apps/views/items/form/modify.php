<form class="form-horizontal form formnews" method="post" action="<?=site_url('items/post')?>">
	<input type="text" style="display:none" name="id" value=""/>
	<div class="response"></div>
	<fieldset class="fields">
		
		<div class="control-group">
			<label class="control-label" for="input01">Name</label>
			<div class="controls">
			  <input type="text" class="input-xlarge" id="title" name="title">
			</div>
		</div>

		<div class="control-group">
		<label class="control-label" for="select01">Type</label>
			<div class="controls">
			  <select id="category" name="category">
					<option value="">-Category-</option>
					<option value="news">News</option>
					<option value="changelog">Change Log</option>
					<option value="Events">Events</option>
			  </select>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="textarea">Description</label>
			<div class="controls">
				<textarea class="input-xlarge" style="height: 100px; width: 400px" id="body" name="body" rows="3"></textarea>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="input01">Worth</label>
			<div class="controls">
			 <input type="text" class="input-xlarge" id="title" name="title" style="width: 120px;" value="0"> (For donation)
			</div>
		</div>
		
		<div class="control-group">
            <label class="control-label" for="status">Donation Item?</label>
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" id="status" name="status" value="1" checked="checked">
                Check if you want to tag as donation item.
              </label>
            </div>
          </div>
		
		<div class="control-group">
			<label class="control-label" for="input01">Buy</label>
			<div class="controls">
			 <input type="text" class="input-xlarge" id="title" name="title" style="width: 120px;" value="0">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="input01">Sell</label>
			<div class="controls">
			 <input type="text" class="input-xlarge" id="title" name="title" style="width: 120px;" value="0">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="input01">Weight</label>
			<div class="controls">
			  <input type="text" class="input-xlarge" id="title" name="title" style="width: 120px;" value="0">
			</div>
		</div>
		

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save changes</button>
		</div>
	</fieldset>
</form>
