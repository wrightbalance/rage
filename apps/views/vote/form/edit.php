<form class="form-horizontal form formnews" method="post" action="<?=site_url('vote/post')?>">
<input type="text" style="display:none" name="id" value=""/>
		<div class="response"></div>
        <fieldset class="fields">
			
          <div class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="name" name="name">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="hours">Interval</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="hours" name="hours" value="12">
            </div>
          </div>
          
           <div class="control-group">
            <label class="control-label" for="credits">Credits</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="credits" name="credits" value="0">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="credits">Vote URL</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="vote_url" name="vote_url">
            </div>
          </div>
		
		  <div class="control-group">
            <label class="control-label" for="image_url">Image URL</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="image_url" name="image_url">
            </div>
          </div>
   

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </fieldset>
      </form>
