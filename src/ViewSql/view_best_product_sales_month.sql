CREATE OR REPLACE VIEW view_best_product_sales_month AS
SELECT
    CONCAT(DATE_FORMAT(MIN(sale.created_at), '%Y-%m'), '-', sales_product.product_id) AS id,
    sale.user_id,
    RANK() OVER (
        PARTITION BY DATE_FORMAT(sale.created_at, '%Y-%m')
        ORDER BY
            COUNT(sales_product.product_id) DESC
    ) AS classement,
    sales_product.product_id,
    COUNT(sales_product.product_id) AS nb_product,
    DATE_FORMAT(MIN(sale.created_at), '%Y') AS years,
    DATE_FORMAT(MIN(sale.created_at), '%m') AS month,
    DATE_FORMAT(MIN(sale.created_at), '%Y-%m') AS date_full
FROM
    sales_product
    LEFT JOIN sale ON sales_product.sale_id = sale.id
GROUP BY
    sales_product.product_id,
    sale.user_id,
    DATE_FORMAT(sale.created_at, '%Y-%m');