<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','link','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }


    public function getAbstract($n_chars=30){
        return (strlen($this->description)>$n_chars)
        ? substr($this->description,0,$n_chars).'...'
        :$this->description;
    }

    public function getHashtag(){
        $tag_labels_array=$this->tags()->pluck('label')->toArray();
        $new_tag_labels_array=[];
        foreach($tag_labels_array as $label){
            $label='#'.$label;
            $new_tag_labels_array[]=$label;
        };

        return implode(', ',$new_tag_labels_array);
    }
}
