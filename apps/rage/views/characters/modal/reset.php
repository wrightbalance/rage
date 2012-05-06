<div class="modal" id="reset" style="margin-top: -20%">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Reset Character</h3>
  </div>
  <div class="modal-body">
    <div class="message">
	</div>
	<input type="hidden" name="char_id" value=""/>
	<input type="hidden" name="action" value=""/>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn close_nevermind" onclick="$('#reset').modal('hide'); $('select[name=reset]').val('')">Nevermind</a>
    <a href="#" class="btn close_reset" onclick="$('#reset').modal('hide'); $('select[name=reset]').val('')" style="display: none">Close</a>
    <a href="#" class="btn btn-primary close_confirm" id="confirm_reset">Yes reset it now</a>
  </div>
</div>
