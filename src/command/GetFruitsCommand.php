<?php

namespace App\command;

use Symfony\Component\Console\{
    Command\Command,
    Output\OutputInterface,
    Input\InputInterface
};
use Symfony\Component\Mailer\{Mailer, Transport};
use Symfony\Component\Mime\Email;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{Fruits, Nutritions};
use App\Repository\FruitsRepository;

class GetFruitsCommand extends Command
{

    private $entityManager;
    private $favRepo;

    public function __construct(EntityManagerInterface $entityManager,FruitsRepository $favRepo)
    {
        $this->entityManager = $entityManager;
        $this->favRepo = $favRepo;
        parent::__construct();
    }

    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        $this
            ->setName('get-fruits')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to insert fruits into database...')
            ->setDescription('This command runs to insert fruits into database...');
    }

    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->entityManager;
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

        $array = array();
        foreach ($fruits as $value) {
            // check if fruit already exists in database
            $fruitOne = $em->getRepository(Fruits::class)->findBy(['fruit_id'=>$value->id]);
            
            // if fruit is not exist in database, just insert one...
            if (!$fruitOne) {
                $array[] = $value->name;
                $this->favRepo->insertFruit($em, $value);
            }
        }
        // mail new fruits list 
        $newFruits = implode(', ',$array);

        $email = (new Email())
        ->from('yourmail@gmail.com')
        ->to('mmmmm@getnada.com')
        ->subject('New Fruits Inserted.')
        ->text('Check about new fruits.')
        ->html('<p>New fruits are :- '.$newFruits.' </p>');
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);
        $mailer->send($email);

        return Command::SUCCESS;
    }
}

?>