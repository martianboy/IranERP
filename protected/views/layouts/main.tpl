<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$this->pageTitle}</title>
{foreach from=$this->globalResources item=resource}
    {$resource}
{/foreach}
</head>
<body>
<script>
{$content}
</script>
</body>
</html>