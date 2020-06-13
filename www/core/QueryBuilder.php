<?php

namespace App\Core;

use App\Core\Connection\ResultInterface;
use App\Core\Connection\BDDInterface;
use App\Core\Connection\PDOConnection;

class QueryBuilder
{
    protected $connection;
    protected $query;
    protected $parameters = [];
    protected $alias;

    public function __construct(BDDInterface $connection = NULL)
    {
        $this->connection = $connection;
        if(NULL === $connection)
            $this->connection = new PDOConnection();
    }

    public function select(string $values = "*"): QueryBuilder
    {
        $this->addToQuery("select $values");
        return $this;
    }

    public function from(string $table, string $alias): QueryBuilder
    {
        $this->addToQuery("from  $table $alias");
        $this->alias = $alias;
        return $this;
    }

    public function where(string $conditions): QueryBuilder
    {
        $this->addToQuery("where  $conditions");
        return $this;
    }

    public function setParameter(string $key, string $value): QueryBuilder
    {
        $this->parameters[":$key"] = $value;
        return $this;
    }

    public function join(string $type = "", string $table, string $aliasTarget, string $fieldSource = "id", string $fieldTarget = "id"): QueryBuilder
    {
        $aliasSource = $this->alias;
        $this->addToQuery("$type join $table $aliasTarget on $aliasSource.$fieldSource = $aliasTarget.$fieldTarget");
        return $this;
    }

    public function addToQuery(string $query): QueryBuilder
    {
        $this->query .= $query . " ";
        return $this;
    }

    public function getQuery(): ResultInterface
    {
        return $this->connection->query($this->query, $this->parameters);
    }
}