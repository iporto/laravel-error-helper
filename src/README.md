# Laravel Error Helper

Um helper simples para gerenciar erros 500 personalizados no Laravel com suporte a dados adicionais.

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require iporto/laravel-error-helper
```

O pacote é automaticamente registrado usando o auto-discovery do Laravel.

## Uso

Este pacote permite que você apresente páginas de erro 500 com dados personalizados, perfeito para exibir detalhes de erro estruturados.

```php
use IPorto\LaravelErrorHelper\Facades\Error;

// Exibir erro simples
Error::abort('Erro ao processar a solicitação');

// Exibir erro com dados adicionais
Error::abort('Erro ao processar o pagamento', [
    'error' => [
        'code' => 'PAYMENT_FAILED',
        'reason' => 'Fundos insuficientes'
    ],
    'trace' => [
        'Tentativa 1 falhou',
        'Tentativa 2 falhou'
    ],
    'exception' => [
        'type' => 'PaymentGatewayException'
    ]
]);

// Alternativamente, você pode usar a classe ErrorHelper diretamente
use IPorto\LaravelErrorHelper\ErrorHelper;

ErrorHelper::abort('Mensagem de erro', $dadosAdicionais);
```

## Configuração do Handler

Para usar este pacote, você precisa atualizar o Handler de exceções do seu aplicativo. Adicione o seguinte código ao seu `App\Exceptions\Handler.php`:

```php
<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use IPorto\LaravelErrorHelper\CustomErrorException;

class Handler extends ExceptionHandler
{
    // Outras configurações existentes...

    public function render($request, Throwable $e)
    {
        if ($e instanceof CustomErrorException) {
            return response()->view('errors.500', [
                'exception' => $e,
                'extra' => $e->getExtraData(),
                'request' => $request
            ], 500);
        }

        return parent::render($request, $e);
    }
}
```

## Requisitos da View

A view de erro 500 (`resources/views/errors/500.blade.php`) deve estar preparada para receber e exibir os dados adicionais. Você pode usar o exemplo abaixo ou adaptar sua view existente:

```blade
@if (isset($extra) && is_array($extra) && count($extra))
  <div class="error-details">
    <h2>Detalhes adicionais do erro</h2>
    
    @foreach (['error' => 'Erro', 'exception' => 'Exception', 'trace' => 'Trace'] as $key => $label)
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
```

## Licença

Este pacote é open-source sob a licença MIT.