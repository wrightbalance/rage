<form class="form-horizontal form formpage" method="post" action="<?=site_url('cms/post_page')?>">
<input type="text" style="display:none" name="_id" value=""/>
		<div class="response"></div>
        <fieldset class="fields">
          <div class="control-group">
            <label class="control-label" for="page_title">Page Title</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="page_title" name="page_title">
            </div>
          </div>

 
          <div class="control-group">
            <label class="control-label" for="page_body">Page Content</label>
            <div class="controls">
              <textarea class="input-xlarge edit" id="page_body" name="page_body" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="publish">Publish?</label>
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" id="publish" name="publish" value="1" checked="checked">
                Check if you want to publish this post.
              </label>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </fieldset>
      </form>
