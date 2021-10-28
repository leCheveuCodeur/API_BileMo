<?php

namespace App\Controller;

use App\Entity\MobilePhone;
use OpenApi\Annotations as OA;
use App\Repository\MobilePhoneRepository;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @OA\Tag(name="Mobile Phones")
 * @OA\Response(
 *     response=401,
 *     description="Invalid / Expired Token"
 * )
 */
class MobilePhoneController extends AbstractController
{
    /**
     * @Rest\Get("/api/mobiles", name="mobile_list")
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
     *     description="Numero of target page"
     * )
     *@OA\Response(
     *     response=200,
     *     description="Returns the paginated list of mobiles phones catalog"
     * )
     * @OA\Get(summary="Get the paginated list of mobile phones")
     * @Rest\View(serializerGroups={"Default","mobile_list"})
     *
     * @Cache(expires="tomorrow", public=true)
     */
    public function listAction(MobilePhoneRepository $mobilePhoneRepository, ParamFetcherInterface $paramFetcher)
    {
        return $mobilePhoneRepository->search(
            "mobile_list",
            $paramFetcher->get('order'),
            $paramFetcher->get('per_page'),
            $paramFetcher->get('page')
        );
    }

    /**
     * @Rest\Get(
     * path = "/api/mobiles/{id}",
     * name ="mobile_show",
     * requirements = {"id"="\d+"}
     * )
     *
     * @OA\Get(summary="Get details of mobile phone")
     * @Rest\View(serializerGroups={"mobile_details"})
     *
     * @Cache(expires="tomorrow", public=true)
     */
    public function showAction(MobilePhone $mobilePhone)
    {
        \sleep(3);
        return $mobilePhone;
    }
}
