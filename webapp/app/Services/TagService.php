<?php

namespace App\Services;
use App\Tag;

class TagService {
    public static function getAll(){
        return Tag::all();
    }

    public static function create(array $data){
        return Tag::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }
}
