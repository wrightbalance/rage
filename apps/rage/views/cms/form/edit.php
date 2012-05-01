<form class="form-horizontal form formnews" method="post" action="<?=site_url('cms/post')?>">
<input type="text" style="display:none" name="_id" value=""/>
		<div class="response"></div>
        <fieldset class="fields">
          <div class="control-group">
            <label class="control-label" for="input01">News Title</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="news_title" name="news_title">
            </div>
          </div>
       
          <div class="control-group">
            <label class="control-label" for="select01">Category</label>
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
            <label class="control-label" for="textarea">News Body</label>
            <div class="controls">
              <textarea class="input-xlarge edit" id="news_body" name="news_body" rows="3"></textarea>
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
