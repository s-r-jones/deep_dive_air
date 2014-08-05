$(document).ready(function()
{
    // login page form validation
    $("#loginForm").validate(
    {
        rules:
        {
            loginEmail:
            {
                email: true,
                required: true
            },
            loginPassword:
            {
                required: true
            }
        },
        
        messages:
        {
            loginEmail: "Please enter a valid email.",
            loginPassword: "Please enter a valid password."
        },
        
        submitHandler: function(form)
        {
            $(form).ajaxSubmit(
            {
                type: "POST",
                url: "php/login_validation.php",
                success: function(ajaxOutput)
                {
                    $("#loginOutputArea").html(ajaxOutput);
                }
            });
        }
    });
    
    // sign up page form validation
    $("#signUpForm").validate(
    {
        rules:
        {
            firstName:
            {
                pattern: /^[^";@#\$&\*]+$/,
                required: true
            },
            lastName:
            {
                pattern: /^[^";@#\$&\*]+$/,
                required: true
            },
            contactEmail:
            {
                email: true,
                required: true
            },
            signUpPhoneNumber:
            {
                required: true
            },
            signUpPassword:
            {
                pattern: /^[^";@#\$&\*]+$/,
                required: true,
                minlength: 8
            },
            confirmSignUpPassword:
            {
                required: true,
                equalTo: "#signUpPassword"
            },
        },
        
        messages:
        {
            firstName:
            {
                pattern: "Illegal characters detected",
                required: "Please enter your first name"
            },
            lastName:
            {
                pattern: "Illegal characters detected",
                required: "Please enter your last name."
            },
            contactEmail: "Please enter a valid email.",
            signUpPhoneNumber:
            {
                pattern: "Illegal characters detected",
                required: "Please enter your phone number."
            },
            signUpPassword:
            {
                pattern: "No spaces or special characters allowed",
                required: "Please enter a valid password",
                minlength: "Password needs to be at least 8 characters long"
            },
            confirmSignUpPassword:
            {
                required: "Please confirm password.",
                equalTo: "Password does not match."
            },
        },
        
        submitHandler: function(form)
        {
            $(form).ajaxSubmit(
            {
                type: "POST",
                url: "php/sign_up_validation.php",
                success: function(ajaxOutput)
                {
                    $("#signUpOutputArea").html(ajaxOutput);
                }
            });
        }
        
    });
    
    // search page form validation
    $("#searchForm").validate(
    {
        rules:
        {
            searchFrom:
            {
                required: true,
                maxlength: 3,
                minlength: 3
            },
            searchTo:
            {
                required: true,
                maxlength: 3,
                minlength: 3
            },
        },
        
        messages:
        {
            searchFrom:
            {
                required: "Please enter a departing destination.",
                maxlength: "Please enter airport code. Example: (ABQ)",
                minlength: "Please enter airport code. Example: (ABQ)"
            },
            searchTo:
            {
                required: "Please enter a arriving destination.",
                maxlength: "Please enter airport code. Example: (LAX)",
                minlength: "Please enter airport code. Example: (LAX)"
            },
        },
        
        submitHandler: function(form)
        {
            $(form).ajaxSubmit(
            {
                type: "POST",
                url: "txt/search.txt",
                data: $(form).serialize(),
                success: function(ajaxOutput)
                {
                    $("#searchOutputArea").html(ajaxOutput);
                }
            });
        }
    });
    
    // jquery form styles
    
    //hide forms
    $("form").hide();
    
    // fade in forms when loaded
    $("form").ready(function()
    {
        $("form").fadeIn();
    });
    
    // hide ouput areas
    $(".outputArea").hide();
    
    // fade in output area messages
    $("button").click(function()
    {
        $(".outputArea").fadeIn();
    });
});







