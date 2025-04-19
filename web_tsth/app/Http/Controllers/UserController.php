<?php
namespace App\Http\Controllers;

use App\Service\ContactUsService;
use App\Service\ContentService;
use App\Service\HabitusService;
use App\Service\LandService;
use App\Service\LanguageService;
use App\Service\NewsService;
use App\Service\PlantService;
use App\Service\VisitorService;

class UserController extends Controller
{
    private $content_service, $plant_service, $visitor_service, $land_service, $new_service, $habitus_service, $language_service, $contact_service;
    public function __construct(ContentService $content_service, PlantService $plant_service, VisitorService $visitor_service, LandService $land_service, NewsService $new_service, HabitusService $habitus_service, LanguageService $languageService, ContactUsService $contact_service)
    {
        $this->content_service  = $content_service;
        $this->plant_service    = $plant_service;
        $this->visitor_service  = $visitor_service;
        $this->land_service     = $land_service;
        $this->new_service      = $new_service;
        $this->habitus_service  = $habitus_service;
        $this->language_service = $languageService;
        $this->contact_service  = $contact_service;
    }
    public function home()
    {
        try {
            $contents     = $this->content_service->get_all_content_user();
            $plants       = $this->plant_service->get_all_plant_user();
            $plantCount   = $plants->count();
            $visitorCount = $this->visitor_service->get_all_visitor_user()->count();
            $landCount    = $this->land_service->get_all_land_user()->count();
            $habitusCount = $this->habitus_service->get_all_user()->count();
            $news         = $this->new_service->get_all_news_user();
            $habituses    = $this->habitus_service->get_all_user();
            $languages    = $this->language_service->get_all_lang_user();
            return view('user.home', compact('contents', 'plants', 'plantCount', 'visitorCount', 'landCount', 'habitusCount', 'news', 'habituses', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function news()
    {
        try {
            $news = $this->new_service->get_all_news_user();

            $contents  = $this->content_service->get_all_content_user();
            $languages = $this->language_service->get_all_lang_user();

            return view('user.news', compact(
                'news',
                'contents',
                'languages',
            ));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function news_detail(int $id)
    {
        try {
            $news       = $this->new_service->get_all_news_user();
            $detailNews = $this->new_service->get_detail_news_user($id);
            $contents   = $this->content_service->get_all_content_user();
            $languages  = $this->language_service->get_all_lang_user();

            // dd($detailNews);
            return view('user.news.detail_news', compact('news', 'contents', 'languages', 'detailNews'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function profile_detail(int $id)
    {
        try {
            $contents      = $this->content_service->get_all_content_user();
            $languages     = $this->language_service->get_all_lang_user();
            $contentDetail = $this->content_service->get_detail_content_user($id);
            return view('user.profile.detail_profile', compact('contents', 'languages', 'contentDetail'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function contact_us()
    {
        // try {
        $contents  = $this->content_service->get_all_content_user();
        $languages = $this->language_service->get_all_lang_user();
        $contacts  = $this->contact_service->get_all_contact_user();
        // dd($contacts);
        return view('user.contact_us', compact('contents', 'languages', 'contacts'));
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('error', 'Something went wrong.');
        // }
    }

}
