<?php

namespace App\Controller;

use App\Entity\User;
use OpenApi\Annotations as OA;
use App\Repository\UserRepository;
use App\Service\SaltCache;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidatorException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @OA\Tag(name="Users")
 * @OA\Response(
 *     response=401,
 *     description="Invalid / Expired Token"
 * )
 */
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
     * @OA\Response(
     *     response=200,
     *     description="Returns the paginated list of users"
     * )
     * @OA\Get(summary="Get the paginated list of users")
     * @Rest\View(serializerGroups={"Default","user_list"})
     */
    public function listAction(UserRepository $userRepository, ParamFetcherInterface $paramFetcher, CacheInterface $cache, SaltCache $saltCache)
    {
        return $cache->get('users_' . $saltCache->salt(), function (ItemInterface $item) use ($userRepository, $paramFetcher) {
            $item->expiresAfter(3600);

            $customerId = $this->getUser()->getId();
            $paginatedCollection = $userRepository->search(
                $customerId,
                "user_list",
                $paramFetcher->get('order'),
                $paramFetcher->get('per_page'),
                $paramFetcher->get('page')
            );
            return $paginatedCollection;
        });
    }

    /**
     * @Rest\Get(
     * path = "/api/users/{id}",
     * name ="user_show",
     * requirements = {"id"="\d+"}
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns details of user"
     * )
     * @OA\Get(summary="Get the details of user")
     * @Rest\View(serializerGroups={"user_details"})
     */
    public function showAction(User $user, CacheInterface $cache)
    {
        return $cache->get('user_' . $user->getId(), function (ItemInterface $item) use ($user) {
            $item->expiresAfter(3600);

            return $user;
        });
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
     * @OA\RequestBody(
     *     description="Add user",
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(
     *                 property="first_name",
     *                 description="First name of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 description="Last name of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 description="Email of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="products_buy",
     *                 description="Id of mobile phones purchased",
     *                 type="object",
     *                 @OA\Property(
     *                      property="id",
     *                      description="Id of mobile phone",
     *                      type="integer"
     *                 ),
     *             ),
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="OK"
     * )
     * @OA\Post(summary="Add a new user")
     * @Rest\View(StatusCode=201,serializerGroups={"user_details","user_products"})
     */
    public function createAction(User $user, EntityManagerInterface $em, ConstraintViolationList $violations, CacheInterface $cache, SaltCache $saltCache)
    {
        if (\count($violations)) {
            $message = 'The JSON sent contains invalid data: ';
            foreach ($violations as $violation) {
                $message .= \sprintf("|| Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ValidatorException($message);
        }
        $user->setCustomer($this->getUser());
        $em->persist($user);
        $em->flush();

        $cache->delete('users_' . $saltCache->salt());

        return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('user_show', ['id' => $user->getId()])]);
    }

    /**
     * @Rest\Delete(
     * path="/api/users/{id}",
     * name="user_delete",
     * requirements = {"id"="\d+"}
     * )
     *
     * @OA\Response(
     *     response=204,
     *     description="Success, user deleted"
     * )
     * @OA\Delete(summary="Delete user")
     * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteAction(User $user, EntityManagerInterface $em, CacheInterface $cache, SaltCache $saltCache)
    {
        $em->remove($user);
        $em->flush();

        $cache->delete('users_' . $saltCache->salt());
    }


    /**
     * @Rest\Patch(
     * path="/api/users",
     * name="user_put"
     * )
     * @ParamConverter(
     * "user",
     * converter="fos_rest.request_body",
     * options={
     *  "validator"={"groups"="Create"}
     * }
     * )
     *
     * @OA\RequestBody(
     *     description="Add user",
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 description="User ID to update",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="name_of_attribute",
     *                 description="Name of the attribute to modify (ex: lastname)",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="OK",
     *     @Model(type=User::class, groups={"user_details", "user_products"})
     * )
     * @OA\Patch(summary="Update user")
     * @Rest\View(StatusCode=Response::HTTP_NO_CONTENT,serializerGroups={"user_details"})
     */
    public function putAction(User $user, EntityManagerInterface $em, ConstraintViolationList $violations, CacheInterface $cache, SaltCache $saltCache)
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

        $cache->delete('users_' . $saltCache->salt());

        return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('user_show', ['id' => $user->getId()])]);
    }
}
