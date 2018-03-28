var gwsh = {};

gwsh.init = function() {
	$('.select-product').on('click', gwsh.selectProduct);
	$('.edit-product').on('click', gwsh.editProductSelection);
	
	// Product post save or update
	$("#post").on('submit', function(event) {	
		//Set the title of the post to the title of the product
		if($("#title").val() !== $("#gwsh_select_product option:selected").val()) {
			gwsh.setTitle();
		}
		//If we don't have a product id stored in the hidden field, it's likely the user
		// didn't select a product from the dropdown. Prompt them to select.
		if($("#gwsh_product_id").val() === "") {
			alert('You need to select a product.');
			return false; //Prevent the form from submitting.
		}
	});

	//'Add Row' button event listener
	$('a[data-event="add-row"]').on('click',function() {
		var $el = $(this);
		var variants = $.parseJSON($("#gwsh_product_variants").val());
		var $field = acf.get_closest_field( $el, 'repeater' ); // ACF magic
		var $select = $field.find('.acf-input > select');
		//On a new Product, when you click 'Add Row' the first time
		// an empty <select> field will be added to the page. We need to
		// populate it with the variants as <option> fields.
		// We only need to do this once because the next row 
		// (when 'Add Row' is clicked) will be 'cloned' by ACF.
		if($select.length == 1 && $select.find('option').length == 0) {
			for(var i=0; i< variants.length; i++) {
				$select.append($('<option>',{
					value: variants[i].product_id + "_" + variants[i].id,
					text: variants[i].title
				}));
			}
		}
	});
}


gwsh.editProductSelection = function() {
	//Enable the select field
	$("#gwsh_select_product").prop("disabled", false);

	//Switch to an 'Edit' button
	$(this)
		.off()
		.removeClass('edit-button')
		.addClass('select-button')
		.attr('aria-label','Select product')
		.text('Select')
		.on('click', gwsh.selectProduct);
}

gwsh.selectProduct = function() {
	var $selected = $("#gwsh_select_product option:selected");

	$("#gwsh_product_id").val($selected.data('id'));
	$("#gwsh_product_title").val($selected.val());

	if($selected.val() != "") {
		gwsh.setTitle($selected.val());

		//Switch to an 'Edit' button
		$(this)
			.off()
			.removeClass('select-button')
			.addClass('edit-button')
			.attr('aria-label','Edit product')
			.text('Edit')
			.on('click', gwsh.editProductSelection);

		//Use AJAX to make an API call to get the
		// product variants
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			async: false,
			cache: false,
			data: {
				action: 'gwsh_get_product_variants',
				productID: $("#gwsh_product_id").val()
			},

			// Send the variants back to the page
			success: function(response) {

				var data = $.parseJSON(response);
				var variants = [];
				for(var i=0; i < data.length; i++) {
					variants[i] = { 
						id: data[i].id, 
						product_id: data[i].product_id,
						title: data[i].title
					};
				}
				
				//Store them in the hidden field for saving
				$("#gwsh_product_variants").val(JSON.stringify(variants));
			}
		});
	}
}

gwsh.setTitle = function(selected) {
	$('#title-prompt-text').addClass('screen-reader-text');
	$("#title").val(selected);
	$("#gwsh_select_product").prop("disabled", true);
}

$(document).ready(function() {
  gwsh.init();
});