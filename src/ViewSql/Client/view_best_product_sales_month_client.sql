CREATE
OR REPLACE VIEW view_best_product_sales_month_client AS
SELECT sale.user_id,
       RANK()                                     OVER (
           PARTITION BY DATE_FORMAT(MIN(sale.created_at), '%Y-%m')
           ORDER BY
               COUNT(sales_product.product_id) DESC
           )                                      AS classement, sales_product.product_id,
       sales_product.client_id,
       product.name                            AS product_name,
       COUNT(sales_product.product_id)         AS nb_product,
       DATE_FORMAT(MIN(sale.created_at), '%Y') AS years,
       DATE_FORMAT(MIN(sale.created_at), '%m') AS month,
       DATE_FORMAT(MIN(sale.created_at), '%Y-%m') AS date_full
FROM sales_product
    LEFT JOIN sale
ON sales_product.sale_id = sale.id
    LEFT JOIN product ON sales_product.product_id = product.id
GROUP BY sales_product.product_id,
    sale.user_id,
    sales_product.client_id,
    DATE_FORMAT(sale.created_at, '%Y-%m');