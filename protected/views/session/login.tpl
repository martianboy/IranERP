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

    <script type="text/javascript">
        $(function() {
            $("#submit").button();
        });
    </script>

    <link rel="stylesheet" href="{$this->baseUrl}/css/jquery/base/jquery.ui.all.css" type="text/css" />
    <style type="text/css">
    	body {
    		direction: rtl;
    	}
        #wrapper {
            margin: 0 auto;
            width: 400px;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <form action="{$this->baseUrl}/session" method="POST">
        <table style="width: 100%">
            <tr>
                <td><label for="username">نام کاربری</label></td>
                <td><input id="username" name="username"></input></td>
            </tr>
            <tr>
                <td><label for="password">گذرواژه</label></td>
                <td><input id="password" name="password" type="password"></input></td>
            </tr>
            <tr>
                <td><input type="hidden" name="op" id="op" value="login"></input></td>
                <td><button type="submit" name="submit" id="submit">ورود</button></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
