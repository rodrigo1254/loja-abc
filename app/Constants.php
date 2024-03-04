<?php

namespace App;

class Constants
{
    public const STATUS_PENDENTE = 1;
    public const STATUS_EM_PROCESSAMENTO = 2;
    public const STATUS_CONFIRMADO = 3;
    public const STATUS_EM_TRANSITO = 4;
    public const STATUS_ENTREGUE = 5;
    public const STATUS_CANCELADO = 6;
    public const STATUS_DEVOLVIDO = 7;
    public const STATUS_REEMBOLSADO = 8;

    public const STATUS_TEXT = [
        self::STATUS_PENDENTE => 'PENDENTE',
        self::STATUS_EM_PROCESSAMENTO => 'EM PROCESSAMENTO',
        self::STATUS_CONFIRMADO => 'CONFIRMADO',
        self::STATUS_EM_TRANSITO => 'EM TRÂNSITO',
        self::STATUS_ENTREGUE => 'ENTREGUE',
        self::STATUS_CANCELADO => 'CANCELADO',
        self::STATUS_DEVOLVIDO => 'DEVOLVIDO',
        self::STATUS_REEMBOLSADO => 'REEMBOLSADO',
    ];

    public const STATUS_REVERSE = [
        'PENDENTE' => self::STATUS_PENDENTE,
        'EM PROCESSAMENTO' => self::STATUS_EM_PROCESSAMENTO,
        'CONFIRMADO' => self::STATUS_CONFIRMADO,
        'EM TRÂNSITO' => self::STATUS_EM_TRANSITO,
        'ENTREGUE' => self::STATUS_ENTREGUE,
        'CANCELADO' => self::STATUS_CANCELADO,
        'DEVOLVIDO' => self::STATUS_DEVOLVIDO,
        'REEMBOLSADO' => self::STATUS_REEMBOLSADO,
    ];
}
