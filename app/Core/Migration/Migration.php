<?php

namespace App\Core\Migration;

abstract class Migration
{
    protected array $queries = [];

    protected string $prefix;


    public function __construct(string $prefix = '')
    {
        $this->prefix = $prefix;
    }

    public abstract function getTableName(): string;

    public abstract function up(): void;

    public function addColumn(string $stype, string $columnName, bool $nullable = false, string $default = ''): void
    {

    }
}