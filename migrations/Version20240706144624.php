<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706144624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7440455A76ED395 ON client (user_id)');
        $this->addSql('ALTER TABLE sale ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E54BC005A76ED395 ON sale (user_id)');
        $this->addSql('ALTER TABLE sales_channel ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sales_channel ADD CONSTRAINT FK_AC00F227A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC00F227A76ED395 ON sales_channel (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sales_channel DROP FOREIGN KEY FK_AC00F227A76ED395');
        $this->addSql('DROP INDEX IDX_AC00F227A76ED395 ON sales_channel');
        $this->addSql('ALTER TABLE sales_channel DROP user_id');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005A76ED395');
        $this->addSql('DROP INDEX IDX_E54BC005A76ED395 ON sale');
        $this->addSql('ALTER TABLE sale DROP user_id');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('DROP INDEX IDX_C7440455A76ED395 ON client');
        $this->addSql('ALTER TABLE client DROP user_id');
    }
}
