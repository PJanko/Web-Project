$("#radio-group").click(function()
	{
    if($('#oui').is(':checked')) {
    	if($( ".contest_input" ).length == 0){
    	$( "#submit" ).before( "<input class='contest_input' name='data[Contest][name]' type='text' placeholder='Nom du Championnat'>");
		$( "#submit" ).before('<input class="contest_input" name="data[Contest][type]" type="text" placeholder="Type de Championnat">');
		$( "#submit" ).before('<input class="contest_input" name="data[Contest][description]" type="text" placeholder="Description">');
		}
    } else {
		$( ".contest_input" ).remove();
    }
});

