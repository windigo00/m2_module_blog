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
     * Blog factory
     *
     * @var \Windigo\Blog\Model\BlogFactory
     */
    protected $_blogFactory;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Windigo\Blog\Model\BlogFactory $blogFactory
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Windigo\Blog\Model\BlogFactory $blogFactory
    ) {
        $this->actionFactory = $actionFactory;
        $this->_blogFactory = $blogFactory;
    }

    /**
     * Validate and Match Blog Blog and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $url_key = trim($request->getPathInfo(), '/wblog/');
        $url_key = rtrim($url_key, '/');
        /** @var \Windigo\Blog\Model\Blog $blog */
        $blog = $this->_blogFactory->create();
        $blog_id = $blog->checkUrlKey($url_key);
		if (!$blog_id) {
            return null;
        }

        $request->setModuleName('wblog')->setControllerName('view')->setActionName('index')->setParam('id', $blog_id);
        $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $url_key);

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
