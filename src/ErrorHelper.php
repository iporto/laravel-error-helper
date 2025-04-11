<?php

namespace IPorto\LaravelErrorHelper;

class ErrorHelper
{
    /**
     * Exibe uma página de erro 500 com dados personalizados.
     *
     * @param string $message Mensagem de erro
     * @param array $data Dados adicionais para exibir na página de erro
     * @param int $code Código HTTP do erro (padrão 500)
     * @return void
     * @throws CustomErrorException
     */
    public static function abort($message = "Erro inesperado no servidor.", array $data = [], int $code = 500)
    {
        throw new CustomErrorException($message, $data, $code);
    }
}