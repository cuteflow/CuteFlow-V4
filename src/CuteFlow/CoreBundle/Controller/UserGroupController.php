<?php

namespace CuteFlow\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CuteFlow\CoreBundle\Entity\UserGroup;
use CuteFlow\CoreBundle\Form\UserGroupType;

/**
 * UserGroup controller.
 *
 * @Route("/usergroup")
 */
class UserGroupController extends Controller
{
    /**
     * Lists all UserGroup entities.
     *
     * @Route("/", name="cuteflow_admin_usergroup")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('CuteFlowCoreBundle:UserGroup')->findAll();
        return array('entities' => $entities);
    }

    /**
     * Displays a form to create a new UserGroup entity.
     *
     * @Route("/new", name="cuteflow_admin_usergroup_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UserGroup();
        $form   = $this->createForm(new UserGroupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new UserGroup entity.
     *
     * @Route("/create", name="cuteflow_admin_usergroup_create")
     * @Method("post")
     * @Template("CuteFlowCoreBundle:UserGroup:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new UserGroup();
        $request = $this->getRequest();
        $form    = $this->createForm(new UserGroupType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('saved.successful', 1);
            return $this->redirect($this->generateUrl('cuteflow_admin_usergroup', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing UserGroup entity.
     *
     * @Route("/{id}/edit", name="cuteflow_admin_usergroup_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CuteFlowCoreBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }

        $editForm = $this->createForm(new UserGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UserGroup entity.
     *
     * @Route("/{id}/update", name="cuteflow_admin_usergroup_update")
     * @Method("post")
     * @Template("CuteFlowCoreBundle:UserGroup:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CuteFlowCoreBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }

        $editForm   = $this->createForm(new UserGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('saved.successful', 1);
            return $this->redirect($this->generateUrl('cuteflow_admin_usergroup'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UserGroup entity.
     *
     * @Route("/delete/{id}", name="cuteflow_admin_usergroup_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $group = $em->find('CuteFlowCoreBundle:UserGroup', $id);

        if (!$group) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $em->remove($group);
        $em->flush();

        $this->getRequest()->getSession()->setFlash('deleted.successful', 1);
        return new \Symfony\Component\HttpFoundation\RedirectResponse(
            $this->generateUrl('cuteflow_admin_usergroup')
        );
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
