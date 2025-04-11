@extends('layouts.app')

@section('title', 'Erro interno - Sistema')

@section('content')
  <div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 px-4 py-8 text-center dark:bg-gray-900">
    <h1 class="mb-4 text-7xl font-extrabold text-red-600 dark:text-red-500">500</h1>

    <p class="text-lg text-gray-700 dark:text-gray-300">
      {{ $exception->getMessage() ?? 'Ocorreu um erro interno no servidor.' }}
    </p>

    @if (config('app.debug') && isset($exception))
      <div class="mt-10 w-full max-w-5xl space-y-8 text-left">

        {{-- Stack Trace --}}
        <div class="rounded-xl border border-red-200 bg-red-50 p-6 shadow-sm dark:border-red-400 dark:bg-red-900/20">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-red-800 dark:text-red-300">Stack Trace</h2>
          </div>
          <p class="font-mono mb-4 text-sm text-red-800 dark:text-red-300">{{ get_class($exception) }}</p>
          <details class="rounded bg-white dark:bg-gray-800">
            <summary class="cursor-pointer px-4 py-2 text-sm font-semibold text-red-700 dark:text-red-400">Ver stack trace completo</summary>
            <pre id="stack-trace" class="font-mono max-h-64 overflow-y-auto whitespace-pre-wrap break-words rounded p-4 text-xs text-red-800 dark:text-red-200">
{{ $exception->getTraceAsString() }}
            </pre>
          </details>
        </div>

        {{-- Dados adicionais da API --}}
        @if (isset($extra) && is_array($extra) && count($extra) && (isset($extra['error']) || isset($extra['exception']) || isset($extra['trace'])))
          <div class="rounded-xl border border-yellow-300 bg-yellow-50 p-6 shadow-sm dark:border-yellow-400 dark:bg-yellow-900/20">
            <h2 class="mb-4 text-xl font-semibold text-yellow-800 dark:text-yellow-300">Dados adicionais do erro</h2>

            @foreach (['error' => 'Erro', 'exception' => 'Exception', 'trace' => 'Trace'] as $key => $label)
              @if (isset($extra[$key]))
                <details class="mb-4 rounded bg-white dark:bg-gray-800">
                  <summary class="cursor-pointer px-4 py-2 text-sm font-semibold text-yellow-800 dark:text-yellow-300">{{ $label }}</summary>
                  <div class="p-4 text-sm text-yellow-900 dark:text-yellow-100">
                    @if (is_array($extra[$key]))
                      @if ($key === 'trace')
                        <ol class="list-decimal space-y-1 pl-5">
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

        {{-- Localização --}}
        @if (method_exists($exception, 'getFile') && method_exists($exception, 'getLine'))
          <div class="rounded-xl border border-blue-200 bg-blue-50 p-6 shadow-sm dark:border-blue-400 dark:bg-blue-900/20">
            <h2 class="mb-2 text-xl font-semibold text-blue-800 dark:text-blue-300">Localização</h2>
            <p class="font-mono text-sm text-blue-900 dark:text-blue-100">{{ $exception->getFile() }}:{{ $exception->getLine() }}</p>
          </div>
        @endif

        {{-- Request --}}
        @if (isset($request))
          <div class="rounded-xl border border-gray-300 bg-white p-6 shadow-sm dark:border-gray-600 dark:bg-gray-800">
            <h2 class="mb-2 text-xl font-semibold text-gray-800 dark:text-gray-100">Request</h2>
            <p class="font-mono text-sm text-gray-800 dark:text-gray-300">{{ $request->method() }} {{ $request->url() }}</p>

            @if ($request->all())
              <h3 class="mb-2 mt-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Dados da requisição:</h3>
              <pre class="font-mono max-h-64 overflow-y-auto whitespace-pre-wrap break-words rounded bg-gray-100 p-4 text-xs text-gray-800 dark:bg-gray-700 dark:text-gray-100">{{ json_encode($request->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @endif
          </div>
        @endif
      </div>
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
@endsection