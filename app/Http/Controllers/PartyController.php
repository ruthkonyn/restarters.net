<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Party;
use App\Group;
use App\User;
use App\Category;
use App\Brands;
use App\Device;
use App\EventsUsers;
use App\Session;
use App\UserGroups;

use Notification;
use App\Notifications\JoinEvent;

use FixometerHelper;
use Auth;
use FixometerFile;
use DateTime;

class PartyController extends Controller
{

  protected $hostParties = array();
  protected $permissionsChecker;
  public $TotalWeight;
  public $TotalEmission;
  public $EmissionRatio;

  // public function __construct($model, $controller, $action)
  // {
  //     parent::__construct($model, $controller, $action);
  //
  //     $Auth = new Auth($url);
  //     if(!$Auth->isLoggedIn() && $action != 'stats'){
  //         header('Location: /user/login');
  //     }
  //
  //     $user = $Auth->getProfile();
  //     $this->user = $user;
  //     $this->set('user', $user);
  //     $this->set('header', true);
  //
  //     if (hasRole($this->user, 'Host'))
  //     {
  //         $Group = new Group;
  //         $group = $Group->ofThisUser($this->user->id);
  //         $this->set('usergroup', $group[0]);
  //         $parties = $this->Party->ofThisGroup($group[0]->idgroups);
  //
  //         foreach($parties as $party){
  //             $this->hostParties[] = $party->idevents;
  //         }
  //         $User = new User;
  //         $this->set('profile', $User->profilePage($this->user->id));
  //
  //         $Device = new Device;
  //         $weights = $Device->getWeights();
  //
  //         $this->TotalWeight = $weights[0]->total_weights;
  //         $this->TotalEmission = $weights[0]->total_footprints;
  //         $this->EmissionRatio = $this->TotalEmission / $this->TotalWeight;
  //     }
  //
  //     $this->permissionsChecker = new PermissionsChecker($this->user, $this->hostParties);
  // }

  public function index()
  {
      // $this->set('title', 'Parties');
      // $this->set('list', $this->Party->findAll());

      // $Party = new Party;
      // $user = User::find(Auth::id());
      //
      // $past = [];
      // $upcoming = [];
      // $moderate = [];
      //
      // $today = new DateTime("today");
      //
      // foreach ($Party->findAll() as $party) {
      //
      //   $p_date = new DateTime("@$party->event_timestamp");
      //
      //   if( is_null($party->wordpress_post_id) ) { //To moderate
      //
      //     $moderate[] = $party;
      //
      //   } elseif ($p_date > $today) { //upcoming
      //
      //     $upcoming[] = $party;
      //
      //   } elseif ($p_date < $today) { //past
      //
      //     $past[] = $party;
      //
      //   }
      //
      //   // dd($today->diff($p_date));
      //
      // }

      $moderate_events = null;

      if( FixometerHelper::hasRole(Auth::user(), 'Administrator') ) {

        $moderate_events = Party::whereNull('wordpress_post_id')
                      ->whereDate('event_date', '>=', date('Y-m-d'))
                      ->orderBy('event_date', 'ASC')
                        ->get();

      }

      $upcoming_events = Party::join('groups', 'groups.idgroups', '=', 'events.group')
                    ->join('users_groups', 'users_groups.group', '=', 'groups.idgroups')
                      ->whereDate('event_date', '>=', date('Y-m-d'))
                        ->where('users_groups.user', Auth::user()->id)
                          ->select('events.*')
                            ->orderBy('wordpress_post_id', 'ASC')
                              ->orderBy('event_date', 'ASC')
                                ->take(5)
                                  ->get();

      $past_events = Party::whereNotNull('wordpress_post_id')
                    ->whereDate('event_date', '<', date('Y-m-d'))
                    ->orderBy('event_date', 'DESC')
                      ->paginate(env('PAGINATE'));

      $user_groups = UserGroups::where('user', Auth::user()->id)->count();

      return view('events.index', [ //party.index
        'title'     => 'Events',
        //'list'      => $Party->findAll(),
        //'user'      => $user,
        'upcoming_events'  => $upcoming_events,
        'past_events'      => $past_events,
        'moderate_events'  => $moderate_events,
        'user_groups'      => $user_groups,
      ]);
  }

  public function create()
  {
      $user = Auth::user();

      if( !FixometerHelper::hasRole(Auth::user(), 'Administrator') && !FixometerHelper::hasRole(Auth::user(), 'Host') )
        return redirect('/user/forbidden');

      $Groups = new Group;
      $Party = new Party;

      // $this->set('grouplist', $Groups->findList());
      //
      // $this->set('title', 'New Party');
      // $this->set('gmaps', true);
      // $this->set('js',
      //             array('head' => array(
      //                             '/ext/geocoder.js'
      //             )));
      //
      // $this->set('group_list', $Groups->findAll());

      if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {

          $error = array();

          // Add SuperHero Restarter!
          // $_POST['users'][] = 29;
          // if(empty($_POST['volunteers'])) {
          //     $volunteers = count($_POST['users']);
          // }
          // else {
          //     $volunteers = $_POST['volunteers'];
          // }

          if (!empty($_POST['location'])) {

            $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($_POST['location'].',United Kingdom')."&key=AIzaSyDb1_XdeHbwLg-5Rr3EOHgutZfqaRp8THE");
            $json = json_decode($json);

            if (is_object($json) && !empty($json->{'results'})) {
                $latitude = $json->{'results'}[0]->{'geometry'}->{'location'}->lat;
                $longitude = $json->{'results'}[0]->{'geometry'}->{'location'}->lng;
            }

          } else {
            $latitude = null;
            $longitude = null;
          }

          // We got data! Elaborate.
          $event_date =       $_POST['event_date'];
          $start      =       $_POST['start'];
          $end        =       $_POST['end'];
          $pax        =       0;
          $free_text  =       $_POST['free_text'];
          $venue      =       $_POST['venue'];
          $location   =       $_POST['location'];
          // $latitude   =       $latitude;
          // $longitude  =       $longitude;
          $group      =       intval($_POST['group']);


          // saving this for wordpress
          $wp_date = $event_date;

          // formatting dates for the DB
          $event_date = date('Y-m-d', strtotime($event_date));

          if(!FixometerHelper::verify($event_date)){
              $error['event_date'] = 'We must have a starting date and time.';
          }
          if(!FixometerHelper::verify($start)){
              $error['name'] = 'We must have a starting date and time.';
          }
          // if(!empty($latitude) || !empty($longitude)) {
          //     // check that these values are floats.
          //     $check_lat = filter_var($latitude, FILTER_VALIDATE_FLOAT);
          //     $check_lon = filter_var($longitude, FILTER_VALIDATE_FLOAT);
          //
          //     if(!$check_lat || !$check_lon){
          //         $error['location'] = 'Coordinates must be in the correct format.';
          //     }
          //
          // }


          if(empty($error)) {

              $startTime = $event_date . ' ' . $start;
              $endTime = $event_date . ' ' . $end;

              $dtStart = new DateTime($startTime);
              $dtDiff = $dtStart->diff(new DateTime($endTime));

              $hours = $dtDiff->h;

              // No errors. We can proceed and create the Party.
              $data = array(
                              'event_date'    => $event_date,
                              'start'         => $start,
                              'end'           => $end,
                              'pax'           => $pax,
                              'free_text'     => $free_text,
                              'venue'         => $venue,
                              'location'      => $location,
                              'latitude'      => $latitude,
                              'longitude'     => $longitude,
                              'group'         => $group,
                              'hours'         => $hours,
                              // 'volunteers'    => $volunteers,
                              'created_at'    => date('Y-m-d H:i:s')
                            );
              $idParty = $Party->insertGetId($data);



              if($idParty){

                  /** check and create User List **/
                  $_POST['users'][] = 29;
                  if(isset($_POST['users']) && !empty($_POST['users'])){
                      $users = $_POST['users'];
                      $Party->createUserList($idParty, $users);
                  }

                  EventsUsers::create([
                    'event' => $idParty,
                    'user' => $user->id,
                    'status' => 2,
                    'role' => 3,
                  ]);

                  /** let's create the image attachment! **/
                  if(isset($_FILES) && !empty($_FILES)){
                      $file = new FixometerFile;
                      $file->upload('file', 'image', $idParty, env('TBL_EVENTS'));
                  }

                  if(env('APP_ENV') != 'development' && env('APP_ENV') != 'local') {
                      /** Prepare Custom Fields for WP XML-RPC - get all needed data **/
                      $Host = $Groups->findHost($group);

                      $custom_fields = array(
                                      array('key' => 'party_host',            'value' => $Host->hostname),
                                      array('key' => 'party_hostavatarurl',   'value' => env('UPLOADS_URL') . 'mid_' .$Host->path),
                                      array('key' => 'party_grouphash',       'value' => $group),
                                      array('key' => 'party_venue',           'value' => $venue),
                                      array('key' => 'party_location',        'value' => $location),
                                      array('key' => 'party_time',            'value' => $start . ' - ' . $end),
                                      array('key' => 'party_date',            'value' => $event_date),
                                      array('key' => 'party_timestamp',       'value' => strtotime($event_date)),
                                      array('key' => 'party_timestamp_end',   'value' => strtotime($endTime)),
                                      array('key' => 'party_stats',           'value' => $idParty),
                                      array('key' => 'party_lat',             'value' => $latitude),
                                      array('key' => 'party_lon',             'value' => $longitude)

                                      );


                      /** Start WP XML-RPC **/
                      $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
                      $wpClient->setCredentials(env('WP_XMLRPC_ENDPOINT'), env('WP_XMLRPC_USER'), env('WP_XMLRPC_PSWD'));


                      $content = array(
                                      'post_type' => 'party',
                                      'custom_fields' => $custom_fields
                                      );
                      $party_name = !empty($data['venue']) ? $data['venue'] : $data['location'];
                      $wpid = $wpClient->newPost($party_name, $free_text, $content);

                      $Party->update(array('wordpress_post_id' => $wpid), $idParty);
                  }

                  if(FixometerHelper::hasRole($user, 'Host')){

                      // $this->sendCreationNotificationEmail($venue, $location, $event_date, $start, $end, $group);
                      // header('Location: /host?action=pc&code=200');

                  } else if(FixometerHelper::hasRole($user, 'Administrator')){
                    // header('Location: /admin?action=pc&code=200');
                  }
               }
              else {
                  $response['danger'] = 'Party could <strong>not</strong> be created. Something went wrong with the database.';
              }

          }
          else {
              $response['danger'] = 'Party could <strong>not</strong> be created. Please look at the reported errors, correct them, and try again.';
          }
          // $this->set('response', $response);
          // $this->set('error', $error);
          // $this->set('udata', $_POST);

          if (!isset($response)) {
            $response = null;
          }
          if (!isset($error)) {
            $error = null;
          }
          if (!isset($_POST)) {
            $udata = null;
          } else {
            $udata = $_POST;
          }

          if(is_numeric($idParty)){

            return redirect('/party/edit/'.$idParty)->with('response', $response);

          } else {

            return view('events.create', [ //party.create
              'title' => 'New Party',
              'grouplist' => $Groups->findList(),
              'gmaps' => true,
              'group_list' => $Groups->findAll(),
              'response' => $response,
              'error' => $error,
              'udata' => $_POST,
              'user' => $user,
              'user_groups' => $user_groups,
            ]);
          }
      }

      $user_groups = UserGroups::where('user', Auth::user()->id)->pluck('group')->toArray();

      return view('events.create', [ //party.create
        'title' => 'New Party',
        'grouplist' => $Groups->findList(),
        'gmaps' => true,
        'group_list' => $Groups->findAll(),
        'user' => $user,
        'user_groups' => $user_groups,
      ]);

  }

  public function sendCreationNotificationEmail($venue, $location, $event_date, $start, $end, $group_id){
      $Groups = new Group;

      $group = $Groups->findOne($group_id);
      $group_name = $group->name;

      $hostname = Auth::user()->name;

      // send email to Admin
      $message = "<p>Hi,</p>" .
      "<p>This is an automatic email to let you know that <strong>". $hostname . " </strong>has created a party on the <strong>" . APPNAME . "</strong>.</p>" .
      "<p><strong>Group Name:</strong> ". $group_name ." <p>" .
      "<p><strong>Party Name:</strong> ". $venue ." </p>" .
      "<p><strong>Party Location:</strong> " . $location ." </p>" .
      "<p><strong>Party Date:</strong> ". $event_date ." </p>" .
      "<p><strong>Party Start Time:</strong> ". $start ." </p>" .
      "<p><strong>Party End Time:</strong> ". $end ." </p>" ;

      $subject = env('APP_NAME') . ": Party created by the host : " . $hostname . " ";
      $headers = "From: " . env('APP_EMAIL') . "\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $email= env('NOTIFICATION_EMAIL');
      $sender = mail($email, $subject, $message, $headers);
  }

  /** sync all parties to wordpress - CREATES PARTIES! **/
  public function sync(){
      /* $parties = $this->Party->findAll();
      $Groups = new Group;
      foreach($parties as $i => $party) {
          $Host = $Groups->findHost($party->group_id);
          $custom_fields = array(
                  array('key' => 'party_host',            'value' => $Host->hostname),
                  array('key' => 'party_hostavatarurl',   'value' => UPLOADS_URL . 'mid_' .$Host->path),
                  array('key' => 'party_grouphash',       'value' => $party->group_id),
                  array('key' => 'party_location',        'value' => $party->location),
                  array('key' => 'party_time',            'value' => $party->start . ' - ' . $party->end),
                  array('key' => 'party_date',            'value' => $party->event_date),
                  array('key' => 'party_timestamp',       'value' => $party->event_timestamp),
                  array('key' => 'party_stats',           'value' => $party->id),
                  array('key' => 'party_lat',             'value' => $party->latitude),
                  array('key' => 'party_lon',             'value' => $party->longitude)
          );
          echo "Connecting ... ";
          $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
          $wpClient->setCredentials(env('WP_XMLRPC_ENDPOINT'), env('WP_XMLRPC_USER'), env('WP_XMLRPC_PSWD'));


          $content = array(
                      'post_type' => 'party',
                      'custom_fields' => $custom_fields
                      );

          $wpid = $wpClient->newPost($party->location, $party->free_text, $content);
          echo "<strong>Posted to WP</strong> ... ";
          $this->Party->update(array('wordpress_post_id' => $wpid), $party->id);
          echo "Updated Fixometer recordset with WPID: " . $wpid . "<br />";
      }
      */
  }

  public function edit($id, Request $request) {
      $user = Auth::user();

      if (!FixometerHelper::userHasEditPartyPermission($id, $user->id))
          return redirect('/user/forbidden');

      $Groups = new Group;
      $File = new FixometerFile;
      $Party = new Party;
      $Device = new Device;

      $allparties = $Party->ofThisGroup('admin', true, true);
      $co2Total = $Device->getWeights();
      $device_count_status = $Device->statusCount();

      $user_groups = UserGroups::where('user', Auth::user()->id)->pluck('group')->toArray();

      $images = $File->findImages(env('TBL_EVENTS'), $id);

      if (!isset($images)) {
        $images = null;
      }

      if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
          $id = $_POST['id'];
          $data = $_POST;
          unset($data['files']);
          unset($data['file']);
          unset($data['users']);
          unset($data['id']);

          // Add SuperHero Restarter!
          // $_POST['users'][] = 29;
          // if(empty($data['volunteers'])) {
          //     $data['volunteers'] = count($_POST['users']);
          // }

          // saving this for WP
          $wp_date = $data['event_date'];

          // formatting dates for the DB
          $data['event_date'] = FixometerHelper::dbDateNoTime($data['event_date']);
          $timestamp = strtotime($data['event_date']);

          if (!empty($data['location'])) {

            $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($data['location'].',United Kingdom')."&key=AIzaSyDb1_XdeHbwLg-5Rr3EOHgutZfqaRp8THE");
            $json = json_decode($json);

            if (is_object($json) && !empty($json->{'results'})) {
                $latitude = $json->{'results'}[0]->{'geometry'}->{'location'}->lat;
                $longitude = $json->{'results'}[0]->{'geometry'}->{'location'}->lng;
            }

          } else {
            $latitude = null;
            $longitude = null;
          }

          $update = array(
            'event_date'  => $data['event_date'],
            'start'       => $data['start'],
            'end'         => $data['end'],
            'free_text'   => $data['free_text'],
            // 'pax'         => $data['pax'],
            // 'volunteers'  => $data['volunteers'],
            'group'       => $data['group'],
            'venue'       => $data['venue'],
            'location'    => $data['location'],
            'latitude'    => $latitude,
            'longitude'   => $longitude,
          );

          $u = $Party->where('idevents', $id)->update($update);

          if(!$u) {
              $response['danger'] = 'Something went wrong. Please check the data and try again.';
          }
          else {
              $response['success'] = 'Event details updated <a href="/party/view/'.$id.'" class="btn btn-success">View event</a>';

              if( ( env('APP_ENV') == 'development' || env('APP_ENV') == 'local' ) && isset($data['moderate']) && $data['moderate'] == 'approve' ) { //For testing purposes

                $Party->where('idevents', $id)->update(['wordpress_post_id' => 99999]);

              } elseif( ( env('APP_ENV') != 'development' && env('APP_ENV') != 'local' ) && isset($data['moderate']) && $data['moderate'] == 'approve' ) {

                  $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
                  $wpClient->setCredentials(env('WP_XMLRPC_ENDPOINT'), env('WP_XMLRPC_USER'), env('WP_XMLRPC_PSWD'));

                  /** Prepare Custom Fields for WP XML-RPC - get all needed data **/
                  $theParty = $Party->findThis($id);
                  $Host = $Groups->findHost($data['group']);
                  $custom_fields = array(
                                  array('key' => 'party_host',            'value' => $Host->hostname),
                                  array('key' => 'party_hostavatarurl',   'value' => env('UPLOADS_URL') . 'mid_' . $Host->path),
                                  array('key' => 'party_grouphash',       'value' => $data['group']),
                                  array('key' => 'party_venue',           'value' => $data['venue']),
                                  array('key' => 'party_location',        'value' => $data['location']),
                                  array('key' => 'party_time',            'value' => $data['start'] . ' - ' . $data['end']),
                                  array('key' => 'party_date',            'value' => $wp_date),
                                  array('key' => 'party_timestamp',       'value' => $theParty->event_timestamp),
                                  array('key' => 'party_timestamp_end',   'value' => $theParty->event_end_timestamp),
                                  array('key' => 'party_stats',           'value' => $id),
                                  array('key' => 'party_lat',             'value' => $data['latitude']),
                                  array('key' => 'party_lon',             'value' => $data['longitude'])
                                  );


                  $content = array(
                                  'post_type' => 'party',
                                  'post_title' => !empty($data['venue']) ? $data['venue'] : $data['location'],
                                  'post_content' => $data['free_text'],
                                  'custom_fields' => $custom_fields
                                  );


                  // Check for WP existence in DB
                  if(!empty($theParty->wordpress_post_id)){

                      // we need to remap all custom fields because they all get unique IDs across all posts, so they don't get mixed up.
                      $thePost = $wpClient->getPost($theParty->wordpress_post_id);

                      foreach( $thePost['custom_fields'] as $i => $field ){
                          foreach( $custom_fields as $k => $set_field){
                              if($field['key'] == $set_field['key']){
                                  $custom_fields[$k]['id'] = $field['id'];
                              }
                          }
                      }

                      $content['custom_fields'] = $custom_fields;
                      $wpClient->editPost($theParty->wordpress_post_id, $content);
                  }
                  else {
                      // Brand new post -> we send it up and update the Fixometer
                      $wpid = $wpClient->newPost($Host->groupname, $free_text, $content);
                      $Party->update(array('wordpress_post_id' => $wpid), $id);
                  }
              }

              if(isset($_POST['users']) && !empty($_POST['users'])){
                  $users = $_POST['users'];
                  $Party->createUserList($id, $users);
              }


              /** let's create the image attachment! **/
              if(isset($_FILES) && !empty($_FILES)){
                  if(is_array($_FILES['file']['name'])) {
                      $files = FixometerHelper::rearrange($_FILES['file']);
                      foreach($files as $upload){
                          $File->upload($upload, 'image', $id, env('TBL_EVENTS'));
                      }
                  }
                  else { }
              }
          }
          if(FixometerHelper::hasRole($user, 'Host')){
              header('Location: /host?action=pe&code=200');
          }
          // $this->set('response', $response);

          if (!isset($images)) {
            $images = null;
          }

          if (!isset($remotePost)) {
            $remotePost = null;
          }

          $party = $Party->findThis($id)[0];

          return view('events.edit', [ //party.edit
            'response' => $response,
            'gmaps' => true,
            'images' => $images,
            'title' => 'Edit Party',
            'group_list' => $Groups->findAll(),
            'formdata' => $party,
            'remotePost' => $remotePost,
            'grouplist' => $Groups->findList(),
            'user' => Auth::user(),
            'co2Total' => $co2Total[0]->total_footprints,
            'wasteTotal' => $co2Total[0]->total_weights,
            'partiesCount' => count($allparties),
            'device_count_status' => $device_count_status,
            'user_groups' => $user_groups,
            'images' => $images,
          ]);
      }

      $images = $File->findImages(env('TBL_EVENTS'), $id);//NB: File facade can't find findImages may need to add

      if (!isset($images)) {
        $images = null;
      }

      $party = $Party->findThis($id)[0];
      // $this->set('images', $images);
      // $this->set('title', 'Edit Party');
      // $this->set('group_list', $Groups->findAll());
      // $this->set('formdata', $Party);

      // $remotePost = $wpClient->getPost($Party->wordpress_post_id);//NB: Add back in when wordpress stuff is fixed
      $remotePost = null;

      // $this->set('remotePost', $remotePost);
      //
      // $this->set('grouplist', $Groups->findList());

      return view('events.edit', [ //party.edit
        'gmaps' => true,
        'images' => $images,
        'title' => 'Edit Party',
        'group_list' => $Groups->findAll(),
        'formdata' => $party,
        'remotePost' => $remotePost,
        'grouplist' => $Groups->findList(),
        'user' => Auth::user(),
        'co2Total' => $co2Total[0]->total_footprints,
        'wasteTotal' => $co2Total[0]->total_weights,
        'partiesCount' => count($allparties),
        'device_count_status' => $device_count_status,
        'user_groups' => $user_groups,
      ]);
  }

  public function view($id) {
      $user = Auth::user();

      $Groups = new Group;
      $File = new FixometerFile;
      $Party = new Party;
      $Device = new Device;

      $allparties = $Party->ofThisGroup('admin', true, true);
      $co2Total = $Device->getPartyWeights($id);

      $images = $File->findImages(env('TBL_EVENTS'), $id);

      if (!isset($images)) {
        $images = null;
      }

      $party = $Party->findThis($id, true)[0];

      $attended_ids = EventsUsers::where('event', $id)->where('status', '=', 2)->pluck('user')->toArray();
      if (!empty($attended_ids)) {
        foreach ($attended_ids as $attended_id) {
          $attended[] = User::getProfile($attended_id);
          $attended_roles[$attended_id] = EventsUsers::where('user', $attended_id)->where('event', $id)->first()->role;
        }
      } else {
        $attended = [];
        $attended_roles = [];
      }

      $invited_ids = EventsUsers::where('event', $id)->where('status', '!=', 2)->pluck('user')->toArray();
      if (!empty($invited_ids)) {
        foreach ($invited_ids as $invited_id) {
          $invited[] = User::getProfile($invited_id);
          $invited_roles[$invited_id] = EventsUsers::where('user', $invited_id)->where('event', $id)->first()->role;
        }
      } else {
        $invited = [];
        $invited_roles = [];
      }

      try {
        $host = User::find(EventsUsers::where('event', $id)->where('role', '=', 3)->first()->user);
      } catch (\Exception $e) {
        $host = null;
      }

      $brands = Brands::all();
      $categories = Category::all();

      // $device_count_status = $Device->statusCount($party->group);
      $device_count_status = $Device->partyStatusCount($id);

      // dd($party);

      return view('events.view', [
        'gmaps' => true,
        'images' => $images,
        'event' => Party::find($id),
        'formdata' => $party,
        'user' => $user,
        'co2Total' => $co2Total[0]->total_footprints,
        'wasteTotal' => $co2Total[0]->total_weights,
        'partiesCount' => count($allparties),
        'device_count_status' => $device_count_status,
        'attended' => $attended,
        'attended_roles' => $attended_roles,
        'invited'  => $invited,
        'invited_roles' => $invited_roles,
        'host' => $host,
        'brands' => $brands,
        'categories' => $categories,
      ]);

  }


  public function manage($id){

      $user = User::find(Auth::id());

      if( !FixometerHelper::hasRole($user, 'Host') && !FixometerHelper::hasRole($user, 'Administrator')){

          return redirect('/user/forbidden');

      } else {

          // $this->set('js',
          //             array('foot' => array(
          //                             '/components/jquery.floatThead/dist/jquery.floatThead.min.js'
          //             )));

          $Device     = new Device;
          $Category   = new Category;
          $User       = new User;
          $Group      = new Group;
          $Party      = new Party;

          // $this->set('grouplist', $Group->findList());

          if(isset($_POST) && !empty($_POST) && is_numeric($_POST['idparty']) && ($_POST['idparty'] > 0) ) {
              $response = null;

              $partydata = $_POST['party'];
              $idparty = $_POST['idparty'];
              $Party->update($partydata, $idparty);

              if(isset($_POST['device'])){
                  $devices = $_POST['device'];

                  // Rearrange files to more friendly Array
                  if(isset($_FILES) && !empty($_FILES)){
                    $files = reflow($_FILES['device']);
                    $File = new FixometerFile;
                  }
                  //dbga($files);
                  foreach ($devices as $i => $device){

                      //dbga($device);
                      $error = false;
                      $device['event'] = $id;
                      $method = null;

                      if(isset($device['id']) && is_numeric($device['id'])){
                          $method = 'update';
                          $iddevice = $device['id'];
                          unset($device['id']);
                      }

                      if(!isset($device['category']) || empty($device['category'])){
                          $response['danger'] = 'Category needed! (device # ' . $i . ')';
                          $error = true;
                      }

                      if(!isset($device['repaired_by']) || empty($device['repaired_by'])){
                          $device['repaired_by'] = 29;
                      }

                      if($method == 'update'){
                          //echo "updating---";
                          $Device->update($device, $iddevice);
                          if (FixometerHelper::featureIsEnabled(env('FEATURE__DEVICE_PHOTOS'))) {
                            if($files[$i]['error'] == 0){
                              $File->simpleUpload($files[$i], 'device', $iddevice, 'Device S/N Image');
                            }
                          }
                      }

                      else {
                          //echo "creating---";
                          $device['category_creation'] = $device['category'];
                          $iddevice = $Device->create($device);
                          if (FixometerHelper::featureIsEnabled(env('FEATURE__DEVICE_PHOTOS'))) {
                            if($files[$i]['error'] == 0){
                              $File->simpleUpload($files[$i], 'device', $iddevice, 'Device S/N Image');
                            }
                          }
                      }

                      $response['success'] = 'Party info updated!';
                  }
              }


              if(env('APP_ENV') != 'development' && env('APP_ENV') != 'local') {
                  /** WP Sync **/
                  $party = $Party->findThis($idparty, true);

                  $Groups = new Group;
                  $partygroup = $party->group;
                  $Host = $Groups->findHost($party->group);

                  $custom_fields = array(
                                      array('key' => 'party_host',            'value' => $Host->hostname),
                                      array('key' => 'party_hostavatarurl',   'value' => UPLOADS_URL . 'mid_' . $Host->path),
                                      array('key' => 'party_grouphash',       'value' => $party->group),
                                      array('key' => 'party_location',        'value' => $party->location),
                                      array('key' => 'party_time',            'value' => substr($party->start, 0, -3) . ' - ' . substr($party->end, 0, -3)),
                                      array('key' => 'party_date',            'value' => date('d/m/Y', $party->event_date)),
                                      array('key' => 'party_timestamp',       'value' => $party->event_timestamp),
                                      array('key' => 'party_timestamp_end',   'value' => $party->event_end_timestamp),
                                      array('key' => 'party_stats',           'value' => $idparty),
                                      array('key' => 'party_lat',             'value' => $party->latitude),
                                      array('key' => 'party_lon',             'value' => $party->longitude)

                                  );


                  /** Start WP XML-RPC **/
                  $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
                  $wpClient->setCredentials(env('WP_XMLRPC_ENDPOINT'), env('WP_XMLRPC_USER'), env('WP_XMLRPC_PSWD'));



                  $text = (empty($party->free_text) ? '...' : $party->free_text);
                  $content = array(
                                  'post_type' => 'party',
                                  'post_title' => $party->location,
                                  'post_content' => $text,
                                  'custom_fields' => $custom_fields
                                  );


                  // Check for WP existence in DB
                  // $theParty = $this->Party->findOne($idparty);
                  if(!empty($party->wordpress_post_id)){
                      // echo "WP id present (" . $party->wordpress_post_id . ")! Editing...<br />";
                      // we need to remap all custom fields because they all get unique IDs across all posts, so they don't get mixed up.
                      $thePost = $wpClient->getPost($party->wordpress_post_id);



                      foreach( $thePost['custom_fields'] as $i => $field ){
                          foreach( $custom_fields as $k => $set_field){
                              if($field['key'] == $set_field['key']){
                                  $custom_fields[$k]['id'] = $field['id'];
                              }
                          }
                      }

                      $content['custom_fields'] = $custom_fields;
                      $wpClient->editPost($party->wordpress_post_id, $content);
                  }
                  else {
                      $returnId = $wpClient->newPost($Host->groupname, $text, $content);
                      $this->Party->update(array('wordpress_post_id' => $returnId), $idparty);
                  }

                  unset($party);
              }
              /** EOF WP Sync **/
              /*
              if($error == false){
                  // If is Admin, redir to host + group id
                  if(hasRole($this->user, 'Administrator')){
                      header('Location: /host/index/' . $partygroup);
                  }
                  else {
                      header('Location: /host');
                  }
              }
              else {
                  //echo "No.";

              }
              */
            // $this->set('response', $response);
          }


          $party      = $Party->findThis($id, true);
          $categories = $Category->listed();
          $restarters = $User->find(array('idroles' => 4));

          $party = $party[0];

          $party->co2 = 0;
          $party->ewaste = 0;
          $party->fixed_devices = 0;
          $party->repairable_devices = 0;
          $party->dead_devices = 0;


          if(!empty($party->devices)){
              foreach($party->devices as $device){

                  if($device->repair_status == env('DEVICE_FIXED')){
                      $party->co2     += (!empty($device->estimate) && $device->category==46 ? ($device->estimate * $this->EmissionRatio) : $device->footprint);
                      $party->ewaste  += (!empty($device->estimate) && $device->category==46 ? $device->estimate : $device->weight);
                  }

                  switch($device->repair_status){
                      case 1:
                          $party->fixed_devices++;
                          break;
                      case 2:
                          $party->repairable_devices++;
                          break;
                      case 3:
                          $party->dead_devices++;
                          break;
                  }
              }
          }

          $party->co2 = number_format(round($party->co2 * $Device->displacement), 0, '.' , ',');

          // $this->set('party', $party);
          // $this->set('devices', $party->devices);
          // $this->set('categories', $categories);
          // $this->set('restarters', $restarters);

          if (!isset($response)) {
            $response = null;
          }

          return view('party.manage', [
            'grouplist' => $Group->findList(),
            'response' => $response,
            'party' => $party,
            'devices' => $party->devices,
            'categories' => $categories,
            'restarters' => $restarters,
            'user' => $user,
          ]);
      }
  }


  public function delete($id){
      if(FixometerHelper::hasRole($this->user, 'Administrator') || (hasRole($this->user, 'Host') && in_array($id, $this->hostParties))){
          // fetch the postID in WP to delete it later
          $party = $this->Party->findOne($id);
          $wpId = $party->wordpress_post_id;

          $usersDelete = $this->Party->deleteUserList($id);
          $r = $this->Party->delete($id);

          if(!$r){
              $response = 'action=de&code=403';
          }
          else {
              if( !is_null($wpId) && is_numeric($wpId) ) {
                  // delete from WordPress
                  /** Start WP XML-RPC **/
                  $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
                  $wpClient->setCredentials(env('WP_XMLRPC_ENDPOINT'), env('WP_XMLRPC_USER'), env('WP_XMLRPC_PSWD'));

                  $deletion = $wpClient->deletePost($wpId);
                  if(!$wpId){
                      $response = 'action=de&code=500';
                  }
                  else {
                      $response = 'action=de&code=200';
                  }
              }
              else {
                  $response = 'action=de&code=200';
              }

          }

          if(FixometerHelper::hasRole($this->user, 'Host')){
              header('Location: /host?' . $response);
          }
          else {
              header('Location: /party?' . $response);
          }

      }

      else {
          header('Location: /user/forbidden');
      }
  }


  public function stats($id, $class = null){
      $Device = new Device;

      // $this->set('framed', true);
      $party = $this->Party->findThis($id, true);

      if($party->device_count == 0){
          $need_attention++;
      }

      $party->co2 = 0;
      $party->fixed_devices = 0;
      $party->repairable_devices = 0;
      $party->dead_devices = 0;
      $party->ewaste = 0;

      foreach($party->devices as $device){

          if($device->repair_status == DEVICE_FIXED){
              $party->co2 += (!empty($device->estimate) && $device->category == 46 ? ($device->estimate * $this->EmissionRatio) : $device->footprint);
              $party->ewaste += (!empty($device->estimate) && $device->category == 46  ? $device->estimate : $device->weight);
          }

          switch($device->repair_status){
              case 1:
                  $party->fixed_devices++;
                  break;
              case 2:
                  $party->repairable_devices++;
                  break;
              case 3:
                  $party->dead_devices++;
                  break;
          }
      }

      $party->co2 = number_format(round($party->co2 * $Device->displacement), 0, '.' , ',');
      $this->set('party', $party);
      if(!is_null($class)) {
          $this->set('class', 'wide');
      }

      return view('party.stats', [
        'framed' => true,
        'party' => $party,
        'class' => 'wide',
      ]);

  }

  public function deleteimage(){
      if(is_null($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])){
          return false;
      }

      else {
          $id = $_GET['id'];
          $path = $_GET['path'];
          $Image = new FixometerFile;

          $Image->deleteImage($id, $path);



          echo json_encode(array('hey' => 'Deleting stuff here!'));


      }
  }

  public function getGroupEmails(Request $request){
    $event_id = $request->input('event_id');

    $group_user_ids = UserGroups::where('group', Party::find($event_id)->group)->pluck('user')->toArray();
    $group_users = User::whereIn('id', $group_user_ids)->pluck('email')->toArray();

    return json_encode($group_users);
  }

  public function updateQuantity(Request $request) {
    $event_id = $request->input('event_id');
    $quantity = $request->input('quantity');

    Party::find($event_id)->update([
      'pax' => $quantity,
    ]);

    return "true";
  }

  public function postSendInvite(Request $request) {

    $from_id = $request->input('from_id');
    $group_name = $request->input('group_name');
    $event_id = $request->input('event_id');
    $invite_group = $request->input('invite_group');
    $emails = explode(',', str_replace(' ', '', $request->input('manual_invite_box')));
    $message = $request->input('message_to_restarters');

    if (empty($emails)) {
      $users = User::whereIn('email', $emails)->get();
      // if (isset($invite_group) && $invite_group == 1) {
      //   $group_user_ids = UserGroups::where('group', Party::find($event_id)->group)->pluck('user')->toArray();
      //   $group_users = User::whereIn('id', $group_user_ids)->get();
      //
      //   $users = $users->merge($group_users);
      // }
      $non_users = array_diff($emails, User::whereIn('email', $emails)->pluck('email')->toArray());
      $from = User::find($from_id);

      foreach ($users as $user) {
        $user_event = EventsUsers::where('user', $user->id)->where('event', $event_id)->first();
        if (is_null($user_event) || $user_event->status != "1") {
          $hash = substr( bin2hex(openssl_random_pseudo_bytes(32)), 0, 24 );
          $url = url('/').'/accept-invite/party-'.$event_id.'/'.$hash;

          if (!is_null($user_event)) {
            $user_event->update([
              'status' => $hash,
            ]);
          } else {
            EventsUsers::create([
              'user' => $user->id,
              'event' => $event_id,
              'status' => $hash,
            ]);
          }

          $arr = array(
            'name' => $from->name,
            'group' => $group_name,
            'url' => $url,
            'message' => $message,
          );
          Notification::send($user, new JoinEvent($arr));
        } else {
          $not_sent[] = $user->email;
        }
      }

      if (!empty($non_users)) {
        foreach ($non_users as $non_user) {
          $hash = substr( bin2hex(openssl_random_pseudo_bytes(32)), 0, 24 );
          $url = url('/').'/user/register/party-'.$event_id.'/'.$hash;

          EventsUsers::create([
            'user' => $user->id,
            'event' => $event_id,
            'status' => $hash,
          ]);

          $invite = JoinEvent::create(array(
            'name' => $from->name,
            'group' => $group_name,
            'url' => $url,
            'message' => $message,
          ));
          $invite->notify();
          // Notification::send($user, new JoinEvent($arr));
        }
      }

      if (!isset($not_sent)) {
        return redirect()->back()->with('success', 'Invites Sent!');
      } else {
        return redirect()->back()->with('warning', 'Invites Sent - apart from these ('.implode(',', $not_sent).') who were already part of the event');
      }
    } else {
      return redirect()->back()->with('warning', 'You have not entered any emails!');
    }

  }

  public function confirmInvite($event_id, $hash, $register_id = null) {

    try {
      $user_event = EventsUsers::where('status', $hash)->where('event', $event_id)->first();
      $user_event->status = 1;

      if (is_null($register_id)) {
        $user_event->save();
        return redirect('/party/view/'.$user_event->event)->with('success', 'Excellent! You are joining us for this party');
      } else {
        $user_event->user = $register_id;
        $user_event->save();
      }
    } catch (\Exception $e) {
      return false;
    }

  }

    public function test() {
      $g = new Party;
      dd($g->ofThisUser('1', false, true));
    }
}
