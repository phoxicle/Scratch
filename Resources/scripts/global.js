// desk menu helpers

function show(s)
{
	s.firstChild.firstChild.style.visibility="visible";
	document.getElementById("label").innerHTML = s.firstChild.firstChild.alt;

}

function hide(s)
{	
	s.firstChild.firstChild.style.visibility="hidden";
	document.getElementById("label").innerHTML = "";
}


$(document).ready(function() {
	var origId = null;
	var editId = null;
	
	$('.editable').dblclick(function() {
		$(editId).addClass('hide');
		$(origId).removeClass('hide');
	
		origId = '#'+$(this).attr('id');
		editId = origId+'_edit';
		
		if($(editId).length > 0){
			$(origId).addClass('hide');
			$(editId).removeClass('hide');
			var firstInput = $(editId+' input[type=text]').get(0);
			if(!firstInput){
				firstInput = $(editId+' textarea').get(0);
			}
			firstInput.focus();
		}
	});
	
	$(document).keyup(function(event) {
		if (event.keyCode == 27) {
			$(editId).addClass('hide');
			$(origId).removeClass('hide');
		}
	});
	

});


