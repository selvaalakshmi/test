CREATE TABLE IF NOT EXISTS `wbm_data_layer_modules` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `module` VARCHAR(255) NOT NULL , `variables` LONGTEXT NULL , `predispatch` BOOLEAN DEFAULT '0' , PRIMARY KEY (`id`) , UNIQUE INDEX `module_UNIQUE` (`module` ASC)) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `wbm_data_layer_properties` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `module` VARCHAR(255) NOT NULL , `parentID` INT(11) NOT NULL DEFAULT '0' , `name` VARCHAR(255) NOT NULL , `value` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT IGNORE INTO `wbm_data_layer_modules` (`id`, `module`, `variables`, `predispatch`) VALUES
  (1, 'frontend_listing_index', NULL, 0),
  (2, 'frontend_detail_index', NULL, 0),
  (3, 'frontend_checkout_cart', NULL, 0),
  (4, 'frontend_checkout_confirm', NULL, 0),
  (5, 'frontend_checkout_finish', NULL, 0),
  (6, 'frontend_checkout_ajaxaddarticlecart', NULL, 0),
  (7, 'frontend_checkout_ajaxdeletearticlecart', NULL, 1),
  (8, 'frontend_search_defaultsearch', NULL, 0),
  (9, 'frontend_register_index', NULL, 0),
  (10, 'frontend_checkout_shippingpayment', NULL, 0),
  (11, 'frontend_index_index', NULL, 0);

INSERT IGNORE INTO `wbm_data_layer_properties` (`id`, `module`, `parentID`, `name`, `value`) VALUES
  (1, 'frontend_listing_index', 0, 'ecommerce', ''),
  (2, 'frontend_listing_index', 1, 'currencyCode', '{0|currency:USE_SHORTNAME:LEFT|truncate:3:\'\'}'),
  (4, 'frontend_listing_index', 1, 'impressions', '$sArticles as $sArticle'),
  (6, 'frontend_listing_index', 4, 'name', '{$sArticle.articleName|escape}'),
  (7, 'frontend_listing_index', 4, 'id', '{$sArticle.ordernumber|escape|to_string}'),
  (8, 'frontend_listing_index', 4, 'price', '{$sArticle.price_numeric}'),
  (9, 'frontend_listing_index', 4, 'brand', '{$sArticle.supplierName|escape}'),
  (10, 'frontend_listing_index', 4, 'category', '{if $sCategoryContent.name}{$sCategoryContent.name|escape}{elseif $smarty.request.c}{{dbquery select=\'description\' from=\'s_categories\' where=[\'id =\' => $smarty.request.c]}|escape}{/if}'),
  (11, 'frontend_listing_index', 4, 'list', 'Category'),
  (12, 'frontend_detail_index', 0, 'ecommerce', ''),
  (13, 'frontend_detail_index', 12, 'detail', ''),
  (14, 'frontend_detail_index', 13, 'actionField', ''),
  (15, 'frontend_detail_index', 14, 'list', '{$sCategoryInfo.name|escape}'),
  (107, 'frontend_detail_index', 13, 'products', '[$sArticle] as $article'),
  (16, 'frontend_detail_index', 107, 'name', '{$article.articleName|escape}'),
  (17, 'frontend_detail_index', 107, 'id', '{$article.ordernumber|escape|to_string}'),
  (18, 'frontend_detail_index', 107, 'price', '{$article.price_numeric}'),
  (19, 'frontend_detail_index', 107, 'brand', '{$article.supplierName|escape}'),
  (20, 'frontend_detail_index', 107, 'category', '{$sCategoryInfo.name|escape}'),
  (21, 'frontend_detail_index', 107, 'variant', '{$article.additionaltext|escape}'),
  (23, 'frontend_detail_index', 12, 'currencyCode', '{0|currency:USE_SHORTNAME:LEFT|truncate:3:\'\'}'),
  (24, 'frontend_checkout_ajaxaddarticlecart', 0, 'event', 'addToCart'),
  (25, 'frontend_checkout_ajaxaddarticlecart', 0, 'ecommerce', ''),
  (26, 'frontend_checkout_ajaxaddarticlecart', 25, 'currencyCode', '{0|currency:USE_SHORTNAME:LEFT|truncate:3:\'\'}'),
  (27, 'frontend_checkout_ajaxaddarticlecart', 25, 'add', ''),
  (28, 'frontend_checkout_ajaxaddarticlecart', 27, 'products', '[0] as $position'),
  (30, 'frontend_checkout_ajaxaddarticlecart', 28, 'id', '{$smarty.request.sAdd|escape|to_string}'),
  (33, 'frontend_checkout_ajaxaddarticlecart', 28, 'quantity', '{$smarty.request.sQuantity}'),
  (108, 'frontend_checkout_ajaxaddarticlecart', 28, 'price', '{dbquery select=\'price\' from=\'s_order_basket\' where=[\'ordernumber =\' => $smarty.request.sAdd, \'sessionID =\' => $smarty.session.Shopware.sessionId] order=[\'id\' => \'DESC\']}'),
  (34, 'frontend_checkout_ajaxdeletearticlecart', 0, 'event', 'removeFromCart'),
  (35, 'frontend_checkout_ajaxdeletearticlecart', 0, 'ecommerce', ''),
  (36, 'frontend_checkout_ajaxdeletearticlecart', 35, 'remove', ''),
  (37, 'frontend_checkout_ajaxdeletearticlecart', 36, 'products', '[0] as $position'),
  (38, 'frontend_checkout_ajaxdeletearticlecart', 37, 'id', '{{dbquery select=\'ordernumber\' from=\'s_order_basket\' where=[\'id =\' => {request_get param=\'sDelete\'}]}|escape|to_string}'),
  (109, 'frontend_checkout_ajaxdeletearticlecart', 37, 'price', '{dbquery select=\'price\' from=\'s_order_basket\' where=[\'id =\' => {request_get param=\'sDelete\'}]}'),
  (110, 'frontend_checkout_ajaxdeletearticlecart', 37, 'quantity', '{dbquery select=\'quantity\' from=\'s_order_basket\' where=[\'id =\' => {request_get param=\'sDelete\'}]}'),
  (39, 'frontend_checkout_cart', 0, 'event', 'checkout'),
  (40, 'frontend_checkout_cart', 0, 'ecommerce', ''),
  (41, 'frontend_checkout_cart', 40, 'checkout', ''),
  (42, 'frontend_checkout_cart', 41, 'actionField', ''),
  (43, 'frontend_checkout_cart', 42, 'step', '1'),
  (44, 'frontend_checkout_cart', 41, 'products', '$sBasket.content as $sArticle'),
  (45, 'frontend_checkout_cart', 44, 'name', '{$sArticle.articlename|escape}'),
  (46, 'frontend_checkout_cart', 44, 'id', '{$sArticle.ordernumber|escape|to_string}'),
  (47, 'frontend_checkout_cart', 44, 'price', '{$sArticle.priceNumeric}'),
  (48, 'frontend_checkout_cart', 44, 'brand', '{$sArticle.additional_details.supplierName|escape}'),
  (49, 'frontend_checkout_cart', 44, 'quantity', '{$sArticle.quantity}'),
  (50, 'frontend_checkout_confirm', 0, 'event', 'checkout'),
  (51, 'frontend_checkout_confirm', 0, 'ecommerce', ''),
  (52, 'frontend_checkout_confirm', 51, 'checkout', ''),
  (53, 'frontend_checkout_confirm', 52, 'actionField', ''),
  (54, 'frontend_checkout_confirm', 53, 'step', '2'),
  (55, 'frontend_checkout_confirm', 53, 'option', '{$sPayment.description|escape}'),
  (56, 'frontend_checkout_confirm', 52, 'products', '$sBasket.content as $sArticle'),
  (57, 'frontend_checkout_confirm', 56, 'name', '{$sArticle.articlename|escape}'),
  (58, 'frontend_checkout_confirm', 56, 'id', '{$sArticle.ordernumber|escape|to_string}'),
  (59, 'frontend_checkout_confirm', 56, 'price', '{$sArticle.priceNumeric}'),
  (60, 'frontend_checkout_confirm', 56, 'brand', '{$sArticle.additional_details.supplierName|escape}'),
  (61, 'frontend_checkout_confirm', 56, 'quantity', '{$sArticle.quantity}'),
  (62, 'frontend_checkout_finish', 0, 'ecommerce', ''),
  (106, 'frontend_checkout_finish', 62, 'purchase', ''),
  (63, 'frontend_checkout_finish', 106, 'actionField', ''),
  (64, 'frontend_checkout_finish', 63, 'id', '{$sOrderNumber|escape|to_string}'),
  (65, 'frontend_checkout_finish', 63, 'revenue', '{$sAmount}'),
  (66, 'frontend_checkout_finish', 63, 'tax', '{$sAmountTax}'),
  (67, 'frontend_checkout_finish', 63, 'shipping', '{$sShippingcosts}'),
  (68, 'frontend_checkout_finish', 106, 'products', '$sBasket.content as $sArticle'),
  (69, 'frontend_checkout_finish', 68, 'name', '{$sArticle.articlename|escape}'),
  (70, 'frontend_checkout_finish', 68, 'id', '{$sArticle.ordernumber|escape|to_string}'),
  (71, 'frontend_checkout_finish', 68, 'price', '{$sArticle.priceNumeric}'),
  (72, 'frontend_checkout_finish', 68, 'brand', '{$sArticle.additional_details.supplierName|escape}'),
  (73, 'frontend_checkout_finish', 68, 'quantity', '{$sArticle.quantity}'),
  (74, 'frontend_search_defaultsearch', 0, 'ecommerce', ''),
  (75, 'frontend_search_defaultsearch', 74, 'currencyCode', '{0|currency:USE_SHORTNAME:LEFT|truncate:3:\'\'}'),
  (76, 'frontend_search_defaultsearch', 74, 'impressions', '$sSearchResults.sArticles as $sArticle'),
  (77, 'frontend_search_defaultsearch', 76, 'name', '{$sArticle.articleName|escape}'),
  (79, 'frontend_search_defaultsearch', 76, 'id', '{$sArticle.ordernumber|escape|to_string}'),
  (80, 'frontend_search_defaultsearch', 76, 'price', '{$sArticle.price_numeric}'),
  (81, 'frontend_search_defaultsearch', 76, 'brand', '{$sArticle.supplierName|escape}'),
  (82, 'frontend_search_defaultsearch', 76, 'list', 'Search Results'),
  (83, 'frontend_search_defaultsearch', 0, 'siteSearchTerm', '{$smarty.request.sSearch|escape}'),
  (84, 'frontend_search_defaultsearch', 0, 'siteSearchResults', '{$sSearchResults.sArticlesCount}'),
  (85, 'frontend_listing_index', 4, 'position', '{($pageIndex|default:1 - 1) * {config name=articlesperpage} + {$smarty.foreach.loop.iteration}}'),
  (86, 'frontend_search_defaultsearch', 76, 'position', '{$smarty.foreach.loop.iteration}'),
  (87, 'frontend_listing_index', 100, 'ecomm_pagetype', 'category'),
  (88, 'frontend_listing_index', 100, 'ecomm_prodid', '[{foreach $sArticles as $sArticle}"{$sArticle.ordernumber|escape}"{if !$sArticle@last},{/if}{/foreach}]'),
  (89, 'frontend_detail_index', 101, 'ecomm_pagetype', 'product'),
  (90, 'frontend_detail_index', 101, 'ecomm_prodid', '{$sArticle.ordernumber|escape}'),
  (91, 'frontend_checkout_cart', 102, 'ecomm_pagetype', 'cart'),
  (92, 'frontend_checkout_cart', 102, 'ecomm_prodid', '[{foreach $sBasket.content as $sArticle}"{$sArticle.ordernumber|escape}"{if !$sArticle@last},{/if}{/foreach}]'),
  (93, 'frontend_checkout_cart', 102, 'ecomm_totalvalue', '{$sAmount}'),
  (94, 'frontend_checkout_finish', 103, 'ecomm_pagetype', 'purchase'),
  (95, 'frontend_checkout_finish', 103, 'ecomm_totalvalue', '{$sAmount}'),
  (96, 'frontend_search_defaultsearch', 104, 'ecomm_pagetype', 'searchresults'),
  (97, 'frontend_search_defaultsearch', 104, 'ecomm_prodid', '[{foreach $sSearchResults.sArticles as $sArticle}"{$sArticle.ordernumber|escape}"{if !$sArticle@last},{/if}{/foreach}]'),
  (98, 'frontend_index_index', 105, 'ecomm_pagetype', 'home'),
  (99, 'frontend_listing_index', 100, 'ecomm_category', '{$sCategoryContent.name|escape}'),
  (100, 'frontend_listing_index', 0, 'google_tag_params', ''),
  (101, 'frontend_detail_index', 0, 'google_tag_params', ''),
  (102, 'frontend_checkout_cart', 0, 'google_tag_params', ''),
  (103, 'frontend_checkout_finish', 0, 'google_tag_params', ''),
  (104, 'frontend_search_defaultsearch', 0, 'google_tag_params', ''),
  (105, 'frontend_index_index', 0, 'google_tag_params', '');