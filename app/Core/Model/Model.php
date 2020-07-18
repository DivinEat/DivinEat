<?php

namespace App\Core\Model;

abstract class Model implements \JsonSerializable
{
    protected ?int $id = null;

    protected ?string $created_at = '';

    protected ?string $updated_at = '';

    public function __construct() {}

    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    public function hydrate(array $row)
    {
        $className = get_class($this);
        $articleObj = new $className();
        foreach ($row as $key => $value) {
            $method = 'set'.$this->snakeToCamelCase($key, true);
            if (method_exists($articleObj, $method)) {
                if($relation = $articleObj->getRelation($key)) {
                    $tmp = new $relation();
                    $managerName = $this->getManagerName($tmp);
                    $articleObj->$method((new $managerName)->find($value));
                } else {
                    $articleObj->$method($value);
                }
            }
        }

        return $articleObj;
    }

    public function jsonSerialize()
    {
        return $this->__toArray();
    }

    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->formatDate($this->created_at);
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): Model
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {   
        return $this->formatDate($this->updated_at);
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(?string $updated_at): Model
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function update(array $params): Model
    {
        foreach ($params as $key => $value)
        {
            $functionName = 'set' . $this->snakeToCamelCase($key);
            $this->$functionName($value);
        }
        $managerName = $this->getManagerName($this);
        (new $managerName)->save($this);

        return $this;
    }

    protected function getManagerName(Model $model): string
    {
        preg_match('/.*\\\([a-zA-Z]*)/', get_class($model), $modelName);

        return 'App\Managers\\' . $modelName[1] . 'Manager';
    }

    protected function snakeToCamelCase($string, $capitalizeFirstCharacter = false)
    {

        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    protected function formatDate($date, bool $heure = true)
    {
        if(null == $date)
            return null;

        $format = ($heure) ? 'd/m/Y H\hi' : 'd/m/Y';
            
        return date($format, strtotime($date));
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}