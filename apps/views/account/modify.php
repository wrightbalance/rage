<form class="form-horizontal">
        <fieldset>
       
          
          <div class="control-group">
            <label class="control-label">User ID</label>
            <div class="controls docs-input-sizes">
				<!--
              <input class="input-mini" type="text" placeholder=".input-mini">
              <input class="input-small" type="text" placeholder=".input-small">
              -->
              <input class="input-medium" name="userid"type="text">
            </div>
          </div>
          
            <div class="control-group">
            <label class="control-label">Password</label>
            <div class="controls docs-input-sizes">
				<!--
              <input class="input-mini" type="text" placeholder=".input-mini">
              <input class="input-small" type="text" placeholder=".input-small">
              -->
              <input class="input-medium" type="text" name="">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="prependedInput">E-mail Address</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">@</span><input class="span2" id="prependedInput" size="16" type="text" name="email	">
              </div>
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
            <label class="control-label" for="appendedInput">Level</label>
            <div class="controls">
              <div class="input-append">
                <input class="span2" id="appendedInput" size="16" type="text">
              </div>
            </div>
          </div>

          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button class="btn">Cancel</button>
          </div>
        </fieldset>
      </form>
