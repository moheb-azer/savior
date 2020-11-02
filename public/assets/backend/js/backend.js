$(function() {

	//Hide Placeholder On Focus Input
	$(document).on('focus', '[placeholder]', function() {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).on('blur', '[placeholder]', function() {
		$(this).attr('placeholder', $(this).attr('data-text'));
	})

    //Make Input Value Float Type
    $(document).on('blur', '.pay', function() {
        if($(this).val() !== ""){
            let val = parseInt($(this).val());
            $(this).val(val.toFixed(2));
        }
    })
})


