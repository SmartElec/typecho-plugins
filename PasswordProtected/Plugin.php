<?php

namespace TypechoPlugin\PasswordProtected;

use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Text;
use Widget\Options;
use Utils\Helper;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * Password Protected插用密码保护你的整个网站。要查看网站内容，访客必须输入密码。
 *
 * @package PasswordProtected
 * @author 泽泽
 * @version 0.6.0
 * @link http://typecho.work
 */
class Plugin implements PluginInterface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static function activate()
    {
        \Typecho\Plugin::factory('Widget_Archive')->beforeRender = __CLASS__ . '::render';//使用插件接口
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */
    public static function config(Form $form)
    {
        /** 密码设置 */
        $password = new Text('password', null, '1234', _t('请输入密码'), _t('请输入想设置的密码，默认密码为1234'));
        $form->addInput($password->addRule('required', _t('密码不能为空')));
    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form)
    {
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render($obj, $select)
    {
            include('theme.php');//前台用户密码输入界面
    }
}
