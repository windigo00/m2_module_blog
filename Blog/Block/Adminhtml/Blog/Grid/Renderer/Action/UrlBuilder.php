<?php

namespace Windigo\Blog\Block\Adminhtml\Blog\Grid\Renderer\Action;

class UrlBuilder
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $frontendUrlBuilder;

    /**
     * @param \Magento\Framework\UrlInterface $frontendUrlBuilder
     */
    public function __construct(\Magento\Framework\UrlInterface $frontendUrlBuilder)
    {
        $this->frontendUrlBuilder = $frontendUrlBuilder;
    }

    /**
     * Get action url
     *
     * @param string $routePath
     * @param string $scope
     * @return string
     */
    public function getUrl($routePath, $scope)
    {
        $this->frontendUrlBuilder->setScope($scope);
        $href = $this->frontendUrlBuilder->getUrl(
            $routePath,
            ['_current' => false]
        );
        return $href;
    }
}
