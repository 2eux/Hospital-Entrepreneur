jQuery.fn.uniform = function(settings) {
  settings = jQuery.extend({
    valid_class    : 'valid',
    invalid_class  : 'invalid',
    focused_class  : 'focused',
    holder_class   : 'ctrlHolder',
    field_selector : 'input, select, textarea'
  }, settings);
  
  return this.each(function() {
    var form = jQuery(this);
    
    // Focus specific control holder
    var focusControlHolder = function(element) {
      var parent = element.parent();
      
      while(typeof(parent) == 'object') {
        if(parent) {
          if(parent[0] && (parent[0].className.indexOf(settings.holder_class) >= 0)) {
            parent.addClass(settings.focused_class);
            return;
          } // if
        } // if
        parent = jQuery(parent.parent());
      } // while
    };
    
    // Select form fields and attach them higlighter functionality
    form.find(settings.field_selector).focus(function() {
      form.find('.' + settings.focused_class).removeClass(settings.focused_class);
      focusControlHolder(jQuery(this));
    }).blur(function() {
      form.find('.' + settings.focused_class).removeClass(settings.focused_class);
    });
  });
};

// Auto set on page load...
$(document).ready(function() {
  jQuery('form.uniForm').uniform();

  $("#register").validate({
	debug: false,
	invalidHandeler: function(form, validator) {
		alert(validator.numberofInvalids());
		alert(validator.showErrors());
	},
	rules: {
		user_name: { required: true, minlength: 4, remote: "/index.php/skipauth/username" },
		hospital_name: { required: true, minlength: 5, remote: "/index.php/skipauth/hospital_name" },
		email: { required: true, email: true },
		password: { required: true, minlength: 8 },
		repeat_password: { required: true, minlength: 8, equalTo: "#password" }
	},
	// the errorPlacement has to take the table layout into account
	errorPlacement: function(error, element) {
			//alert("Error:" + error);
			element.removeClass("error");
			element.parent().addClass("error");
			element.parent().find(".formHint").html("<p id='error_text'>" + error.text() + "</p><br />");
		},

	messages: {
		hospital_name: {
			required: "Enter a username",
			minlength: jQuery.format("Enter at least {0} characters"),
			remote: jQuery.format("{0} is already in use")
		},
		username: {
			required: "Enter a username",
			minlength: jQuery.format("Enter at least {0} characters"),
			remote: jQuery.format("{0} is already in use")
		},
		password: {
			required: "Provide a password",
			rangelength: jQuery.format("Enter at least {0} characters")
		},
		repeat_password: {
			required: "Repeat your password",
			minlength: jQuery.format("Enter at least {0} characters"),
			equalTo: "Enter the same password as above"
		},
		email: {
			required: "Please enter a valid email address",
			minlength: "Please enter a valid email address",
			remote: jQuery.format("{0} is already in use")
		},
		terms: " "
	}
  });	

});



