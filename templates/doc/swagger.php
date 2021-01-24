<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Specification - Swagger UI</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.35.0/swagger-ui.min.css"
        integrity="sha512-jsql70MmFqKJfWGCXmi3GHPP2q2oi3Ad+6PRQWNeo6df+rxKB07IuBvcCXSrpgKPXaikkQgEQVO2YrtgmSJhUw=="
        crossorigin="anonymous" />
</head>
<body>
<div id="swagger-ui"></div>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.35.0/swagger-ui-standalone-preset.min.js"
    integrity="sha512-WI88XrK/8xukiZdnlwlGrcdIyD9qgNXL15LiWbVnq0qpgd/YzRiewFplb5VyRxsbwZf7wRU5BnkCeNP/OV5CEg=="
    crossorigin="anonymous"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.35.0/swagger-ui-bundle.min.js"
    integrity="sha512-7aNGLo3pjgERnsRoSSRrr8Xy6lX8QeKJG3sh8qAeKDvRCExTvDxG6IPRNrCoY0EZG9B5BzGWV5l0xK9DqSSu+w=="
    crossorigin="anonymous"></script>
<script>
    window.onload = function () {
        const ui = SwaggerUIBundle({
            spec: <?= $spec ?>,
        dom_id: '#swagger-ui',
            deepLinking: true,
            supportedSubmitMethods: [],
            presets: [
            SwaggerUIBundle.presets.apis,
        ],
            plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
    })
        window.ui = ui
    }
</script>
</body>
</html>
