<?php

namespace App\Controller;

use App\Entity\MobilePhone;
use App\Repository\MobilePhoneRepository;
use App\Representation\MobilePhones;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     *     description="The pagination offset"
     * )
     *
     * @Rest\View(serializerGroups={"mobile_list"})
     */
    public function listAction(MobilePhoneRepository $mobilePhoneRepository, ParamFetcherInterface $paramFetcher)
    {
        $pager = $mobilePhoneRepository->search(
            $paramFetcher->get('order'),
            $paramFetcher->get('per_page'),
            $paramFetcher->get('page')
        );

        return $pager;
    }

    /**
     * @Rest\Get(
     * path = "/api/mobiles/{id}",
     * name ="mobile_show",
     * requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(serializerGroups={"mobile_detail"})
     */
    public function showAction(MobilePhone $mobilePhone)
    {
        return $mobilePhone;
    }
}
