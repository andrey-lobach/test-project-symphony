<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.3.19
 * Time: 17.42
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Message;
use AppBundle\Entity\MessageList;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MessageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('author', TextType::class)
            ->add('message', TextareaType::class)
            ->add('messageList', EntityType::class, [
                'class' => MessageList::class,
                'choice_label' => 'title',
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('author')
            ->add('message');
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('author')
            ->addIdentifier('message');
    }

    public function toString($object)
    {
        return $object instanceof Message
            ? $object->getId()
            : 'Message'; // shown in the breadcrumb on the create view
    }

}