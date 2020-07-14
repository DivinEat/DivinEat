<?php

namespace App\Core;

abstract class Migration
{
    public abstract function getTableName(): string;

    public abstract function up(): void;
}