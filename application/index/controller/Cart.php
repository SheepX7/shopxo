<?php
namespace app\index\controller;

use app\service\BuyService;

/**
 * 购物车
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Cart extends Common
{
    /**
     * 构造方法
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-11-30
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->Is_Login();
    }
    
    /**
     * 首页
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-02-22T16:50:32+0800
     */
    public function Index()
    {
        $cart_list = BuyService::CartList(['user'=>$this->user]);
        $this->assign('cart_list', $cart_list['data']);

        $base = [
            'total_price'   => empty($cart_list['data']) ? 0 : array_sum(array_column($cart_list['data'], 'total_price')),
            'total_stock'   => empty($cart_list['data']) ? 0 : array_sum(array_column($cart_list['data'], 'stock')),
            'ids'           => empty($cart_list['data']) ? '' : implode(',', array_column($cart_list['data'], 'id')),
        ];
        $this->assign('base', $base);
        return $this->fetch();
    }

    /**
     * 购物车保存
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-13
     * @desc    description
     */
    public function Save()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        $params = $_POST;
        $params['user'] = $this->user;
        $ret = BuyService::CartAdd($params);
        return json($ret);
    }

    /**
     * 购物车删除
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-14
     * @desc    description
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        $params = $_POST;
        $params['user'] = $this->user;
        $ret = BuyService::CartDelete($params);
        return json($ret);
    }

    /**
     * 数量保存
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-14
     * @desc    description
     */
    public function Stock()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        $params = $_POST;
        $params['user'] = $this->user;
        $ret = BuyService::CartStock($params);
        return json($ret);
    }
}
?>