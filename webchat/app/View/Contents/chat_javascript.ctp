<?php
/**
 * 
 * ClientEngage: ClientEngage Visitor Chat (http://www.clientengage.com)
 * Copyright 2013, ClientEngage (http://www.clientengage.com)
 *
 * You must have purchased a valid license from CodeCanyon in order to have 
 * the permission to use this file.
 * 
 * You may only use this file according to the respective licensing terms 
 * you agreed to when purchasing this item on CodeCanyon.
 * 
 * 
 * 
 *
 * @author          ClientEngage <contact@clientengage.com>
 * @copyright       Copyright 2013, ClientEngage (http://www.clientengage.com)
 * @link            http://www.clientengage.com ClientEngage
 * @since           ClientEngage - Visitor Chat v 1.0
 * 
 */
$chatHtml = <<<CHATHTML
    <div class="vc_chat_container" style="display: none;">
        <div class="vc_chat_head">
            <i class="vc_header_icon"><span class="vc_notification_badge"><span class="vc_notification_badge_number"></span></span></i>
            <span class="vc_chat_head-title">{HeaderText}</span>
        </div>
        <div class="vc_chat_toggle_container">
            <div class="vc_sub-head-spacer"></div>
            <div class="vc_notifications_wrapper">
                <i class="vc_btn_notifications_close">&times;</i>
                <ul class="vc_errorlist"></ul>
            </div>
            <div class="vc_enquiry_wrapper">
                <form class="vc_form_enquiry" accept-charset="UTF-8">
                    <p>{OfflineMessage}</p>
                    <input maxlength="45" type="text" name="data[Enquiry][username]" placeholder="{UsernamePlaceholder}" class="vc_input_enquiry_username" />
                    <input maxlength="85" type="text" name="data[Enquiry][email]" placeholder="{EmailPlaceholder}" class="vc_input_enquiry_email" />
                    <textarea maxlength="1500" placeholder="{EnquiryMessagePlaceholder}" name="data[Enquiry][message]" class="vc_input_enquiry_message"></textarea>
                    <a href="#" class="vc_btn_enquiry vc_btn_style">{EnquiryButtonText}</a>
                </form>
            </div>
            <div class="vc_signup_wrapper">
                <form class="vc_form_signup" accept-charset="UTF-8">
                    <p>{OnlineMessage}</p>
                    <input maxlength="45" type="text" name="data[Discussion][username]" placeholder="{UsernamePlaceholder}" class="vc_input_username" />
                    <input maxlength="85" type="text" name="data[Discussion][email]" placeholder="{EmailPlaceholder}" class="vc_input_email" />
                    <input type="hidden" class="vc_input_visitor_time" name="data[Discussion][visitor_time]" />
                    <a href="#" class="vc_btn_signup vc_btn_style">{StartChatButtonText}</a>
                </form>
            </div>
            <div class="vc_conversation">
                <div class="vc_conversation_container">
                    <p class="vc_message_intro" data-id="-10">{FirstMessageText}</p>
                </div>
                <div class="vc_composing_container"></div>
                <form class="vc_form_reply" accept-charset="UTF-8">
                    <div class="vc_exit_chat_container">
                        <a href="#" class="vc_btn_exit_chat">{ExitChatButtonText}</a>
                        <div class="vc_exit_chat_confirmation_wrapper" style="display: none;">
                            <span>{ExitChatQuestionText} </span> 
                            <a href="#" class="vc_btn_exit_chat_confirm">{ExitChatButtonConfirmText}</a><span> | </span>
                            <a href="#" class="vc_btn_exit_chat_cancel">{ExitChatButtonCancelText}</a>
                        </div>
                    </div>
                    <textarea maxlength="750" placeholder="{MessagePlaceholderText}" name="data[Message][message]" class="vc_input_message"></textarea>
                    <a href="#" class="vc_btn_send vc_btn_style">{MessageSendButtonText}</a>
                </form>
            </div>
        </div>
    </div>
CHATHTML;

$chatHtml = preg_replace('~>\s+<~', '><', str_replace("'", "\'", preg_replace('/\s+/', ' ', trim($chatHtml))));
?><?php if (false): ?><script type="text/javascript"><?php endif; ?>

    var visitorChat = {
        config: {
            signedUp: false, // indicates whether the visitor has signed-up yet
            windowFocused: false, // indicates whether the window is focussed
            isNewPage: true, // is a reloaded page (to get last 20 messages)
            processingSignUp: false, // currently processing the signup
            processingEnquiry: false, // currently processing the enquiry
            processingSend: false, // is currently processing a send operation
            visitor: {username: "", avatar: ""}, // holds visitor information
            timerReadMessages: null, // read timer
            timerCheckStatus: null, // status timer
            isOnline: false, // indicates wheter an operator is online
            decayHistory: 0, // number of reads without any messages returned
            defaultTimeout: 2000, // default timeout between read-operations
            isInitialStatusCheck: true, // is the status being checked for the first time? --> initialsie chat
            muteNotificationSoundOnce: false, // forces a single mute for the first load
            assetBase: "<?php echo $this->Html->getWebroot(); ?>", // baseUrl for system-assets
            hasSessionSaf: false, // indicates whether a session is active for Safari-browsers,
            restoreOpenState: false,
            animateHover: <?php echo AppConfig::read('Chat.animate_hover') === true ? 'true' : 'false'; ?>,
            hideEmail: <?php echo AppConfig::read('Chat.hide_email') === true ? 'true' : 'false'; ?>,
            hideOffline: <?php echo AppConfig::read('Chat.hide_offline') === true ? 'true' : 'false'; ?>
        },
        Lang: <?php echo json_encode(AppConfig::read('Translations')); ?>,
        init: function() {
            console.log("Init called...");
            // initial animation making the chat-box appear
            jQuery(".vc_chat_container").css('margin-bottom', '-50px');

            if (!visitorChat.config.hideOffline)
                jQuery(".vc_chat_container").show();

            jQuery(".vc_chat_container").animate({marginBottom: 0}, {duration: 500, queue: true, complete: function() {
                    if (visitorChat.config.restoreOpenState)
                    {
                        visitorChat.config.isNewPage = true; // to keep it from loading everything (id >= 0)
                        jQuery(".vc_chat_head").trigger("click");
                    }
                }});

            visitorChat.initAnimateHover();

            jQuery(window).focus(function() {
                visitorChat.config.windowFocused = true;
                console.log('Window focus');
            });
            jQuery(window).blur(function() {
                visitorChat.config.windowFocused = false;
                console.log('Window blur');
            });

            // Process header-click
            jQuery(document).on("click", ".vc_chat_head", visitorChat.headerClick);

            // Process enquiry
            jQuery(document).on("click", ".vc_btn_enquiry", visitorChat.enquiryClick);
            // Process enquiry
            jQuery(document).on("submit", ".vc_form_enquiry", visitorChat.enquirySubmit);

            // Process sign-up
            jQuery(document).on("click", ".vc_btn_signup", visitorChat.signUpClick);
            // Process sign-up
            jQuery(document).on("submit", ".vc_form_signup", visitorChat.signUpSubmit);

            // Process send-click
            jQuery(document).on("click", ".vc_btn_send", visitorChat.sendClick);
            // Process submission
            jQuery(document).on("submit", ".vc_form_reply", visitorChat.onSendSubmit);

            // Process exiting chat
            jQuery(document).on("click", ".vc_btn_exit_chat", visitorChat.btnExitChatClick);
            jQuery(document).on("click", ".vc_btn_exit_chat_confirm", visitorChat.btnExitChatConfirmClick);
            jQuery(document).on("click", ".vc_btn_exit_chat_cancel", visitorChat.btnExitChatCancelClick);

            jQuery(document).on("click", ".vc_btn_notifications_close", visitorChat.btnNotificationsCloseClick);

            // Process enter-key
            jQuery(document).on("keyup", ".vc_chat_container textarea, .vc_chat_container input", visitorChat.messageKeyUp);

            // Process keyDown
            jQuery(document).on("keydown", ".vc_input_message", visitorChat.messageKeyDown);

            // IE7/8 fix for placeholders
            jQuery('.vc_chat_container [placeholder]').each(function() {
                jQuery(this).css('color', '#ccc').val(jQuery(this).attr('placeholder'));
            }).bind('focus', function() {
                jQuery(this).css('color', 'inherit');
                if (jQuery(this).val() === jQuery(this).attr('placeholder')) {
                    jQuery(this).val('');
                }
            }).bind('blur', function() {
                if (jQuery(this).val() === '') {
                    jQuery(this).val(jQuery(this).attr('placeholder')).css('color', '#ccc');
                }
            });

            visitorChat.readMessages(); // initialise reading
        },
        initAnimateHover: function() {
            if (visitorChat.config.animateHover !== true)
                return;

            jQuery(".vc_chat_container").animate({opacity: 0.7}, {duration: 0, queue: false});
            jQuery(".vc_chat_container").hover(
                    function() {
                        jQuery(this).animate({opacity: 1}, {duration: 200, queue: false});
                    },
                    function() {
                        if (!jQuery(this).hasClass("vc_box_open"))
                            jQuery(this).animate({opacity: 0.7}, {duration: 200, queue: false});
                    }
            );
            jQuery(".vc_chat_container").bind("chatOpen", function(e, isOpen) {
                if (isOpen)
                {
                    console.log("Triggered: chat opened");
                    jQuery(this).animate({opacity: 1}, {duration: 200, queue: false});
                }
                else
                {
                    console.log("Triggered: chat closed");
                    jQuery(this).animate({opacity: 0.7}, {duration: 200, queue: false});
                }
            });
        },
        enquiryClick: function(e) {
            e.preventDefault();
            jQuery(".vc_form_enquiry").submit();
        },
        btnExitChatClick: function(e) {
            e.preventDefault();
            jQuery(".vc_exit_chat_confirmation_wrapper").show();
            jQuery(this).hide();
            console.log("Click: exit chat");
        },
        btnExitChatConfirmClick: function(e) {
            e.preventDefault();
            console.log("Click: confirm exit chat");

            clearTimeout(visitorChat.config.timerReadMessages); // we're not signed-up anymore (only re-enable if unsucessfully signed-out)
            clearTimeout(visitorChat.config.timerCheckStatus); // to be re-enabled

            // Process Post
            var formData = jQuery(this).serializeArray();
            formData.push({name: 'data[sign_out]', value: true});

            jQuery.ajax({
                url: "<?php echo Router::url(array('controller' => 'discussions', 'action' => 'signout', 'admin' => false), true); ?>",
                data: formData,
                dataType: "jsonp",
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    if (result.success === true)
                    {
                        visitorChat.resetDefaultState();
                        console.log("Sign-out successful...");
                    }
                    else
                    {

                    }
                },
                complete: function() {
                    visitorChat.checkStatus(true);
                }
            });

        },
        btnExitChatCancelClick: function(e) {
            e.preventDefault();
            console.log("Click: cancel exit chat");
            jQuery(".vc_exit_chat_confirmation_wrapper").hide();
            jQuery(".vc_btn_exit_chat").show();
        },
        resetDefaultState: function() {
            visitorChat.config.signedUp = false;
            visitorChat.config.visitor = {username: "", avatar: ""};

            jQuery(".vc_conversation_container").html('<p class="vc_message_intro" data-id="-10">' + visitorChat.Lang.FirstMessageText + '</p>');
            jQuery(".vc_exit_chat_confirmation_wrapper").hide();
            jQuery(".vc_btn_exit_chat").show();

            jQuery(".vc_chat_head").trigger("click");
        },
        enquirySubmit: function(e) {
            e.preventDefault();
            console.log("Enquiry submit");

            if (visitorChat.config.processingEnquiry)
                return false;




            var validationErrors = {};

            if (jQuery.trim(jQuery(".vc_input_enquiry_username").val()) === '' || jQuery(".vc_input_enquiry_username").val() === jQuery(".vc_input_enquiry_username").attr("placeholder"))
            {
                validationErrors["username"] = [visitorChat.Lang.ValidationUsernameRequired];
                console.log("Enquiry: username empty");
            }
            if (jQuery.trim(jQuery(".vc_input_enquiry_email").val()) === '' || jQuery(".vc_input_enquiry_email").val() === jQuery(".vc_input_enquiry_email").attr("placeholder"))
            {
                validationErrors["email"] = [visitorChat.Lang.ValidationEmailRequired];
                console.log("Enquiry: email empty");
            }
            if (jQuery.trim(jQuery(".vc_input_enquiry_message").val()) === '' || jQuery(".vc_input_enquiry_message").val() === jQuery(".vc_input_enquiry_message").attr("placeholder"))
            {
                validationErrors["message"] = [visitorChat.Lang.ValidationEnquiryRequired];
                console.log("Enquiry: enquiry empty");
            }
            if (validationErrors.hasOwnProperty("username") || validationErrors.hasOwnProperty("email") || validationErrors.hasOwnProperty("message"))
            {
                visitorChat.renderNotifications(validationErrors, true);
                return;
            }

            visitorChat.config.processingEnquiry = true;

            var enquiryForm = jQuery(this);
            enquiryForm.addClass("vc_enquiry_sending");

            // Process Post
            var formData = jQuery(this).serializeArray();
            formData.push({name: 'data[Enquiry][current_page]', value: encodeURIComponent(encodeURIComponent(document.URL))});

            jQuery.ajax({
                url: "<?php echo Router::url(array('controller' => 'enquiries', 'action' => 'submit', 'admin' => false), true); ?>",
                data: formData,
                dataType: "jsonp",
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    if (result.success === true)
                    {
                        visitorChat.clearNotifications();
                        jQuery(".vc_form_enquiry")[0].reset();

                        var notifications = {success: [visitorChat.Lang.EnquirySubmitSuccess]};
                        visitorChat.renderNotifications(notifications, false);
                    }
                    else
                    {
                        visitorChat.renderNotifications(result.errors, true);
                    }
                },
                complete: function() {
                    visitorChat.config.processingEnquiry = false;
                    enquiryForm.removeClass("vc_enquiry_sending");
                    jQuery(".vc_chat_container input, .vc_chat_container textarea").trigger("blur"); // For the IE7/8 placeholder-fix
                }
            });

            return false;
        },
        onSendSubmit: function() {
            console.log('Send submit');
            var message = jQuery.trim(jQuery(".vc_input_message").val());
            message = jQuery('<p>' + message + '</p>').text();
            jQuery(".vc_input_message").val(message);

            if (message === "" || jQuery(".vc_input_message").val() === jQuery(".vc_input_message").attr("placeholder"))
                return false;

            if (visitorChat.config.processingSend)
                return false;

            var messageForm = jQuery(this);
            messageForm.addClass("vc_message_sending");

            visitorChat.config.processingSend = true;
            // Process Post
            var formData = jQuery(".vc_form_reply").serializeArray();

            formData.push({name: 'data[Message][current_page]', value: encodeURIComponent(encodeURIComponent(document.URL))});
            formData.push({name: 'data[last_id]', value: visitorChat.getMaxId()});
            formData.push({name: 'data[is_new_page]', value: visitorChat.config.isNewPage});

            visitorChat.config.isNewPage = false; // set false on first interaction
            jQuery(".vc_input_message").val("");

            var tmpMessage = {Message: [], User: {username: visitorChat.config.visitor.username, avatar: visitorChat.config.visitor.avatar, is_admin: false}};

            tmpMessage.Message.id = visitorChat.getMaxId() + 999;
            tmpMessage.Message.message = message;
            tmpMessage.Message.created = new Date();

            visitorChat.addMessageToChat(tmpMessage, {confirmed: false});
            visitorChat.scrollBottom(false);

            jQuery.ajax({
                url: "<?php echo Router::url(array('controller' => 'messages', 'action' => 'send', 'admin' => false), true); ?>",
                data: formData,
                dataType: "jsonp",
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    if (result.success === true)
                    {
                        jQuery("[data-id=" + tmpMessage.Message.id + "]").remove();
                        visitorChat.addMessageToChat(result.data);

                        for (var k = 0; k < result.messages.length; k++)
                        {
                            visitorChat.addMessageToChat(result.messages[k]);
                        }
                        if (result.messages.length > 0) // animate only if more messages
                            visitorChat.scrollBottom(true);

                    }
                    else
                    { // indicate submission error
                        jQuery("[data-id=" + tmpMessage.Message.id + "]").css('border', '1px dashed #f00');
                    }
                },
                complete: function() {
                    visitorChat.config.processingSend = false;
                    messageForm.removeClass("vc_message_sending");
                }
            });

            return false;
        },
        headerClick: function(e) {
            e.preventDefault();

            if (!visitorChat.config.signedUp && (e.originalEvent !== undefined) && !jQuery(".vc_chat_toggle_container").is(":visible") && visitorChat.config.hasSession !== true && visitorChat.browserTest('Safari') === true)
            {
                // Post to create session-cookie for safari if not signed-up AND online --> and clicked on header
                jQuery('<form method="post" action="<?php echo Router::url(array('controller' => 'discussions', 'action' => 'session_redir', 'admin' => false), true); ?>"><input type="hidden" name="data[referer]" value="' + window.location + '" /></form>').submit();
            }

            jQuery(".vc_notification_badge_number").fadeOut();
            jQuery(".vc_notification_badge_number").html('');
            jQuery(".vc_chat_container").removeClass('vc_has_unread_messages');

            if (!visitorChat.config.signedUp) // not signed-up
            {
                if (visitorChat.config.isOnline) // is online: can sign-up
                {
                    jQuery(".vc_signup_wrapper").show();
                    jQuery(".vc_conversation").hide();
                    jQuery(".vc_enquiry_wrapper").hide();
                }
                else // is offline: show enquiry form
                {
                    jQuery(".vc_enquiry_wrapper").show();
                    jQuery(".vc_signup_wrapper").hide();
                    jQuery(".vc_conversation").hide();
                }
            }
            else
            {
                jQuery(".vc_enquiry_wrapper").hide();
                jQuery(".vc_signup_wrapper").hide(); // online and signed-up: show conversation
                jQuery(".vc_conversation").show();
            }

            // manage animations
            var wasClosed = jQuery(".vc_chat_toggle_container").is(":visible");
            jQuery(".vc_chat_toggle_container").slideToggle("fast", function() {
                visitorChat.scrollBottom(true);
                if (!wasClosed)
                {
                    jQuery(".vc_chat_container").addClass("vc_box_open");
                    jQuery(".vc_chat_container").trigger("chatOpen", true);
                }
            });
            if (wasClosed)
            {
                jQuery(".vc_chat_container").addClass("vc_chat_closing");
                jQuery(".vc_chat_container").animate({marginBottom: -50}, {duration: 200, queue: true, complete: function() {
                        jQuery(".vc_chat_container").animate({marginBottom: 0}, {duration: 500, queue: true, complete: function() {
                            }});
                        jQuery(".vc_chat_container").removeClass("vc_box_open");
                        jQuery(".vc_chat_container").removeClass("vc_chat_closing");
                        jQuery(".vc_chat_container").trigger("chatOpen", false);
                    }});
            }
            else
            {
                jQuery(".vc_input_message").focus();
            }

            if (e.originalEvent !== undefined) {
                console.log("Header clicked by a human.");
                visitorChat.readMessages();
            }

            // always force-refresh status if header is clicked
            visitorChat.checkStatus(true);

        },
        signUpClick: function(e) {
            e.preventDefault();
            console.log("Clicked sign-up submit...");
            jQuery(".vc_form_signup").submit();
        },
        signUpSubmit: function(e) {
            e.preventDefault();

            if (visitorChat.config.processingSignUp)
                return false;


            var validationErrors = {};

            if (jQuery.trim(jQuery(".vc_input_username").val()) === '' || jQuery(".vc_input_username").val() === jQuery(".vc_input_username").attr("placeholder"))
            {
                validationErrors["username"] = [visitorChat.Lang.ValidationUsernameRequired];
                console.log("Signup: username empty");
            }

            if (!visitorChat.config.hideEmail && (jQuery.trim(jQuery(".vc_input_email").val()) === '' || jQuery(".vc_input_email").val() === jQuery(".vc_input_email").attr("placeholder")))
            {
                validationErrors["email"] = [visitorChat.Lang.ValidationEmailRequired];
                console.log("Signup: email empty");
            }
            if (validationErrors.hasOwnProperty("username") || validationErrors.hasOwnProperty("email"))
            {
                visitorChat.renderNotifications(validationErrors, true);
                return;
            }


            visitorChat.config.processingSignUp = true;

            var now = new Date();
            var dateStr = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
            jQuery(".vc_input_visitor_time").val(dateStr); // set visitor's local time

            var formData = jQuery(".vc_form_signup").serializeArray();

            if (visitorChat.config.hideEmail) {
                formData.push({name: 'data[Discussion][email]', value: 'not.provided@example.com'});
            }

            jQuery.ajax({
                url: "<?php echo Router::url(array('controller' => 'discussions', 'action' => 'signup', 'admin' => false), true); ?>",
                data: formData,
                dataType: "jsonp",
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    if (result.success === true)
                    {
                        // initialise user data
                        visitorChat.config.visitor.username = jQuery(".vc_input_username").val();
                        visitorChat.config.visitor.avatar = CryptoJS.MD5(jQuery.trim(jQuery(".vc_input_email").val()).toLowerCase());
                        console.log("Set username...");
                        visitorChat.clearNotifications();
                        visitorChat.config.signedUp = true;

                        visitorChat.setHeaderText();

                        visitorChat.readMessages(); // initialise reading messages
                        jQuery(".vc_signup_wrapper").hide();
                        jQuery(".vc_conversation").show();
                        visitorChat.scrollBottom(false);

                    }
                    else
                    {
                        console.log("Sign-Up return:");
                        console.log(result);
                        visitorChat.renderNotifications(result.errors, true);
                    }
                },
                complete: function() {
                    visitorChat.config.processingSignUp = false;
                    console.log("Submitting sign-up complete...");
                }
            });

        },
        setHeaderText: function() {
            if (visitorChat.config.signedUp === true)
                jQuery(".vc_chat_head-title").html(visitorChat.Lang.HeaderCurrentlyChatting);
            else if (visitorChat.config.isOnline === true)
                jQuery(".vc_chat_head-title").html(visitorChat.Lang.HeaderOnline);
            else
                jQuery(".vc_chat_head-title").html(visitorChat.Lang.HeaderOffline);
        },
        checkStatus: function(async) {
            var chatHtml = '<?php echo $chatHtml; ?>';
            if (jQuery(".vc_chat_container").length === 0)
            {
                for (i in visitorChat.Lang)
                {
                    chatHtml = chatHtml.replace(new RegExp("{" + i + "}", "gm"), visitorChat.Lang[i]);
                }

                jQuery('body').append(chatHtml);

                if (visitorChat.config.hideEmail) {
                    jQuery(".vc_chat_container .vc_input_email").hide();
                }

                console.log("Added ChatHTML...");
            }
            if (jQuery("#vc_stylesheet").length === 0)
            {
                var vcCss = document.createElement('link');
                vcCss.setAttribute('rel', 'stylesheet');
                vcCss.type = 'text/css';
                vcCss.id = 'vc_stylesheet';
                vcCss.href = '<?php echo Router::url(array('controller' => 'contents', 'action' => 'chat_stylesheet', 'admin' => false), true); ?>';
                document.body.appendChild(vcCss);
            }

            clearTimeout(visitorChat.config.timerCheckStatus);
            console.log("Checking status...");

            var formData = []; // upon first load send visitor's referer (will only be stored once per session)

            if (visitorChat.config.isInitialStatusCheck)
                formData.push({name: 'data[referer]', value: encodeURIComponent(encodeURIComponent(document.referrer))});
            else // do not send on first request (since that's where we want to find out whether to maximise the chat)
                formData.push({name: 'data[open_state]', value: (jQuery(".vc_chat_toggle_container").is(":visible") && !jQuery(".vc_chat_container").hasClass("vc_chat_closing"))});

            jQuery.ajax({
                url: "<?php echo Router::url(array('controller' => 'discussions', 'action' => 'status', 'admin' => false), true); ?>",
                dataType: "jsonp",
                data: formData,
                async: async,
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    var wasSignedUp = visitorChat.config.signedUp; // to check later if the visitor was signed-up before
                    console.log("Checking status success...");

                    if (result.success)
                    {
                        visitorChat.config.visitor.username = result.username; // initialise visitor-data
                        visitorChat.config.visitor.avatar = result.avatar; // initialise visitor-data
                        visitorChat.config.signedUp = result.signed_up;
                        visitorChat.config.isOnline = result.online;
                        visitorChat.config.hasSessionSaf = result.has_session_saf; // indicates whether a session is in progress
                    }

                    if (result.success && result.signed_up === false && visitorChat.config.signedUp)
                    {
                        console.log("Not signed-up anymore: restoring chat to default");
                        visitorChat.resetDefaultState();
                    }

                    console.log("Chat online: " + result.online);
                    if (visitorChat.config.isOnline)
                    {
                        jQuery(".vc_chat_container").addClass("vc_state_online").removeClass("vc_state_offline").fadeIn();
                    }
                    else
                    {
                        jQuery(".vc_chat_container").removeClass("vc_state_online").addClass("vc_state_offline");
                    }

                    if (!visitorChat.config.signedUp)
                    {
                        if (visitorChat.config.isOnline)
                        { // not signed-up and chat online: can start discussion
                            jQuery(".vc_signup_wrapper").show();
                            jQuery(".vc_conversation").hide();
                            jQuery(".vc_enquiry_wrapper").hide();
                        }
                        else
                        { // not signed-up and chat offline: show enquiry
                            jQuery(".vc_enquiry_wrapper").show();
                            jQuery(".vc_signup_wrapper").hide();
                            jQuery(".vc_conversation").hide();
                        }
                    }
                    else
                    {
                        if (visitorChat.config.isOnline)
                        {
                            visitorChat.clearNotifications();
                        }
                        else
                        {
                            var notifications = {offline: [visitorChat.Lang.OperatorOfflineMessage]};
                            visitorChat.renderNotifications(notifications, true);
                        }
                    }

                    console.log("Initial Status Check: " + visitorChat.config.isInitialStatusCheck);
                    var wasInitialStatusCheck = visitorChat.config.isInitialStatusCheck;
                    if (visitorChat.config.isInitialStatusCheck === true)
                    {
                        visitorChat.config.isInitialStatusCheck = false;
                        visitorChat.config.muteNotificationSoundOnce = true;

                        visitorChat.setHeaderText(); // so it's set before showing the box
                        visitorChat.init(); // initialise chat

                        if (result.open_state === true)
                        {
                            console.log("Restoring opened state");
                            visitorChat.config.restoreOpenState = true;
                        }
                    }

                    if (result.success && result.signed_up === true && wasSignedUp === false && wasInitialStatusCheck === false)
                    {
                        console.log("Has signed-up on a different page & is NOT pageLoad: set chat to active");
                        jQuery(".vc_enquiry_wrapper").hide();
                        jQuery(".vc_signup_wrapper").hide();
                        jQuery(".vc_conversation").show();
                        visitorChat.readMessages();
                    }
                },
                complete: function() {
                    console.log("Checking status complete...");
                    visitorChat.setHeaderText(); // for other status-refreshes
                    visitorChat.config.timerCheckStatus = setTimeout(function() {
                        visitorChat.checkStatus(true);
                    }, 25000);
                }
            });
        },
        getJsonpCallbackName: function() {
            var callback = 'visitorChat_';
            var cStr = parseInt(new Date().getTime() / 1000).toString().substring(5) + (Math.random() + ' ').substring(5, 10);
            var mult = parseInt(cStr.charAt(Math.floor(Math.random() * cStr.length)));
            mult = (mult === 0 || mult === 1) ? mult + 2 : mult;
            console.log("5-digit time: " + cStr);
            console.log("Multiplier: " + mult);
            var cStr = mult.toString() + cStr.toString() + (cStr * mult).toString();
            callback += cStr.toString().split("").reverse().join("");
            console.log("Final callback: " + callback);
            return callback;
        },
        timerNotifications: null,
        renderNotifications: function(errorMessages, isError) {
            console.log("Rendering notifications:");
            console.log(errorMessages);

            if (isError)
            {
                jQuery(".vc_notifications_wrapper").removeClass("vc_notification_success");
                jQuery(".vc_notifications_wrapper").addClass("vc_notification_error");
            }
            else
            {
                jQuery(".vc_notifications_wrapper").addClass("vc_notification_success");
                jQuery(".vc_notifications_wrapper").removeClass("vc_notification_error");
            }

            jQuery(".vc_notifications_wrapper ul.vc_errorlist").html("");
            for (k in errorMessages)
            {
                for (var l = 0; l < errorMessages[k].length; l++)
                    jQuery(".vc_notifications_wrapper ul.vc_errorlist").append(jQuery("<li>" + errorMessages[k][l] + "</li>"));
            }
            jQuery(".vc_notifications_wrapper").slideDown();

            clearTimeout(visitorChat.timerNotifications);
            visitorChat.timerNotifications = setTimeout(function() {
                jQuery(".vc_notifications_wrapper").slideUp();
            }, 10000);
        },
        clearNotifications: function() {
            jQuery(".vc_notifications_wrapper").hide();
            jQuery(".vc_notifications_wrapper ul.vc_errorlist").html("");
        },
        btnNotificationsCloseClick: function(e) {
            e.preventDefault();
            console.log("Click: close notifications");
            jQuery(".vc_notifications_wrapper").slideUp();
        },
        messageKeyUp: function(e) {
            if (e.shiftKey)
                return;
            if (e.keyCode === 13 && !jQuery(this).hasClass("vc_input_enquiry_message")) {
                console.log('ENTER: submitting parent form');
                jQuery(this).parents('form').submit();
            }
        },
        messageKeyDownWait: false,
        messageKeyDown: function(e) {

            // if IsWaiting return else start action
            // write 500ms timeout set isWaiting true, afterwards false

            if (visitorChat.messageKeyDownWait === true)
            {
                console.log("Composing: 500ms have not yet passed");
                return;
            }
            else
            {
                visitorChat.messageKeyDownWait = true;

                setTimeout(function() {
                    visitorChat.messageKeyDownWait = false;
                }, 1000);

            }

            jQuery.ajax({
                url: "<?php echo Router::url(array('controller' => 'discussions', 'action' => 'composing', 'admin' => false), true); ?>",
                dataType: "jsonp",
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    console.log("Sent Composing-State...");
                },
                complete: function() {
                }
            });

        },
        sendClick: function(e) {
            e.preventDefault();
            jQuery('form.vc_form_reply').submit();
        },
        addMessageToChat: function(message, options) {
            var isConfirmed = ""; // render pending/confirmed message
            if ((typeof options !== 'undefined' && options.confirmed === false) && visitorChat.config.visitor.username === message.User.username)
                isConfirmed = " vc_submission_pending";
            else if (typeof options === 'undefined' && visitorChat.config.visitor.username === message.User.username)
                isConfirmed = " vc_submission_confirmed";

            // add only if it does not exist (in case of duplicates)
            if (jQuery(".vc_conversation_container [data-id=" + message.Message.id + "]").length === 0)
            {
                // remove the intro-sentence
                jQuery(".vc_conversation_container .vc_message_intro").remove();
                var mTime = ('0' + new Date(message.Message.created).getHours()).slice(-2) + ":" + ('0' + new Date(message.Message.created).getMinutes()).slice(-2);
                var newMessage = jQuery("<div style=\"clear: both\" class=\"vc_chatrow" + (message.User.is_admin ? " vc_admin_message" : "") + "\" data-id=\"" + message.Message.id + "\"><div class=\"vc_time" + isConfirmed + "\">" + mTime + "</div><p><i style=\"background-image: url(//www.gravatar.com/avatar/" + message.User.avatar + "?s=40&d=identicon);\" class=\"vc_avatar\"></i><span class=\"vc_username\">" + message.User.username + "</span> " + visitorChat.prepareMessageText(message.Message.message) + "</p></div>");
                jQuery(".vc_conversation_container").append(newMessage);

                jQuery('.vc_conversation_container').children().sort(function(a, b) {
                    var aF = parseInt(jQuery(a).attr("data-id"));
                    var bF = parseInt(jQuery(b).attr("data-id"));
                    if (aF > bF)
                        return 1;
                    else if (aF < bF)
                        return -1;
                    else
                        return 0;
                }).appendTo('.vc_conversation_container');
            }
        },
        prepareMessageText: function(text) {
            var smilies = [
                {s: [' :-) ', ' :) '], r: "smiling"},
                {s: [' :-( ', ' :( '], r: "frowning"},
                {s: [' :-/ ', ' :/ '], r: "unsure"},
                {s: [' ;-) ', ' ;) '], r: "winking"},
                {s: [' :-D ', ' :D '], r: "grinning"},
                {s: [' B-) ', ' B) '], r: "cool"},
                {s: [' :-P ', ' :P '], r: "tongue_out"},
                {s: [' :-| ', ' :| '], r: "speechless"},
                {s: [' :-O ', ' :O '], r: "gasping"},
                {s: [' X-( ', ' X( '], r: "angry"},
                {s: [' O:-) ', ' 0:) '], r: "angel"}
            ];

            text = " " + text + " ";
            for (var i = 0; i < smilies.length; i++)
            {
                for (var j = 0; j < smilies[i].s.length; j++)
                {
                    var smilie = ' <i style="background-image: url(' + ('{VC_REP}' + 'img/smilies/' + smilies[i].r + '.png') + ');" class="vc_smilie" >' + jQuery.trim(smilies[i].s[j].toString()) + '</i> ';
                    var regex = new RegExp(visitorChat.escapeRegExp(smilies[i].s[j]), 'g');
                    text = text.replace(regex, smilie);
                }
            }

            var wAddress = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            var eAddress = /\w+@[a-zA-Z_]+?(?:\.[a-zA-Z]{2,6})+/gim;
            text = text
                    .replace(wAddress, '<a href="$&">$&</a>')
                    .replace(eAddress, '<a href="mailto:$&">$&</a>');

            var tmp = jQuery("<div>" + text + "<div>");
            tmp.find("a").each(function() {
                if (jQuery(this).attr("href").indexOf(document.domain) === -1)
                {
                    jQuery(this).attr("target", "_blank").addClass("vc_link_external");
                }
                else
                {
                    jQuery(this).addClass("vc_link_internal");
                }
            });
            var regex = new RegExp(visitorChat.escapeRegExp("{VC_REP}"), 'g');
            text = jQuery(tmp).html().replace(regex, visitorChat.config.assetBase);

            return jQuery.trim(text).replace(/\n/g, '<br />');
        },
        escapeRegExp: function(str) {
            return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
        },
        loadMore: function() {
            visitorChat.readMessages(true);
        },
        readMessages: function(loadMore) {

            if (!loadMore) // Do not clear if loadMore
                clearTimeout(visitorChat.config.timerReadMessages); // clear timer and force refresh when opening chat

            // not signed-up yet, so return
            if (!visitorChat.config.signedUp)
            {
                console.log("Not signed-up: don't read messages...");
                return;
            }

            if (visitorChat.config.isNewPage)
            {
                console.log("Is new page...");
            }

            var requestData = [];
            if (loadMore === true)
            {   // clicked loadMore button
                requestData.push({name: 'data[first_id]', value: visitorChat.getMinId()});
                requestData.push({name: 'data[load_more]', value: true});
                console.log("Loading more...");
            }
            else
            {   // is a normal timed reload
                requestData.push({name: 'data[last_id]', value: visitorChat.getMaxId()});
                requestData.push({name: 'data[is_new_page]', value: visitorChat.config.isNewPage});
                console.log("Timed reload...");
            }
            jQuery.ajax({
                data: requestData,
                url: "<?php echo Router::url(array('controller' => 'messages', 'action' => 'read', 'admin' => false), true); ?>",
                dataType: "jsonp",
                jsonpCallback: visitorChat.getJsonpCallbackName(),
                success: function(result) {
                    if (result.success === true)
                    {
                        // keep element so we can scroll to it later
                        var scrollToElem = jQuery("[data-id=" + visitorChat.getMinId() + "]");

                        for (var i = 0; i < result.messages.length; i++)
                        {
                            visitorChat.addMessageToChat(result.messages[i]);
                        }

                        if (loadMore) // clicked loadMore, so remove
                            jQuery(".vc_btn_load_more").remove();

                        if (result.messages.length >= 20 && jQuery(".vc_btn_load_more").length === 0) // insert only if at least 20 loaded (there are likely to be more)
                        {
                            jQuery(".vc_conversation_container").prepend(jQuery("<a href=\"#\" data-id=\"-10\" class=\"vc_btn_load_more vc_btn_style\">Load More</a>"));
                            jQuery(".vc_btn_load_more").on("click", visitorChat.loadMore);
                        }

                        if (result.composing === true && result.messages.length === 0)
                        {
                            // Show composing-indicator if no messages transferred
                            jQuery(".vc_composing_container").html(visitorChat.Lang.OperatorComposing.replace("{username}", result.composing_username)).slideDown();
                        }
                        else
                        {
                            jQuery(".vc_composing_container").slideUp();
                        }
                        if (result.messages.length > 0)
                        {
                            jQuery(".vc_composing_container").slideUp();
                        }

                        if (!loadMore && result.messages.length > 0)
                        {
                            visitorChat.playNotificationSound();
                            visitorChat.scrollBottom(true); // new messages, scroll down

                            if (!visitorChat.config.isNewPage && !jQuery(".vc_conversation_container").is(":visible"))
                            {
                                jQuery(".vc_chat_container").animate({opacity: 1}, {duration: 200, queue: false}); // remove transparency to draw attention to the new message
                                // minimised and there are new messages: animate
                                jQuery(".vc_chat_container").animate({'margin-bottom': -7}, 100, function() {
                                    jQuery(this).animate({'margin-bottom': 0}, 100, function() {
                                        jQuery(this).animate({'margin-bottom': -5}, 100, function() {
                                            jQuery(this).animate({'margin-bottom': 0}, 200, function() {
                                            });
                                        });
                                    });
                                });

                                jQuery(".vc_notification_badge_number").fadeIn();
                                // Render notification badge
                                var newVal = (isNaN(parseInt(jQuery(".vc_notification_badge_number").html())) ? 0 : parseInt(jQuery(".vc_notification_badge_number").html())) + result.messages.length;
                                console.log("Unread count: " + newVal);
                                jQuery(".vc_notification_badge_number").html(newVal);
                                jQuery(".vc_chat_container").addClass('vc_has_unread_messages');
                            }
                        }
                        else if (loadMore) // show previousy first element at the bottom
                        {
                            visitorChat.scrollToElement(scrollToElem);
                        }

                        if (result.messages.length === 0)
                            visitorChat.config.decayHistory++;
                        else
                            visitorChat.config.decayHistory = 0;

                        console.log("Decay-History: " + visitorChat.config.decayHistory);

                        var duration = visitorChat.calculateTimeOutDuration();
                        console.log(duration);

                        if (!loadMore)
                        {
                            visitorChat.config.timerReadMessages = setTimeout(function() {
                                visitorChat.readMessages(false);
                            }, duration);
                        }


                    }
                    else if (result.success === false)
                    {
                        // there appears to be an error, let's check the status
                        visitorChat.checkStatus(true);
                    }
                    else
                    {

                    }
                    visitorChat.config.isNewPage = false;

                }

            });
        },
        playNotificationSound: function() {

            if (visitorChat.config.isNewPage || (visitorChat.config.windowFocused && jQuery(".vc_conversation_container").is(":visible")) || visitorChat.config.muteNotificationSoundOnce)
            {
                visitorChat.config.muteNotificationSoundOnce = false;
                console.log("Notification sound muted...");
                return;
            }
            jQuery("#vc_auto_tag").remove();
            var soundWav = visitorChat.config.assetBase + "files/notification/vc_blubb.wav";
            var soundMp3 = visitorChat.config.assetBase + "files/notification/vc_blubb.mp3";
            var soundOgg = visitorChat.config.assetBase + "files/notification/vc_blubb.ogg";

            jQuery('<audio id="vc_auto_tag" autoplay="autoplay">').append(jQuery('<source>').attr('src', soundWav))
                    .append(jQuery('<source>').attr('src', soundMp3))
                    .append(jQuery('<source>').attr('src', soundOgg))
                    .appendTo('body');

            console.log("Playing notification sound...");

        },
        calculateTimeOutDuration: function() {
            if (!jQuery(".vc_conversation_container").is(":visible"))
                return 10000;

            var calcTimeOut = (parseFloat(visitorChat.config.decayHistory / 10) * 1000);

            if (calcTimeOut > 10000)
                return 10000;

            if (calcTimeOut > visitorChat.config.defaultTimeout)
            {
                return calcTimeOut;
            }

            return visitorChat.config.defaultTimeout;
        },
        getMaxId: function() {
            if (jQuery(".vc_chatrow").length === 0)
                return 0;

            var numbers = jQuery(".vc_chatrow").map(function() {
                return parseFloat(this.getAttribute('data-id')) || -Infinity;
            }).toArray();

            return Math.max.apply(Math, numbers);
        },
        getMinId: function() {
            if (jQuery(".vc_chatrow").length === 0)
                return 0;

            var numbers = jQuery(".vc_chatrow").map(function() {
                return parseFloat(this.getAttribute('data-id')) || -Infinity;
            }).toArray();

            return Math.min.apply(Math, numbers);
        },
        scrollBottom: function(animate) {
            if (!animate)
                jQuery(".vc_conversation_container").scrollTop(jQuery(".vc_conversation_container")[0].scrollHeight);
            else
                jQuery(".vc_conversation_container").animate({scrollTop: jQuery(".vc_conversation_container")[0].scrollHeight}, 800);
        },
        scrollToElement: function(elem) {
            // scrolls to keep the element and the two ones following at the bottom of the box
            var offset = jQuery(elem).offset().top + (jQuery(elem).height() * 2) - jQuery(".vc_conversation_container").height();
            jQuery(".vc_conversation_container").animate({scrollTop: offset}, 800);
        },
        browserTest: function(test) {
            var isOpera = !!(window.opera && window.opera.version); // Opera 8.0+
            var isFirefox = visitorChat.testStyle('MozBoxSizing'); // FF 0.8+
            var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
            var isChrome = !isSafari && visitorChat.testStyle('WebkitTransform'); // Chrome 1+
            var isIE = /*@cc_on!@*/false || visitorChat.testStyle('msTransform'); // At least IE6

            var browserValue = {
                'Opera': isOpera,
                'Firefox': isFirefox,
                'Safari': isSafari,
                'Chrome': isChrome,
                'IE': isIE
            };

            return browserValue[test];
        },
        testStyle: function(property) {
            return property in document.documentElement.style;
        },
        checkIfMobileDevice: function() {
            var n = (navigator.userAgent || navigator.vendor || window.opera);
            return /android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(n) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(n.substr(0, 4));
        }
    };

    function vcLoadJS(vcCallback) {
        var script = document.createElement("script")
        script.type = "text/javascript";
        if (script.readyState) {
            script.onreadystatechange = function() {
                if (script.readyState == "loaded" || script.readyState == "complete") {
                    script.onreadystatechange = null;
                    vcCallback();
                }
            };
        } else {
            script.onload = function() {
                vcCallback();
            };
        }

        script.src = '<?php echo $this->Html->getWebroot() . 'js/jquery/jquery.min.js'; ?>';
        var ph = document.getElementsByTagName('script')[0];
        ph.parentNode.insertBefore(script, ph);
    }
    if (<?php echo AppConfig::read('Chat.hide_mobile') === true ? 'visitorChat.checkIfMobileDevice() === false' : 'true'; ?>)
    {
        if (typeof jQuery == 'undefined')
        {
            vcLoadJS(function() {
                (function($) {
                    jQuery(document).ready(function() {
                        visitorChat.checkStatus(false);
                    });
                })(jQuery);
            });
        }
        else
        {
            (function($) {
                jQuery(document).ready(function() {
                    visitorChat.checkStatus(false);
                });
            })(jQuery);
        }
    }
<?php if (false): ?></script><?php endif; ?>
<?php
echo <<<JSMD5
/**
 * The code below this is not covered by the CodeCanyon Regular License.
 * Feel free to re-use the code below as per your requirements whilst following  
 * the respective licensing terms.
 */
/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
if(false)alert();
var CryptoJS=CryptoJS||function(s,p){var m={},l=m.lib={},n=function(){},r=l.Base={extend:function(b){n.prototype=this;var h=new n;b&&h.mixIn(b);h.hasOwnProperty("init")||(h.init=function(){h.\$super.init.apply(this,arguments)});h.init.prototype=h;h.\$super=this;return h},create:function(){var b=this.extend();b.init.apply(b,arguments);return b},init:function(){},mixIn:function(b){for(var h in b)b.hasOwnProperty(h)&&(this[h]=b[h]);b.hasOwnProperty("toString")&&(this.toString=b.toString)},clone:function(){return this.init.prototype.extend(this)}},
q=l.WordArray=r.extend({init:function(b,h){b=this.words=b||[];this.sigBytes=h!=p?h:4*b.length},toString:function(b){return(b||t).stringify(this)},concat:function(b){var h=this.words,a=b.words,j=this.sigBytes;b=b.sigBytes;this.clamp();if(j%4)for(var g=0;g<b;g++)h[j+g>>>2]|=(a[g>>>2]>>>24-8*(g%4)&255)<<24-8*((j+g)%4);else if(65535<a.length)for(g=0;g<b;g+=4)h[j+g>>>2]=a[g>>>2];else h.push.apply(h,a);this.sigBytes+=b;return this},clamp:function(){var b=this.words,h=this.sigBytes;b[h>>>2]&=4294967295<<
32-8*(h%4);b.length=s.ceil(h/4)},clone:function(){var b=r.clone.call(this);b.words=this.words.slice(0);return b},random:function(b){for(var h=[],a=0;a<b;a+=4)h.push(4294967296*s.random()|0);return new q.init(h,b)}}),v=m.enc={},t=v.Hex={stringify:function(b){var a=b.words;b=b.sigBytes;for(var g=[],j=0;j<b;j++){var k=a[j>>>2]>>>24-8*(j%4)&255;g.push((k>>>4).toString(16));g.push((k&15).toString(16))}return g.join("")},parse:function(b){for(var a=b.length,g=[],j=0;j<a;j+=2)g[j>>>3]|=parseInt(b.substr(j,
2),16)<<24-4*(j%8);return new q.init(g,a/2)}},a=v.Latin1={stringify:function(b){var a=b.words;b=b.sigBytes;for(var g=[],j=0;j<b;j++)g.push(String.fromCharCode(a[j>>>2]>>>24-8*(j%4)&255));return g.join("")},parse:function(b){for(var a=b.length,g=[],j=0;j<a;j++)g[j>>>2]|=(b.charCodeAt(j)&255)<<24-8*(j%4);return new q.init(g,a)}},u=v.Utf8={stringify:function(b){try{return decodeURIComponent(escape(a.stringify(b)))}catch(g){throw Error("Malformed UTF-8 data");}},parse:function(b){return a.parse(unescape(encodeURIComponent(b)))}},
g=l.BufferedBlockAlgorithm=r.extend({reset:function(){this._data=new q.init;this._nDataBytes=0},_append:function(b){"string"==typeof b&&(b=u.parse(b));this._data.concat(b);this._nDataBytes+=b.sigBytes},_process:function(b){var a=this._data,g=a.words,j=a.sigBytes,k=this.blockSize,m=j/(4*k),m=b?s.ceil(m):s.max((m|0)-this._minBufferSize,0);b=m*k;j=s.min(4*b,j);if(b){for(var l=0;l<b;l+=k)this._doProcessBlock(g,l);l=g.splice(0,b);a.sigBytes-=j}return new q.init(l,j)},clone:function(){var b=r.clone.call(this);
b._data=this._data.clone();return b},_minBufferSize:0});l.Hasher=g.extend({cfg:r.extend(),init:function(b){this.cfg=this.cfg.extend(b);this.reset()},reset:function(){g.reset.call(this);this._doReset()},update:function(b){this._append(b);this._process();return this},finalize:function(b){b&&this._append(b);return this._doFinalize()},blockSize:16,_createHelper:function(b){return function(a,g){return(new b.init(g)).finalize(a)}},_createHmacHelper:function(b){return function(a,g){return(new k.HMAC.init(b,
g)).finalize(a)}}});var k=m.algo={};return m}(Math);
(function(s){function p(a,k,b,h,l,j,m){a=a+(k&b|~k&h)+l+m;return(a<<j|a>>>32-j)+k}function m(a,k,b,h,l,j,m){a=a+(k&h|b&~h)+l+m;return(a<<j|a>>>32-j)+k}function l(a,k,b,h,l,j,m){a=a+(k^b^h)+l+m;return(a<<j|a>>>32-j)+k}function n(a,k,b,h,l,j,m){a=a+(b^(k|~h))+l+m;return(a<<j|a>>>32-j)+k}for(var r=CryptoJS,q=r.lib,v=q.WordArray,t=q.Hasher,q=r.algo,a=[],u=0;64>u;u++)a[u]=4294967296*s.abs(s.sin(u+1))|0;q=q.MD5=t.extend({_doReset:function(){this._hash=new v.init([1732584193,4023233417,2562383102,271733878])},
_doProcessBlock:function(g,k){for(var b=0;16>b;b++){var h=k+b,w=g[h];g[h]=(w<<8|w>>>24)&16711935|(w<<24|w>>>8)&4278255360}var b=this._hash.words,h=g[k+0],w=g[k+1],j=g[k+2],q=g[k+3],r=g[k+4],s=g[k+5],t=g[k+6],u=g[k+7],v=g[k+8],x=g[k+9],y=g[k+10],z=g[k+11],A=g[k+12],B=g[k+13],C=g[k+14],D=g[k+15],c=b[0],d=b[1],e=b[2],f=b[3],c=p(c,d,e,f,h,7,a[0]),f=p(f,c,d,e,w,12,a[1]),e=p(e,f,c,d,j,17,a[2]),d=p(d,e,f,c,q,22,a[3]),c=p(c,d,e,f,r,7,a[4]),f=p(f,c,d,e,s,12,a[5]),e=p(e,f,c,d,t,17,a[6]),d=p(d,e,f,c,u,22,a[7]),
c=p(c,d,e,f,v,7,a[8]),f=p(f,c,d,e,x,12,a[9]),e=p(e,f,c,d,y,17,a[10]),d=p(d,e,f,c,z,22,a[11]),c=p(c,d,e,f,A,7,a[12]),f=p(f,c,d,e,B,12,a[13]),e=p(e,f,c,d,C,17,a[14]),d=p(d,e,f,c,D,22,a[15]),c=m(c,d,e,f,w,5,a[16]),f=m(f,c,d,e,t,9,a[17]),e=m(e,f,c,d,z,14,a[18]),d=m(d,e,f,c,h,20,a[19]),c=m(c,d,e,f,s,5,a[20]),f=m(f,c,d,e,y,9,a[21]),e=m(e,f,c,d,D,14,a[22]),d=m(d,e,f,c,r,20,a[23]),c=m(c,d,e,f,x,5,a[24]),f=m(f,c,d,e,C,9,a[25]),e=m(e,f,c,d,q,14,a[26]),d=m(d,e,f,c,v,20,a[27]),c=m(c,d,e,f,B,5,a[28]),f=m(f,c,
d,e,j,9,a[29]),e=m(e,f,c,d,u,14,a[30]),d=m(d,e,f,c,A,20,a[31]),c=l(c,d,e,f,s,4,a[32]),f=l(f,c,d,e,v,11,a[33]),e=l(e,f,c,d,z,16,a[34]),d=l(d,e,f,c,C,23,a[35]),c=l(c,d,e,f,w,4,a[36]),f=l(f,c,d,e,r,11,a[37]),e=l(e,f,c,d,u,16,a[38]),d=l(d,e,f,c,y,23,a[39]),c=l(c,d,e,f,B,4,a[40]),f=l(f,c,d,e,h,11,a[41]),e=l(e,f,c,d,q,16,a[42]),d=l(d,e,f,c,t,23,a[43]),c=l(c,d,e,f,x,4,a[44]),f=l(f,c,d,e,A,11,a[45]),e=l(e,f,c,d,D,16,a[46]),d=l(d,e,f,c,j,23,a[47]),c=n(c,d,e,f,h,6,a[48]),f=n(f,c,d,e,u,10,a[49]),e=n(e,f,c,d,
C,15,a[50]),d=n(d,e,f,c,s,21,a[51]),c=n(c,d,e,f,A,6,a[52]),f=n(f,c,d,e,q,10,a[53]),e=n(e,f,c,d,y,15,a[54]),d=n(d,e,f,c,w,21,a[55]),c=n(c,d,e,f,v,6,a[56]),f=n(f,c,d,e,D,10,a[57]),e=n(e,f,c,d,t,15,a[58]),d=n(d,e,f,c,B,21,a[59]),c=n(c,d,e,f,r,6,a[60]),f=n(f,c,d,e,z,10,a[61]),e=n(e,f,c,d,j,15,a[62]),d=n(d,e,f,c,x,21,a[63]);b[0]=b[0]+c|0;b[1]=b[1]+d|0;b[2]=b[2]+e|0;b[3]=b[3]+f|0},_doFinalize:function(){var a=this._data,k=a.words,b=8*this._nDataBytes,h=8*a.sigBytes;k[h>>>5]|=128<<24-h%32;var l=s.floor(b/
4294967296);k[(h+64>>>9<<4)+15]=(l<<8|l>>>24)&16711935|(l<<24|l>>>8)&4278255360;k[(h+64>>>9<<4)+14]=(b<<8|b>>>24)&16711935|(b<<24|b>>>8)&4278255360;a.sigBytes=4*(k.length+1);this._process();a=this._hash;k=a.words;for(b=0;4>b;b++)h=k[b],k[b]=(h<<8|h>>>24)&16711935|(h<<24|h>>>8)&4278255360;return a},clone:function(){var a=t.clone.call(this);a._hash=this._hash.clone();return a}});r.MD5=t._createHelper(q);r.HmacMD5=t._createHmacHelper(q)})(Math);
JSMD5;
