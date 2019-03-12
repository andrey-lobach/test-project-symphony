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
use Symfony\Component\Form\Extension\Core\Type\TextType;


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
            ->add('id')
            ->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title');
    }
    public function toString($object)
    {
        return $object instanceof MessageList
            ? $object->getTitle()
            : 'Message'; // shown in the breadcrumb on the create view
    }
}