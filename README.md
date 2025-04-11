# Laravel Error Helper

Um helper simples para gerenciar erros 500 personalizados no Laravel com suporte a dados adicionais, desenvolvido pela iPORTO.

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require iporto/laravel-error-helper
```

O pacote é automaticamente registrado usando o auto-discovery do Laravel.

## Publicar views de exemplo

O pacote inclui templates de erro prontos para uso. Para publicá-los:

```bash
php artisan vendor:publish --tag=laravel-error-helper-views
```

Isso irá publicar:
- `resources/views/errors/500.blade.php` - Template com Tailwind CSS (requer layout app)
- `resources/views/errors/basic-500.blade.php` - Template independente sem dependências

## Uso

Este pacote permite que você apresente páginas de erro 500 com dados personalizados, perfeito para exibir detalhes de erro estruturados.

```php
use IPorto\LaravelErrorHelper\Facades\Error;

// Exibir erro simples
Error::abort('Erro ao processar a solicitação');

// Exibir erro com dados adicionais
Error::abort('Erro ao processar o pagamento', [
    'errors' => [
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

Se você preferir usar o template básico sem dependências:

```php
public function render($request, Throwable $e)
{
    if ($e instanceof CustomErrorException) {
        return response()->view('errors.basic-500', [
            'exception' => $e,
            'extra' => $e->getExtraData(),
            'request' => $request
        ], 500);
    }

    return parent::render($request, $e);
}
```

## Exemplo de implementação

Aqui está um exemplo completo de como você pode usar o pacote em seu controller:

```php
<?php

namespace App\Http\Controllers;

use IPorto\LaravelErrorHelper\Facades\Error;
use Exception;

class PaymentController extends Controller
{
    public function processPayment()
    {
        try {
            // Simula uma tentativa de pagamento...
            // throw new Exception("Gateway de pagamento indisponível");
            
            return redirect()->route('success');
        } catch (Exception $e) {
            // Usar o ErrorHelper para exibir erro personalizado
            Error::abort('Falha ao processar pagamento', [
                'errors' => [
                    'code' => 'PAYMENT_PROCESSOR_ERROR',
                    'message' => $e->getMessage()
                ],
                'exception' => [
                    'class' => get_class($e),
                    'code' => $e->getCode()
                ],
                'trace' => [
                    'request_id' => request()->header('X-Request-ID'),
                    'timestamp' => now()->toIso8601String()
                ]
            ]);
        }
    }
}
```

## Personalização

Você pode personalizar completamente a visualização dos erros editando os arquivos publicados em `resources/views/errors/`.

## Licença

Este pacote é open-source sob a licença MIT.