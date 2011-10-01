<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{$this->pageTitle}</title>
    <link rel="stylesheet" href="{$this->baseUrl}/css/jquery/base/jquery.ui.all.css" type="text/css" />

<!--    <link rel="Stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-darkness/jquery-ui.css" type="text/css" /> -->

    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/jquery-1.6.2.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.position.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.menu.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.button.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.popup.js"></script>
    <script type="text/javascript" src="{$this->baseUrl}/js/jquery/ui/jquery.ui.tabs.js"></script>

    <script type="text/javascript">
    	$(function() {
        	var ali = $("#AppMenuButton").button({
			    icons: {
				    primary: "ui-icon-triangle-1-s"
			    }
		    }).next().menu({
			    select: function(event, ui) {
			        
				    $(this).hide();
			    }
		    });
		    ali.popup();
		    
		    $("#Alerts").button({
		    });
		    
        	$("#Help").button({
			    icons: {
				    primary: "ui-icon-triangle-1-s"
			    }
		    }).next().menu({
			    select: function(event, ui) {
			        alert(event);
				    $(this).hide();
			    }
		    }).popup();

            $("#Profile").button();
            
		    $("#Logout").button({
		        text: false,
		        icons: { primary: "ui-icon-power"}
		    });
		    
		    /***** Tabs ***************/
		    var $tabs = $("#tabs").tabs();
        	var activeTab;
        	var openTabs = [];
        	
        	function getSelectedTabIndex() {
                return $tabs.tabs('option', 'selected');
            }
            
            beginTab = $("#tabs ul li:eq(" + getSelectedTabIndex() + ")").find("a");
            //loadTabFrame($(beginTab).attr("href"),$(beginTab).attr("rel"));
            
            $("a.tabref").click(function() {
                loadTabFrame($(this).attr("href"),$(this).attr("rel"));
            });
            
            function loadTabFrame(tab, url) {
                if ($(tab).find("iframe").length == 0) {
                    var html = [];
                    html.push('<div class="tabIframeWrapper">');
                    html.push('<iframe class="iframetab" src="' + url + '">Load Failed?</iframe>');
                    html.push('</div>');
                    $(tab).append(html.join(""));
                    $(tab).find("iframe").height($(window).height()-80);
                }
                return false;
            }

    	});
    </script>
    
    <style type="text/css">
    	body {
    		direction: rtl;
    	}
    	nav {
    	    margin-bottom: 20px;
    	}
    	.iframetab {
            width:100%;
            height:auto;
            border:0px;
            margin:0px;
            background:url("data/iframeno.png");
            position:relative;
            top:-13px;
        }

    	.ui-widget {
    		font-family: Verdana, "Nazli", sans-serif;
    	}
    	.ui-button-text-icon-secondary .ui-button-text, .ui-button-text-icons .ui-button-text {
            padding: 0.4em 1em 0.4em 2.1em;
        }
        .ui-menubar-item {
            float: right;
        }
        .ui-tabs .ui-tabs-nav li {
            float: right;
        }
        
        .ui-button-text-icon-secondary .ui-button-icon-secondary, .ui-button-text-icons .ui-button-icon-secondary, .ui-button-icons-only .ui-button-icon-secondary {
            left: 0.5em;
            right: auto;
        }
        .ui-menubar {
            padding-left: auto;
            padding-right: 0;
        }
        .ui-menu { width: 200px; position: absolute; z-index: 1000;}
        
        .ui-menu .ui-menu-icon {
            float: left;
            position: static;
        }
    </style>
</head>
<body>
	<div class="wrapper">
	    <nav>
		    <button id="AppMenuButton">منو</button>
		    <ul>
			    <li>
			        <a href="#">منو آیتم ۱</a>
			        <ul>
			            <li><a href="#">سلام</a></li>
			            <li><a href="#">علیک سلام</a></li>
			        </ul>
			    </li>
			    <li><a href="#">منو آیتم ۲</a></li>
			    <li><a href="#">منو آیتم ۳</a></li>
			    <li><a href="#">منو آیتم ۴</a></li>
		    </ul>

		    <button id="Alerts">هشدارها <span id="AlertsCount" style="color: red;">(۴)</span></button>

            <button id="Help">راهنما</button>
            <ul>
                <li><a href="#">درباره</a>
			        <ul>
			            <li><a href="#">سلام</a></li>
			            <li><a href="#">علیک سلام</a></li>
			        </ul>
			    </li>
            </ul>
            
		    <button id="Profile">عباس مشایخ</button>
		    

	        <button id="Logout">خروج</button>
	        
	        <img src="" alt="" id="CorpLogo">
	        <img src="" alt="" id="IRERPLogo">
	    </nav>
	    
	    <div id="tabs">
	        <ul>
	            <li><a href="#Dashboard"><span>میز کار</span></a></li>
	            <li><a class="tabref" href="#Accounting" rel="/menu">حساب‌داری</a></li>
	        </ul>
	        <div id="Dashboard">
	            <p>تست تست تست</p>
	        </div>
	        <div id="Accounting">
	        </div>
	    </div>
	</div>
</body>
</html>
