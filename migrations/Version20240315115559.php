<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240315115559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create promo code table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE "marketing"."promo_codes_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            '
                            CREATE TABLE "marketing"."promo_codes" (
                                    id INT NOT NULL DEFAULT nextval(\'marketing.promo_codes_id_seq\'::regclass), 
                                    name VARCHAR(100) NOT NULL, 
                                    code VARCHAR(50) NOT NULL, 
                                    available_views INT NOT NULL, 
                                    active INT NOT NULL, 
                                    PRIMARY KEY(id))'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC6CA0BD77153098 ON "marketing"."promo_codes" (code)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE "marketing"."promo_codes_id_seq" CASCADE');
        $this->addSql('DROP INDEX UNIQ_CC6CA0BD77153098');
        $this->addSql('DROP TABLE "marketing"."promo_codes"');
    }
}
