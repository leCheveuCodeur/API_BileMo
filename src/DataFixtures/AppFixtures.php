<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Faker\Factory;
use Liior\Faker\Prices;
use App\Entity\MobilePhone;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CustomerRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\MobilePhoneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $userRepository, $customerRepository, $mobilePhoneRepository, $slugger;
    protected $nbMobilePhones = 50;

    public function __construct(
        UserRepository $userRepository,
        CustomerRepository $customerRepository,
        MobilePhoneRepository $mobilePhoneRepository,
        SluggerInterface $slugger
    ) {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->mobilePhoneRepository = $mobilePhoneRepository;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Prices($faker));

        $manufactorer = ['LaPomme', 'SamSoul', 'NokNok', 'Gogol', 'Sonish', 'FairpasPhone'];

        for ($mp = 0; $mp < $this->nbMobilePhones; $mp++) {
            $mobilePhone = new MobilePhone;
            $mobilePhone->setModel(ucfirst($faker->domainWord()))
                ->setManufacturer($manufactorer[array_rand($manufactorer, 1)])
                ->setDescription($faker->paragraphs(3, \true))
                ->setYear(\mt_rand(2015, 2021))
                ->setPrice($faker->price(100, 1000, \true, \true));

            $manager->persist($mobilePhone);
        }
        $manager->flush();

        for ($c = 0; $c < 5; $c++) {
            $customer = new Customer;
            $customer->setEmail($faker->companyEmail());
            \preg_match('/[\w \- \_]+(?=\.\w{2,3}$)/', $customer->getEmail(), $matches);
            $customer->setCompanyName(\ucfirst($matches[0]))
                ->setRegisteredSince($faker->dateTimeBetween('-5 years'));

            for ($u = 0; $u < \mt_rand(150, 300); $u++) {
                $user = new User;
                $user->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setEmail(\strtolower($this->slugger->slug($user->getFirstName() . '.' . $user->getLastName(), '.') . '@' . $faker->freeEmailDomain()))
                    ->addProductsBuy($this->mobilePhoneRepository->findOneBy(['id' => \mt_rand(1, $this->nbMobilePhones - 1)]));

                $manager->persist($user);
                $customer->addUser($user);
            }

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
