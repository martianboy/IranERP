<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{$this->pageTitle}</title>

    <script src="{$this->baseUrl}/js/jquery/jquery-1.6.2.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.core.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.widget.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.position.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.menu.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.button.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.popup.js"></script>
    <script src="{$this->baseUrl}/js/jquery/ui/jquery.ui.tabs.js"></script>

    <link rel="stylesheet" href="{$this->baseUrl}/css/jquery/base/jquery.ui.all.css" type="text/css" />
    <style type="text/css">
        @font-face {
            font-family: Nazli;
            src: local(Nazli),   /* full font name */
               url({$this->baseUrl}/css/fonts/nazli.ttf);  /* otherwise, download it */
        }
        @font-face {
            font-family: Nazli;
            src: local(Nazli Bold),   /* full font name */
               local(Nazli-Bold),   /* Postscript name */
               url({$this->baseUrl}/css/fonts/nazlib.ttf);  /* otherwise, download it */
            font-weight: bold;
        }
        @font-face {
            font-family: Roya;
            src: local(Roya),   /* full font name */
               url({$this->baseUrl}/css/fonts/roya.ttf);  /* otherwise, download it */
        }
        @font-face {
            font-family: Roya;
            src: local(Roya Bold),   /* full font name */
               local(Roya-Bold),   /* Postscript name */
               url({$this->baseUrl}/css/fonts/royab.ttf);  /* otherwise, download it */
            font-weight: bold;
        }
		html, body, div, h1, h2, h3, h4, h5, h6, p, img, dl, dt, dd, ol, ul, li, table, tr, td, form, object, embed, article, aside, canvas, command, details, fieldset, figcaption, figure, footer, group, header, hgroup, legend, mark, menu, meter, nav, output, progress, section, summary, time, audio, video {
			margin: 0;
			padding: 0;
			border: 0;
			border-image: initial;
		}
    	body {
    		direction: rtl;
    		font-family: Roya, Helvetica, Arial, sans-serif;
    	}
    	h1, h2, h3, h4, h5, h6 {
    	}
    	a {
    		text-decoration: none;
    		color: #15C;
    	}
    	a:hover {
    		text-decoration: underline;
    	}
        label {
            cursor: default;
        }
    	button, input, select, textarea {
			font-family: inherit;
			font-size: inherit;
		}
    	input[type=text],
    	input[type=password] {
    	    box-sizing: border-box;
    	    -moz-box-sizing: border-box;
    	    -webkit-box-sizing: border-box;
    	    border: 1px solid #D9D9D9;
    	    padding: 0 8px;
    	    border-radius: 1px;
    	    border: 1px solid #D9D9D9;
    	    border-top: 1px solid silver;
    	}
    	input[type="button"], input[type="submit"], input[type="reset"], input[type="file"] ::-webkit-file-upload-button, button {
	        padding: 1px 10px;
	    }
        input[type=checkbox],
        input[type=radio] {
            -webkit-appearance: none;
            appearance: none;
            width: 13px;
            height: 13px;
            margin: 0;
            cursor: pointer;
            vertical-align: middle;
            background: #fff;
            border: 1px solid #dcdcdc;
            -webkit-border-radius: 1px;
            -moz-border-radius: 1px;
            border-radius: 1px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            position: relative;
        }
        input[type=checkbox]:active,
        input[type=radio]:active {
            border-color: #c6c6c6;
            background: #ebebeb;
        }
        input[type=checkbox]:hover {
            border-color: #c6c6c6;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
            -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
            box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
        }
        input[type=radio] {
            -webkit-border-radius: 1em;
            -moz-border-radius: 1em;
            border-radius: 1em;
            width: 15px;
            height: 15px;
        }
        input[type=checkbox]:checked,
        input[type=radio]:checked {
            background: #fff;
        }
        input[type=radio]:checked::after {
            content: '';
            display: block;
            position: relative;
            top: 3px;
            left: 3px;
            width: 7px;
            height: 7px;
            background: #666;
            -webkit-border-radius: 1em;
            -moz-border-radius: 1em;
            border-radius: 1em;
        }
        input[type=checkbox]:checked::after {
            content: url(//ssl.gstatic.com/ui/v1/menu/checkmark.png);
            display: block;
            position: absolute;
            top: -6px;
            left: -5px;
        }
        input[type=checkbox]:focus {
            outline: none;
            border-color:#4d90fe;
        }
        #wrapper {
            margin: 0 auto;
            width: 400px;
        }
        
        .formLabel {
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
	    .formButton {
            display: inline-block;
            min-width: 46px;
            text-align: center;
            color: #444;
            font-size: 13px;
            font-weight: bold;
            height: 28px;
            padding: 0 8px;
            line-height: 27px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            transition: all 0.22s;
            -moz-transition: all 0.22s;
            -webkit-transition: all 0.22s;
            border: 1px solid #dcdcdc;
            background-color: whiteSmoke;
            background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
            background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
            background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
            cursor: default;
            user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
        }
        .formButton:hover {
            border: 1px solid #c6c6c6;
            color: #333;
            text-decoration: none;
            -webkit-transition: all 0.0s;
            -moz-transition: all 0.0s;
            -ms-transition: all 0.0s;
            -o-transition: all 0.0s;
            transition: all 0.0s;
            background-color: #f8f8f8;
            background-image: -webkit-gradient(linear,left top,left bottom,from(#f8f8f8),to(#f1f1f1));
            background-image: -webkit-linear-gradient(top,#f8f8f8,#f1f1f1);
            background-image: -moz-linear-gradient(top,#f8f8f8,#f1f1f1);
            background-image: -ms-linear-gradient(top,#f8f8f8,#f1f1f1);
            background-image: -o-linear-gradient(top,#f8f8f8,#f1f1f1);
            background-image: linear-gradient(top,#f8f8f8,#f1f1f1);
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }
        .formButton:active {
            background-color: #f6f6f6;
            background-image: -webkit-gradient(linear,left top,left bottom,from(#f6f6f6),to(#f1f1f1));
            background-image: -webkit-linear-gradient(top,#f6f6f6,#f1f1f1);
            background-image: -moz-linear-gradient(top,#f6f6f6,#f1f1f1);
            background-image: -ms-linear-gradient(top,#f6f6f6,#f1f1f1);
            background-image: -o-linear-gradient(top,#f6f6f6,#f1f1f1);
            background-image: linear-gradient(top,#f6f6f6,#f1f1f1);
            -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
            -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
        .formButton:visited {
            color: #666;
        }

        .formButtonSubmit {
            text-shadow: 0 1px rgba(0,0,0,0.1);
        }
        button.formButton,
        input[type=submit].formButton {
    	    line-height: 29px;
    	    vertical-align: bottom;
    	    margin: 0;
    	    height: 29px;
        }

        .loginBox {
        	background-color: whiteSmoke;
        	border: 1px solid #e5e5e5;
        	padding: 20px 25px 15px;
        	margin: 16px 0 0;
        }
        .loginBox h2 {
			font-size: 18px;
			line-height: 17px;
			height: 17px;
			margin: 0 0 1.2em;
			position: relative;
			font-family: Nazli; 
        }
        .loginBox div {
        	margin: 0 0 1em;
        }
        .loginBox .formLabel {
            margin: 0 0 0.2em;
            display: block;
        }
    	.loginBox input[type=text],
    	.loginBox input[type=password] {
    		height: 32px;
    		font-size: 15px;
    		width: 100%;
    	}
    	.loginBox input[type=submit] {
    		margin: 0 0 1.2em 1.5em;
			height: 32px;
			font-size: 17px;
    	}
    	.loginBox input[type=submit].formButton {
    	}
    	.loginBox ul {
			margin: 0;
		}
		.loginBox ul li {
			list-style-type: none;
			margin: 0 0 .5em;
		}
        .loginBox label {
        	display: block;
        }
        .loginBox label.rememberMeCheckbox {
            display: inline-block;
            margin: 4px 0 0;
            vertical-align: top;
        }
        .loginBox .rememberMeLabel {
            padding: 0 0.4em 0 0;
            color: #666;
            line-height: 0;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        .loginBox .usernameField input,
        .loginBox .passwordField input {
            font-family: Helvetica, Arial, sans-serif;
            text-align: left;
            direction: ltr;
        }
    </style>
</head>
<body>
<div id="wrapper">
	<div class="loginBox">
		<h2>واردشدن به سامانه</h2>
    	<form action="{$this->baseUrl}/session" method="POST">
    		<div class="usernameField">
    			<label for="username"><strong class="formLabel">نام کاربری</strong></label>
    			<input type="text" id="username" name="username" spellcheck="false">
    		</div>
    		<div class="passwordField">
    			<label for="password"><strong class="formLabel">گذرواژه</strong></label>
    			<input type="password" name="password" id="password">
    		</div>
    		<input type="hidden" name="op" id="op" value="login"></input>
        	<input class="formButton formButtonSubmit" type="submit" name="logIn" id="logIn" value="وارد شو">
                <label class="rememberMeCheckbox">
                    <input type="checkbox" name="rememberMe" id="rememberMe" value="yes">
                    <span class="rememberMeLabel">مرا به خاطر بسپار</span>
                    </input>
                </label>
    	</form>
    	<ul>
    		<li><a href="{$this->baseUrl}/recoverAccount">نمی‌توانید وارد شوید؟</a></li>
    	</ul>
    </div>
</div>
</body>
</html>
