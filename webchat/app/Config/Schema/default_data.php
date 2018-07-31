<?php

/**
 * This is a data-loading file which is inserted into the 
 * installation routine so as to create the default themes.
 * 
 * Included in schema's ::after() callback:
 * include APP . 'Config' . DS . 'Schema' . DS . 'default_data.php';
 * 
 */
/**
 * Default Translations
 * The default translation-JSON is saved in the actual InstallerController since
 * the Settings-record will be created there.
 * 
 */
// Adding Default Styles
$Style = ClassRegistry::init('Style');

// Default Style: Blue
$styleBlueCSS = <<<CHATSTYLE
.vc_chat_container
{
	width:379px;
	position:fixed;
	bottom:0;
	right:50px;
	z-index:9999;
	background-color:transparent;
}

.vc_chat_container *
{
	font-family:Arial,Helvetica,sans-serif;
	font-size:13px;
	margin:0;
	padding:0;
}

.vc_chat_container p
{
	margin:5px 0;
}

.vc_signup_wrapper
{
	max-height:375px;
}

.vc_conversation_container
{
	max-height:375px;
	list-style:none;
	overflow:auto;
	margin:0;
	padding:20px 10px;
}

.vc_conversation_container a
{
	color:#036;
}

.vc_conversation_container a.vc_btn_style
{
	color:#fff;
}

div.vc_chat_head
{
	color:#fff;
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_blue.png);
	height:52px;
	line-height:55px;
	cursor:pointer;
}

.vc_chat_head-title
{
	margin:5px 0 0 15px;
	color: #fff;
}

.vc_header_icon
{
	display:block;
	background-image:url({BaseURL}img/icon_visitorchat.png);
	width:21px;
	height:16px;
	float:right;
	margin:15px 75px 0 0;
}

.vc_header_icon span.vc_notification_badge span
{
	display:block;
	height:16px;
	width:15px;
	text-align:center;
	font-size:9px;
	color:#555;
	position:relative;
	top:-20px;
	left:4px;
	margin:0;
	padding:0;
}

.vc_sub-head-spacer
{
	padding:1px;
}

.vc_conversation
{
	display:none;
	margin:0 12px 0 11px;
}

.vc_chat_toggle_container
{
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_blue.png) center -52px;
	display:none;
}

.vc_signup_wrapper,.vc_notifications_wrapper,.vc_enquiry_wrapper
{
	display:none;
	overflow:auto;
	line-height:1;
	padding:25px;
}

.vc_exit_chat_container
{
	text-align:right;
	width:95%;
	margin:0 auto;
	padding:5px 1px 0 0;
}

.vc_exit_chat_container span,.vc_exit_chat_container a
{
	font-size:80%;
	color:#666;
	text-decoration:none;
}

.vc_exit_chat_container a:hover
{
	color:#333;
}

a.vc_btn_exit_chat_confirm:hover
{
	color:red;
}

a.vc_btn_exit_chat_cancel:hover
{
	color:#0c0;
}

form.vc_form_reply
{
	position:relative;
}

.vc_form_reply
{
	background-color:#e3e3e3;
	text-align:center;
	border-top:1px solid #d3d3d3;
}

.vc_input_message
{
	height:100px;
	margin:10px auto 5px;
}

.vc_input_enquiry_message
{
	height:100px;
}

.vc_form_signup,.vc_form_enquiry
{
	text-align:center;
}

.vc_chat_container textarea,.vc_chat_container input[type=text]
{
	width:95%;
	min-width:95%;
	max-width:95%;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	background-color:#fff;
	border:1px solid #ccc;
	-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-webkit-transition:border linear .2s, box-shadow linear .2s;
	-moz-transition:border linear .2s, box-shadow linear .2s;
	-o-transition:border linear .2s, box-shadow linear .2s;
	transition:border linear .2s, box-shadow linear .2s;
	display:inline-block;
	font-size:14px;
	line-height:20px;
	color:#555;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	vertical-align:middle;
	margin:3px 0;
	padding:4px 6px;
}

.vc_chat_container input[type=text]
{
  	height: 30px;
}

.vc_message_sending textarea, .vc_enquiry_sending textarea
{
  	background: #fff url({BaseURL}img/styles/loading.gif) 98% 5px no-repeat;
}

.vc_chatrow
{
	display:block;
	border-top:1px dashed #e3e3e3;
	margin:5px 0;
  	clear: both;
}

.vc_chatrow p
{
	color:#444;
	word-wrap:break-word;
}

.vc_time
{
	float:right;
	font-size:80%;
	color:#ccc;
	padding-left:12px;
	margin:3px;
}

.vc_submission_pending
{
	background:transparent url({BaseURL}img/bullet_clock.png) left center no-repeat;
}

.vc_submission_confirmed
{
	background:transparent url({BaseURL}img/bullet_tick.png) left center no-repeat;
}

.vc_username
{
	font-weight:700;
}

.vc_username:after
{
	content:":";
}

.vc_avatar
{
  	float: left;
  	margin: 0 5px 5px 0;
  	display: inline-block;
  	width: 40px;
  	height: 40px;
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	-webkit-border-radius: 5px;
}

.vc_smilie
{
	background-repeat:no-repeat;
	display:inline-block;
	width:15px;
	height:17px;
	text-indent:-9999px;
	white-space:nowrap;
}

.vc_btn_load_more
{
	width:100%!important;
}

.vc_notifications_wrapper
{
	text-shadow:0 1px 0 rgba(255,255,255,0.5);
}

.vc_notification_success
{
	color:#468847;
}

.vc_notification_error
{
	color:#b94a48;
}

.vc_errorlist
{
	margin:0 0 0 25px;
	padding:0;
}

i.vc_btn_notifications_close
{
	float:right;
	font-weight:700;
	font-size:20px;
	color:#ccc;
	cursor:pointer;
	margin:-15px 0 0;
	padding:0;
}

.vc_btn_style
{
	width:95%;
	text-align:center;
	line-height:1.2;
	font-size:90%;
	-moz-box-shadow:inset 0 1px 0 0 #3f8ff2;
	-webkit-box-shadow:inset 0 1px 0 0 #3f8ff2;
	box-shadow:inset 0 1px 0 0 #3f8ff2;
	background:0;
	background-color:#1c5694;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #172f52;
	display:inline-block;
	color:#fff;
	font-weight:700;
	text-decoration:none;
	text-shadow:1px 1px 0 #000c17;
	margin:0 auto 5px;
	padding:2px 0;
}

.vc_btn_style:hover
{
	background:0;
	background-color:#00307d;
    color: #fff;
  	text-decoration: none;
}

.vc_btn_style:active
{
	position:relative;
	top:1px;
}

.vc_composing_container 
{
  	display: none;
  width: 95%;
  margin: 0 auto;
  background: transparent url({BaseURL}img/bullet_pencil.png) 6px center no-repeat;
  padding-left: 19px;
  font-style: italic;
}

@media only screen and (max-height: 620px) {
	.vc_conversation_container
	{
		max-height:300px!important;
	}
}

@media only screen and (max-height: 545px) {
	.vc_conversation_container
	{
		max-height:200px!important;
	}
}

@media only screen and (max-height: 445px) {
	.vc_conversation_container
	{
		max-height:150px!important;
	}
}

@media only screen and (max-width: 480px) {
	.vc_chat_container
	{
		width:95%!important;
		right:auto!important;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		box-shadow:0 0 5px rgba(0,0,0,.5);
		-webkit-box-shadow:0 0 5px rgba(0,0,0,.5);
		-moz-box-shadow:0 0 5px rgba(0,0,0,.5);
	}
	
	div.vc_chat_head
	{
		background-color:#036;
		background-image:none;
		line-height:25px;
		height:auto;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		padding:10px;
	}
	
	.vc_chat_toggle_container
	{
		background-color:#fff;
		background-image:none;
		border-color:#036;
		border-style:solid;
		border-width:0 1px;
	}
	
	.vc_header_icon
	{
		background-image:url({BaseURL}img/icon_visitorchat.png);
		margin:0;
	}
	
	.vc_header_icon span.vc_notification_badge span
	{
		top:-5px;
		left:5px;
	}
	
	.vc_notification_success
	{
		background-color:#dff0d8;
		border:1px solid #d6e9c6;
	}
	
	.vc_conversation_container
	{
		max-height:375px;
		border-color:#036;
	}
	
	.vc_notification_error
	{
		background-color:#f2dede;
		border:1px solid #eed3d7;
	}
	
	.vc_sub-head-spacer
	{
		display:none;
		padding:0;
	}
	
	.vc_chat_head-title,.vc_conversation
	{
		margin:0;
	}
}
CHATSTYLE;

$styleBlue = array('Style' => array(
        'title' => 'Default - Blue',
        'css' => $styleBlueCSS,
        ));

$Style->create();
$Style->save($styleBlue);
// Default Style: Blue
// Default Style: Red
$styleRedCSS = <<<CHATSTYLE
.vc_chat_container
{
	width:379px;
	position:fixed;
	bottom:0;
	right:50px;
	z-index:9999;
	background-color:transparent;
}

.vc_chat_container *
{
	font-family:Arial,Helvetica,sans-serif;
	font-size:13px;
	margin:0;
	padding:0;
}

.vc_chat_container p
{
	margin:5px 0;
}

.vc_signup_wrapper
{
	max-height:375px;
}

.vc_conversation_container
{
	max-height:375px;
	list-style:none;
	overflow:auto;
	margin:0;
	padding:20px 10px;
}

.vc_conversation_container a
{
	color:#af2c17;
}

.vc_conversation_container a.vc_btn_style
{
	color:#fff;
}

div.vc_chat_head
{
	color:#fff;
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_red.png);
	height:52px;
	line-height:55px;
	cursor:pointer;
}

.vc_chat_head-title
{
	margin:5px 0 0 15px;
	color: #fff;
}

.vc_header_icon
{
	display:block;
	background-image:url({BaseURL}img/icon_visitorchat.png);
	width:21px;
	height:16px;
	float:right;
	margin:15px 75px 0 0;
}

.vc_header_icon span.vc_notification_badge span
{
	display:block;
	height:16px;
	width:15px;
	text-align:center;
	font-size:9px;
	color:#555;
	position:relative;
	top:-20px;
	left:4px;
	margin:0;
	padding:0;
}

.vc_sub-head-spacer
{
	padding:1px;
}

.vc_conversation
{
	display:none;
	margin:0 12px 0 11px;
}

.vc_chat_toggle_container
{
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_red.png) center -52px;
	display:none;
}

.vc_signup_wrapper,.vc_notifications_wrapper,.vc_enquiry_wrapper
{
	display:none;
	overflow:auto;
	line-height:1;
	padding:25px;
}

.vc_exit_chat_container
{
	text-align:right;
	width:95%;
	margin:0 auto;
	padding:5px 1px 0 0;
}

.vc_exit_chat_container span,.vc_exit_chat_container a
{
	font-size:80%;
	color:#666;
	text-decoration:none;
}

.vc_exit_chat_container a:hover
{
	color:#333;
}

a.vc_btn_exit_chat_confirm:hover
{
	color:red;
}

a.vc_btn_exit_chat_cancel:hover
{
	color:#0c0;
}

form.vc_form_reply
{
	position:relative;
}

.vc_form_reply
{
	background-color:#e3e3e3;
	text-align:center;
	border-top:1px solid #d3d3d3;
}

.vc_input_message
{
	height:100px;
	margin:10px auto 5px;
}

.vc_input_enquiry_message
{
	height:100px;
}

.vc_form_signup,.vc_form_enquiry
{
	text-align:center;
}

.vc_chat_container textarea,.vc_chat_container input[type=text]
{
	width:95%;
	min-width:95%;
	max-width:95%;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	background-color:#fff;
	border:1px solid #ccc;
	-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-webkit-transition:border linear .2s, box-shadow linear .2s;
	-moz-transition:border linear .2s, box-shadow linear .2s;
	-o-transition:border linear .2s, box-shadow linear .2s;
	transition:border linear .2s, box-shadow linear .2s;
	display:inline-block;
	font-size:14px;
	line-height:20px;
	color:#555;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	vertical-align:middle;
	margin:3px 0;
	padding:4px 6px;
}

.vc_chat_container input[type=text]
{
  	height: 30px;
}

.vc_message_sending textarea, .vc_enquiry_sending textarea
{
  	background: #fff url({BaseURL}img/styles/loading.gif) 98% 5px no-repeat;
}

.vc_chatrow
{
	display:block;
	border-top:1px dashed #e3e3e3;
	margin:5px 0;
  	clear: both;
}

.vc_chatrow p
{
	color:#444;
	word-wrap:break-word;
}

.vc_time
{
	float:right;
	font-size:80%;
	color:#ccc;
	padding-left:12px;
	margin:3px;
}

.vc_submission_pending
{
	background:transparent url({BaseURL}img/bullet_clock.png) left center no-repeat;
}

.vc_submission_confirmed
{
	background:transparent url({BaseURL}img/bullet_tick.png) left center no-repeat;
}

.vc_username
{
	font-weight:700;
}

.vc_username:after
{
	content:":";
}

.vc_avatar
{
  	float: left;
  	margin: 0 5px 5px 0;
  	display: inline-block;
  	width: 40px;
  	height: 40px;
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	-webkit-border-radius: 5px;
}

.vc_smilie
{
	background-repeat:no-repeat;
	display:inline-block;
	width:15px;
	height:17px;
	text-indent:-9999px;
	white-space:nowrap;
}

.vc_btn_load_more
{
	width:100%!important;
}

.vc_notifications_wrapper
{
	text-shadow:0 1px 0 rgba(255,255,255,0.5);
}

.vc_notification_success
{
	color:#468847;
}

.vc_notification_error
{
	color:#b94a48;
}

.vc_errorlist
{
	margin:0 0 0 25px;
	padding:0;
}

i.vc_btn_notifications_close
{
	float:right;
	font-weight:700;
	font-size:20px;
	color:#ccc;
	cursor:pointer;
	margin:-15px 0 0;
	padding:0;
}

.vc_btn_style
{
	width:95%;
	text-align:center;
	line-height:1.2;
	font-size:90%;
	-moz-box-shadow:inset 0 1px 0 0 #f29c93;
	-webkit-box-shadow:inset 0 1px 0 0 #f29c93;
	box-shadow:inset 0 1px 0 0 #f29c93;
	background:0;
	background-color:#af2c17;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #af2c17;
	display:inline-block;
	color:#fff;
	font-weight:700;
	text-decoration:none;
	text-shadow:1px 1px 0 #000c17;
	margin:0 auto 5px;
	padding:2px 0;
}

.vc_btn_style:hover
{
	background:0;
	background-color:#962615;
  	color: #fff;
  	text-decoration: none;
}

.vc_btn_style:active
{
	position:relative;
	top:1px;
}

.vc_composing_container 
{
  	display: none;
  width: 95%;
  margin: 0 auto;
  background: transparent url({BaseURL}img/bullet_pencil.png) 6px center no-repeat;
  padding-left: 19px;
  font-style: italic;
}

@media only screen and (max-height: 620px) {
	.vc_conversation_container
	{
		max-height:300px!important;
	}
}

@media only screen and (max-height: 545px) {
	.vc_conversation_container
	{
		max-height:200px!important;
	}
}

@media only screen and (max-height: 445px) {
	.vc_conversation_container
	{
		max-height:150px!important;
	}
}

@media only screen and (max-width: 480px) {
	.vc_chat_container
	{
		width:95%!important;
		right:auto!important;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		box-shadow:0 0 5px rgba(0,0,0,.5);
		-webkit-box-shadow:0 0 5px rgba(0,0,0,.5);
		-moz-box-shadow:0 0 5px rgba(0,0,0,.5);
	}
	
	div.vc_chat_head
	{
		background-color:#af2c17;
		background-image:none;
		line-height:25px;
		height:auto;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		padding:10px;
	}
	
	.vc_chat_toggle_container
	{
		background-color:#fff;
		background-image:none;
		border-color:#af2c17;
		border-style:solid;
		border-width:0 1px;
	}
	
	.vc_header_icon
	{
		background-image:url({BaseURL}img/icon_visitorchat.png);
		margin:0;
	}
	
	.vc_header_icon span.vc_notification_badge span
	{
		top:-5px;
		left:5px;
	}
	
	.vc_notification_success
	{
		background-color:#dff0d8;
		border:1px solid #d6e9c6;
	}
	
	.vc_conversation_container
	{
		max-height:375px;
		border-color:#af2c17;
	}
	
	.vc_notification_error
	{
		background-color:#f2dede;
		border:1px solid #eed3d7;
	}
	
	.vc_sub-head-spacer
	{
		display:none;
		padding:0;
	}
	
	.vc_chat_head-title,.vc_conversation
	{
		margin:0;
	}
}
CHATSTYLE;

$styleRed = array('Style' => array(
        'title' => 'Default - Red',
        'css' => $styleRedCSS,
        ));

$Style->create();
$Style->save($styleRed);
// Default Style: Red
// Default Style: Green
$styleGreenCSS = <<<CHATSTYLE
.vc_chat_container
{
	width:379px;
	position:fixed;
	bottom:0;
	right:50px;
	z-index:9999;
	background-color:transparent;
}

.vc_chat_container *
{
	font-family:Arial,Helvetica,sans-serif;
	font-size:13px;
	margin:0;
	padding:0;
}

.vc_chat_container p
{
	margin:5px 0;
}

.vc_signup_wrapper
{
	max-height:375px;
}

.vc_conversation_container
{
	max-height:375px;
	list-style:none;
	overflow:auto;
	margin:0;
	padding:20px 10px;
}

.vc_conversation_container a
{
	color:#8bb82b;
}

.vc_conversation_container a.vc_btn_style
{
	color:#fff;
}

div.vc_chat_head
{
	color:#fff;
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_green.png);
	height:52px;
	line-height:55px;
	cursor:pointer;
}

.vc_chat_head-title
{
	margin:5px 0 0 15px;
	color: #fff;
}

.vc_header_icon
{
	display:block;
	background-image:url({BaseURL}img/icon_visitorchat.png);
	width:21px;
	height:16px;
	float:right;
	margin:15px 75px 0 0;
}

.vc_header_icon span.vc_notification_badge span
{
	display:block;
	height:16px;
	width:15px;
	text-align:center;
	font-size:9px;
	color:#555;
	position:relative;
	top:-20px;
	left:4px;
	margin:0;
	padding:0;
}

.vc_sub-head-spacer
{
	padding:1px;
}

.vc_conversation
{
	display:none;
	margin:0 12px 0 11px;
}

.vc_chat_toggle_container
{
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_green.png) center -52px;
	display:none;
}

.vc_signup_wrapper,.vc_notifications_wrapper,.vc_enquiry_wrapper
{
	display:none;
	overflow:auto;
	line-height:1;
	padding:25px;
}

.vc_exit_chat_container
{
	text-align:right;
	width:95%;
	margin:0 auto;
	padding:5px 1px 0 0;
}

.vc_exit_chat_container span,.vc_exit_chat_container a
{
	font-size:80%;
	color:#666;
	text-decoration:none;
}

.vc_exit_chat_container a:hover
{
	color:#333;
}

a.vc_btn_exit_chat_confirm:hover
{
	color:red;
}

a.vc_btn_exit_chat_cancel:hover
{
	color:#0c0;
}

form.vc_form_reply
{
	position:relative;
}

.vc_form_reply
{
	background-color:#e3e3e3;
	text-align:center;
	border-top:1px solid #d3d3d3;
}

.vc_input_message
{
	height:100px;
	margin:10px auto 5px;
}

.vc_input_enquiry_message
{
	height:100px;
}

.vc_form_signup,.vc_form_enquiry
{
	text-align:center;
}

.vc_chat_container textarea,.vc_chat_container input[type=text]
{
	width:95%;
	min-width:95%;
	max-width:95%;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	background-color:#fff;
	border:1px solid #ccc;
	-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-webkit-transition:border linear .2s, box-shadow linear .2s;
	-moz-transition:border linear .2s, box-shadow linear .2s;
	-o-transition:border linear .2s, box-shadow linear .2s;
	transition:border linear .2s, box-shadow linear .2s;
	display:inline-block;
	font-size:14px;
	line-height:20px;
	color:#555;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	vertical-align:middle;
	margin:3px 0;
	padding:4px 6px;
}

.vc_chat_container input[type=text]
{
  	height: 30px;
}

.vc_message_sending textarea, .vc_enquiry_sending textarea
{
  	background: #fff url({BaseURL}img/styles/loading.gif) 98% 5px no-repeat;
}

.vc_chatrow
{
	display:block;
	border-top:1px dashed #e3e3e3;
	margin:5px 0;
  	clear: both;
}

.vc_chatrow p
{
	color:#444;
	word-wrap:break-word;
}

.vc_time
{
	float:right;
	font-size:80%;
	color:#ccc;
	padding-left:12px;
	margin:3px;
}

.vc_submission_pending
{
	background:transparent url({BaseURL}img/bullet_clock.png) left center no-repeat;
}

.vc_submission_confirmed
{
	background:transparent url({BaseURL}img/bullet_tick.png) left center no-repeat;
}

.vc_username
{
	font-weight:700;
}

.vc_username:after
{
	content:":";
}

.vc_avatar
{
  	float: left;
  	margin: 0 5px 5px 0;
  	display: inline-block;
  	width: 40px;
  	height: 40px;
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	-webkit-border-radius: 5px;
}

.vc_smilie
{
	background-repeat:no-repeat;
	display:inline-block;
	width:15px;
	height:17px;
	text-indent:-9999px;
	white-space:nowrap;
}

.vc_btn_load_more
{
	width:100%!important;
}

.vc_notifications_wrapper
{
	text-shadow:0 1px 0 rgba(255,255,255,0.5);
}

.vc_notification_success
{
	color:#468847;
}

.vc_notification_error
{
	color:#b94a48;
}

.vc_errorlist
{
	margin:0 0 0 25px;
	padding:0;
}

i.vc_btn_notifications_close
{
	float:right;
	font-weight:700;
	font-size:20px;
	color:#ccc;
	cursor:pointer;
	margin:-15px 0 0;
	padding:0;
}

.vc_btn_style
{
	width:95%;
	text-align:center;
	line-height:1.2;
	font-size:90%;
	-moz-box-shadow:inset 0 1px 0 0 #c1ed9c;
	-webkit-box-shadow:inset 0 1px 0 0 #c1ed9c;
	box-shadow:inset 0 1px 0 0 #c1ed9c;
	background:0;
	background-color:#9dce2c;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #83c41a;
	display:inline-block;
	color:#fff;
	font-weight:700;
	text-decoration:none;
	text-shadow:1px 1px 0 #689324;
	margin:0 auto 5px;
	padding:2px 0;
}

.vc_btn_style:hover
{
	background:0;
	background-color:#8bb82b;
    color: #fff;
  	text-decoration: none;
}

.vc_btn_style:active
{
	position:relative;
	top:1px;
}

.vc_composing_container 
{
  	display: none;
  width: 95%;
  margin: 0 auto;
  background: transparent url({BaseURL}img/bullet_pencil.png) 6px center no-repeat;
  padding-left: 19px;
  font-style: italic;
}

@media only screen and (max-height: 620px) {
	.vc_conversation_container
	{
		max-height:300px!important;
	}
}

@media only screen and (max-height: 545px) {
	.vc_conversation_container
	{
		max-height:200px!important;
	}
}

@media only screen and (max-height: 445px) {
	.vc_conversation_container
	{
		max-height:150px!important;
	}
}

@media only screen and (max-width: 480px) {
	.vc_chat_container
	{
		width:95%!important;
		right:auto!important;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		box-shadow:0 0 5px rgba(0,0,0,.5);
		-webkit-box-shadow:0 0 5px rgba(0,0,0,.5);
		-moz-box-shadow:0 0 5px rgba(0,0,0,.5);
	}
	
	div.vc_chat_head
	{
		background-color:#8bb82b;
		background-image:none;
		line-height:25px;
		height:auto;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		padding:10px;
	}
	
	.vc_chat_toggle_container
	{
		background-color:#fff;
		background-image:none;
		border-color:#8bb82b;
		border-style:solid;
		border-width:0 1px;
	}
	
	.vc_header_icon
	{
		background-image:url({BaseURL}img/icon_visitorchat.png);
		margin:0;
	}
	
	.vc_header_icon span.vc_notification_badge span
	{
		top:-5px;
		left:5px;
	}
	
	.vc_notification_success
	{
		background-color:#dff0d8;
		border:1px solid #d6e9c6;
	}
	
	.vc_conversation_container
	{
		max-height:375px;
		border-color:#8bb82b;
	}
	
	.vc_notification_error
	{
		background-color:#f2dede;
		border:1px solid #eed3d7;
	}
	
	.vc_sub-head-spacer
	{
		display:none;
		padding:0;
	}
	
	.vc_chat_head-title,.vc_conversation
	{
		margin:0;
	}
}
CHATSTYLE;

$styleGreen = array('Style' => array(
        'title' => 'Default - Green',
        'css' => $styleGreenCSS,
        ));

$Style->create();
$Style->save($styleGreen);
// Default Style: Green
// Default Style: Black
$styleBlackCSS = <<<CHATSTYLE
.vc_chat_container
{
	width:379px;
	position:fixed;
	bottom:0;
	right:50px;
	z-index:9999;
	background-color:transparent;
}

.vc_chat_container *
{
	font-family:Arial,Helvetica,sans-serif;
	font-size:13px;
	margin:0;
	padding:0;
}

.vc_chat_container p
{
	margin:5px 0;
}

.vc_signup_wrapper
{
	max-height:375px;
}

.vc_conversation_container
{
	max-height:375px;
	list-style:none;
	overflow:auto;
	margin:0;
	padding:20px 10px;
}

.vc_conversation_container a
{
	color:#151515;
}

.vc_conversation_container a.vc_btn_style
{
	color:#fff;
}

div.vc_chat_head
{
	color:#fff;
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_black.png);
	height:52px;
	line-height:55px;
	cursor:pointer;
}

.vc_chat_head-title
{
	margin:5px 0 0 15px;
	color: #fff;
}

.vc_header_icon
{
	display:block;
	background-image:url({BaseURL}img/icon_visitorchat.png);
	width:21px;
	height:16px;
	float:right;
	margin:15px 75px 0 0;
}

.vc_header_icon span.vc_notification_badge span
{
	display:block;
	height:16px;
	width:15px;
	text-align:center;
	font-size:9px;
	color:#555;
	position:relative;
	top:-20px;
	left:4px;
	margin:0;
	padding:0;
}

.vc_sub-head-spacer
{
	padding:1px;
}

.vc_conversation
{
	display:none;
	margin:0 12px 0 11px;
}

.vc_chat_toggle_container
{
	background:transparent url({BaseURL}img/styles/backgrounds/vc_background_black.png) center -52px;
	display:none;
}

.vc_signup_wrapper,.vc_notifications_wrapper,.vc_enquiry_wrapper
{
	display:none;
	overflow:auto;
	line-height:1;
	padding:25px;
}

.vc_exit_chat_container
{
	text-align:right;
	width:95%;
	margin:0 auto;
	padding:5px 1px 0 0;
}

.vc_exit_chat_container span,.vc_exit_chat_container a
{
	font-size:80%;
	color:#666;
	text-decoration:none;
}

.vc_exit_chat_container a:hover
{
	color:#333;
}

a.vc_btn_exit_chat_confirm:hover
{
	color:red;
}

a.vc_btn_exit_chat_cancel:hover
{
	color:#0c0;
}

form.vc_form_reply
{
	position:relative;
}

.vc_form_reply
{
	background-color:#e3e3e3;
	text-align:center;
	border-top:1px solid #d3d3d3;
}

.vc_input_message
{
	height:100px;
	margin:10px auto 5px;
}

.vc_input_enquiry_message
{
	height:100px;
}

.vc_form_signup,.vc_form_enquiry
{
	text-align:center;
}

.vc_chat_container textarea,.vc_chat_container input[type=text]
{
	width:95%;
	min-width:95%;
	max-width:95%;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	background-color:#fff;
	border:1px solid #ccc;
	-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	box-shadow:inset 0 1px 1px rgba(0,0,0,0.075);
	-webkit-transition:border linear .2s, box-shadow linear .2s;
	-moz-transition:border linear .2s, box-shadow linear .2s;
	-o-transition:border linear .2s, box-shadow linear .2s;
	transition:border linear .2s, box-shadow linear .2s;
	display:inline-block;
	font-size:14px;
	line-height:20px;
	color:#555;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	vertical-align:middle;
	margin:3px 0;
	padding:4px 6px;
}

.vc_chat_container input[type=text]
{
  	height: 30px;
}

.vc_message_sending textarea, .vc_enquiry_sending textarea
{
  	background: #fff url({BaseURL}img/styles/loading.gif) 98% 5px no-repeat;
}

.vc_chatrow
{
	display:block;
	border-top:1px dashed #e3e3e3;
	margin:5px 0;
  	clear: both;
}

.vc_chatrow p
{
	color:#444;
	word-wrap:break-word;
}

.vc_time
{
	float:right;
	font-size:80%;
	color:#ccc;
	padding-left:12px;
	margin:3px;
}

.vc_submission_pending
{
	background:transparent url({BaseURL}img/bullet_clock.png) left center no-repeat;
}

.vc_submission_confirmed
{
	background:transparent url({BaseURL}img/bullet_tick.png) left center no-repeat;
}

.vc_username
{
	font-weight:700;
}

.vc_username:after
{
	content:":";
}

.vc_avatar
{
  	float: left;
  	margin: 0 5px 5px 0;
  	display: inline-block;
  	width: 40px;
  	height: 40px;
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	-webkit-border-radius: 5px;
}

.vc_smilie
{
	background-repeat:no-repeat;
	display:inline-block;
	width:15px;
	height:17px;
	text-indent:-9999px;
	white-space:nowrap;
}

.vc_btn_load_more
{
	width:100%!important;
}

.vc_notifications_wrapper
{
	text-shadow:0 1px 0 rgba(255,255,255,0.5);
}

.vc_notification_success
{
	color:#468847;
}

.vc_notification_error
{
	color:#b94a48;
}

.vc_errorlist
{
	margin:0 0 0 25px;
	padding:0;
}

i.vc_btn_notifications_close
{
	float:right;
	font-weight:700;
	font-size:20px;
	color:#ccc;
	cursor:pointer;
	margin:-15px 0 0;
	padding:0;
}

.vc_btn_style
{
	width:95%;
	text-align:center;
	line-height:1.2;
	font-size:90%;
	-moz-box-shadow:inset 0 1px 0 0 #bababa;
	-webkit-box-shadow:inset 0 1px 0 0 #bababa;
	box-shadow:inset 0 1px 0 0 #bababa;
	background:0;
	background-color:#292929;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	border:1px solid #7a7a7a;
	display:inline-block;
	color:#fff;
	font-weight:700;
	text-decoration:none;
	text-shadow:1px 1px 0 #000;
	margin:0 auto 5px;
	padding:2px 0;
}

.vc_btn_style:hover
{
	background:0;
	background-color:#151515;
    color: #fff;
  	text-decoration: none;
}

.vc_btn_style:active
{
	position:relative;
	top:1px;
}

.vc_composing_container 
{
  	display: none;
  width: 95%;
  margin: 0 auto;
  background: transparent url({BaseURL}img/bullet_pencil.png) 6px center no-repeat;
  padding-left: 19px;
  font-style: italic;
}

@media only screen and (max-height: 620px) {
	.vc_conversation_container
	{
		max-height:300px!important;
	}
}

@media only screen and (max-height: 545px) {
	.vc_conversation_container
	{
		max-height:200px!important;
	}
}

@media only screen and (max-height: 445px) {
	.vc_conversation_container
	{
		max-height:150px!important;
	}
}

@media only screen and (max-width: 480px) {
	.vc_chat_container
	{
		width:95%!important;
		right:auto!important;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		box-shadow:0 0 5px rgba(0,0,0,.5);
		-webkit-box-shadow:0 0 5px rgba(0,0,0,.5);
		-moz-box-shadow:0 0 5px rgba(0,0,0,.5);
	}
	
	div.vc_chat_head
	{
		background-color:#151515;
		background-image:none;
		line-height:25px;
		height:auto;
		-webkit-border-top-left-radius:15px;
		-webkit-border-top-right-radius:15px;
		-moz-border-radius-topleft:15px;
		-moz-border-radius-topright:15px;
		border-top-left-radius:15px;
		border-top-right-radius:15px;
		padding:10px;
	}
	
	.vc_chat_toggle_container
	{
		background-color:#fff;
		background-image:none;
		border-color:#151515;
		border-style:solid;
		border-width:0 1px;
	}
	
	.vc_header_icon
	{
		background-image:url({BaseURL}img/icon_visitorchat.png);
		margin:0;
	}
	
	.vc_header_icon span.vc_notification_badge span
	{
		top:-5px;
		left:5px;
	}
	
	.vc_notification_success
	{
		background-color:#dff0d8;
		border:1px solid #d6e9c6;
	}
	
	.vc_conversation_container
	{
		max-height:375px;
		border-color:#151515;
	}
	
	.vc_notification_error
	{
		background-color:#f2dede;
		border:1px solid #eed3d7;
	}
	
	.vc_sub-head-spacer
	{
		display:none;
		padding:0;
	}
	
	.vc_chat_head-title,.vc_conversation
	{
		margin:0;
	}
}
CHATSTYLE;

$styleBlack = array('Style' => array(
        'title' => 'Default - Black',
        'css' => $styleBlackCSS,
        ));

$Style->create();
$Style->save($styleBlack);
// Default Style: Black
