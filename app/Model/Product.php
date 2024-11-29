<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setName($name)
    {
        $data = [
          'name' => $name
        ];
        $validator = Validator::make($data, [
            'name' => 'required|unique:products,name',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        } else {
            $this->attributes['name'] = $name;
        }
    }

    public function getDescription()
    {
        return $this->attributes['description'];
    }

    public function setDescription($description)
    {
        $data = [
            'description' => $description
        ];
        $validator = Validator::make($data, [
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        } else {
            $this->attributes['description'] = $description;
        }
    }

    public function getId() {
        return $this->attributes['id'];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
