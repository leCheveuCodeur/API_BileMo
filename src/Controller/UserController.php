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
     * @Rest\View(serializerGroups={"user_list"})
     */
    public function listAction(UserRepository $userRepository, ParamFetcherInterface $paramFetcher)
    {
        $customerId = $this->getUser()->getId();
        $pager = $userRepository->search(
            $customerId,
            $paramFetcher->get('order'),
            $paramFetcher->get('per_page'),
            $paramFetcher->get('page')
        );

        return $pager;
    }

    /**
     * @Rest\Get(
     * path = "/api/users/{id}",
     * name ="user_show",
     * requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(serializerGroups={"user_detail"})
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
     * @Rest\View(StatusCode=201,serializerGroups={"user_detail","user_create"})
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
}
