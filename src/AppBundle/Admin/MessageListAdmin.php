<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.3.19
 * Time: 17.42
 */

namespace AppBundle\Admin;

use AppBundle\Entity\MessageList;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;


class MessageListAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title');
    }

    public function toString($object)
    {
        return $object instanceof MessageList
            ? $object->getTitle()
            : 'Message';
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('title');
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        $blogAdmin = $this->getChild('admin.blog_post');
        $menu->addChild('View MessageList', [
            'uri' => $admin->generateUrl('show', ['id' => $id])
        ]);
        if ($this->isGranted('EDIT')) {
            $menu->addChild('Edit MessageList', [
                'uri' => $admin->generateUrl('edit', ['id' => $id])
            ]);
        }
        if ($blogAdmin->isGranted('LIST')) {
            $menu->addChild('Manage Messages', [
                'uri' => $blogAdmin->generateUrl('list')
            ]);
        }
    }
}