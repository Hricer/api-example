<?php declare(strict_types=1);

namespace App\Controller\User;

use App\ArgumentResolver\Attribute\Body;
use App\ArgumentResolver\Attribute\Entity;
use App\ArgumentResolver\Attribute\QueryParam;
use App\DTO\User\UserDTO;
use App\DTO\User\UserFilterDTO;
use App\Entity\User\User;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController
{
    # example: /edit/20
    #[Route('/edit/{id}',  methods: ['GET'])]
    public function list(int $id): never
    {
        dd($id);
        // int(20)
    }

    # example: /query-params?limit=20
    #[Route('/query-params', methods: ['GET'])]
    public function queryParams(#[QueryParam] int $limit, #[QueryParam] int $page = 1): never
    {
        dd($limit, $page);
        // int(20), int(1)
    }

    # example: /custom?sort=byIdDesc
    #[Route('/custom', methods: ['GET'])]
    public function customNameAndNullable(#[QueryParam('sort')] ?string $sorting): never
    {
        dd($sorting);
        // string("byIdDesc")
    }

    # example: /array?ids[]=2&id[]=3
    # example: /array?ids=2,3
    #[Route('/array', methods: ['GET'])]
    public function array(#[QueryParam] ?array $ids): never
    {
        dd($ids);
        // array(2, 3)
    }

    # example: /object?filter[roleId]=2&filter[createdFrom]=2022-11-04T15:23
    #[Route('/object', methods: ['GET'])]
    public function object(#[QueryParam] UserFilterDTO $filter): never
    {
        dd($filter);
        // UserFilterDTO(search: null, active: null, roleId: 2, createdFrom: DateTime())
    }

    # example: /entity/1
    #[Route('/entity/{user}', methods: ['GET'])]
    public function entityByPK(#[Entity] ?User $user = null): never
    {
        dd($user);
    }

    # example: /entity/10/my-awesome-article
    #[Route('/entity/{category}/{article}', methods: ['GET'])]
    public function entityByProperty(#[Entity] Category $category, #[Entity('slug')] Article $article): never
    {
        dd($category, $article);
    }

    # determine header content-type (xml, json, form) and deserialize
    #[Route('/user', methods: ['POST'])]
    public function userPost(#[Body] UserDTO $userDTO): never
    {
        dd($userDTO);
    }

    #[Route('/user/{user}', methods: ['PUT', 'PATCH'])]
    public function userPut(#[Entity] User $user, #[Body] UserDTO $userDTO): never
    {
        dd($user, $userDTO);
    }
}
