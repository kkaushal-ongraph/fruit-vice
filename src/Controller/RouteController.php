<?php

namespace App\Controller;

use Symfony\Component\{
    HttpFoundation\Response,
    Mailer\MailerInterface,
    Mime\Email
};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\{Mailer, Transport};
use App\Repository\FruitsRepository;


use App\Entity\{Fruits, Nutritions};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RouteController extends AbstractController
{
    /**
     * route for fetch data from fruityvice.com api 
     * @author Kkaushal
     * @param $entityManager | Instance of EntityManagerInterface
     * @param $mailer | Instance of MailerInterface
     * @return Response 
     */ 
    #[Route('/route', name: 'app_route')]
    public function index(EntityManagerInterface $entityManager, MailerInterface $mailer,FruitsRepository $fruitRepo): Response
    {
        $ch = curl_init();
        $url =  "https://fruityvice.com/api/fruit/all";
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url, // your preferred link
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));

        $fruits = json_decode(curl_exec($ch));
        curl_close($ch);

        // interate fruits data obtained from API
        $array = array();
        foreach ($fruits as $value) {
            
            // check if fruit already exists in database
            $fruitOne = $entityManager->getRepository(Fruits::class)->findOneBy(['fruit_id' => $value->id]);

            // if fruit is not exist in database, just insert one...
            if (!$fruitOne) {
                $array[] = $value->name;
                $fruitRepo->insertFruit($entityManager, $value);
            }
        }
        $newFruits = implode(', ',$array);
        $this->sendMail($mailer , $newFruits);

        return new Response('API executed successfully!');
    }

    /**
     * if new fruit is insert sending mail
     * @author Kkaushal 
     * @param $mailer | Instance of MailerInterface
     * @param array[] | $value contain fruits list
     * @return void
     */
    public function sendMail($mailer , $value)
    {
        $email = (new Email())
            ->from('sendMail')
            ->to('receiverMail')
            ->subject('New Fruits Inserted.')
            ->text('Check about new fruits.')
            ->html('<p>New fruits are :- '.$value.' </p>');
            $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer = new Mailer($transport);
            $mailer->send($email);
    }
}
