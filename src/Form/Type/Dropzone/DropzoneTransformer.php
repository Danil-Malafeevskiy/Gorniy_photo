<?php

namespace App\Form\Type\Dropzone;

use App\Repository\ImgRepository;
use Symfony\Component\Form\DataTransformerInterface;

class DropzoneTransformer implements DataTransformerInterface
{
    public function __construct(
        private ImgRepository $imgRepository
    ){
    }

    public function transform($value)
    {
        // TODO: Implement transform() method.
    }

    public function reverseTransform(mixed $value) : array
    {

        return $this->imgRepository->findBy(['id' => $value['dropzone']]);
    }
}
