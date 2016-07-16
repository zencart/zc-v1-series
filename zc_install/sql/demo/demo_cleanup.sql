# This script deletes ALL records from the tables which are 
# populated with demo data.   Do not use if you have begun 
# adding real data or gone live with your site; you will need 
# to delete the demo data more selectively in that case. 

TRUNCATE TABLE address_book; 
TRUNCATE TABLE categories;
TRUNCATE TABLE categories_description;
TRUNCATE TABLE customers;
TRUNCATE TABLE customers_info; 
TRUNCATE TABLE ezpages; 
TRUNCATE TABLE featured; 
TRUNCATE TABLE group_pricing; 
TRUNCATE TABLE manufacturers; 
TRUNCATE TABLE manufacturers_info; 
TRUNCATE TABLE media_clips; 
TRUNCATE TABLE media_manager; 
TRUNCATE TABLE media_to_products;
TRUNCATE TABLE piece_style; 
TRUNCATE TABLE product_piece_extra; 
TRUNCATE TABLE product_types_to_category; 
TRUNCATE TABLE products; 
TRUNCATE TABLE products_attributes; 
TRUNCATE TABLE products_attributes_download; 
TRUNCATE TABLE products_description; 
TRUNCATE TABLE products_discount_quantity; 
TRUNCATE TABLE products_options; 
TRUNCATE TABLE products_options_values; 
TRUNCATE TABLE products_options_values_to_products_options; 
TRUNCATE TABLE products_to_categories; 
TRUNCATE TABLE artists; 
TRUNCATE TABLE artists_info; 
TRUNCATE TABLE agency; 
TRUNCATE TABLE agency_info; 
TRUNCATE TABLE reviews; 
TRUNCATE TABLE reviews_description; 
TRUNCATE TABLE salemaker_sales; 
TRUNCATE TABLE specials; 
