{{ $appName }}
{{ $heading }}

@if (!empty($recipientName))
Hola {{ $recipientName }},

@endif
{{ $intro }}

{{ $detailTitle }}: {{ $detailText }}

{{ $buttonText }}:
{{ $buttonUrl }}

{{ $secondaryText }}

{{ $farewell }}
{{ $appName }}

Si el enlace no abre al hacer clic, copialo y pegalo en tu navegador:
{{ $buttonUrl }}
