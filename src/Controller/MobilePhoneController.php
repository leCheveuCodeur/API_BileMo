<?php

namespace App\Controller;

use App\Entity\MobilePhone;
use App\Repository\MobilePhoneRepository;
use App\Representation\MobilePhones;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;

class MobilePhoneController extends AbstractController
{
    /**
     * @Rest\Get("/mobiles", name="mobile_list")
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="22",
     *     description="Max number of movies per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     * @Rest\View
     */
    public function listAction(MobilePhoneRepository $mobilePhoneRepository, ParamFetcherInterface $paramFetcher)
    {
        $pager = $mobilePhoneRepository->search(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new MobilePhones($pager);
    }

    /**
     * @Rest\Get(
     * path = "/mobiles/{id}",
     * name ="mobile_show",
     * requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View
     */
    public function showAction(MobilePhone $mobilePhone)
    {
        return $mobilePhone;
    }
    
}
