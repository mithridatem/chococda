<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService implements ServiceInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em
        )
    {
    }

    public function create(Object $object)
    {
        //tester si l'objet existe
        if (!$this->userRepository->findOneBy(["email"=> $object->getEmail()])) {
            $this->em->persist($object);
            $this->em->flush();
        }
        throw new \Exception("Le compte existe déja");
    }
    public function update(Object $object)
    {
        if($this->userRepository->findOneBy(["email"=> $object->getEmail()])) {
            $this->em->persist($object);
            $this->em->flush();
        }
        throw new \Exception("Le compte n'existe pas");
    }
    public function delete(int $id)
    {
        if($this->userRepository->find($id)) {
            $this->em->remove($this->userRepository->find($id));
            $this->em->flush();
        }
        throw new \Exception("Le compte n'existe pas");
    }
    public function findOneBy(int $id):Object
    {
        return $this->userRepository->find($id)??throw new \Exception('Le compte n\'existe pas');
    }
    public function findAll(): array
    {
        return $this->userRepository->findAll()??throw new \Exception('Il n\'y a pas de compte en BDD');
    }
}
