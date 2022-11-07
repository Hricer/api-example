<?php declare(strict_types=1);

namespace App\ArgumentResolver;

use App\ArgumentResolver\Attribute\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class QueryParamResolver implements ArgumentValueResolverInterface
{
    public function __construct(private DenormalizerInterface $denormalizer)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $attrs = $argument->getAttributes(QueryParam::class);

        return count($attrs) > 0;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $attribute = $argument->getAttributes(QueryParam::class)[0];
        $name = $attribute->getName() ?? $argument->getName();
        $value = $request->query->all()[$name] ?? null;

        if ($argument->getType() === 'array') {
            $value = $this->resolveArray($value);
        } else if (class_exists($argument->getType())) {
            $value = $this->resolveNormalizeObject($value, $argument->getType());
        }

        if ($value === null && $argument->hasDefaultValue()) {
            $value = $argument->getDefaultValue();
        }

        if ($value === null && !$argument->isNullable()) {
            throw throw new NotFoundHttpException(sprintf('Request query parameter "%s" is required.', $name));
        }

        if ($value === null) {
            yield null;

            return;
        }

        yield $value;
    }

    private function resolveNormalizeObject(?array $array, string $type): object
    {
        return $this->denormalizer->denormalize($array, $type, null, [
            AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
        ]);
    }

    private function resolveArray(null|array|string $array): ?array
    {
        if ($array === null) {
            return null;
        }

        if (is_array($array)) {
            return $array ?: null;
        }

        return explode(',', $array);
    }
}
