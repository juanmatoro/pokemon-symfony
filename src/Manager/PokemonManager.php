<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PokemonManager
{
    public function uploadImage(UploadedFile $file, string $target): string
    {
        $fileName = uniqid().".".$file->guessClientExtension();

        $file->move($target, $fileName);

        return $fileName;
    }
}
