<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$entity.name}</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        h1 { color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { max-height: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://images.pexels.com/photos/356040/pexels-photo-356040.jpeg" class="logo" alt="Company Logo">
        <h1>{$entity.name}</h1>
        <p>Generated on {$now|date_format:"%d %B %Y"}</p>
    </div>

    {foreach from=$fields item=field}
        <div class="field">
            <span class="label">{$field.label}:</span>
            <span class="value">{$entity.$field.name}</span>
        </div>
    {/foreach}

    <div class="footer" style="margin-top: 50px; font-size: 0.8em; color: #777;">
        <p>© {$now|date_format:"%Y"} Your Company. All rights reserved.</p>
    </div>
</body>
</html>