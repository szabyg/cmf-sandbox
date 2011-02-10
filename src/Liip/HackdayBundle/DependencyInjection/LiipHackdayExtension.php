<?php

namespace Liip\HackdayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LiipHackdayExtension extends Extension
{
    /**
     * Yaml config files to load
     * @var array
     */
    protected $resources = array(
        'config' => 'config.yml',
    );

    /**
     * Loads the services based on your application configuration.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function configLoad($configs, ContainerBuilder $container)
    {
        $config = array_shift($configs);
        foreach ($configs as $tmp) {
            $config = array_replace_recursive($config, $tmp);
        }

        $loader = $this->getFileLoader($container);
        $loader->load($this->resources['config']);

        foreach ($config as $key => $value) {
            $container->setParameter($this->getAlias().'.'.$key, $value);
        }

        $config = array_shift($configs);
        foreach ($configs as $tmp) {
            $config = array_replace_recursive($config, $tmp);
        }
    }

    /**
     * Get File Loader
     *
     * @param ContainerBuilder $container
     */
    public function getFileLoader(ContainerBuilder $container)
    {
        return new YamlFileLoader($container, __DIR__.'/../Resources/config');
    }

    /**
     * @inheritDoc
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * @inheritDoc
     */
    public function getNamespace()
    {
        return 'http://liip.ch/schema/dic/'.$this->getAlias();
    }

    /**
     * @inheritDoc
     */
    public function getAlias()
    {
        return 'liip_hackday';
    }
}