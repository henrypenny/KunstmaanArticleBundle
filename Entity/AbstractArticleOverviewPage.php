<?php

namespace Kunstmaan\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\ArticleBundle\PagePartAdmin\AbstractArticleOverviewPagePagePartAdminConfigurator;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\NodeBundle\Helper\RenderContext;
use Kunstmaan\PagePartBundle\Helper\HasPagePartsInterface;
use Kunstmaan\PagePartBundle\PagePartAdmin\AbstractPagePartAdminConfigurator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * The article overview page which shows its articles
 *
 * @ORM\Entity()
 * @ORM\Table(name="kuma_abstractarticleoverviewpages")
 */
class AbstractArticleOverviewPage extends AbstractPage implements HasPagePartsInterface
{
    /**
     * The blog will have BlogEntry's as its children
     *
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array (
            array(
                'name' => 'Abstract Article',
                'class'=> "Kunstmaan\ArticleBundle\Entity\AbstractArticlePage"
            )
        );
    }

    /**
     * @return AbstractPagePartAdminConfigurator[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array(new AbstractArticleOverviewPagePagePartAdminConfigurator());
    }

    /**
     * @param ContainerInterface $container
     * @param Request            $request
     * @param RenderContext      $context
     */
    public function service(ContainerInterface $container, Request $request, RenderContext $context)
    {
        parent::service($container, $request, $context);
        $em = $container->get('doctrine')->getManager();
        $repository = $em->getRepository('KunstmaanArticleBundle:AbstractArticlePage');
        $context['articles'] = $repository->getArticles();
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return "KunstmaanArticleBundle:AbstractArticleOverviewPage:view.html.twig";
    }

}
