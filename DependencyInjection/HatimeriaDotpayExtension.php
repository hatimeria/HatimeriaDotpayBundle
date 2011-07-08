<?php
namespace Hatimeria\DotpayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class HatimeriaDotpayExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $request       = $config['request'];
        $request['id'] = $config['id'];
        $container->setParameter('hatimeria_dotpay.request', $request);

        foreach (array('form', 'services') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->updateParameters($config, $container, 'hatimeria_dotpay.');
    }

    public function updateParameters($config, ContainerBuilder $container, $ns = '')
    {
        foreach ($config as $key => $value)
        {
            if (is_array($value)) {
                $this->updateParameters($value, $container, $ns . $key . '.');
            } else {
                $container->setParameter($ns . $key, $value);
            }
        }
    }

}