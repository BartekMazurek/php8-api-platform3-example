<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240315130837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create promo code history';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE "marketing"."promo_codes_history_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE "marketing"."promo_codes_history" (
                                id INT NOT NULL DEFAULT nextval(\'marketing.promo_codes_history_id_seq\'::regclass), 
                                value JSON DEFAULT NULL, 
                                operation VARCHAR(6) NOT NULL, 
                                created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(), 
                                PRIMARY KEY(id))'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE "marketing"."promo_codes_history_id_seq" CASCADE');
        $this->addSql('DROP TABLE "marketing"."promo_codes_history"');
    }
}
