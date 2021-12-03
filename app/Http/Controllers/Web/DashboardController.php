<?php

namespace App\Http\Controllers\Web;

use App\Classes\Matcher;
use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Channels;
use App\Models\Contacts;
use App\Models\Logs;
use App\Models\Medias;
use App\Models\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->account->contacts()->withCount('requests')->get()->sum('requests_count');
        $contacts_month = Contacts::select(
            DB::raw("(count(*)) as total"),
            DB::raw("(DATE_FORMAT(created_at,'%m-%Y')) as my_date")
        )->where('account_id', auth()->user()->account->id)
            ->groupBy(DB::raw("DATE_FORMAT(created_at,'%m-%Y')"))
            ->get();
        $contacts_day = Contacts::select(
            DB::raw("(count(*)) as total"),
            DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y')) as my_date")
        )->where('account_id', auth()->user()->account->id)
            ->groupBy(DB::raw("DATE_FORMAT(created_at,'%d-%m-%Y')"))
            ->get();
        $channels_traffic = auth()->user()->account->channels()->withCount('requests')->get();
        $medias_traffic = Medias::with(['channels'=> function($q)
        {
            $q->where('account_id','=', auth()->user()->account->id)->withCount('requests');
        }])->get()->map(function ($media){
            $media->requests_count = $media->channels->sum('requests_count');
            return $media;
        });
        $data_day = [
            'labels' => $contacts_day->pluck('my_date'),
            'datasets' => [
                [
                    'label' => 'contacts',
                    'data' => $contacts_day->pluck('total')
                ]]
        ];
        $data_month = [
            'labels' => $contacts_month->pluck('my_date')->toarray(),
            'datasets' => [
                [
                    'label' => 'contacts',
                    'data' => $contacts_month->pluck('total')->toarray()
                ]]
        ];
        $data_traffic_channels = [
            'labels' => $channels_traffic->pluck('name')->toarray(),
            'datasets' => [
                [
                    'label' => 'requests',
                    'data' => $channels_traffic->pluck('requests_count')->toarray()
                ]]
        ];
        $data_traffic_channels = [
            'labels' => $channels_traffic->pluck('name')->toarray(),
            'datasets' => [
                [
                    'label' => 'requests',
                    'data' => $channels_traffic->pluck('requests_count')->toarray()
                ]]
        ];
        return view('dashboard.index', ['requests' => $requests, 'contacts_stat_month' => $data_month, 'contacts_stat_day' => $data_day, 'data_traffic_channels' => $data_traffic_channels, 'media_traffic' => $medias_traffic]);
    }

    public function channels()
    {
        $channels = auth()->user()->account()->first()->channels()->with(['media', 'authorization', 'responder'])->get();
        $medias = Medias::all();
        foreach ($medias as $media) {
            $class = "App\Services\\" . ucfirst($media['tag']) . "Service";
            if (class_exists($class)) {
                $obj = new $class;
                $media['redirectUrl'] = $obj->getUrl();
            }
        }
        return view('dashboard.channels', ['channels' => $channels, 'medias' => $medias, 'responders' => auth()->user()->account->responders]);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs('uploads', auth()->user()->account->id . '.png', 'public');
            return response()->json([
                'code' => "success",
                'path' => $path
            ]);
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'subject' => 'required',
            'message' => 'required'
        ]);
        Contact::create($request->all());

        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
    }

    public function profile()
    {
        return view('dashboard.profile', ['profile' => auth()->user()->account]);
    }

    public function pricing()
    {
        return view('dashboard.pricing');
    }

    public function activity()
    {
        $activities = Logs::whereHas('keys',function ($query){
            $query->where('account_id',auth()->user()->account->id)->where('name','ADMIN');
        })->with('keys')->orderBy('created_at','Desc');
        return view('dashboard.activity',['activities'=>$activities->get()]);
    }

    public function configuration()
    {
        return view('dashboard.configuration');
    }

    public function users()
    {
        $keys = auth()->user()->account->keys->toArray();
        return view('dashboard.users', ['users' => $keys, 'scopes' => Helper::getViewScopes()]);
    }

    public function updateChannel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:channels,id',
            'responder' => 'required|exists:responders,id',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "error",
                'messages' => $validator->errors()->all()
            ]);
        }
        $channel = Channels::find($request->id);
        $channel->update(['responder_id' => $request->responder, 'status' => $request->status]);
        if ($channel->wasChanged()) {
            return response()->json([
                'code' => "success"
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Nothing to update or Internal error !!"
        ]);
    }

    public function getLogs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:access_keys,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "error",
                'messages' => $validator->errors()->all()
            ]);
        }
        $logs = Logs::where('access_id', $request->id)->orderbyDesc('created_at')->get();
        return response()->json([
            'code' => "success",
            'data' => $logs
        ]);
    }

    public function deleteChannel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:channels,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "error",
                'messages' => $validator->errors()->all()
            ]);
        }
        $channel = Channels::find($request->id);
        $channel->delete();
        if (is_null($channel)) {
            return response()->json([
                'code' => "success"
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }

    public function addAccessKey(Request $request)
    {
        $scopes = array_column($request->scopes, 'name');
        $status = $request->status;
        $name = $request->name;
        $accessKey = Access_keys::create(["token" => Helper::generateToken(auth()->user()->account), "status" => $status, "name" => $name, "account_id" => auth()->user()->account->id, "scopes" => json_encode($scopes)]);
        if ($accessKey) {
            return response()->json([
                'code' => "success",
                'data' => $accessKey
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }
    public function editAccessKey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:access_keys,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "error",
                'messages' => $validator->errors()->all()
            ]);
        }
        $accessKey = Access_keys::find($request->id);
        $scopes = array_column($request->scopes, 'name');
        $status = $request->status;
        $name = $request->name;
        $accessKey->update(["status" => $status, "name" => $name, "account_id" => auth()->user()->account->id, "scopes" => json_encode($scopes)]);
        if ($accessKey) {
            return response()->json([
                'code' => "success",
                'data' => $accessKey
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }
    public function showAccessKey(Request $request)
    {
        $accessKey = Access_keys::find($request->id);
        if ($accessKey && $accessKey->account_id == auth()->user()->account->id) {
            return response()->json([
                'code' => "success",
                'data' => $accessKey
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }

    public function updateProfilePic(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs('uploads', auth()->user()->account->id . '.png', 'public');
            return response()->json([
                'code' => "success",
                'path' => $path
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }

    public function updateProfile(Request $request)
    {
        $account = auth()->user()->account;
        $account->update($request->all());
        if ($account->wasChanged()) {
            return response()->json([
                'code' => "success",
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }

    public function addLiveChat(Request $request)
    {
        $account = auth()->user()->account;
        $media = Medias::where('tag', 'liveChat')->first();
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $now = new DateTimeImmutable();
        $channelId = uniqid();
        $token = $configuration->builder()
            ->issuedAt($now)
            ->withClaim('cid', $channelId)
            ->getToken($configuration->signer(), $configuration->signingKey());
        $authorization = Authorizations::create(['token' => $token->toString(), 'status' => 1, 'account_id' => $account->id, 'media_id' => $media->id]);
        $path = "";
        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs('channels', $channelId . '.png', 'public');
        }
        $channel = Channels::Create(['identifier' => $channelId, 'account_id' => $account->id, 'media_id' => $media->id, 'responder_id' => $request->responder_id, 'name' => $request->name, 'picture' => Storage::disk('public')->url($path), 'status' => $request->status, 'authorization_id' => $authorization->id]);
        if ($channel) {
            return response()->json([
                'code' => "success",
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }

    public function showLiveChat(Request $request, Channels $channel)
    {
        $account = auth()->user()->account;
        $media = Medias::where('tag', 'liveChat')->first();
        if ($channel && $channel->account_id == $account->id && $channel->media_id == $media->id) {
            return response()->json([
                'code' => "success",
                'data' => $channel
            ]);
        }
    }

    public function connect(Request $request, $accountId)
    {
        $account = Accounts::find($accountId);
        if (!$account) {
            return view('dashboard.error');
        }
        if (!is_null($account->user)) {
            return redirect('dashboard');
        }
        return view('auth.register', ['account' => $account]);
    }
}
