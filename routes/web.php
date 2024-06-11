<?php

use App\Http\Controllers\Admin\AdminKeywordController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AttorneyController;
use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\IyzicoController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Search\LandscapeSearch;
use App\Http\Controllers\Search\StandartSearch;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestCaseController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;

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

Route::post('admin-tracking', [TrackingController::class, 'index']);

// Sitemap.xml
Route::get('sitemap.xml', SitemapController::class);
// Route::any('test', [TestController::class, 'test']);

Route::group(['prefix' => '{locale?}'], function () {
    Auth::routes();
});
Route::get('account/email/change/{token}', [EmailVerificationController::class, 'changeEmail'])->name('change.email');
Route::get('account/verify/{token}', [EmailVerificationController::class, 'verifyAccount'])->name('user.verify');
Route::post('account/verify/send', [EmailVerificationController::class, 'sendLink'])->name('send.verify.email.link');
Route::get('logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/{language?}', [FrontController::class, 'index'])->name('front.index');
Route::get('/{language?}/articles', [FrontController::class, 'articles'])->name('front.articles');
Route::get('/{language?}/article/{slug}', [FrontController::class, 'article'])->name('front.article');

// Contact Form Post
Route::post('contact-form', [HomeController::class, 'send'])->name('contact.form');

// Dashboard Routes
Route::group(['prefix' => '{language?}'], function () {
    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'is_verify_email']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::view('/marka-tescil-siniflari', 'dashboard.pages.classes')->name('dashboard.classes');
        Route::resource('keyword', KeywordController::class);
        Route::post('keyword/search', [KeywordController::class, 'search'])->name('keyword.search');
        Route::resource('contact', ContactController::class)->middleware('role:super admin|admin')->only(['index', 'show']);
        Route::resource('report', ReportController::class)->only(['index', 'show']);
        // Search routes
        Route::view('/advanced-search', 'dashboard.pages.advanced-search')->name('advanced-search');

        // Image Search
        Route::get('image/history/{lang?}{history?}', [ImageController::class, 'history'])->name('image.history');
        Route::get('image/search', [ImageController::class, 'search'])->name('image.search');
        Route::post('image/search', [ImageController::class, 'searchPost'])->name('image.search.post');
        Route::get('image/fill-values', [ImageController::class, 'fill'])->name('image.fill');
        Route::resource('image', ImageController::class);
        Route::get('image-test', [ImageController::class, 'test'])->name('image.test');

        Route::get('/search', [StandartSearch::class, 'index'])->name('search');
        Route::post('/search', [StandartSearch::class, 'search'])->name('search.post');

        Route::get('/landscape-search', [LandscapeSearch::class, 'index'])->name('landscape-search');
        Route::post('/landscape-search', [LandscapeSearch::class, 'search'])->name('search.landscape-search');
        Route::post('/trademark-detail', [LandscapeSearch::class, 'details'])->name('trademark.details');

        // Tour routes
        Route::post('/tour-settings', [TourController::class, 'update'])->name('tour.update');
        Route::post('/tour-settings-all', [TourController::class, 'updateAll'])->name('tour.updateAll');

        // Subscription routes
        Route::post('/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
        Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');

        Route::get('/subscription-page', [SubscriptionController::class, 'plans'])->name('subscription.list');
        Route::any('/order/{name}/{is_downgrade}', [SubscriptionController::class, 'createOrder'])->name('create.order');

        // Iyzico Products and plans
        Route::get('/create-product', [IyzicoController::class, 'createProduct'])->name('create.product');
        Route::get('/create-pricing-plans', [IyzicoController::class, 'createPlans'])->name('create.plans');
        Route::get('/create-customers', [IyzicoController::class, 'createCustomers'])->name('create.customers');
        Route::any('/iyzico-callback', [SubscriptionController::class, 'callback'])->withoutMiddleware(['auth', 'is_verify_email'])->name('iyzico.callback');
        Route::get('/subscription-management', [SubscriptionController::class, 'manageSub'])->name('subscription.management');
        Route::post('/cancel-subscription', [SubscriptionController::class, 'cancelSubscription'])->name('cancel.subscription');

        Route::get('/locked-page', [SubscriptionController::class, 'locked'])->name('locked');

        // Subscription custom email
        Route::post('/send-email', [SubscriptionController::class, 'sendEmail'])->name('send.email');

        // Settings routes
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [HomeController::class, 'settings'])->name('settings');
            Route::get('/change-password', [HomeController::class, 'showChangePasswordGet'])->name('change.password.get');
            Route::post('/change-password', [HomeController::class, 'changePasswordPost'])->name('change.password.post');
            Route::get('/change-email', [HomeController::class, 'changeEmail'])->name('custom.change.email');
            Route::post('/change-email', [HomeController::class, 'updateEmail'])->name('custom.update.email');
            Route::get('/change-name', [HomeController::class, 'changeName'])->name('change.name');
            Route::post('/change-name', [HomeController::class, 'updateName'])->name('update.name');
        });
        Route::post('/change-language', [HomeController::class, 'updateLanguage'])->name('language.update');

        // Admin Routes
        Route::group(['prefix' => 'admin', 'middleware' => ['role:super admin|admin']], function () {
            Route::resource('report-admin', AdminReportController::class);
            Route::resource('keyword-admin', AdminKeywordController::class);
            Route::any('/dashboard/admin/keyword-admin/{keyword}', [KeywordAdminController::class, 'destroy'])->name('keyword-admin.destroy');

            Route::resource('user', UserController::class)->except(['update']);
            Route::post('user', [UserController::class, 'update'])->name('user.update');
            Route::post('keyword-update', [UserController::class, 'keywordUpdate'])->name('user.keywordLimit');
            Route::post('landscape-update', [UserController::class, 'landscapeUpdate'])->name('user.landscape-limit');
            Route::post('plan-update', [UserController::class, 'planUpdate'])->name('user.plan-update');
            Route::post('keyword-import/{id}', [UserController::class, 'import'])->name('keywords.import');
            Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletin.index');
            Route::resource('error', ErrorController::class);
            Route::get('/attorneys', [AttorneyController::class, 'index'])->name('attorney');
            Route::resource('plans', PlanController::class)->except(['update']);
            Route::resource('articles', ArticleController::class);
            Route::post('plans-search-limit-update', [PlanController::class, 'SearchUpdate'])->name('plans-search-limit.update');
            Route::post('plans-keyword-limit-update', [PlanController::class, 'KeywordLimit'])->name('plans-keyword-limit.update');
            Route::post('plans-name-update', [PlanController::class, 'PlanName'])->name('plans-name.update');
            Route::get('tests', [TestCaseController::class, 'index'])->name('tests.index');
        });
    });
});


