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

    public function getTableNameWithPrefix(): string
    {
        return $this->prefix . $this->getTableName();
    }

    public abstract function up(): void;

    public function run(): void
    {
        $this->up();
    }

    public function id(): void
    {
        $this->addColumn('BIGINT UNSIGNED', 'id', ['primary' => true]);
    }

    public function string(string $columnName, int $length, bool $nullable): void
    {
        $this->addColumn('VARCHAR(' . $length . ')', $columnName, ['nullable' => $nullable]);
    }

    public function addColumn(string $type, string $columnName, array $params = []): void
    {
        $query = $columnName . ' ' . $type;
        $query .= isset($params['nullable']) && $params['nullable'] ? ' NULL' : ' NOT NULL';

        if (! empty($params['default']))
            $query .= ' DEFAULT \'' . $params['default'] . '\'';

        if (isset($params['primary']) && $params['primary'])
            $query .= ' PRIMARY KEY';

        $this->queries[] = $query;
    }
}