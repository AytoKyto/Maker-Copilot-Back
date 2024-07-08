<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706110334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, canal_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E54BC00568DB5B2E (canal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_product (id INT AUTO_INCREMENT NOT NULL, sale_id INT DEFAULT NULL, product_id INT DEFAULT NULL, price_id INT DEFAULT NULL, client_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DDB378CD4A7E4868 (sale_id), INDEX IDX_DDB378CD4584665A (product_id), INDEX IDX_DDB378CDD614C7E7 (price_id), INDEX IDX_DDB378CD19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC00568DB5B2E FOREIGN KEY (canal_id) REFERENCES sales_channel (id)');
        $this->addSql('ALTER TABLE sales_product ADD CONSTRAINT FK_DDB378CD4A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE sales_product ADD CONSTRAINT FK_DDB378CD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sales_product ADD CONSTRAINT FK_DDB378CDD614C7E7 FOREIGN KEY (price_id) REFERENCES price (id)');
        $this->addSql('ALTER TABLE sales_product ADD CONSTRAINT FK_DDB378CD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE price CHANGE product_id product_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC00568DB5B2E');
        $this->addSql('ALTER TABLE sales_product DROP FOREIGN KEY FK_DDB378CD4A7E4868');
        $this->addSql('ALTER TABLE sales_product DROP FOREIGN KEY FK_DDB378CD4584665A');
        $this->addSql('ALTER TABLE sales_product DROP FOREIGN KEY FK_DDB378CDD614C7E7');
        $this->addSql('ALTER TABLE sales_product DROP FOREIGN KEY FK_DDB378CD19EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE sales_channel');
        $this->addSql('DROP TABLE sales_product');
        $this->addSql('ALTER TABLE price CHANGE product_id product_id INT DEFAULT NULL');
    }
}
