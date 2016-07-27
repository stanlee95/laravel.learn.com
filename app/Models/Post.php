<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany('App\Models\Photos');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\Models\ProjectFiles');
    }

    /**
     *
     * @return mixed
     */
    public static function getPublishedPost()
    {
        return static::latest('id')->where('published', '1')->get();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function getComments($id)
    {

        return static::where('parent_id', $id)->where('published', '1')->get();
    }

    /**
     *
     * @return mixed
     */
    public static function getAllPostNonPublished()
    {

        return static::get();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function getAllCommentsNonPublished($id)
    {

        return static::where('parent_id', $id)->get();
    }

    /**
     * @param int $id
     * @param int $parent_id
     *
     * @return mixed
     */
    public static function getAllPost($id, $parent_id)
    {
        return static::where('published', '1')->where('category_id', $id)->where('category_sub_id', $parent_id)->get();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function getAllPostById($id)
    {
        return static::where('published', '1')->where('category_id', $id)->get();
    }
}
