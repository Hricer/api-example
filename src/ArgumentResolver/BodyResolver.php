<?php declare(strict_types=1);

namespace App\ArgumentResolver;

use App\ArgumentResolver\Attribute\Body;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BodyResolver implements ArgumentValueResolverInterface
{
    public function __construct(private SerializerInterface&DenormalizerInterface $serializer)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $attrs = $argument->getAttributes(Body::class);

        return count($attrs) > 0;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $attribute = $argument->getAttributes(Body::class)[0];
        $type = $attribute->isArray() ? sprintf("array<%s>", $argument->getType()) : $argument->getType();

        if (!$format = $attribute->getFormat()) {
            $format = match ($request->getContentType()) {
                'application/json' => 'json',
                'application/xml' => 'xml',
                'application/yaml', 'application/x-yaml' => 'yaml',
                'form' => 'form',
                default => $request->getContentType(),
            };
        }

        if ($format === 'form') {
            yield $this->serializer->denormalize($request->request->all(), $type, null, $attribute->getContext());

            return;
        }

        yield $this->serializer->deserialize($request->getContent(), $type, $format, $attribute->getContext());
    }
}
