<form class="form-horizontal form" action="<?=site_url('account/update')?>" method="post">
<input type="hidden" name="old_userid"/>
<input type="hidden" name="old_email"/>
<input type="hidden" name="old_nickname"/>
<input type="hidden" name="account_id"/>
<input type="hidden" name="action" value="update_account"/>
<div class="response"></div>
        <fieldset class="fields">
       
          <div class="control-group">
            <label class="control-label">Display Name</label>
            <div class="controls docs-input-sizes">
              <input class="input-medium" name="nickname" type="text">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label">User ID</label>
            <div class="controls docs-input-sizes">
              <input class="input-medium" name="userid"type="text">
            </div>
          </div>
 
          <div class="control-group">
            <label class="control-label">E-mail Address</label>
            <div class="controls docs-input-sizes">
              <input class="input-medium"  type="text" name="email">
            </div>
          </div>
          
          
          <div class="control-group">
            <label class="control-label" for="prependedInput">Gender</label>
            <div class="controls">
              <div class="input-prepend">
                <select class="span2">
                <option class="M">Male</option>
                <option class="F">Female</option>

              </select>
              </div>
            </div>
          </div>
          
          <!--
          <div class="control-group">
            <label class="control-label" for="appendedInput">Credits</label>
            <div class="controls">
              <div class="input-append">
                <input class="span2" id="appendedInput" size="16" type="text"><span class="add-on">.00</span>
              </div>
            </div>
          </div>
          -->
           <div class="control-group">
            <label class="control-label" for="appendedInput">Account Level</label>
            <div class="controls">
              <div class="input-append">
                <input class="span2" id="appendedInput" size="16" type="text" name="group_id">
              </div>
            </div>
          </div>
           
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </fieldset>
      </form>
