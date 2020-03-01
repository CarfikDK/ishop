<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\ProductModel;
use RedBeanPHP\R;

class ProductController extends AppController
{

    public function viewAction()
    {
        $alias = $this->route['alias'];
        $product = R::findOne('product', "alias = ? AND status = '1'", [$alias]);
        if (!$product)
        {
            throw new \Exception('Страница не найдена', 404);
        }

        //связанные товары
        $related = R::getAll("SELECT * FROM related_product JOIN  product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);

        //галерея
        $gallery = R::findAll('gallery', 'product_id = ?', [$product->id]);

        //просмотренные товары
        $p_model = new ProductModel();
        $p_model->setRecentlyViewed($product->id);

        //отримання переглянутих товарів
        $r_view = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($r_view)
        {
            $recentlyViewed = R::find('product', 'id IN (' . R::genSlots($r_view) .') LIMIT 3', $r_view);
        }

        //хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

        //модификаторы
        $mods = R::findAll('modification', 'product_id = ?', [$product->id]);

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs', 'mods'));
    }

}