<?php

namespace App\Services;
use App\Tag;

class TagService {
    public static function getAll(){
        try {
            return Tag::all();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function create(array $data){
        try {
            return Tag::create([
                'name' => $data['name'],
                'description' => $data['description']
            ]);
        } catch (\Exception $ex) {
            return false;
        }
    }
}
