<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class CheckAuthService extends JsonResource
{
    private $menu;

    private $authenticated = null;

    private $edit_profile_link = '';

    private $is_admin = null;

    private $is_host = null;

    public function __construct()
    {
        $this->edit_profile_link = env('APP_URL')."/profile/edit/";

        $this->menu = collect([
            'general' => collect([]),
            'reporting' => collect([])
        ]);

        if ($email = \Cookie::get('authenticated')) {
            $this->handle();
        }
    }

    public function handle()
    {
        $user = User::where('email', $email)->first();

        if ( ! $user) {
            return false;
        }

        $this->authenticated = true;

        $this->is_admin = $user->getUserFromDiscourse()['user']['admin'];

        $this->is_host = $user->getUserFromDiscourse()['user']['moderator'];

        $this->edit_profile_link = $this->edit_profile_link.$user->id;

        if ($this->is_host || $this->is_admin) {
            if ($this->is_admin) {
                $this->menu['reporting']->put(Lang::get('general.time_reporting'), url('reporting/time-volunteered?a'));
            }

            $this->menu['reporting']->put(Lang::get('general.party_reporting'), url('search'));
        }

        $this->menu['general']->put(Lang::get('general.about_page'), Lang::get('general.about_page_url'));
        $this->menu['general']->put(Lang::get('general.guidelines_page'), Lang::get('general.guidelines_page_url'));
        $this->menu['general']->put(Lang::get('general.privacy_page'), Lang::get('general.privacy_page_url'));
        $this->menu['general']->put(Lang::get('general.menu_help_feedback'), Lang::get('general.help_feedback_url'));
        $this->menu['general']->put(Lang::get('general.menu_help_feedback'), Lang::get('general.help_feedback_url'));
        $this->menu['general']->put(Lang::get('general.menu_faq'), Lang::get('general.faq_url'));
        $this->menu['general']->put(Lang::get('general.therestartproject'), Lang::get('general.restartproject_url'));
    }

   /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
          'authenticated' => $this->authenticated,
          'edit_profile_link' => $this->edit_profile_link,
          'is_admin' => $this->is_admin,
          'menu' => $this->menu->toArray(),
      ];
    }
}
