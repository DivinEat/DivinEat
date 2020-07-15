<?php

namespace App\Core\Migration;

use App\Core\Connection\PDOConnection;

class MigrationRunner
{
    protected PDOConnection $pdoConnection;

    public function __construct()
    {
        $this->pdoConnection = new PDOConnection();
    }

    public function run(): void
    {
        $dirs = array_filter(scandir(ROOT . '/migrations/'), function (string $value) {
            return ! (in_array($value, ['.', '..']));
        });

        array_map([$this, 'loadMigration'], $dirs);
    }

    protected function loadMigrationFile(string $migrationFileName): Migration
    {
        include ROOT . '/migrations/' . $migrationFileName;

        $className = '\\' . preg_replace('/ /', '', preg_replace('/.php$/', '',
            ucwords(preg_replace('/_/', ' ', $migrationFileName))
        ));

        return new $className(DB_PREFIXE);
    }

    protected function isTableExist(string $tableName): bool
    {
        return $this->pdoConnection->query("
        SELECT * FROM information_schema.tables 
        WHERE table_schema = '" . DB_NAME . "'
        AND table_name = '" . $tableName . "'
        LIMIT 1;
        ")->getValueResult();
    }

    protected function loadMigration(string $migrationFileName): void
    {
        $migrationClass = $this->loadMigrationFile($migrationFileName);

        if (! $this->isTableExist($migrationClass->getTableNameWithPrefix()))
            $this->pdoConnection->query($migrationClass->getCreationQuery());
    }

    protected function iniateMigration(): void
    {
        $this->loadMigration('initiate_migration.php');
    }
}