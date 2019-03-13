<?php

namespace AppBundle\Admin;

use AppBundle\Entity\MessageList;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

/**
 * Class MessageListAdmin
 */
class MessageListAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show'   => [],
                        'edit'   => [],
                        'delete' => [],
                    ],
                ]
            );
    }

    /**
     * @param $object
     *
     * @return mixed|string
     */
    public function toString($object)
    {
        return $object instanceof MessageList ? $object->getTitle() : 'Message';
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('title');
    }

    /**
     * @param MenuItemInterface   $menu
     * @param string              $action
     * @param AdminInterface|null $childAdmin
     *
     * @return mixed|void
     */
    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }
        /** @var AdminInterface $admin */
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        $blogAdmin = $this->getChild('admin.blog_post');
        $menu->addChild(
            'View MessageList',
            [
                'uri' => $admin->generateUrl('show', ['id' => $id]),
            ]
        );
        if ($this->isGranted('EDIT')) {
            $menu->addChild(
                'Edit MessageList',
                [
                    'uri' => $admin->generateUrl('edit', ['id' => $id]),
                ]
            );
        }
        if ($blogAdmin->isGranted('LIST')) {
            $menu->addChild(
                'Manage Messages',
                [
                    'uri' => $blogAdmin->generateUrl('list'),
                ]
            );
        }
    }
}
