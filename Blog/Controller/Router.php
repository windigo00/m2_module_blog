<?php

namespace Windigo\Blog\Controller;

use Magento\Framework\App\RouterInterface;

/**
 * Description of Router
 *
 * @author KuBik
 */
class Router implements RouterInterface {
	/**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Post factory
     *
     * @var \Windigo\Blog\Model\PostFactory
     */
    protected $_postFactory;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Windigo\Blog\Model\PostFactory $postFactory
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Windigo\Blog\Model\PostFactory $postFactory
    ) {
        $this->actionFactory = $actionFactory;
        $this->_postFactory = $postFactory;
    }

    /**
     * Validate and Match Blog Post and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $url_key = trim($request->getPathInfo(), '/wblog/');
        $url_key = rtrim($url_key, '/');

        /** @var \Windigo\Blog\Model\Post $post */
        $post = $this->_postFactory->create();
        $post_id = $post->checkUrlKey($url_key);
        if (!$post_id) {
            return null;
        }

        $request->setModuleName('wblog')->setControllerName('view')->setActionName('index')->setParam('post_id', $post_id);
        $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $url_key);

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
