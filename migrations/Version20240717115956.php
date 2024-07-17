<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717115956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE view_benefit_month (user_id INT NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE view_benefit_month_category (user_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE view_benefit_month_product (product_id INT NOT NULL, user_id INT NOT NULL, nb_product INT NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE view_canal_month (user_id INT NOT NULL, canal_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, nb_product_value INT NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE view_canal_month_product (product_id INT NOT NULL, user_id INT NOT NULL, canal_id INT NOT NULL, name VARCHAR(255) NOT NULL, benefit_value DOUBLE PRECISION NOT NULL, price_value DOUBLE PRECISION NOT NULL, nb_product_value INT NOT NULL, ursaf_value DOUBLE PRECISION NOT NULL, expense_value DOUBLE PRECISION NOT NULL, commission_value DOUBLE PRECISION NOT NULL, time_value DOUBLE PRECISION NOT NULL, benefit_pourcent DOUBLE PRECISION NOT NULL, years VARCHAR(4) NOT NULL, month VARCHAR(2) NOT NULL, date_full VARCHAR(7) NOT NULL, PRIMARY KEY(product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE urssaf_pourcent urssaf_pourcent DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP TABLE view_benefit_month');
        // $this->addSql('DROP TABLE view_benefit_month_category');
        // $this->addSql('DROP TABLE view_benefit_month_product');
        // $this->addSql('DROP TABLE view_canal_month');
        // $this->addSql('DROP TABLE view_canal_month_product');
        $this->addSql('ALTER TABLE user CHANGE urssaf_pourcent urssaf_pourcent INT DEFAULT NULL');
    }
}
