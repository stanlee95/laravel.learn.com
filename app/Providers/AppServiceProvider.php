<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $category = Category::getCategory();
        $cat = array();
        $sub_category = array();

        foreach ($category as $item){
            if($item->parent_id==NULL){
                $cat[]= $item;
            }
            if(Category::getSubCategory($item->id)!==NULL) {
                $sub_category[$item->id] = Category::getSubCategory($item->id);
            }
        }

        View::share(['category'=> $cat, 'sub_category'=>$sub_category ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function recursion($sub_category, $parent_id){

        if(empty($sub_category[$parent_id])) {
            return;
        }

        foreach ($sub_category[$parent_id] as $item){

            echo '<li><a href="/category/'.$item->id.
                '/'.$item->name.'">'
                .$item->name .'</a>';
            self::recursion($sub_category,$item->id);
            echo '</li>';
        }
        echo '</ul>';
    }
}
