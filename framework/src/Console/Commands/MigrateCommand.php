<?php

namespace Learn\Custom\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Learn\Custom\Console\CommandInterface;
use Throwable;

class MigrateCommand implements CommandInterface
{
    protected string $name = 'migrate';

    private const string MIGRATION_TABLE_NAME = 'migrations';

    public function __construct(protected Connection $connection, protected string $migrationFiles) {}

    public function execute(array $parameters = []): int
    {
        try {
            $this->createMigrationTable();

            $this->connection->beginTransaction();

            $appliedMigrations = $this->getAppliedMigrations();

            $migrationFiles = $this->getMigrationFiles();

            $migrationsToApply = array_diff($migrationFiles, $appliedMigrations);

            $schema = new Schema();

            foreach ($migrationFiles as $migrationFile) {
                $migrationInstance = require $this->migrationFiles. '/' . $migrationFile;

                $migrationInstance->up($schema);

                $this->addMigration($migrationFile);
            }

            $rowSqls = $schema->toSql($this->connection->getDatabasePlatform());

            foreach ($rowSqls as $sqlRow) {
                $this->connection->executeQuery($sqlRow);
            }

            $this->connection->commit();

            return 0;
        } catch (Throwable $e) {
            if ($this->connection->isTransactionActive()) {
                dd(123);
                $this->connection->rollBack();
            }
            throw $e;
        }
    }

    protected function createMigrationTable()
    {
        $schemaManager = $this->connection->createSchemaManager();

        if ($schemaManager->tableExists(self::MIGRATION_TABLE_NAME)) {
            return;
        }

        $schema = new Schema;
        $table = $schema->createTable(self::MIGRATION_TABLE_NAME);
        $table->addColumn('id', Types::INTEGER, [
            'autoincrement' => true,
            'unsigned' => true,
        ]);
        $table->addColumn('migration', Types::STRING, [
            'length' => 255,
        ]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->setPrimaryKey(['id']);

        $rowSql = $schema->toSql($this->connection->getDatabasePlatform());

        $this->connection->executeQuery(array_shift($rowSql));
    }

    private function getAppliedMigrations(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder
            ->select('migration')
            ->from(self::MIGRATION_TABLE_NAME)
            ->executeQuery()
            ->fetchFirstColumn();
    }

    private function getMigrationFiles()
    {
        $migrationFiles = scandir($this->migrationFiles);

        return array_values(array_filter($migrationFiles, fn ($fileName) => ! in_array($fileName, ['.', '..'])));
    }

    private function addMigration(string $migration)
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->insert(self::MIGRATION_TABLE_NAME)
            ->values(['migration' => ':migration'])
            ->setParameter('migration', $migration)
            ->executeQuery();
    }
}
