<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('getRoleId', function ($name){
            $roles = Role::all();
            for($i = 0; $i < count($roles); $i++) {
                if(strtolower($name) === strtolower($roles[$i]->name)) {
                    return $roles[$i]->id;
                }
            }
        });

        Builder::macro('getCategoryId', function ($name){
            $categories = Category::all();
            for($i = 0; $i < count($categories); $i++) {
                if(strtolower($name) === strtolower($categories[$i]->name)) {
                    return $categories[$i]->id;
                }
            }
        });

        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });

        Builder::macro('searchMultipleUsers', function ($string, $filter = []) {
            
            $this->whereHas('roles', function ($query) use ($filter) {
                if(array_key_exists('role', $filter) && !empty($filter['role'])){
                    $query->where('name' , '=' ,  ucfirst($filter['role']));
                }                                
            });

            if(array_key_exists('role', $filter) && !empty($filter['role']) && $filter['role'] == 'driver' && array_key_exists('account_status', $filter) && !empty($filter['account_status'])){
                $this->whereHas('driver', function ($query) use ($filter) {
                    $query->where('account_status' , '=' ,  $filter['account_status']);
                });
            }else{    
                // $this->whereHas('driver', function ($query) use ($filter) {           
                //    $query->where('account_status' , '=' , 'approved');
                // });
            }  

            if($string) { 

                return $this->where(function($query) use ($string) {
                            $query->where('id', 'like', '%'.$string.'%')
                            ->orWhere('name', 'like', '%'.$string.'%')
                            ->orWhere('email', 'like', '%'.$string.'%')
                            ->orWhere('phone', 'like', '%'.$string.'%')
                            ->orWhere('created_at', 'like', '%'.$string.'%');
                        });                     
                           
            } else {

                return  $this;
            }
        });


        Builder::macro('searchMultipleStore', function ($string, $filter) {

            if(array_key_exists('application_status', $filter) && !empty($filter['application_status'])){
                $this->where('application_status', '=' , $filter['application_status']);
            }             
           
            if($string) {               
                return $this->where(function($query) use ($string) {
                            $query->where('id', 'like', '%'.$string.'%')
                            ->orWhere('name', 'like', '%'.$string.'%')
                            ->orWhere('email', 'like', '%'.$string.'%')
                            ->orWhere('phone', 'like', '%'.$string.'%')
                            ->orWhere('created_at', 'like', '%'.$string.'%');
                        });                      
                           
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleOrder', function ($string, $filter) {
            if($string) {               
                return $this->where(function($query) use ($string) {
                        $query->where('order_number', 'like', '%'.$string.'%')
                            ->orWhere('order_status', 'like', '%'.$string.'%')
                            ->orWhere('comments', 'like', '%'.$string.'%');
                        });                      
                           
            } else {
                return $this;
            }
        });

        
        Builder::macro('searchMultiplePage', function ($string) {
            if($string) {               
                return $this->where(function($query) use ($string) {
                            $query->where('title', 'like', '%'.$string.'%');
                        });
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultiple', function ($string) {
            if($string) {
                return $this->where('id', '=', intval($string))
                             ->orWhere('name', 'like', '%'.$string.'%')
                             ->orWhere('description', 'like', '%'.$string.'%')
                             ->orWhere('created_at', 'like', '%'.$string.'%');
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleRole', function ($string) {
            if($string) {
                return $this->where('id', '=', intval($string))
                             ->orWhere('name', 'like', '%'.$string.'%')
                             ->orWhere('created_at', 'like', '%'.$string.'%');
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleTag', function ($string) {
            if($string) {
                return $this->Where('title', 'like', '%'.$string.'%');
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleFaqs', function ($string) {
            if($string) {
                return $this->Where('id', '=', intval($string))
                             ->orWhere('title', 'like', '%'.$string.'%')
                             ->orWhereHas('category', function ($query) use ($string) {
                                $query->where('name', 'like', '%'.$string.'%');                                                     
                            });
            } else {
                return $this;
            }
        });

       Builder::macro('searchMultipleCategory', function ($string, $filter = []) {

            if(array_key_exists('is_provider', $filter) && $filter['store_id']){
                $this->where('store_id' , '=' ,  $filter['store_id'])->orWhereNull('store_id');
            } 

            if($string) {  
            
                return $this->where(function ($query) use ($string, $filter) {
                    $query->where('name', "like", "%" . $string . "%");
                    // $query->orWhereHas('store', function ($query2) use ($string, $filter) {
                    //     if(array_key_exists('is_provider', $filter) && !$filter['is_provider']){
                    //         $query2->where('name', 'like', '%'.$string.'%');  
                    //     }                                                                      
                    // });
                });      
  
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleCoutry', function ($string) {
            if($string) {
                return $this->Where('id', '=', intval($string))
                             ->orWhere('name', 'like', '%'.$string.'%');
                             
            } else {
                return $this;
            }
        });
 
 
        Builder::macro('searchMultipleState', function ($string) {
            if($string) {
                return $this->Where('id', '=', intval($string))
                             ->orWhere('name', 'like', '%'.$string.'%');
                             
            } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleCity', function ($string) {
            if($string) {
                return $this->Where('id', '=', intval($string))
                             ->orWhere('name', 'like', '%'.$string.'%');
             } else {
                return $this;
            }
        });
        
        
        Builder::macro('searchMultipleAddOnOption', function ($string, $filter = []) {

            if(array_key_exists('is_provider', $filter)){
                $this->where('store_id' , '=' ,  $filter['store_id']);
            } 

            if($string) {

                return $this->where(function ($query) use ($string, $filter) {
                    $query->where('name', "like", "%" . $string . "%");
                    // $query->orWhereHas('store', function ($query2) use ($string, $filter) {
                    //     if(array_key_exists('is_provider', $filter) && !$filter['is_provider']){
                    //         $query2->where('name', 'like', '%'.$string.'%');  
                    //     }                                                                      
                    // });
                });    
             } else {
                return $this;
            }
        });

        Builder::macro('searchMultipleProduct', function ($string, $filter = []) {
            
            if(array_key_exists('is_provider', $filter) && $filter['store_id']){
                $this->where('store_id' , '=' ,  $filter['store_id']);
            }                              
     
            if($string) {
                return $this->where(function ($query) use ($string) {
                            $query->where('name', "like", "%" . $string . "%");
                            $query->orWhere('sku', "like", "%" . $string . "%");
                            $query->orWhereHas('productCategories', function ($query2) use ($string) {
                                $query2->where('name', 'like', '%'.$string.'%');                                                     
                            });
                        });                          
                     
            } else {
                return $this;
            }

        });

        Builder::macro('searchMultipleStoreType', function ($string) {
            if($string) {
                return $this->where(function($query) use ($string) {
                    $query->where('name', 'like', '%'.$string.'%');
                });
            } else {
                return $this;
            }
        });
 

    }
}

