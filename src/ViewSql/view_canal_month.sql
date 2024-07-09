CREATE VIEW view_canal_month AS 
SELECT 
    sp.name AS name,
    sp.user_id AS user_id,
    sale.canal_id,
    SUM(sale.benefit) AS benefit_value,
    SUM(sale.price) AS price_value,
    SUM(sale.nb_product) AS nb_product_value,
    AVG(sale.ursaf) AS ursaf_value,
    SUM(sale.expense) AS expense_value,
    AVG(sale.commission) AS commission_value,
    SUM(time) AS time_value,
    (SUM(sale.benefit) / SUM(price)) * 100 AS benefit_pourcent,
    DATE_FORMAT(sale.created_at, '%Y') AS years,
    DATE_FORMAT(sale.created_at, '%m') AS month,
    DATE_FORMAT(sale.created_at, '%Y-%m') AS date_full
FROM
    sale sale
LEFT JOIN sales_channel sp ON sale.canal_id = sp.id
GROUP BY
    sp.name,
    sp.user_id,
    sale.canal_id,
    DATE_FORMAT(sale.created_at, '%Y'),
    DATE_FORMAT(sale.created_at, '%m'),
    DATE_FORMAT(sale.created_at, '%Y-%m');
