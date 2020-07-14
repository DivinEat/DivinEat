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

    public function getCreationQuery(): string
    {
        $this->up();

        return $this->getQuery();
    }

    public function id(): void
    {
        $this->addColumn('BIGINT UNSIGNED', 'id', ['primary' => true]);
    }

    public function string(string $columnName, int $length = 255, array $params = []): void
    {
        $this->addColumn('VARCHAR(' . $length . ')', $columnName, $params);
    }

    public function double(string $columnName, array $params = []): void
    {
        $this->addColumn('DOUBLE', $columnName, $params);
    }

    public function date(string $columnName, array $params = []): void
    {
        $this->addColumn('DATE', $columnName, $params);
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

    protected function getQuery(): string
    {
        $query = 'CREATE TABLE ' . $this->getTableNameWithPrefix() . '(';
        $query .= implode(', ', $this->queries);
        return $query .= ' );';
    }
}