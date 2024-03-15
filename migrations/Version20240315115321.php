<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240315115321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create marketing schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA "marketing"');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SCHEMA "marketing"');
    }
}
