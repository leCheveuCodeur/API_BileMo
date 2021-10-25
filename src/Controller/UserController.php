<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidatorException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/api/users", name="user_list")
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="per_page",
     *     requirements="\d+",
     *     default="5",
     *     description="Max number of movies per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     *
     * @Rest\View(serializerGroups={"Default","user_list"})
     */
    public function listAction(UserRepository $userRepository, ParamFetcherInterface $paramFetcher)
    {
        $customerId = $this->getUser()->getId();
        $paginatedCollection = $userRepository->search(
            $customerId,
            "user_list",
            $paramFetcher->get('order'),
            $paramFetcher->get('per_page'),
            $paramFetcher->get('page')
        );

        return $paginatedCollection;
    }

    /**
     * @Rest\Get(
     * path = "/api/users/{id}",
     * name ="user_show",
     * requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(serializerGroups={"user_details"})
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     * @Rest\Post(
     * path="/api/users",
     * name="user_create"
     * )
     * @ParamConverter(
     * "user",
     * converter="fos_rest.request_body",
     * options={
     *  "validator"={"groups"="Create"}
     * }
     * )
     *
     * @Rest\View(StatusCode=201,serializerGroups={"user_details","user_create"})
     */
    public function createAction(User $user, EntityManagerInterface $em, ConstraintViolationList $violations)
    {
        if (\count($violations)) {
            $message = 'The JSON sent contains invalid data: ';
            foreach ($violations as $violation) {
                $message .= \sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ValidatorException($message);
        }
        $user->setCustomer($this->getUser());
        $em->persist($user);
        $em->flush();

        return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('user_show', ['id' => $user->getId()])]);
    }

    /**
     * @Rest\Delete(
     * path="/api/users/{id}",
     * name="user_delete",
     * requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteAction(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();
    }


    /**
     * @Rest\Put(
     * path="/api/users/{id}",
     * name="user_put",
     * requirements = {"id"="\d+"})
     * @ParamConverter(
     * "user",
     * converter="fos_rest.request_body",
     * options={
     *  "validator"={"groups"="Create"}
     * }
     * )
     *
     * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT,serializerGroups={"user_details","user_create"})
     */
    public function putAction(User $user, EntityManagerInterface $em, ConstraintViolationList $violations, UserRepository $userRepository)
    {
        if (\count($violations)) {
            $message = 'The JSON sent contains invalid data: ';
            foreach ($violations as $violation) {
                $message .= \sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ValidatorException($message);
        }

        $em->persist($user);
        $em->flush();

        return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('user_show', ['id' => $user->getId()])]);
    }
}
