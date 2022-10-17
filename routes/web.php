<?php

use App\Http\Livewire\Applications\Calendar;
use App\Http\Livewire\Applications\Crm;
use App\Http\Livewire\Applications\Datatables;
use App\Http\Livewire\Applications\Kanban;
use App\Http\Livewire\Applications\Stats;
use App\Http\Livewire\Applications\Wizard;

use App\Http\Livewire\Authentication\Error\Error404;
use App\Http\Livewire\Authentication\Error\Error500;
use App\Http\Livewire\Authentication\Lock\Basic;
use App\Http\Livewire\Authentication\Lock\Cover;
use App\Http\Livewire\Authentication\Lock\Illustration;
use App\Http\Livewire\Authentication\Reset\Basic as ResetBasic;
use App\Http\Livewire\Authentication\Reset\Cover as ResetCover;
use App\Http\Livewire\Authentication\Reset\Illustration as ResetIllustration;
use App\Http\Livewire\Authentication\SignIn\Basic as SignInBasic;
use App\Http\Livewire\Authentication\SignIn\Cover as SignInCover;
use App\Http\Livewire\Authentication\SignIn\Illustration as SignInIllustration;
use App\Http\Livewire\Authentication\SignUp\Basic as SignUpBasic;
use App\Http\Livewire\Authentication\SignUp\Cover as SignUpCover;
use App\Http\Livewire\Authentication\SignUp\Illustration as SignUpIllustration;
use App\Http\Livewire\Authentication\Verification\Basic as VerificationBasic;
use App\Http\Livewire\Authentication\Verification\Cover as VerificationCover;
use App\Http\Livewire\Authentication\Verification\Illustration as VerificationIllustration;
use App\Http\Livewire\Dashboard\Automotive;
use App\Http\Livewire\Dashboard\Discover;

use App\Http\Livewire\Dashboard\SmartHome;
use App\Http\Livewire\Ecommerce\Orders\Details;
use App\Http\Livewire\Ecommerce\Orders\OrderList;
use App\Http\Livewire\Ecommerce\Products\EditProduct;
use App\Http\Livewire\Ecommerce\Products\NewProduct;
use App\Http\Livewire\Ecommerce\Products\ProductPage;
use App\Http\Livewire\Ecommerce\Products\ProductsList;
use App\Http\Livewire\Ecommerce\Referral;
use App\Http\Livewire\LaravelExamples\Category\Create as CategoryCreate;
use App\Http\Livewire\LaravelExamples\Category\Edit as CategoryEdit;
use App\Http\Livewire\LaravelExamples\Category\Index as CategoryIndex;
use App\Http\Livewire\LaravelExamples\Items\Create as ItemsCreate;
use App\Http\Livewire\LaravelExamples\Items\Edit as ItemsEdit;
use App\Http\Livewire\LaravelExamples\Items\Index as ItemsIndex;
use App\Http\Livewire\LaravelExamples\Profile\Edit;
use App\Http\Livewire\Pages\Account\Billing;
use App\Http\Livewire\Pages\Account\Invoice;
use App\Http\Livewire\Pages\Account\Security;
use App\Http\Livewire\Pages\Account\Settings;
use App\Http\Livewire\Pages\Charts;
use App\Http\Livewire\Pages\Notifications;
use App\Http\Livewire\Pages\PricingPage;
use App\Http\Livewire\Pages\Profile\Overview;
use App\Http\Livewire\Pages\Profile\Projects;
use App\Http\Livewire\Pages\Projects\General;
use App\Http\Livewire\Pages\Projects\NewProject;
use App\Http\Livewire\Pages\Projects\Timeline;
use App\Http\Livewire\Pages\Rtl;
use App\Http\Livewire\Pages\SweetAlerts;
use App\Http\Livewire\Pages\Users\NewUser;
use App\Http\Livewire\Pages\Users\Reports;
use App\Http\Livewire\Pages\Vr\VrDefault;
use App\Http\Livewire\Pages\Vr\VrInfo;
use App\Http\Livewire\Pages\Widgets;
use App\Http\Livewire\LaravelExamples\Profile\Edit as ProfileEdit;
use App\Http\Livewire\LaravelExamples\Tag\Create as TagCreate;
use App\Http\Livewire\LaravelExamples\Tag\Edit as TagEdit;
use App\Http\Livewire\LaravelExamples\Tag\Index as TagIndex;

use Illuminate\Support\Facades\Route;
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('sign-in');
});


Route::group(['namespace' => 'App\Http\Livewire'], function()
{
    foreach (glob(__DIR__. '/web/*') as $router_files){
        (basename($router_files =='web.php')) ? : (require_once $router_files);
    }

});

 
