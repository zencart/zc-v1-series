<?php
/**
 * Default autoloader namespace configuration
 *
 * @package initSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version  $Id: New in v1.6.0 $
 */
define('NAMESPACE_QUERYBUILDERDEFINITIONS', 'ZenCart\QueryBuilderDefinitions');
define('NAMESPACE_PAGINATOR', 'ZenCart\Paginator');
define('NAMESPACE_QUERYBUILDER', 'ZenCart\QueryBuilder');
define('NAMESPACE_REQUEST', 'ZenCart\Request');
define('NAMESPACE_DASHBOARDWIDGETS', 'ZenCart\DashboardWidget');
define('NAMESPACE_CONTROLLERS', 'ZenCart\Controllers');
define('NAMESPACE_SERVICES', 'ZenCart\Services');
define('NAMESPACE_AJAXDISPATCH', 'ZenCart\AjaxDispatch');
define('NAMESPACE_LEAD', 'ZenCart\Lead');
define('NAMESPACE_CHECKOUTFLOW', 'ZenCart\CheckoutFlow');
define('NAMESPACE_VIEW', 'ZenCart\View');
define('NAMESPACE_ADMINUSER', 'ZenCart\AdminUser');
define('NAMESPACE_VALITRON', 'Valitron');
define('NAMESPACE_FORMVALIDATION', 'ZenCart\FormValidation');
define('NAMESPACE_AURADI', 'Aura\Di');
define('NAMESPACE_INTEROPCONTAINER', 'Interop\Container');
define('NAMESPACE_ADMINNOTIFICATIONS', 'ZenCart\AdminNotifications');

define('URL_SERVICES', 'zencart/Services/src/');
define('URL_CONTROLLERS', 'zencart/Controllers/src/');
define('URL_AJAXDISPATCH', 'zencart/AjaxDispatch/src/');
define('URL_DASHBOARDWIDGETS', 'zencart/DashboardWidget/src/');
define('URL_QUERYBUILDERDEFINITIONS', 'zencart/QueryBuilderDefinitions/src/');
define('URL_PAGINATOR', 'zencart/Paginator/src/');
define('URL_QUERYBUILDER', 'zencart/QueryBuilder/src/');
define('URL_REQUEST', 'zencart/Request/src/');
define('URL_LEAD', 'zencart/Lead/src/');
define('URL_CHECKOUTFLOW', 'zencart/CheckoutFlow/src/');
define('URL_VIEW', 'zencart/View/src/');
define('URL_ADMINUSER', 'zencart/AdminUser/src/');
define('URL_VALITRON', 'vlucas/valitron/src/Valitron');
define('URL_FORMVALIDATION', 'zencart/FormValidation/src/');
define('URL_AURADI', 'aura/di/src/');
define('URL_INTEROPCONTAINER', 'container-interop/container-interop/src/Interop/Container/');
define('URL_ADMINNOTIFICATIONS', 'zencart/AdminNotifications/src/');

/**
 * An array of namespace => basedir configurations
 */
return array(
    '\Aura\Web' => DIR_CATALOG_LIBRARY . 'aura/web/src',
    NAMESPACE_SERVICES => DIR_CATALOG_LIBRARY . URL_SERVICES,
    NAMESPACE_CONTROLLERS => DIR_CATALOG_LIBRARY . URL_CONTROLLERS,
    NAMESPACE_AJAXDISPATCH => DIR_CATALOG_LIBRARY . URL_AJAXDISPATCH,
    NAMESPACE_DASHBOARDWIDGETS => DIR_CATALOG_LIBRARY . URL_DASHBOARDWIDGETS,
    NAMESPACE_QUERYBUILDERDEFINITIONS => DIR_CATALOG_LIBRARY. URL_QUERYBUILDERDEFINITIONS,
    NAMESPACE_PAGINATOR => DIR_CATALOG_LIBRARY. URL_PAGINATOR,
    NAMESPACE_QUERYBUILDER => DIR_CATALOG_LIBRARY. URL_QUERYBUILDER,
    NAMESPACE_REQUEST => DIR_CATALOG_LIBRARY. URL_REQUEST,
    NAMESPACE_LEAD => DIR_CATALOG_LIBRARY. URL_LEAD,
    NAMESPACE_CHECKOUTFLOW => DIR_CATALOG_LIBRARY. URL_CHECKOUTFLOW,
    NAMESPACE_VIEW => DIR_CATALOG_LIBRARY. URL_VIEW,
    NAMESPACE_ADMINUSER => DIR_CATALOG_LIBRARY. URL_ADMINUSER,
    NAMESPACE_VALITRON => DIR_CATALOG_LIBRARY. URL_VALITRON,
    NAMESPACE_FORMVALIDATION => DIR_CATALOG_LIBRARY. URL_FORMVALIDATION,
    NAMESPACE_AURADI => DIR_CATALOG_LIBRARY. URL_AURADI,
    NAMESPACE_INTEROPCONTAINER => DIR_CATALOG_LIBRARY. URL_INTEROPCONTAINER,
    NAMESPACE_ADMINNOTIFICATIONS => DIR_CATALOG_LIBRARY. URL_ADMINNOTIFICATIONS,
);
