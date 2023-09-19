<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class MySlugger
{
    private $slugger;
    private $toLower;

    public function __construct(SluggerInterface $slugger, bool $toLower)
    {
        $this->toLower = $toLower;
        $this->slugger = $slugger;
    }

    public function slugify(string $str)
    {
        // Convert a string to a slug format and in lower case
        if($this->toLower)
        {
            return $this->slugger->slug($str)->lower();
        }
        // Return the result of the slug
        return $this->slugger->slug($str);
    }
}
