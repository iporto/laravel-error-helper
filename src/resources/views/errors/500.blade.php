@extends('layouts.app')

@section('title', 'Erro interno do servidor')

@section('content')
  <div class="flex min-h-screen flex-col items-center justify-center">
    <div class="w-full max-w-5xl">
      <!-- Cabeçalho do erro -->
      <div class="mb-10 text-center">
        <div class="relative mx-auto mb-6 inline-block">
          <h1 class="text-8xl font-black text-black">500</h1>
        </div>

        <h2 class="mb-4 text-2xl font-bold uppercase text-gray-800 dark:text-gray-100">Erro interno do servidor</h2>

        <div class="mx-auto max-w-2xl overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
          <div class="divide-y divide-gray-100 dark:divide-gray-700">
            <div class="px-6 py-4">
              <p class="font-mono truncate text-base text-gray-800 dark:text-gray-300">
                {{ $exception->getMessage() ?? 'Ocorreu um erro interno no servidor.' }}
              </p>
            </div>
          </div>
        </div>
      </div>

      @if (config('app.debug') && isset($exception))
        <div class="space-y-6">
          <!-- Stack Trace -->
          <div class="overflow-hidden rounded-xl border border-red-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md dark:border-red-900/30 dark:bg-gray-800">
            <div class="bg-red-50 px-6 py-4 dark:bg-red-900/20">
              <div class="flex items-center justify-between">
                <h3 class="flex items-center gap-2 text-xl font-semibold text-red-800 dark:text-red-300">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0112 12.75zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 01-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 002.248-2.354M12 12.75a2.25 2.25 0 01-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 00-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 01.4-2.253M12 8.25a2.25 2.25 0 00-2.248 2.146M12 8.25a2.25 2.25 0 012.248 2.146M8.683 5a6.032 6.032 0 01-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0115.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 00-.575-1.752M4.921 6a24.048 24.048 0 00-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 01-5.223 1.082" />
                  </svg>
                  Stack Trace
                </h3>
                <button onclick="copyToClipboard('stack-trace')" class="rounded-md bg-white px-3 py-1 text-sm font-medium text-red-700 shadow-sm transition hover:bg-red-50 dark:bg-gray-700 dark:text-red-300 dark:hover:bg-gray-600">
                  Copiar
                </button>
              </div>
              <p class="font-mono mb-2 mt-2 text-sm text-red-800 dark:text-red-300">{{ get_class($exception) }}</p>
            </div>
            <details class="group">
              <summary class="flex cursor-pointer items-center justify-between px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50">
                <span>Ver stack trace completo</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </summary>
              <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-700">
                <pre id="stack-trace" class="font-mono max-h-64 overflow-y-auto whitespace-pre-wrap break-words rounded bg-gray-50 p-4 text-xs text-red-800 dark:bg-gray-900/50 dark:text-red-200">{{ $exception->getTraceAsString() }}</pre>
              </div>
            </details>
          </div>

          <!-- Dados adicionais da API -->
          @if (isset($extra) && is_array($extra) && count($extra) && (isset($extra['error']) || isset($extra['exception']) || isset($extra['trace'])))
            <div class="overflow-hidden rounded-xl border border-yellow-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md dark:border-yellow-900/30 dark:bg-gray-800">
              <div class="bg-yellow-50 px-6 py-4 dark:bg-yellow-900/20">
                <h3 class="flex items-center gap-2 text-xl font-semibold text-yellow-800 dark:text-yellow-300">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                  </svg>
                  Dados adicionais
                </h3>
              </div>
              <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach (['error' => 'Erro', 'exception' => 'Exception', 'trace' => 'Trace'] as $key => $label)
                  @if (isset($extra[$key]))
                    <details class="group">
                      <summary class="flex cursor-pointer items-center justify-between px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50">
                        <span class="flex items-center gap-2">
                          @if ($key === 'error')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                          @elseif ($key === 'exception')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                          @elseif ($key === 'trace')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                          @endif
                          {{ $label }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </summary>
                      <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-700">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                          @if (is_array($extra[$key]))
                            @if ($key === 'trace')
                              <ol class="list-decimal space-y-1 pl-5">
                                @foreach ($extra[$key] as $item)
                                  <li class="px-2 py-1 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    {{ is_array($item) ? json_encode($item, JSON_UNESCAPED_UNICODE) : $item }}
                                  </li>
                                @endforeach
                              </ol>
                            @else
                              <div class="space-y-2">
                                @foreach ($extra[$key] as $subKey => $value)
                                  <div class="rounded border border-gray-100 bg-gray-50 px-3 py-2 dark:border-gray-700 dark:bg-gray-700/30">
                                    <p><span class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($subKey) }}:</span>
                                      <span class="font-mono ml-1 text-gray-700 dark:text-gray-300">
                                        {{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $value }}
                                      </span>
                                    </p>
                                  </div>
                                @endforeach
                              </div>
                            @endif
                          @else
                            <p class="font-mono rounded bg-gray-50 p-3 dark:bg-gray-700/30">{{ $extra[$key] }}</p>
                          @endif
                        </div>
                      </div>
                    </details>
                  @endif
                @endforeach
              </div>
            </div>
          @endif

          <!-- Localização -->
          @if (method_exists($exception, 'getFile') && method_exists($exception, 'getLine'))
            <div class="overflow-hidden rounded-xl border border-blue-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md dark:border-blue-900/30 dark:bg-gray-800">
              <div class="bg-blue-50 px-6 py-4 dark:bg-blue-900/20">
                <h3 class="flex items-center gap-2 text-xl font-semibold text-blue-800 dark:text-blue-300">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                  </svg>
                  Localização
                </h3>
              </div>
              <div class="px-6 py-4">
                <div class="overflow-hidden overflow-x-auto rounded border border-gray-100 bg-gray-50 dark:border-gray-700 dark:bg-gray-700/30">
                  <div class="flex items-center gap-2 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-blue-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <p class="font-mono truncate text-sm text-blue-900 dark:text-blue-100">{{ $exception->getFile() }}:<span class="font-bold">{{ $exception->getLine() }}</span></p>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <!-- Request -->
          @if (isset($request))
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
              <div class="bg-gray-50 px-6 py-4 dark:bg-gray-700/30">
                <h3 class="flex items-center gap-2 text-xl font-semibold text-gray-800 dark:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                  </svg>
                  Request
                </h3>
              </div>
              <div class="divide-y divide-gray-100 dark:divide-gray-700">
                <div class="px-6 py-4">
                  <div class="flex items-center gap-2 rounded-lg border border-gray-100 bg-gray-50 px-4 py-2 dark:border-gray-700 dark:bg-gray-700/30">
                    <span class="rounded-md bg-purple-100 px-2 py-1 text-xs font-bold uppercase text-purple-800 dark:bg-purple-800/30 dark:text-purple-300">
                      {{ $request->method() }}
                    </span>
                    <p class="font-mono truncate text-sm text-gray-800 dark:text-gray-300">{{ $request->url() }}</p>
                  </div>
                </div>

                @if ($request->all())
                  <div class="px-6 py-4">
                    <h4 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Dados da requisição:</h4>
                    <pre class="font-mono max-h-64 overflow-y-auto whitespace-pre-wrap break-words rounded border border-gray-100 bg-gray-50 p-4 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-200">{{ json_encode($request->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                  </div>
                @endif
              </div>
            </div>
          @endif
        </div>
      @else
        <!-- Versão de produção - Sem detalhes -->
        <div class="mx-auto mt-8 max-w-md text-center">
          <p class="mb-6 text-gray-600 dark:text-gray-400">Nossa equipe foi notificada e está trabalhando para resolver o problema.</p>
        </div>
      @endif
    </div>
  </div>

  <script>
    function copyToClipboard(elementId) {
      const el = document.getElementById(elementId);
      if (el) {
        navigator.clipboard.writeText(el.innerText)
          .then(() => {
            // Criar um elemento temporário para feedback visual
            const notification = document.createElement('div');
            notification.textContent = 'Copiado para a área de transferência!';
            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.right = '20px';
            notification.style.padding = '10px 15px';
            notification.style.backgroundColor = '#10B981'; // verde
            notification.style.color = 'white';
            notification.style.borderRadius = '4px';
            notification.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            notification.style.zIndex = '9999';
            notification.style.transition = 'opacity 0.5s ease-in-out';

            document.body.appendChild(notification);

            // Remover após 2 segundos
            setTimeout(() => {
              notification.style.opacity = '0';
              setTimeout(() => {
                document.body.removeChild(notification);
              }, 500);
            }, 2000);
          })
          .catch(err => {
            console.error('Erro ao copiar: ', err);
          });
      }
    }
  </script>
@endsection
