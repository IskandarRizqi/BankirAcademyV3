<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LearningController;
use App\Http\Controllers\API\LokerController;
use App\Http\Controllers\API\ManualPaymentController;
use App\Http\Controllers\API\MemberFeatureController;
use App\Http\Controllers\API\MobileJobController;
use App\Http\Controllers\API\MobileProfileController;
use App\Http\Controllers\API\NavigationController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\PublicCatalogController;
use App\Http\Controllers\API\PublicContentController;
use App\Http\Controllers\API\ScraperIngestionController;
use App\Http\Controllers\ArticleGeneratorController;
use App\Http\Controllers\Backend\PembayaranController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\RecentRegistrationController;
use App\Http\Middleware\AksesByIpAddress;
use App\Http\Middleware\VerifyScraperApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'mobile.access'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/auth')->name('api.v1.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');

    Route::post('/google', [AuthController::class, 'google'])
        ->middleware('throttle:5,1')
        ->name('google');

    Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationNotification'])
        ->middleware('throttle:3,10')
        ->name('email.verification-notification');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware('throttle:10,1')
        ->name('email.verify');

    Route::middleware(['auth:sanctum', 'mobile.access'])->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
    });
});

Route::middleware(['auth:sanctum', 'mobile.access'])
    ->prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::get('/navigation', NavigationController::class)->name('navigation.index');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:6'])
    ->prefix('v1/participant')
    ->name('api.v1.participant.')
    ->group(function () {
        Route::get('/profile', [ParticipantController::class, 'profile'])->name('profile');
        Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('dashboard');
        Route::get('/general-training', [ParticipantController::class, 'generalTraining'])->name('general-training.index');
        Route::get('/general-training/{subMateri}', [ParticipantController::class, 'generalTrainingDetail'])
            ->whereNumber('subMateri')
            ->name('general-training.show');
        Route::post('/general-training/{subMateri}/enroll', [ParticipantController::class, 'enrollGeneralTraining'])
            ->whereNumber('subMateri')
            ->name('general-training.enroll');
        Route::get('/history', [ParticipantController::class, 'history'])->name('history');
        Route::get('/jobs', [ParticipantController::class, 'jobs'])->name('jobs.index');
        Route::get('/jobs/{id}', [ParticipantController::class, 'job'])->whereNumber('id')->name('jobs.show');
        Route::post('/jobs/{id}/apply', [ParticipantController::class, 'applyJob'])
            ->whereNumber('id')
            ->name('jobs.apply');
    });

Route::get('/getloker', [LokerController::class, 'get_data']);
Route::prefix('v1/public')->name('api.v1.public.')->group(function () {
    Route::get('/classes', [PublicCatalogController::class, 'classes'])->name('classes.index');
    Route::get('/classes/{slug}', [PublicCatalogController::class, 'classDetail'])->name('classes.show');
    Route::get('/ebooks', [PublicCatalogController::class, 'ebooks'])->name('ebooks.index');
    Route::get('/interactive-videos', [PublicCatalogController::class, 'interactiveVideos'])->name('interactive-videos.index');
    Route::get('/articles', [PublicContentController::class, 'articles'])->name('articles.index');
    Route::get('/articles/{slug}', [PublicContentController::class, 'article'])->name('articles.show');
    Route::get('/jobs', [PublicContentController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/{id}', [PublicContentController::class, 'job'])->whereNumber('id')->name('jobs.show');
});

Route::middleware(['auth:sanctum', 'mobile.access'])->prefix('v1/payments')->name('api.v1.payments.')->group(function () {
    Route::post('/membership', [ManualPaymentController::class, 'storeMembership'])->name('membership.store');
    Route::post('/class/manual', [ManualPaymentController::class, 'storeClass'])->name('class.manual');
    Route::post('/ebook/manual', [ManualPaymentController::class, 'storeEbook'])->name('ebook.manual');
    Route::post('/video/manual', [ManualPaymentController::class, 'storeVideo'])->name('video.manual');
    Route::get('/', [ManualPaymentController::class, 'index'])->name('index');
    Route::post('/{payment}/proof', [ManualPaymentController::class, 'uploadProof'])->name('proof');
    Route::post('/{payment}/cancel', [ManualPaymentController::class, 'cancel'])->name('cancel');
    Route::post('/{payment}/expire', [ManualPaymentController::class, 'expire'])->name('expire');
    Route::post('/{payment}/iht', [ManualPaymentController::class, 'payIht'])->name('iht.pay');
    Route::get('/{payment}/invoice/pdf', [ManualPaymentController::class, 'invoicePdf'])->name('invoice.pdf');
    Route::get('/{payment}/invoice', [ManualPaymentController::class, 'invoice'])->name('invoice');
    Route::get('/{payment}', [ManualPaymentController::class, 'show'])->name('show');
});

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:6'])
    ->prefix('v1/learning')
    ->name('api.v1.learning.')
    ->group(function () {
        Route::get('/catalog', [LearningController::class, 'catalog'])->name('catalog');
        Route::get('/materials/{materi}', [LearningController::class, 'material'])
            ->whereNumber('materi')
            ->name('materials.show');
        Route::post('/materials/{materi}/sub-materials/{subMateri}/items/{item}/complete', [LearningController::class, 'completeItem'])
            ->whereNumber(['materi', 'subMateri', 'item'])
            ->name('items.complete');
        Route::get('/materials/{materi}/tests/{type}', [LearningController::class, 'test'])
            ->whereNumber('materi')
            ->whereIn('type', ['pre', 'post'])
            ->name('tests.show');
        Route::post('/materials/{materi}/tests/{type}/attempts', [LearningController::class, 'submitTest'])
            ->whereNumber('materi')
            ->whereIn('type', ['pre', 'post'])
            ->name('tests.submit');
        Route::get('/materials/{materi}/attempts', [LearningController::class, 'attempts'])
            ->whereNumber('materi')
            ->name('attempts.index');
        Route::get('/materials/{materi}/attempts/{attempt}', [LearningController::class, 'attempt'])
            ->whereNumber(['materi', 'attempt'])
            ->name('attempts.show');
        Route::get('/certificates', [LearningController::class, 'certificates'])->name('certificates.index');
        Route::get('/materials/{materi}/certificate', [LearningController::class, 'certificate'])
            ->whereNumber('materi')
            ->name('materials.certificate');
        Route::get('/materials/{materi}/certificate/download', [LearningController::class, 'certificateDownload'])
            ->whereNumber('materi')
            ->name('materials.certificate.download');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:2,6'])
    ->prefix('v1/profile')
    ->name('api.v1.profile.')
    ->group(function () {
        Route::get('/membership', [MobileProfileController::class, 'membership'])->name('membership.show');
        Route::get('/locations/{level}', [MobileProfileController::class, 'locations'])->name('locations.index');
        Route::patch('/membership', [MobileProfileController::class, 'updateMembership'])->name('membership.update');
        Route::post('/phone/otp', [MobileProfileController::class, 'sendOtp'])
            ->middleware('throttle:5,10')
            ->name('phone.otp.send');
        Route::post('/phone/otp/verify', [MobileProfileController::class, 'verifyOtp'])
            ->middleware('throttle:10,10')
            ->name('phone.otp.verify');
        Route::get('/cv', [MobileProfileController::class, 'cv'])
            ->middleware('mobile.membership:individual')
            ->name('cv.show');
        Route::post('/cv', [MobileProfileController::class, 'storeCv'])
            ->middleware('mobile.membership:individual')
            ->name('cv.store');
        Route::patch('/cv', [MobileProfileController::class, 'updateCv'])
            ->middleware('mobile.membership:individual')
            ->name('cv.update');
        Route::delete('/cv', [MobileProfileController::class, 'deleteCv'])
            ->middleware('mobile.membership:individual')
            ->name('cv.delete');
        Route::get('/cv/pdf', [MobileProfileController::class, 'cvPdf'])
            ->middleware('mobile.membership:individual')
            ->name('cv.pdf');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:2'])
    ->prefix('v1/member/jobs')
    ->name('api.v1.member.jobs.')
    ->group(function () {
        Route::get('/', [MobileJobController::class, 'index'])->name('index');
        Route::get('/{id}', [MobileJobController::class, 'show'])->whereNumber('id')->name('show');
        Route::get('/applications', [MobileJobController::class, 'applications'])
            ->middleware('mobile.membership:individual')
            ->name('applications.index');
        Route::post('/{id}/apply', [MobileJobController::class, 'apply'])
            ->whereNumber('id')
            ->middleware(['mobile.membership:individual', 'throttle:apply-loker'])
            ->name('apply');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:4,5'])
    ->prefix('v1/organization')
    ->name('api.v1.organization.')
    ->group(function () {
        Route::get('/profile', [OrganizationController::class, 'profile'])->name('profile');
        Route::get('/dashboard', [OrganizationController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [OrganizationController::class, 'users'])->name('users.index');
        Route::get('/users/{id}', [OrganizationController::class, 'showUser'])->whereNumber('id')->name('users.show');
        Route::post('/users', [OrganizationController::class, 'storeUser'])->name('users.store');
        Route::patch('/users/{id}', [OrganizationController::class, 'updateUser'])->whereNumber('id')->name('users.update');
        Route::delete('/users/{id}', [OrganizationController::class, 'destroyUser'])->whereNumber('id')->name('users.destroy');
        Route::get('/users/template', [OrganizationController::class, 'downloadTemplate'])->name('users.template');
        Route::post('/users/import', [OrganizationController::class, 'importStudents'])->name('users.import');
        Route::get('/monitoring', [OrganizationController::class, 'monitoring'])->name('monitoring');
        Route::get('/scholarships', [OrganizationController::class, 'scholarships'])->name('scholarships.index');
        Route::post('/scholarships/{id}/{action}', [OrganizationController::class, 'scholarshipAction'])
            ->whereNumber('id')
            ->whereIn('action', ['approve', 'reject'])
            ->name('scholarships.action');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:2'])
    ->prefix('v1/member')
    ->name('api.v1.member.')
    ->group(function () {
        Route::get('/dashboard', [MemberFeatureController::class, 'dashboard'])->name('dashboard');
        Route::get('/classes', [MemberFeatureController::class, 'classes'])->name('classes');
        Route::get('/certificates', [MemberFeatureController::class, 'certificates'])->name('certificates');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:2', 'mobile.membership:company'])
    ->prefix('v1/company')
    ->name('api.v1.company.')
    ->group(function () {
        Route::get('/sop', [MemberFeatureController::class, 'sop'])->name('sop.index');
        Route::get('/bonus-applications', [MemberFeatureController::class, 'bonusApplications'])->name('bonus-applications.index');
    });

Route::middleware(['auth:sanctum', 'mobile.access', 'mobile.role:2', 'mobile.membership:company'])
    ->prefix('v1/company')
    ->name('api.v1.company.')
    ->group(function () {
        Route::get('/profile', [MobileJobController::class, 'companyProfile'])->name('profile.show');
        Route::patch('/profile', [MobileJobController::class, 'updateCompanyProfile'])
            ->name('profile.update');
        Route::get('/jobs', [MobileJobController::class, 'companyJobs'])->name('jobs.index');
        Route::post('/jobs', [MobileJobController::class, 'storeCompanyJob'])->name('jobs.store');
        Route::patch('/jobs/{id}', [MobileJobController::class, 'updateCompanyJob'])
            ->whereNumber('id')
            ->name('jobs.update');
        Route::delete('/jobs/{id}', [MobileJobController::class, 'deleteCompanyJob'])
            ->whereNumber('id')
            ->name('jobs.delete');
    });

Route::middleware([AksesByIpAddress::class])->group(function () {
    Route::get('/loker', [LokerController::class, 'index']);
    Route::get('/kelas', [KelasController::class, 'index']);
});

Route::get('/apiberanda', [HomeController::class, 'apiberanda']);
Route::get('/tripay/create', [PembayaranController::class, 'tripaycreate']);
Route::middleware([VerifyScraperApiKey::class, 'throttle:60,1'])->group(function () {
    Route::post('/v1/scraper/loker-draft', [ScraperIngestionController::class, 'store']);
});
Route::post('/upload-article-image', [ArticleGeneratorController::class, 'upload']);
Route::get('/keywords/next', [ArticleGeneratorController::class, 'getNextKeyword']);
Route::post('/articles/store-n8n', [ArticleGeneratorController::class, 'storeFromN8n']);
Route::get('/articles', [ArticleGeneratorController::class, 'apiIndex']);
Route::get('/tripay/ppob', [PembayaranController::class, 'tripayppob']);
Route::post('/c4/notifikasi', [CheckoutController::class, 'handleDokuTransactionNotification']);
Route::post('/doku/notification', [CheckoutController::class, 'handleNotification']);
Route::post('/doku/membership/notification', [CheckoutController::class, 'handleNotificationmembership']);
Route::get('/api/recent-registrations/random', [RecentRegistrationController::class, 'getRandomCustomer'])
    ->name('api.recent-registrations.random');
