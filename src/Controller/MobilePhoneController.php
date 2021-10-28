<?php

namespace App\Controller;

use App\Entity\MobilePhone;
use App\Repository\MobilePhoneRepository;
use App\Representation\MobilePhones;
use App\Service\SaltCache;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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
     */
    public function listAction(MobilePhoneRepository $mobilePhoneRepository, ParamFetcherInterface $paramFetcher, CacheInterface $cache, SaltCache $saltCache)
    {
        return $cache->get('mobiles_' . $saltCache->salt(), function (ItemInterface $item) use ($mobilePhoneRepository, $paramFetcher) {
            $item->expiresAfter(3600);

            return $mobilePhoneRepository->search(
                "mobile_list",
                $paramFetcher->get('order'),
                $paramFetcher->get('per_page'),
                $paramFetcher->get('page')
            );
        });
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
     */
    public function showAction(MobilePhone $mobilePhone, CacheInterface $cache)
    {
        return $cache->get('mobile_' . $mobilePhone->getId(), function (ItemInterface $item) use ($mobilePhone) {
            $item->expiresAfter(3600);

            return $mobilePhone;
        });
    }
}
