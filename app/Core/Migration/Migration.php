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

    public function text(string $columnName, array $params = []): void
    {
        $this->addColumn('TEXT', $columnName, $params);
    }

    public function bool(string $columnName, array $params = []): void
    {
        $this->addColumn('BOOLEAN', $columnName, $params);
    }

    public function unsignedBigInteger(string $columnName, array $params = []): void
    {
        $this->addColumn('BIGINT UNSIGNED', $columnName, $params);
    }

    public function timestamp(): void
    {
        $this->addColumn('timestamp', 'created_at', ['default' => 'CURRENT_TIMESTAMP']);
        $this->addColumn('timestamp', 'updated_at', [
            'nullable' => true,
            'default' => 'NULL',
            'update' => 'CURRENT_TIMESTAMP'
        ]);
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
        {
            $query .= ' DEFAULT ';
            $query .= in_array($params['default'], ['NULL', 'CURRENT_TIMESTAMP']) ?
            $params['default'] : '\''.$params['default'].'\'';
        }

        if (isset($params['primary']) && $params['primary'])
            $query .= ' PRIMARY KEY';

        if (! empty($params['update']))
        {
            $query .= ' ON UPDATE ';
            $query .= in_array($params['update'], ['NULL', 'CURRENT_TIMESTAMP']) ?
                $params['update'] : '\''.$params['update'].'\'';
        }

        $this->queries[] = $query;
    }

    protected function getQuery(): string
    {
        $query = 'CREATE TABLE ' . $this->getTableNameWithPrefix() . '(';
        $query .= implode(', ', $this->queries);

        return $query . ' );';
    }
}