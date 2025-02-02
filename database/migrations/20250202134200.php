<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable("users");
        $table->addColumn("id", Types::INTEGER, ["autoincrement" => true]);
        $table->addColumn("username", Types::STRING, ["notnull" => true, "length" => 50]);
        $table->addColumn("password", Types::STRING, ["notnull" => true, "length" => 50]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default'=> 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        //
    }
};
