<?php
namespace App\Core;

use App\Core\Connection\BDDInterface;
use App\Core\Connection\ResultInterface;
use App\Core\Connection\PDOConnection;

class QueryBuilder
{
    protected $connection;
    protected $query;
    protected $parameters;
    protected $alias;

    public function __construct(BDDInterface $connection = NULL)
    {
        $this->connection = $connection;
        if(NULL === $connection){
            $this->connection = new PDOConnection();
        }

        $this->query = "";
        $this->parameters = [];
    }

    public function select(string $values = "*"): QueryBuilder
    {
        $this->query .= "select ".$values." ";
        return $this;
    }

    public function from(string $table, string $alias): QueryBuilder
    {
        $this->query .= "from ".DB_PREFIXE.$table." as ".$alias." ";
        $this->alias = $alias;
        return $this;
    }

    public function where(string $conditions): QueryBuilder
    {
        $this->query = $this->query."where ".$conditions;
        return $this;
    }

    public function orderBy(string $orderby): QueryBuilder
    {
        $this->query = $this->query."order by ".$orderby;
        return $this;
    }

    public function limit(string $limit): QueryBuilder
    {
        $this->query = $this->query."limit ".$limit;
        return $this;
    }

    public function like(string $like): QueryBuilder
    {
        $this->query = $this->query."like '%".$like."%' ";
        return $this;
    }

    public function setParameter(string $key, string $value): QueryBuilder
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    public function join(string $join = "inner", string $table, string $aliasTarget, string $fieldSource = "id", string $fieldTarget = "id"): QueryBuilder
    {
        $this->query .= $join." join ".DB_PREFIXE.$table." ".$aliasTarget." on ".$this->alias.".".$fieldSource." = ".$aliasTarget.".".$fieldTarget." ";
        return $this;
    }

    public function leftJoin(string $table, string $aliasTarget, string $fieldSource = "id", string $fieldTarget = "id"): QueryBuilder
    {
        join("left", $table, $aliasTarget, $fieldSource, $fieldTarget);
    }

    public function rightJoin(string $table, string $aliasTarget, string $fieldSource = "id", string $fieldTarget = "id"): QueryBuilder
    {
        join("right", $table, $aliasTarget, $fieldSource, $fieldTarget);
    }

    public function innerJoin(string $table, string $aliasTarget, string $fieldSource = "id", string $fieldTarget = "id"): QueryBuilder
    {
        join("inner", $table, $aliasTarget, $fieldSource, $fieldTarget);
    }

    public function addToQuery(string $query): QueryBuilder
    {
        $this->query .= " ".$query." ";
        return $this;
    }

    public function getQuery(): ResultInterface
    {
        return $this->connection->query($this->query, $this->parameters);
    }
    
    public function delete(string $table): QueryBuilder
    {
        $this->query .= "delete from ".DB_PREFIXE.$table." ";
        return $this;
    }
}