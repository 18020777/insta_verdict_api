<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317183940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE poll ALTER options TYPE JSON');
        $this->addSql('ALTER TABLE poll ALTER votes TYPE JSON');
        $this->addSql('COMMENT ON COLUMN poll.options IS NULL');
        $this->addSql('COMMENT ON COLUMN poll.votes IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_username ON "user" (username)');
        $this->addSql('ALTER TABLE poll ALTER options TYPE TEXT');
        $this->addSql('ALTER TABLE poll ALTER votes TYPE TEXT');
        $this->addSql('COMMENT ON COLUMN poll.options IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN poll.votes IS \'(DC2Type:array)\'');
    }
}
