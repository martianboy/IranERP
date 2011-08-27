<!DOCTYPE html>
<html dir='{$this->direction}'>
<head>
    <meta charset="utf-8">
    <title>{$this->pageTitle}</title>
{foreach from=$this->globalResources item=resource}
    {$resource}
{/foreach}
</head>
<body>
{$content}
</body>
</html>