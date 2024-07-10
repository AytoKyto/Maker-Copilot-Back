<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710200249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create views view_benefit_month_product and view_canal_month';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE VIEW view_benefit_month_product AS 
        //     SELECT 
        //         sale.user_id,
        //         sales_product.product_id,
        //         SUM(price.benefit) AS benefit_value,
        //         SUM(price.price) AS price_value,
        //         AVG(price.ursaf) AS ursaf_value,
        //         SUM(price.expense) AS expense_value,
        //         AVG(price.commission) AS commission_value,
        //         SUM(price.time) AS time_value,
        //         (SUM(price.benefit) / SUM(price.price)) * 100 AS benefit_pourcent,
        //         DATE_FORMAT(sale.created_at, \'%Y\') AS years,
        //         DATE_FORMAT(sale.created_at, \'%m\') AS month,
        //         DATE_FORMAT(sale.created_at, \'%Y-%m\') AS date_full
        //     FROM
        //         sales_product
        //     LEFT JOIN sale ON sales_product.sale_id = sale.id
        //     LEFT JOIN price ON sales_product.price_id = price.id
        //     GROUP BY
        //         sale.user_id,
        //         sales_product.product_id,
        //         DATE_FORMAT(sale.created_at, \'%Y\'),
        //         DATE_FORMAT(sale.created_at, \'%m\'),
        //         DATE_FORMAT(sale.created_at, \'%Y-%m\')'
        // );

        // $this->addSql('CREATE VIEW view_canal_month AS 
        //     SELECT 
        //         sp.name AS name,
        //         sale.user_id AS user_id,
        //         sale.canal_id,
        //         SUM(sale.benefit) AS benefit_value,
        //         SUM(sale.price) AS price_value,
        //         SUM(sale.nb_product) AS nb_product_value,
        //         AVG(sale.ursaf) AS ursaf_value,
        //         SUM(sale.expense) AS expense_value,
        //         AVG(sale.commission) AS commission_value,
        //         SUM(sale.time) AS time_value,
        //         (SUM(sale.benefit) / SUM(sale.price)) * 100 AS benefit_pourcent,
        //         DATE_FORMAT(sale.created_at, \'%Y\') AS years,
        //         DATE_FORMAT(sale.created_at, \'%m\') AS month,
        //         DATE_FORMAT(sale.created_at, \'%Y-%m\') AS date_full
        //     FROM
        //         sale
        //     LEFT JOIN sales_channel sp ON sale.canal_id = sp.id
        //     GROUP BY
        //         sp.name,
        //         sale.user_id,
        //         sale.canal_id,
        //         DATE_FORMAT(sale.created_at, \'%Y\'),
        //         DATE_FORMAT(sale.created_at, \'%m\'),
        //         DATE_FORMAT(sale.created_at, \'%Y-%m\')'
        // );

        $this->addSql('ALTER TABLE sale CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE benefit benefit DOUBLE PRECISION NOT NULL, CHANGE nb_product nb_product DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP VIEW view_benefit_month_product');
        $this->addSql('DROP VIEW view_canal_month');
        $this->addSql('ALTER TABLE sale CHANGE price price INT NOT NULL, CHANGE benefit benefit INT NOT NULL, CHANGE nb_product nb_product INT DEFAULT NULL');
    }
}
