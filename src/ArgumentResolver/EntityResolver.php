<?php declare(strict_types=1);

namespace App\ArgumentResolver;

use App\ArgumentResolver\Attribute\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntityResolver implements ArgumentValueResolverInterface
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $attrs = $argument->getAttributes(Entity::class);

        return count($attrs) > 0;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $attribute = $argument->getAttributes(Entity::class)[0];
        $value = $request->attributes->get($argument->getName());
        $repository = $this->doctrine->getRepository($argument->getType());
        $entity = null;

        if ($value) {
            if ($attribute->getProperty()) {
                $entity = $repository->findOneBy([$attribute->getProperty() => $value]);
            } else {
                $entity = $repository->find($value);
            }

            if (!$entity) {
                throw throw new NotFoundHttpException(sprintf('Entity "%s(%s)" not found.', $argument->getType(), $value));
            }
        }

        yield $entity;
    }
}
