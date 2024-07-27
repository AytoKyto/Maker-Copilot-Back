<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726124819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE view_benefit_month (date_full VARCHAR(7) NOT NULL, user_id INT NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, PRIMARY KEY(date_full)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_benefit_month_category (date_full VARCHAR(7) NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, PRIMARY KEY(date_full)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_benefit_month_product (date_full VARCHAR(7) NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, nb_product INT NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, PRIMARY KEY(date_full)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_benefit_year_product (years VARCHAR(4) NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, nb_product INT NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, PRIMARY KEY(years)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_best_product_sales_month (classement INT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(classement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_best_product_sales_year (classement INT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, years VARCHAR(4) NOT NULL, PRIMARY KEY(classement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_canal_month (canal_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, nb_product_value INT NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(canal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_canal_month_product (canal_id INT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, nb_product_value INT NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(canal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view_canal_year_product (canal_id INT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, nb_product_value INT NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, PRIMARY KEY(canal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD objectif_value INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE view_benefit_month');
        $this->addSql('DROP TABLE view_benefit_month_category');
        $this->addSql('DROP TABLE view_benefit_month_product');
        $this->addSql('DROP TABLE view_benefit_year_product');
        $this->addSql('DROP TABLE view_best_product_sales_month');
        $this->addSql('DROP TABLE view_best_product_sales_year');
        $this->addSql('DROP TABLE view_canal_month');
        $this->addSql('DROP TABLE view_canal_month_product');
        $this->addSql('DROP TABLE view_canal_year_product');
        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user DROP objectif_value');
    }
}
