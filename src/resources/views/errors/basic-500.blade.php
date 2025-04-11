<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro 500 - Erro Interno</title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            width: 100%;
            margin: 40px auto;
        }
        h1 {
            font-size: 5rem;
            margin-bottom: 0.5rem;
            color: #dc2626;
            text-align: center;
        }
        h2 {
            font-size: 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        p {
            margin-bottom: 1rem;
        }
        details {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        summary {
            padding: 10px 15px;
            cursor: pointer;
            font-weight: 600;
            background-color: #f3f4f6;
        }
        details div {
            padding: 15px;
        }
        pre {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            white-space: pre-wrap;
            font-size: 0.875rem;
        }
        .error-message {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card-red {
            border-left: 4px solid #dc2626;
        }
        .card-yellow {
            border-left: 4px solid #eab308;
        }
        .card-blue {
            border-left: 4px solid #2563eb;
        }
        .card-gray {
            border-left: 4px solid #6b7280;
        }
        .font-mono {
            font-family: monospace;
        }
        ol {
            padding-left: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>500</h1>
        
        <p class="error-message">
            {{ $exception->getMessage() ?? 'Ocorreu um erro interno no servidor.' }}
        </p>

        @if (config('app.debug') && isset($exception))
            <!-- Stack Trace -->
            <div class="card card-red">
                <h2>Stack Trace</h2>
                <p class="font-mono">{{ get_class($exception) }}</p>
                <details>
                    <summary>Ver stack trace completo</summary>
                    <div>
                        <pre id="stack-trace" class="font-mono">{{ $exception->getTraceAsString() }}</pre>
                    </div>
                </details>
            </div>

            <!-- Dados adicionais -->
            @if (isset($extra) && is_array($extra) && count($extra) && (isset($extra['errors']) || isset($extra['exception']) || isset($extra['trace'])))
                <div class="card card-yellow">
                    <h2>Dados adicionais do erro</h2>

                    @foreach (['errors' => 'Erro', 'exception' => 'Exception', 'trace' => 'Trace'] as $key => $label)
                        @if (isset($extra[$key]))
                            <details>
                                <summary>{{ $label }}</summary>
                                <div>
                                    @if (is_array($extra[$key]))
                                        @if ($key === 'trace')
                                            <ol>
                                                @foreach ($extra[$key] as $item)
                                                    <li>{{ is_array($item) ? json_encode($item, JSON_UNESCAPED_UNICODE) : $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            @foreach ($extra[$key] as $subKey => $value)
                                                <p><strong>{{ ucfirst($subKey) }}:</strong> {{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</p>
                                            @endforeach
                                        @endif
                                    @else
                                        <p>{{ $extra[$key] }}</p>
                                    @endif
                                </div>
                            </details>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Localização -->
            @if (method_exists($exception, 'getFile') && method_exists($exception, 'getLine'))
                <div class="card card-blue">
                    <h2>Localização</h2>
                    <p class="font-mono">{{ $exception->getFile() }}:{{ $exception->getLine() }}</p>
                </div>
            @endif

            <!-- Request -->
            @if (isset($request))
                <div class="card card-gray">
                    <h2>Request</h2>
                    <p class="font-mono">{{ $request->method() }} {{ $request->url() }}</p>

                    @if ($request->all())
                        <h3>Dados da requisição:</h3>
                        <pre class="font-mono">{{ json_encode($request->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @endif
                </div>
            @endif
        @endif
    </div>

    <script>
        function copyToClipboard(elementId) {
            const el = document.getElementById(elementId);
            if (el) {
                navigator.clipboard.writeText(el.innerText).then(() => {
                    alert('Conteúdo copiado para a área de transferência!');
                });
            }
        }
    </script>
</body>
</html>