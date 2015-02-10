<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			new FOS\UserBundle\FOSUserBundle(),
			new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),

            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

//			new Sonata\CoreBundle\SonataCoreBundle(),
//			new Sonata\BlockBundle\SonataBlockBundle(),
//			new Sonata\jQueryBundle\SonatajQueryBundle(),
//			new Knp\Bundle\MenuBundle\KnpMenuBundle(),
//			new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),

			// Then add SonataAdminBundle
//			new Sonata\AdminBundle\SonataAdminBundle(),

			new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
			new Dictionary\DictionaryBundle\DictionaryBundle(),
			new Dictionary\AdminBundle\DictionaryAdminBundle(),
			new Dictionary\UserBundle\UserBundle(),
            new Dictionary\PrevediBundle\PrevediBundle()
		);

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
