<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
Use App\Entity\Chocoblast;
use App\Repository\ChocoblastRepository;

class ChocoblastService implements ServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ChocoblastRepository $chocoblastRepository
        )
    { }
    public function create(object $objet){
        //test si le chocoblast existe
        if(!$this->chocoblastRepository->findOneBy(["title"=>$objet->getTitle(), "createAt"=>$objet->getCreateAt()])) {
            $this->em->persist($objet);
            $this->em->flush();
        }
        else{
            throw new \Exception("Le chocoblast existe deja");
        }
    }

    public function update(object $objet){
        //test si le chocoblast existe
        if($this->chocoblastRepository->findOneBy(["title"=>$objet->getTitle(), "createAt"=>$objet->getCreateAt()])) {
            $this->em->persist($objet);
            $this->em->flush();
        }
        else{
            throw new \Exception("Le chocoblast n'existe pas");
        }
    }
    public function delete(int $id){
        $chocoblast = $this->chocoblastRepository->find($id);
        //test si le chocoblast existe
        if($chocoblast){
            $this->em->remove($chocoblast);
            $this->em->flush();
        }
        else{
            throw new \Exception("Le chocoblast n'existe pas");
        }
    }
    public function findOneBy(int $id): object{
        return $this->chocoblastRepository->find($id)??throw new \Exception("Le chocoblast n'existe pas");
    }
    public function findActiveOrNot(bool $status): array{
        return $this->chocoblastRepository->findBy(["status"=>$status])??throw new \Exception("Il n'y à aucun chocoblast actifs en BDD");
    }
    public function findAll(): array{
        return $this->chocoblastRepository->findAll()??throw new \Exception("Il n'y à aucun chocoblast en BDD");
    }

    public function getCountChocoblastAuthor(): array {
        return $this->chocoblastRepository->topChocoblastAuthor();
    }

    public function getCountChocoblastTarget(): array {
        return $this->chocoblastRepository->topChocoblastTarget();
    }
}
