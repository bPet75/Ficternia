<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Collection;

class Content extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'project_id',
        'type',
    ];

    public function content(){
        return $this->hasOne(self::getClass($this->type), 'content_id', 'id');
    }

    public function owner(){
        return $this->hasOneThrough(
        User::class,
        Project::class,
        'id',
        'id',
        'project_id',
        'user_id'
        );
    }

    public static function getClass($type){
        switch ($type) {
            case 'story':
                return Story::class;
                break;
            case 'character':
                return Character::class;
                break;
            case 'location':
                return Location::class;
                break;
            case 'event':
                return Event::class;
                break;
            case 'religion':
                return Religion::class;
                break;
            case 'note':
                return Note::class;
                break;
            case 'draft':
                return Draft::class;
                break;
            case 'collection':
                return Collection::class;
                break;
            default:
                return -1;
                break;
        }
    }
    public static function getType($class){
        switch ($class) {
            case Story::class:
                return 'story';
                break;
            case Character::class:
                return 'character';
                break;
            case Location::class:
                return 'location';
                break;
            case Event::class:
                return 'event';
                break;
            case Religion::class:
                return 'religion';
                break;
            case Note::class:
                return 'note';
                break;
            case Draft::class:
                return 'draft';
                break;
            case Collection::class:
                return 'collection';
                break;
            default:
                return -1;
                break;
        }
    }
    public static function types(){
        return [
            "story",
            "character",
            "location",
            "event",
            "religion",
            "note",
            "draft",
            "collection",
        ];
    }
    public function related(){
        return $this->BelongsToMany(Content::class, "content_to_contents", "first_id", "second_id");
    }
    public function related_reverse(){
        return $this->BelongsToMany(Content::class, "content_to_contents", "second_id", "first_id");
    }
}
