<?php
/**
 * Template Name: Custom Template
 */
?>
<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery.inputmask.js"></script>
<?php get_template_part('templates/page', 'header'); ?>
<?php //while (have_posts()) : the_post(); ?>
<?php //endwhile; ?>
<?php get_template_part('templates/content', 'page'); ?>

<div class="container">
    <div class="row contact_form">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="font-30 section-title">Create a new OneSource account</h1>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <div class="input-group">
                        <input id="SubscriptionType" name="SubscriptionType" type="hidden" value="1" tabindex="2">
                        <input data-val="true" data-val-required="The IsTrial field is required." id="IsTrial"
                               name="IsTrial" type="hidden" value="False" tabindex="3">
                        <input autocomplete="off" class="textsignup form-control WidthValue text-box single-line"
                               required
                               data-val="true" data-val-required="Please enter a company name." id="txtCompanyName"
                               name="CompanyName" onchange="CompanyNameValidation()" placeholder="Company name"
                               tabindex="4"
                               type="text" value="">
                    </div>
                    <span class="field-validation-valid text-danger" data-valmsg-for="CompanyName"
                          data-valmsg-replace="true" id="txtCompanyName_span"></span>
                    <span class="field-validation-error text-danger" style="display:none" id="SpanCompanyName">This Company name is already in use.  Please enter another Company name. </span>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <div class="input-group">
                        <input autocomplete="off" class="textsignup form-control WidthValue text-box single-line"
                               data-val="true" data-val-required=" Please enter contact full name."
                               required
                               id="txtCompanyContactName" name="CompanyContactName" placeholder="Contact name"
                               type="text" value="" tabindex="5">
                    </div>
                    <span class="field-validation-valid text-danger" data-valmsg-for="CompanyContactName"
                          data-valmsg-replace="true" id="txtCompanyContactName_span"></span>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <div class="input-group">
                        <input class="textsignup form-control WidthValue text-box single-line" data-val="true"
                               data-val-phone="The PhoneNumber field is not a valid phone number."
                               required
                               data-val-required="Please enter a phone number." id="txtPhoneNumber" name="PhoneNumber"
                               placeholder="Phone" type="tel" value="" tabindex="6">
                    </div>
                    <span class="field-validation-valid text-danger" data-valmsg-for="PhoneNumber"
                          data-valmsg-replace="true" id="txtPhoneNumber_span"></span>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <div class="input-group">
                        <input autocomplete="new-password"
                               class="textsignup form-control WidthValue text-box single-line" data-val="true"
                               data-val-email="Please enter a valid email address."
                               required
                               data-val-required="Please enter the email address." id="txtEmailAddress"
                               name="EmailAddress" onchange="CompanySignUpValidation()" placeholder="Email address"
                               type="email" value="" tabindex="7" data-original-title="" title="">
                    </div>
                    <span class="field-validation-valid text-danger" data-valmsg-for="EmailAddress"
                          data-valmsg-replace="true" id="txtEmailAddress_span"></span>
                    <span class="field-validation-error text-danger" style="display:none" id="spanEmail">
                            <strong>This email address is already in use.  You can try another email address or <a
                                        href="https://www.osqbo.com" class="btnclick"> Login</a> or
                                <a href="https://www.osqbo.com/Home/CreateAnotherCompany"
                                   class="btnclick"
                                   style="cursor:pointer">Create another company.</a>
                            </strong>
                        </span>
                    <span id="txtEmailAddress_spanvalid" class="text-danger"></span>
                    <span id="#txtEmailAddress_span" class="text-danger"></span>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <div class="input-group">
                        <input autocomplete="new-password" class="textsignup form-control text-box single-line password"
                               data-val="true" data-val-length="Use 10 or more characters and no spaces."
                               data-val-length-max="100" data-val-length-min="10"
                               required
                               data-val-regex="Use 10 or more characters and no spaces."
                               data-val-regex-pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{10,})"
                               data-val-required="Please enter a password." id="txtPassword" name="Password"
                               placeholder="Password" type="password" value="" tabindex="9" data-original-title=""
                               title="">
                        <span class="input-group-addon toggle-password"
                              style="position: relative;height: 50px;width: 44px;"><i class="fa fa-lock"></i></span>
                    </div>
                    <span class="field-validation-valid text-danger" data-valmsg-for="Password"
                          data-valmsg-replace="true" id="txtPassword_span"></span>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div float-right">
                    <div class="form-group">
                        <div id="recapchaWidget" class="g-recaptcha"></div>
                    </div>
                    <span class="field-validation-valid text-danger" data-valmsg-replace="true"
                          id="CaptchaCode_span"></span>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <input id="btnsignup" type="submit" value="CREATE ACCOUNT" class="green--btn btnsignup float-right">
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-sm-8 center_div">
                    <div class="bottom-links">
                        <p>Already have a OneSource account?
                            <a href="https://osqbo.com">Sign in</a>
                        </p>
                        <p>You want to add one more company?
                            <a href="https://osqbo.com/Home/CreateAnotherCompany?PricingType=1" style="cursor:pointer">Add Another
                                Company.</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="passwordpopover_content" style="display:none">
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td>
                        <span id="txt_length_error" class="txt_length_error">
                            <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                            Use 10 or more characters
                        </span>
                        <span id="txt_length_success" class="txt_length_success" style="display:none">
                                <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                                Use 10 or more characters
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="txt_Ucase_error" class="txt_Ucase_error">
                            <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                            Use upper case (e.g. ABC)
                        </span>
                        <span id="txt_Ucase_success" class="txt_Ucase_success" style="display:none">
                                <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                                Use upper case (e.g. ABC)
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="txt_Lcase_error" class="txt_Lcase_error">
                            <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                            Use lower case (e.g. abc)
                        </span>
                        <span id="txt_Lcase_success" class="txt_Lcase_success" style="display:none">
                            <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                            Use lower case (e.g. abc)
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="txt_numb_error" class="txt_numb_error ">
                            <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                            Use a number (e.g. 1234)
                        </span>
                        <span id="txt_numb_success" class="txt_numb_success" style="display:none">
                            <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                            Use a number (e.g. 1234)
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="txt_spl_error" class="txt_spl_error ">
                            <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                            Use a symbol (e.g. @!#$)
                        </span>
                        <span id="txt_spl_success" class="txt_spl_success" style="display:none">
                            <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                            Use a symbol (e.g. @!#$)
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="confirmpassword_popovercontent" style="display:none">
    <div class="container">
        <table>
            <tbody>
            <tr>
                <td>
                        <span class="txtconfirmpassword_equal_error">
                            <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                            Your Passwords do not match.
                        </span>
                    <span class="txtconfirmpassword_equal_valid" style="display:none">
                            <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                            Password matched
                        </span>
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="Email_popovercontent" class="" style="display:none">
    <div class="container">
        <table>
            <tbody>
            <tr>
                <td>
                    <span class="txtemail_error">
                        <i class="fa fa-times padright5" style="color:#FF0000;"></i>
                        Email address not valid
                    </span>
                    <span class="txtemail_valid" style="display:none">
                        <i class="fa fa-check padright5" style="color:#32CD32;"></i>
                        Email address valid
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
<div id="Signin_popovercontent" class="" style="display:none">
    <div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Already have an account?
            </div>
            <div class="panel-body">
                <div class="form-control">
                    <input class="form-control" placeholder="EmailID" tabindex="16">
                </div>
                <div class="form-control">
                    <input class="form-control" placeholder="Password" tabindex="17">
                </div>
                <div class="form-control">
                    <button class="btn btn-success">Login</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Loading_modal" role="dialog">
    <div class="modal-dialog" id="loading_img">
        <img src="/Content/images/gears.svg">
    </div>
</div>
<div id="ConfirmAlertForCreateAnotherCompany" class="modal fade">
    <div class="modal-dialog" style="margin-top:30vh">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="">Confirmation</h4>
                    </div>
                    <div class="panel-body">
                        <p>Do you want to create another company, that you can log in to using the same email
                            address?</p>
                    </div>
                    <div class="panel-footer" style="text-align:right">
                        <button type="button" class="btn btn-danger pull-left" onclick="btnNoCreateAnotherCompany()">
                            No
                        </button>
                        <button type="button" class="btn btn-success" onclick="CreateAnotherCompanyCall()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popupModal" class="modals">
    <div class="modal-contents">
         <div class="modal-body">
            <p class="message_text"></p>
            </div>
        </div>
    </div>
<div style="display: none;" id="loader-wrapper">
    <div id="loader"></div>
</div>
<script>

    jQuery(function () {
        var IsEmailvalid = false;
        var tabindexValue = 0;
        jQuery("#txtPhoneNumber").inputmask({"mask": "(999) 999-9999"});

        jQuery(".btnclick").click(function (e) {
            e.stopImmediatePropagation();
            jQuery("input").off("blur");
        });

        jQuery("input").each(function () {
            jQuery(this).attr("tabindex", (tabindexValue += 1));
        });

        jQuery("input").each(function () {
            if (jQuery(this).hasClass("input-validation-error")) {
                jQuery(this).focus();
                return false;
            }
            else {
                jQuery("#txtCompanyName").focus();
            }
        });

        //password validations
        jQuery("#txtPassword").on("keyup focus", function () {
            var text = jQuery("#txtPassword").val();
            var C_word = /[A-Z]+/g;
            var S_word = /[a-z]+/g;
            var numbers = /\d+/g;
            var symbol = /[^a-zA-Z0-9]+/g;
            if (text != "") {
                if (jQuery("#txtPassword").val().length > 9) {
                    jQuery(".txt_length_error").hide();
                    jQuery(".txt_length_success").show();
                } else {
                    jQuery(".txt_length_error").show();
                    jQuery(".txt_length_success").hide();
                }

                if (C_word.test(text)) {
                    //console.log("2")
                    jQuery(".txt_Ucase_error").hide();
                    jQuery(".txt_Ucase_success").show();
                } else {
                    jQuery(".txt_Ucase_error").show();
                    jQuery(".txt_Ucase_success").hide();
                }

                if (S_word.test(text)) {
                    jQuery(".txt_Lcase_error").hide();
                    jQuery(".txt_Lcase_success").show();
                }
                else {
                    jQuery(".txt_Lcase_error").show();
                    jQuery(".txt_Lcase_success").hide();
                }

                if (numbers.test(text)) {
                    jQuery(".txt_numb_error").hide();
                    jQuery(".txt_numb_success").show();
                } else {
                    jQuery(".txt_numb_error").show();
                    jQuery(".txt_numb_success").hide();
                }

                if (symbol.test(text)) {
                    jQuery(".txt_spl_error").hide();
                    jQuery(".txt_spl_success").show();
                } else {
                    jQuery(".txt_spl_error").show();
                    jQuery(".txt_spl_success").hide();
                }

            }
            else {
                jQuery(".txt_length_error").show();
                jQuery(".txt_Ucase_error").show();
                jQuery(".txt_Lcase_error").show();
                jQuery(".txt_numb_error").show();
                jQuery(".txt_spl_error").show();

                jQuery(".txt_length_success").hide();
                jQuery(".txt_Ucase_success").hide();
                jQuery(".txt_Lcase_success").hide();
                jQuery(".txt_numb_success").hide();
                jQuery(".txt_spl_success").hide();

            }
        });

        jQuery("#txtEmailAddress").on("keyup focus", function () {
            var email = jQuery("#txtEmailAddress").val();
            var symbol = /^[@]+$/;
            var Dot = /^[.]+$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/g;
            if (jQuery("#txtEmailAddress").val() != "") {
                if (emailReg.test(email)) {
                    jQuery(".txtemail_error").hide();
                    jQuery(".txtemail_valid").show();
                } else {
                    jQuery(".txtemail_error").show();
                    jQuery(".txtemail_valid").hide();
                }
            }
        });

        jQuery("#txtPassword").popover({
            placement: "right",
            trigger: "focus",
            html: true,
            content: jQuery('#passwordpopover_content').html()
        });

        jQuery("#txtEmailAddress").popover({
            placement: "right",
            trigger: "focus",
            html: true,
            content: jQuery("#Email_popovercontent").html()
        });

    });

    jQuery(document).ready(function () {
        var EmailExists = false;
        jQuery("#btnsignup").click(function () {
            var CompanyName = jQuery.trim(jQuery("#txtCompanyName").val());
            var ContactName = jQuery.trim(jQuery("#txtCompanyContactName").val());
            var Phone = jQuery.trim(jQuery("#txtPhoneNumber").val());
            var EmailAddress = jQuery.trim(jQuery("#txtEmailAddress").val());
            var Password = jQuery.trim(jQuery("#txtPassword").val());
            var CaptchaCode = grecaptcha.getResponse(widId);

            if (CompanyName == "") {
                jQuery("#txtCompanyName_span").html("Please enter a company name.");
            } else {
                jQuery("#txtCompanyName_span").html("");
            }
            if (ContactName == "") {
                jQuery("#txtCompanyContactName_span").html(" Please enter contact full name.");
            } else {
                jQuery("#txtCompanyContactName_span").html("");
            }
            if (Phone == "") {
                jQuery("#txtPhoneNumber_span").html("Please enter a phone number.");
            } else {
                jQuery("#txtPhoneNumber_span").html("");
            }
            if (EmailAddress == "") {
                jQuery("#txtEmailAddress_span").html(" Please enter the email address.");
            } else {
                jQuery("#txtEmailAddress_span").html("");
            }
            if (Password == "") {
                jQuery("#txtPassword_span").html("Please enter a password.");
            } else {
                jQuery("#txtPassword_span").html("");
            }
            if (CaptchaCode == "" || CaptchaCode == undefined || CaptchaCode.length == 0) {
                jQuery("#CaptchaCode_span").html("Verification expired. Check the checkbox again.");
            } else {
                jQuery("#CaptchaCode_span").html("");
            }
            if (CompanyName && ContactName && Phone && EmailAddress && Password && CaptchaCode) {
                jQuery("#loader-wrapper").show();
                var url = 'https://osqbo.com/home/SignupCompany';
                jQuery.post(url, {
                    CompanyName: CompanyName,
                    ContactName: ContactName,
                    Phone: Phone,
                    Email: EmailAddress,
                    Password: Password
                }, function (data) {
                    jQuery("#loader-wrapper").hide();
                    console.log(data);
                    jQuery(".message_text").text('');
                    if (data && data.IsCompanyCreated == true) {
                        jQuery("#txtCompanyName").val('');
                        jQuery("#txtCompanyContactName").val('');
                        jQuery("#txtPhoneNumber").val('');
                        jQuery("#txtEmailAddress").val('');
                        jQuery("#txtPassword").val('');
                        jQuery(".message_text").html("Thank you for signing up with OneSource Software<br>\n" +
                            "An activation link has been sent to your email address.<br>\n" +
                            "Please click on the activation link provided in the email.<br>\n" +
                            "If you don't see the email, please check your spam or junk mail folder.");
                        window.location.reload(true);
                    } else {
                        jQuery(".message_text").text(data.ErrorMessage);
                    }
                    dialogOpen();
                });

            }
        });

        jQuery(document).keypress(function (e) {
            if (e.which == 13) {
                var IDValue = e.target.id;
                var CurrenttabIndex = jQuery("#" + IDValue).attr('tabindex')
                if (CurrenttabIndex != 0 || CurrenttabIndex != "" || CurrenttabIndex != undefined) {
                    CurrenttabIndex = parseInt(CurrenttabIndex) + 1;
                    jQuery('input[tabindex=' + CurrenttabIndex + ']').focus();
                }
                if (CurrenttabIndex == 12) {
                    jQuery("#captcha-input").focus();
                }
                if (CurrenttabIndex == 15) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    jQuery("#btnsignup").focus();
                }
                if (CurrenttabIndex == 16) {
                    jQuery("#btnsignup").submit();
                }
                if (e.which == 13 && CurrenttabIndex != 16) {
                    return false
                }
            }
        });

        jQuery(".toggle-password").click(function () {
            jQuery(this).children().toggleClass("fa-lock fa-unlock");
            var input = jQuery("#txtPassword");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

    });

    jQuery(function () {
        jQuery("input").change(function (event) {
            var validationtext = "";
            var ElementID = jQuery(this).prop("id");
            console.log(ElementID);
            if (!(jQuery(event.relatedTarget).hasClass("btnsignup"))) {
                if (jQuery.trim(jQuery(this).val()) == "") {
                    switch (ElementID) {
                        case "txtCompanyName":
                            validationtext = "Please enter a company name.";
                            break;
                        case "txtCompanyContactName":
                            validationtext = "Please enter contact full name.";
                            break;
                        case "txtPhoneNumber":
                            validationtext = "Please enter a phone number.";
                            break;
                        case "txtEmailAddress":
                            validationtext = "Please enter the email address.";
                            break;
                        case "txtUserName":
                            validationtext = "Please enter user name.";
                            break;
                        case "txtPassword":
                            validationtext = "Please enter a password.";
                            break;
                    }
                    if (validationtext != "") {
                        jQuery("#" + ElementID + "_span").text(validationtext);
                        jQuery("#" + ElementID + "_span").focus();
                        jQuery("#" + ElementID + "_span").addClass("input-validation-error")
                    }
                }
                else if (jQuery.trim(jQuery(this).val()) != "") {

                    if (ElementID == "txtEmailAddress") {
                        var email = jQuery("#txtEmailAddress").val();
                        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/g;
                        if (email != "") {
                            if (emailReg.test(email)) {
                                jQuery('#btnsignup').removeAttr('disabled');
                                jQuery("#txtEmailAddress_spanvalid").text('');
                                jQuery("#txtEmailAddress_spanvalid").removeClass("input-validation-error");
                                return true;
                            }
                            else {
                                jQuery('#btnsignup').attr('disabled', 'disabled');
                                jQuery("#txtEmailAddress_spanvalid").text('Please enter a valid email address.');
                                jQuery("#txtEmailAddress_spanvalid").addClass("input-validation-error");
                                return false
                            }
                        }
                        else {
                            jQuery("#txtEmailAddress_spanvalid").text('');
                            jQuery("#txtEmailAddress_spanvalid").removeClass("input-validation-error");
                        }
                    }
                    else if (ElementID == "txtPhoneNumber") {
                        var PhoneNumber = jQuery("#txtPhoneNumber").val();
                        PhoneNumber = PhoneNumber.replace(/[()_-\s]/g, "");
                        if (PhoneNumber.length < 10) {
                            jQuery('#btnsignup').attr('disabled', 'disabled');
                            jQuery("#" + ElementID + "_span").text('Please enter a 10 digit phone number');
                            jQuery("#" + ElementID + "_span").focus();
                            jQuery("#" + ElementID + "_span").addClass("input-validation-error");
                            return false
                        }
                        else {
                            jQuery('#btnsignup').removeAttr('disabled');
                            jQuery("#" + ElementID + "_span").text("");
                            jQuery("#" + ElementID + "_span").removeClass("input-validation-error")
                        }
                    }
                    else if (ElementID == "txtPassword") {
                        var Password = jQuery.trim(jQuery("#txtPassword").val());
                        var C_word = /[A-Z]+/g
                        var S_word = /[a-z]+/g
                        var numbers = /\d+/g
                        var symbol = /[^a-zA-Z0-9]+/g

                        if (Password.length < 10) {
                            jQuery('#btnsignup').attr('disabled', 'disabled');
                            jQuery("#" + ElementID + "_span").text("Use 10 or more characters");
                            jQuery("#" + ElementID + "_span").focus();
                            jQuery("#" + ElementID + "_span").addClass("input-validation-error");
                            return false
                        }
                        else if (!C_word.test(Password)) {
                            jQuery('#btnsignup').attr('disabled', 'disabled');
                            jQuery("#" + ElementID + "_span").text("Use upper case (e.g. ABC)");
                            jQuery("#" + ElementID + "_span").focus();
                            jQuery("#" + ElementID + "_span").addClass("input-validation-error");
                            return false
                        }
                        else if (!S_word.test(Password)) {
                            jQuery('#btnsignup').attr('disabled', 'disabled');
                            jQuery("#" + ElementID + "_span").text("Use lower case (e.g. abc)");
                            jQuery("#" + ElementID + "_span").focus();
                            jQuery("#" + ElementID + "_span").addClass("input-validation-error");
                            return false
                        }
                        else if (!numbers.test(Password)) {
                            jQuery('#btnsignup').attr('disabled', 'disabled');
                            jQuery("#" + ElementID + "_span").text("Use a number (e.g. 1234)");
                            jQuery("#" + ElementID + "_span").addClass("input-validation-error");
                            return false
                        }
                        else if (!symbol.test(Password)) {
                            jQuery('#btnsignup').attr('disabled', 'disabled');
                            jQuery("#" + ElementID + "_span").text("Use a symbol (e.g. @!#$)");
                            jQuery("#" + ElementID + "_span").focus();
                            jQuery("#" + ElementID + "_span").addClass("input-validation-error");
                            return false
                        }

                    }
                    else {
                        jQuery("#" + ElementID + "_span").text("");
                        jQuery("#" + ElementID + "_span").removeClass("input-validation-error");
                    }
                }
                else {
                    jQuery("#" + ElementID + "_span").text("");
                    jQuery("#" + ElementID + "_span").removeClass("input-validation-error")
                }
            }
        });
    });

    function EmailValidate() {
        var email = jQuery("#txtEmailAddress").val();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/g;
        if (email != "") {
            if (emailReg.test(email)) {
                jQuery("#txtEmailAddress_spanvalid").text('');
                jQuery("#txtEmailAddress_spanvalid").removeClass("input-validation-error");
                return true;
            }
            else {
                jQuery("#txtEmailAddress_spanvalid").text('Please enter a valid email address.');
                jQuery("#txtEmailAddress_spanvalid").addClass("input-validation-error");
                return false
            }
        }
        else {
            jQuery("#txtEmailAddress_spanvalid").text('');
            jQuery("#txtEmailAddress_spanvalid").removeClass("input-validation-error");
        }
    }

    function CompanyNameValidation() {
        if (jQuery("#txtCompanyName").val() != "") {
            var url = 'https://www.osqbo.com/Home/CompanySignUpValidation';
            jQuery.post(url, {
                Type: 'CompanyValidate',
                Values: jQuery("#txtCompanyName").val(),
                ExtraCondition: ""
            }, function (data) {
                if (data == "True") {
                    jQuery("#SpanCompanyName").css("display", "block");
                } else {
                    jQuery("#SpanCompanyName").hide();
                }
            });
        }
    }

    function CompanySignUpValidation() {
        if (EmailValidate()) {
            var url = 'https://www.osqbo.com/Home/CompanySignUpValidation';
            jQuery.post(url, {
                Type: 'EmailAddress',
                Values: jQuery("#txtEmailAddress").val(),
                ExtraCondition: ""
            }, function (data) {
                if (data == "True") {
                    jQuery("#spanEmail").css("display", "block");
                } else {
                    EmailExists = false;
                    jQuery("#spanEmail").hide();

                }
            })
        }
    }

    function CreateAnotherCompanyCall() {
        var companyname = jQuery("#txtCompanyName").val();
        var contactName = jQuery("#CompanyName").val();
        var phonenumber = jQuery("#PhoneNumber").val();
        var emailaddress = jQuery("#txtEmailAddress").val();
    }

    function CreateAnotherCompany() {
        jQuery("#ConfirmAlertForCreateAnotherCompany").modal();
    }

    function btnNoCreateAnotherCompany() {
        jQuery("#txtEmailAddress").val("").change();
        jQuery("#ConfirmAlertForCreateAnotherCompany").modal("hide");
    }

    var widId = "";

    var onloadCallback = function () {
        widId = grecaptcha.render('recapchaWidget', {
            'sitekey': '6LfYyqcaAAAAAFCTn58JOEBRG4meLtAn6ghv_dNC'
        });
    };

    function dialogOpen(){
        var modal = document.getElementById("popupModal");
        modal.style.display = "block";
        setTimeout(function() {
            modal.style.display = "none";
        }, 3000);
    }

</script>
