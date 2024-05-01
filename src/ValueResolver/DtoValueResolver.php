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
    public  function __construct(
        private readonly SerializerInterface $serializer,
        private  readonly ValidatorInterface $validator
    )
    {}

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
            $data = [];

            if ($request->getMethod() === Request::METHOD_POST) {
                $data = $request->request->all();
            } elseif ($request->getMethod() === Request::METHOD_GET) {
                $data = $request->query->all();
            }

            $dto = $this->serializer->deserialize(
                json_encode($data,JSON_THROW_ON_ERROR),
                $argumentType,
                'json',
            );

        } catch (\Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            $validations = [];
            foreach ($violations as $violation) {
                $validations[$violation->getPropertyPath()] = $violation->getMessage();
            }

            throw new BadRequestHttpException(json_encode([
                'message' => 'message.common.not_valid',
                'validations' => $validations
            ]));
        }

        // create and return the value object
        return [$dto];
    }
}