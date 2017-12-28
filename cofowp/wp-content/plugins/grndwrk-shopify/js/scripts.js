$("#post").on('submit', function(event) {
	
	if($("#title").val() !== $("#gwsh_product_title option:selected").text()) {
		$("#title").val($("#gwsh_product_title option:selected").text());
	}
	if($("#gwsh_product_id").val() === "") {
		$('#title-prompt-text').addClass('screen-reader-text');
		$("#gwsh_product_id").val($("#gwsh_product_title option:selected").data('id'));
	}

});

$("#gwsh_product_title").on('change', function() {
	$("#gwsh_product_id").val($("#gwsh_product_title option:selected").data('id'));
});