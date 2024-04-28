<?php

namespace App\ValueResolver;

use App\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoValueResolver implements ValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public  function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @throws \Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        // get the argument type (e.g. BookingId)
        $argumentType = $argument->getType();
        if (
            !$argumentType
            || !is_subclass_of($argumentType, DtoInterface::class, true)
        ) {
            return [];
        }

        try {
            $data = $request->getContent();

            $dto = $this->serializer->deserialize(json_encode($data), $argumentType, 'json');
        } catch (\Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            throw new BadRequestHttpException(json_encode($errors));
        }

        // create and return the value object
        return [$dto];
    }
}